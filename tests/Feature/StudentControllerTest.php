<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_index_returns_students_with_their_programs(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $student = $this->createStudent();
        $student->programs()->attach($program->id, ['status' => 'active']);

        $this->getJson('/api/students')
            ->assertOk()
            ->assertJsonPath('0.id', $student->id)
            ->assertJsonPath('0.programs.0.id', $program->id)
            ->assertJsonPath('0.programs.0.pivot.status', 'active');
    }

    public function test_valid_payload_creates_student_and_returns_201(): void
    {
        $this->postJson('/api/students', [
            'full_name' => 'Citra Lestari',
            'birth_date' => '2017-03-15',
            'guardian_name' => 'Rina Lestari',
            'contact_phone' => '081234567890',
            'address' => 'Tulungagung',
            'joined_at' => '2026-01-10',
        ])
            ->assertCreated()
            ->assertJsonPath('data.full_name', 'Citra Lestari')
            ->assertJsonPath('data.status', 'active');

        $this->assertDatabaseHas('students', [
            'full_name' => 'Citra Lestari',
            'status' => 'active',
        ]);
    }

    public function test_show_returns_student_with_its_programs(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $student = $this->createStudent();
        $student->programs()->attach($program->id);

        $this->getJson("/api/students/{$student->id}")
            ->assertOk()
            ->assertJsonPath('id', $student->id)
            ->assertJsonPath('programs.0.id', $program->id);
    }

    public function test_valid_payload_updates_student_and_returns_200(): void
    {
        $student = $this->createStudent();

        $this->putJson("/api/students/{$student->id}", [
            'full_name' => 'Budi Santoso Jaya',
            'contact_phone' => '081234567899',
            'status' => 'inactive',
        ])
            ->assertOk()
            ->assertJsonPath('data.full_name', 'Budi Santoso Jaya')
            ->assertJsonPath('data.status', 'inactive');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'full_name' => 'Budi Santoso Jaya',
            'status' => 'inactive',
        ]);
    }

    public function test_destroy_removes_student_and_returns_200(): void
    {
        $student = $this->createStudent();

        $this->deleteJson("/api/students/{$student->id}")
            ->assertOk();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_destroy_is_blocked_when_student_still_has_programs(): void
    {
        $program = Program::create(['name' => 'Program Tari']);
        $student = $this->createStudent();
        $student->programs()->attach($program->id);

        $this->deleteJson("/api/students/{$student->id}")
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Murid masih memiliki hubungan dengan program. Lepaskan dari program terlebih dahulu.');

        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }

    public function test_returns_422_when_creating_student_with_missing_required_data(): void
    {
        $this->postJson('/api/students', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['full_name']);
    }

    public function test_returns_422_when_creating_student_with_invalid_column_values(): void
    {
        $this->postJson('/api/students', [
            'full_name' => str_repeat('a', 256),
            'birth_date' => '2100-01-01',
            'guardian_name' => str_repeat('b', 256),
            'contact_phone' => str_repeat('1', 21),
            'address' => ['invalid'],
            'joined_at' => 'bukan-tanggal',
            'status' => 'invalid',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'full_name',
                'birth_date',
                'guardian_name',
                'contact_phone',
                'address',
                'joined_at',
                'status',
            ]);
    }

    public function test_returns_422_when_updating_student_with_invalid_birth_date(): void
    {
        $student = $this->createStudent();

        $this->putJson("/api/students/{$student->id}", [
            'birth_date' => '2100-01-01',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['birth_date']);
    }

    public function test_returns_404_when_student_does_not_exist(): void
    {
        $this->getJson('/api/students/999')
            ->assertNotFound();
    }

    private function createStudent(array $attributes = []): Student
    {
        return Student::create([
            'full_name' => 'Budi Santoso',
            'birth_date' => '2016-05-10',
            'guardian_name' => 'Siti Santoso',
            'contact_phone' => '081234567891',
            'address' => 'Tulungagung',
            ...$attributes,
        ]);
    }
}
