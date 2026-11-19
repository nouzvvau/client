<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('students')) {
            return;
        }

        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (! Schema::hasColumn('students', 'class')) {
                $table->string('class')->nullable()->after('name');
            }
        });

        if (Schema::hasColumn('students', 'full_name')) {
            DB::table('students')
                ->whereNull('name')
                ->update(['name' => DB::raw('full_name')]);
        }

        if (
            Schema::hasColumn('students', 'class')
            && Schema::hasTable('program_student')
            && Schema::hasTable('programs')
        ) {
            $memberships = DB::table('program_student')
                ->join('programs', 'programs.id', '=', 'program_student.program_id')
                ->select('program_student.student_id', 'programs.name')
                ->orderBy('program_student.program_id')
                ->get();

            foreach ($memberships as $membership) {
                DB::table('students')
                    ->where('id', $membership->student_id)
                    ->whereNull('class')
                    ->update(['class' => $membership->name]);
            }
        }

        $legacyColumns = array_values(array_filter([
            'full_name',
            'birth_date',
            'guardian_name',
            'contact_phone',
            'address',
            'joined_at',
            'status',
            'created_at',
            'updated_at',
        ], fn (string $column): bool => Schema::hasColumn('students', $column)));

        if ($legacyColumns !== []) {
            Schema::table('students', function (Blueprint $table) use ($legacyColumns) {
                $table->dropColumn($legacyColumns);
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('students')) {
            return;
        }

        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'full_name')) {
                $table->string('full_name')->nullable()->after('id');
            }

            if (! Schema::hasColumn('students', 'birth_date')) {
                $table->date('birth_date')->nullable();
            }

            if (! Schema::hasColumn('students', 'guardian_name')) {
                $table->string('guardian_name')->nullable();
            }

            if (! Schema::hasColumn('students', 'contact_phone')) {
                $table->string('contact_phone')->nullable();
            }

            if (! Schema::hasColumn('students', 'address')) {
                $table->text('address')->nullable();
            }

            if (! Schema::hasColumn('students', 'joined_at')) {
                $table->date('joined_at')->nullable();
            }

            if (! Schema::hasColumn('students', 'status')) {
                $table->string('status')->default('active');
            }

            if (! Schema::hasColumn('students', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (! Schema::hasColumn('students', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }
};
