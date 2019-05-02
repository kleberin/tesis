<?php

namespace App\Http\Controllers;

use App\Dealer;
use App\Customer;
use App\WorkOrder;
use App\Util\HungarianBipatiteMatching;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * 
     */
    public function upload()
    {
        return view('upload.single');
    }

    /**
     * 
     */
    public function update()
    {
        return view('update-wo.single');
    }

    /**
     * 
     */
    public function uploadCsv(Request $request, Customer $customerRepo,WorkOrder $workOrderRepo)
    {
        //dd($request);
        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();
  
        Storage::disk('local')->putFileAs(
          'files',
          $uploadedFile,
          $filename
        );

        // leer csv
        // insertar valores
        $filename1 = storage_path('app\files\\' . $filename);
        $handle = fopen($filename1, "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ";")) {

            if ($header) {
                $header = false;
            } else {
                $customer = $customerRepo->firstOrCreate([
                    'id' => $csvLine[1],
                    'reference_number' => $csvLine[3],
                    'name' => $csvLine[2],
                    'address' => $csvLine[7],
                    'phone' => $csvLine[4],
                    'latitude'=> $csvLine[8],
                    'longitude' => $csvLine[9]
                ]);
                $work_order = $workOrderRepo->firstOrNew([
                    'id' => $csvLine[0]
                ]);
                $work_order->customer_id = $csvLine[1];
                $work_order->description = $csvLine[5];
                $work_order->status = $csvLine[6];
                $work_order->date = Carbon::create(2019,4,8,0,0,0,'America/Guayaquil');
                $work_order->user_id= null;
                $work_order->save();
            }
        }
        
        return response()->json(['count' => 30, 'status' => 'ok']);
    }

    /**
     * 
     */

    public function updateCsv(Request $request,WorkOrder $workOrderRepo)
    {
        
        $updateedFile = $request->file('file');
        $filename = $updateedFile->getClientOriginalName();
  
        Storage::disk('local')->putFileAs(
          'files',
          $updateedFile,
          $filename
        );

        // leer csv
        // insertar valores
        $filename1 = storage_path('app\files\\' . $filename);
        $handle = fopen($filename1, "r");
        $header = true;

        $no_se = [];
        while ($csvLine = fgetcsv($handle, 1000, ";")) {
            if ($header) {
                $header = false;
            } else {
                $work_order = $workOrderRepo->find($csvLine[0]);
                if (is_null($work_order)) {
                    $no_se[$csvLine[0]] = 'No existe';
                }
                else {
                    $work_order->status = 'Agendada';
                    $work_order->date = Carbon::parse($csvLine[1],'America/Guayaquil');
                    $work_order->save();
                    $no_se[$csvLine[0]] = 'Ok';
                }
            }
        }
        
        return response()->json(['count' => count($no_se), 'detail' => $no_se, 'status' => 'ok']);
    }

    public function executeSps() {
        $usuario = getenv('DB_USERNAME');
        $password =getenv('DB_PASSWORD');
        $servidor = getenv('DB_HOST');
        $basededatos = getenv('DB_DATABASE');
    
        DB::select('call distancia_entre');
        DB::select('call sp_fila_columna');
        // creación de la conexión a la base de datos con mysql_connect()
        $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
        
        // Selección del a base de datos a utilizar
        $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
        // establecer y realizar consulta. guardamos en variable.
        $consulta = "SELECT * 
                    FROM distancia_dealers";
        $resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
        $resultado2 = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
        
        $i=0;
        $nConfig = mysqli_num_rows ($resultado);
        $nConfigF = mysqli_num_fields ($resultado);

        // Bucle while que recorre cada registro y muestra cada campo en la tabla.
    
        while ($columna = mysqli_fetch_array( $resultado ))
        {

            $k = 0;
            for ($j = 0; $j < $nConfig ; $j++)
            {

                if($k < $nConfigF-1) 
                {

                    $array[$i][$j]=$columna[$k];
                    $k++;
                }
                else 
                {
                
                $k=0;
                $array[$i][$j]=$columna[$k];
                $k++;
                } 


            }
            $i++;
        }
        
        $i=0;
        while ($fila = mysqli_fetch_row($resultado2)) 
        {
            $array_dealer[$i][0]=$fila[0];
            $i++;
        }
        
        // cerrar conexión de base de datos
        mysqli_close( $conexion );

        
        $hungarian = new HungarianBipatiteMatching($array);
        $result = $hungarian->execute();

        for ($j = 0; $j < $nConfig ; $j++)
        {
            $array_dealer[$j][1]=$result[$j];
        }

        $conexion2 = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
    
        // Selección del a base de datos a utilizar
        $db2 = mysqli_select_db( $conexion2, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );  
        $query = "INSERT INTO `$basededatos`.`dealer_asignado` (CUSTOMER_ID,ID_DEALER) VALUES "; 
        for ($j = 0; $j < $nConfig ; $j++) 
        {
            $fieldVal1 = (int) $array_dealer[$j][0];
            $fieldVal2 = (int) $array_dealer[$j][1];
            $fieldVal2 = $fieldVal2 % ($nConfigF-1);
            $fieldVal2 = $fieldVal2 + 1;
            $valuesArr[] = "('$fieldVal1', '$fieldVal2')"; 
        }
        $query .= implode(',', $valuesArr);
        mysqli_query($conexion2,$query) or die ( "Algo ha ido mal en la consulta a la base de datos");
        mysqli_close( $conexion2 );
        DB::select('call asignacion_wo');
        return response()->json(['status' => 'ok']);
    }

    /**
     * @param Dealer $dealerRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLiveData(Dealer $dealerRepository)
    {
        $data = $dealerRepository->select('id', 'name', 'address', 'latitude', 'longitude')->get();
        return response()->json($data);
    }

}
