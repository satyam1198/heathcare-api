<?php

namespace App\Http\Controllers;

use App\Interfaces\AppointmentControllerInterface;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AppointmentController extends Controller  implements AppointmentControllerInterface
{

    public function __construct(protected AppointmentRepositoryInterface $appointmentRepository) {}

    /**
     * Display a listing of the user's appointments.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $appointments = $this->appointmentRepository->getUserAppointments(auth()->id());

        return response()->json([
            'appointments' => $appointments,
        ]);
    }


    /**
     * Book a new appointment.
     *
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function book(Request $request) :JsonResponse
    {
        $appointment = $this->appointmentRepository->bookAppointment($request);

        if (isset($appointment['error'])) {
            return response()->json(['message' => $appointment['error']], 409);
        }

        return response()->json([
            'message' => 'Appointment booked successfully.',
            'appointment' => $appointment
        ], 201);
    }

    /**
     * Cancel an existing appointment of ony loged in user.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function cancel(int $id) :JsonResponse
    {        
        try {
            $result = $this->appointmentRepository->cancelAppointment($id, auth()->id());

            if (isset($result['error'])) {
                return response()->json(['message' => $result['error']], 403);
            }

            return response()->json(['message' => 'Cancelled Successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
    }

    /**
     * Mark an appointment as completed.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function markAsCompleted(int $id) :JsonResponse
    {
        try {
            $appointment = $this->appointmentRepository->completeAppointment($id, auth()->id());
            
            return response()->json(['message' => 'Completed', 'appointment' => $appointment]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found'], 404);
        }
    }
}
