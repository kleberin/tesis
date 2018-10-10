<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /** @var User */
    private $userRepo;

    /**
     * TecnicianController constructor.
     *
     * @param User $userRepo
     */
    public function __construct(User $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $id)
    {
        /** @var User $technician */
        $technician = $this->userRepo->findOrFail($id);

        return response()->json($technician);
    }
}
