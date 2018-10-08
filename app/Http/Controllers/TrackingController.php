<?php

namespace App\Http\Controllers;

use App\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    /** @var Tracking */
    private $trackingRepo;

    /**
     * TrackingController constructor.
     *
     * @param Tracking $trackingRepo
     */
    public function __construct(Tracking $trackingRepo)
    {
        $this->trackingRepo = $trackingRepo;
    }

    /**
     *
     * @param Request $request
     */
    public function postLocationUpdates(Request $request)
    {
        $locations = $request->all();
        $userId = Auth::id();
        $uploaded = 0;

        foreach ($locations as $location)
        {
            /** @var Tracking $tracking */
            $this->trackingRepo->create([
                'user_id' => $userId,
                'reported_at' => Carbon::parse($location['timestamp'])->setTimezone('UTC'),
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'accuracy' => $location['accuracy']
            ]);

            $uploaded++;
        }

        return response()->json([
            'status' => 1,
            'uploaded' => $uploaded
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLiveData()
    {
        $today = Carbon::today();
        $today->addHours(5);
        $lastTracking = DB::table('trackings')
            ->select('user_id', DB::raw('MAX(id) as id'))
            ->groupBy('user_id');
        $data = $this->trackingRepo
            ->select('trackings.id', 'users.name', 'trackings.latitude', 'trackings.longitude', 'trackings.reported_at')
            ->join('users', 'trackings.user_id', '=', 'users.id')
            ->joinSub($lastTracking, 't1', function ($join) {
                $join->on('trackings.id', '=', 't1.id');
            })
            ->where('reported_at', '>=', $today)
            ->get();
        return response()->json($data);
    }
}
