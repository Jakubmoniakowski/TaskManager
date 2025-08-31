<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use App\Models\StatusTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'user_id'        => User::factory(),
            'title'          => $this->faker->sentence,
            'description'    => $this->faker->optional()->sentence,
            'status_id'      => Status::factory()->state(['code' => 'active']),
            'status_task_id' => StatusTask::factory(),
            'due_date'       => $this->faker->optional()->date(),
        ];
    }
}
