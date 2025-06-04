<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     *  Retrieve all appointments for a specific user.
     *  @param int $userId
     * 
     *  @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserAppointments(int $userId)
    {
        return Appointment::with('healthcareProfessional')->where('user_id', $userId)->get();
    }

    /**
     * Book a new appointment for the authenticated user.
     *
     * @param Request $request
     * 
     * @return Appointment|\Illuminate\Http\JsonResponse
     */
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'healthcare_professional_id' => 'required|exists:healthcare_professionals,id',
            'appointment_start_time' => 'required',
            'appointment_end_time' => 'required',
        ]);

        $conflict = Appointment::where('healthcare_professional_id', $validated['healthcare_professional_id'])
            ->where('status', 'booked')
            ->where(function ($query) use ($validated) {
                $query->where('appointment_start_time', '<', $validated['appointment_end_time'])
                      ->where('appointment_end_time', '>', $validated['appointment_start_time']);
            })->exists();

        if ($conflict) {
            return ['error' => 'Time slot unavailable.'];
        }

        return Appointment::create([
            'user_id' => Auth::id(),
            'healthcare_professional_id' => $validated['healthcare_professional_id'],
            'appointment_start_time' => $validated['appointment_start_time'],
            'appointment_end_time' => $validated['appointment_end_time'],
            'status' => 'booked',
        ]);
    }

    /**
     * Cancel an existing appointment for the authenticated user.
     *
     * @param int $id
     * @param int $userId
     * 
     * @return Appointment|\Illuminate\Http\JsonResponse
     */
    public function cancelAppointment(int $id, int $userId)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if (Carbon::parse($appointment->appointment_start_time)->diffInHours(now()) < 24) {
            return ['error' => 'Cannot cancel within 24 hours.'];
        }

        $appointment->update(['status' => 'cancelled']);
        return $appointment;
    }

    /**
     * Complete an existing appointment for the authenticated user.
     *
     * @param int $id
     * @param int $userId
     * 
     * @return Appointment
     */
    public function completeAppointment(int $id, int $userId)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $appointment->update(['status' => 'completed']);
        return $appointment;
    }
}
