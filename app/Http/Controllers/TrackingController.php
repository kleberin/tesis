<?php

namespace App\Http\Controllers;

use App\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
