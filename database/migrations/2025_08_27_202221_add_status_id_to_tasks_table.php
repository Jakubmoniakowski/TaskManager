<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 🔹 dodajemy kolumnę status_id z domyślną wartością = 1 (Active)
            $table->foreignId('status_id')
                ->default(1)
                ->after('completed') // pojawi się zaraz po kolumnie "completed"
                ->constrained('statuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // cofnięcie zmian
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
