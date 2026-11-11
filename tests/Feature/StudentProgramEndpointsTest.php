<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentProgramEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_added_to_a_program(): void
    {
        $student = Student::create(['full_name' => 'Murid Uji']);
        $program = Program::create(['name' => 'Program Uji']);

        $this->postJson("/api/students/{$student->id}/programs", [
            'program_id' => $program->id,
            'joined_at' => '2026-01-15',
        ])->assertCreated();

        $this->assertDatabaseHas('program_student', [
            'student_id' => $student->id,
            'program_id' => $program->id,
            'status' => 'active',
            'joined_at' => '2026-01-15',
        ]);
    }

    public function test_student_program_membership_can_be_updated_and_removed(): void
    {
        $student = Student::create(['full_name' => 'Murid Uji']);
        $program = Program::create(['name' => 'Program Uji']);
        $student->programs()->attach($program->id, ['status' => 'active']);

        $this->putJson("/api/students/{$student->id}/programs/{$program->id}", [
            'status' => 'inactive',
        ])->assertOk();

        $this->assertDatabaseHas('program_student', [
            'student_id' => $student->id,
            'program_id' => $program->id,
            'status' => 'inactive',
        ]);

        $this->deleteJson("/api/students/{$student->id}/programs/{$program->id}")
            ->assertOk();

        $this->assertDatabaseMissing('program_student', [
            'student_id' => $student->id,
            'program_id' => $program->id,
        ]);
    }

    public function test_empty_update_payload_is_rejected(): void
    {
        $student = Student::create(['full_name' => 'Murid Uji']);
        $program = Program::create(['name' => 'Program Uji']);
        $student->programs()->attach($program->id, ['status' => 'active']);

        $this->putJson("/api/students/{$student->id}/programs/{$program->id}", [])
            ->assertUnprocessable();
    }
}
