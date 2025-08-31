<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'Active', 'code' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Unactive', 'code' => 'unactive', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
