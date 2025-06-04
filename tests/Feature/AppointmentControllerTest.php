<?php

namespace Tests\Feature;

use App\Http\Controllers\AppointmentController;
use App\Models\User;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;


class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $mockRepo;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepo = Mockery::mock(AppointmentRepositoryInterface::class);
        $this->app->instance(AppointmentRepositoryInterface::class, $this->mockRepo);

        $this->controller = new AppointmentController($this->mockRepo);

        // Simulate logged-in user
        $this->actingAs(AuthUser::factory()->create());
    }

    /** @test */
    public function it_returns_user_appointments()
    {
        $fakeAppointments = [['id' => 1, 'status' => 'booked']];
        $this->mockRepo->shouldReceive('getUserAppointments')
            ->once()
            ->with(Auth::id())
            ->andReturn($fakeAppointments);

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(['appointments' => $fakeAppointments], $response->getData(true));
    }

    // /** @test */
    // public function it_books_an_appointment_successfully()
    // {
    //     $request = Request::create('/api/appointments', 'POST', [
    //         'healthcare_professional_id' => 1,
    //         'appointment_start_time' => now()->toDateTimeString(),
    //         'appointment_end_time' => now()->addHour()->toDateTimeString(),
    //     ]);

    //     $appointmentData = ['id' => 1, 'status' => 'booked'];

    //     $this->mockRepo->shouldReceive('bookAppointment')
    //         ->once()
    //         ->with($request)
    //         ->andReturn($appointmentData);

    //     $response = $this->controller->book($request);

    //     $this->assertEquals(201, $response->status());
    //     $this->assertEquals([
    //         'message' => 'Appointment booked successfully.',
    //         'appointment' => $appointmentData
    //     ], $response->getData(true));
    // }

    // /** @test */
    // public function it_fails_to_book_due_to_conflict()
    // {
    //     $request = Request::create('/api/appointments', 'POST', []);

    //     $this->mockRepo->shouldReceive('bookAppointment')
    //         ->once()
    //         ->with($request)
    //         ->andReturn(['error' => 'Time slot unavailable.']);

    //     $response = $this->controller->book($request);

    //     $this->assertEquals(409, $response->status());
    //     $this->assertEquals(['message' => 'Time slot unavailable.'], $response->getData(true));
    // }

    // /** @test */
    // public function it_cancels_an_appointment_successfully()
    // {
    //     $this->mockRepo->shouldReceive('cancelAppointment')
    //         ->once()
    //         ->with(1, Auth::id())
    //         ->andReturn(['id' => 1, 'status' => 'cancelled']);

    //     $response = $this->controller->cancel(1);

    //     $this->assertEquals(200, $response->status());
    //     $this->assertEquals(['message' => 'Cancelled Successfully'], $response->getData(true));
    // }

    // /** @test */
    // public function it_prevents_cancel_if_less_than_24_hours()
    // {
    //     $this->mockRepo->shouldReceive('cancelAppointment')
    //         ->once()
    //         ->with(1, Auth::id())
    //         ->andReturn(['error' => 'Cannot cancel within 24 hours.']);

    //     $response = $this->controller->cancel(1);

    //     $this->assertEquals(403, $response->status());
    //     $this->assertEquals(['message' => 'Cannot cancel within 24 hours.'], $response->getData(true));
    // }

    // /** @test */
    // public function it_marks_appointment_as_completed()
    // {
    //     $this->mockRepo->shouldReceive('completeAppointment')
    //         ->once()
    //         ->with(1, Auth::id())
    //         ->andReturn(['id' => 1, 'status' => 'completed']);

    //     $response = $this->controller->markAsCompleted(1);

    //     $this->assertEquals(200, $response->status());
    //     $this->assertEquals([
    //         'message' => 'Completed',
    //         'appointment' => ['id' => 1, 'status' => 'completed']
    //     ], $response->getData(true));
    // }

    // /** @test */
    // public function it_returns_404_if_completion_fails()
    // {
    //     $this->mockRepo->shouldReceive('completeAppointment')
    //         ->once()
    //         ->with(1, Auth::id())
    //         ->andThrow(new \Exception());

    //     $response = $this->controller->markAsCompleted(1);

    //     $this->assertEquals(404, $response->status());
    //     $this->assertEquals(['message' => 'Not found'], $response->getData(true));
    // }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
