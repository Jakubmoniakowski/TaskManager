<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamp('created_at')->useCurrent();
        });

        // wstawienie podstawowych statusów
        DB::table('status_tasks')->insert([
            ['id' => 1, 'name' => 'Otwarte',    'code' => 'open',        'created_at' => now()],
            ['id' => 2, 'name' => 'W trakcie',  'code' => 'in_progress', 'created_at' => now()],
            ['id' => 3, 'name' => 'Zakończone', 'code' => 'done',        'created_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status_tasks');
    }
};
