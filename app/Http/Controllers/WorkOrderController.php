<?php

namespace App\Http\Controllers;

use App\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLiveData()
    {
        $from = Carbon::today('America/Guayaquil');
        $from->addHours(5);
        $to = Carbon::today('America/Guayaquil');
        $to->addHours(29);
        $data = $this->workOrderRepo
            ->join('customers', 'customers.id', 'work_orders.customer_id')
            ->select('work_orders.id', 'work_orders.status', 'work_orders.date', 'customers.latitude', 'customers.longitude')
            ->where('status', 'Agendada')
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->get();
        return response()->json($data);
    }
}
