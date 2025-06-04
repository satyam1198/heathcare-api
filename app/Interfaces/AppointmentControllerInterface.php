<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AppointmentControllerInterface
{
    public function index(): JsonResponse;

    public function book(Request $request): JsonResponse;

    public function cancel(int $id): JsonResponse;

    public function markAsCompleted(int $id): JsonResponse;
}
