<?php

namespace App\Http\Controllers;

use App\Dealer;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
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
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Dealer $dealerRepo) {
        /** @var User $user */
        $user = Auth::user();

        $qb = $dealerRepo->select('id', 'name');
        if ($user->role_id == 3) {
            $dealers = $qb->orderBy('name');
        }
        else {
            $dealers = $qb->where('id', $user->dealer_id);
        }

        $data = $qb->get();
        return response()->json($data);
    }
}