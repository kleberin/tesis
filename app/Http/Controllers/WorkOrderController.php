<?php

namespace App\Http\Controllers;

use App\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    /** @var WorkOrder */
    private $workOrderRepo;

    /**
     * WorkOrderController constructor.
     *
     * @param WorkOrder $workOrderRepo
     */
    public function __construct(WorkOrder $workOrderRepo)
    {
        $this->workOrderRepo = $workOrderRepo;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLiveData(Request $request)
    {
        /** @var array $dealerIds */
        $dealerIds = $request->query('dealerIds');

        $from = Carbon::today('America/Guayaquil');
        $from->addHours(5);
        $to = Carbon::today('America/Guayaquil');
        $to->addHours(29);
        $qb = $this->workOrderRepo
            ->join('customers', 'customers.id', 'work_orders.customer_id')
            ->join('users', 'users.id', 'work_orders.user_id')
            ->select('work_orders.id', 'work_orders.status', 'work_orders.date', 'customers.latitude', 'customers.longitude')
            ->where('status', 'Agendada')
            ->where('date', '>=', $from)
            ->where('date', '<=', $to);
        
        if ($dealerIds == null) {
            $user = Auth::user();
            if ($user->role_id != 3)
                $qb->where('users.dealer_id', $user->dealer_id);
        }
        else {
            $qb->whereIn('users.dealer_id', $dealerIds);
        }

        $data = $qb->get();        
        return response()->json($data);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCreatedData()
    {
        $data = $this->workOrderRepo
            ->join('customers', 'customers.id', 'work_orders.customer_id')
            ->select('work_orders.id', 'work_orders.status', 'work_orders.date', 'customers.latitude', 'customers.longitude')
            ->where('status', 'Creada')
            ->get();
        return response()->json($data);
    }

    public function getAsigdData(Request $request)
    {
        /** @var array $dealerIds */
        $dealerIds = $request->query('dealerIds');

        $qb = $this->workOrderRepo
            ->join('customers', 'customers.id', 'work_orders.customer_id')
            ->join('dealers', 'dealers.id', 'work_orders.dealer_id')
            ->select('work_orders.id', 'work_orders.status', 'work_orders.date', 'customers.latitude', 'customers.longitude')
            ->where('status', 'Asignada');

        if ($dealerIds == null) {
            $user = Auth::user();
            if ($user->role_id != 3)
                $qb->where('dealers.id', $user->dealer_id);
        }
        else {
            $qb->whereIn('dealers.id', $dealerIds);
        }

        $data = $qb->get();
        return response()->json($data);
    }
}
