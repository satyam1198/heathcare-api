<?php

namespace App\Http\Controllers;

use App\Interfaces\HealthCareProfessionalControllerInterface;
use App\Models\HealthcareProfessional;
use Illuminate\Http\JsonResponse;


class HealthcareProfessionalController extends Controller implements HealthCareProfessionalControllerInterface
{
    /**
     * Display a listing of healthcare professionals.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $professionals = HealthcareProfessional::all();

        return response()->json([
            'healthcare_professionals' => $professionals,
        ]);
    }
}
