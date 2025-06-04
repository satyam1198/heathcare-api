<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface AppointmentRepositoryInterface
{
    public function getUserAppointments(int $userId);
    public function bookAppointment(Request $request);
    public function cancelAppointment(int $id, int $userId);
    public function completeAppointment(int $id, int $userId);
}
