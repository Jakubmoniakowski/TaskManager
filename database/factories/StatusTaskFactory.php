<?php

namespace Database\Factories;

use App\Models\StatusTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusTaskFactory extends Factory
{
    protected $model = StatusTask::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->slug(),
        ];
    }
}
