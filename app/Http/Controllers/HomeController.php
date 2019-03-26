<?php

namespace App\Http\Controllers;

use App\Dealer;
use Illuminate\Http\Request;

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

    public function upload()
    {
        return view('upload');
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
