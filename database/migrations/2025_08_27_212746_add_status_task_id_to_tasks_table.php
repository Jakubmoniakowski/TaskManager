<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('status_task_id')->nullable()->after('description');

            $table->foreign('status_task_id')
                ->references('id')
                ->on('status_tasks')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['status_task_id']);
            $table->dropColumn('status_task_id');
        });
    }
};
