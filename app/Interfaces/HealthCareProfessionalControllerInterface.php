<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface HealthCareProfessionalControllerInterface
{
    public function index(): JsonResponse;
}
