<?php

use App\Livewire\TaskManager;
use App\Models\User;
use App\Models\Task;
use App\Models\Status;
use App\Models\StatusTask;
use Livewire\Livewire;

it('Dodaje nowe zadanie', function () {
    $user = User::factory()->create();
    $statusTask = StatusTask::factory()->create(['code' => 'open']);
    $statusActive = Status::factory()->create(['code' => 'active']);

    $this->actingAs($user);

    Livewire::test(TaskManager::class)
        ->set('title', 'Testowe zadanie')
        ->set('description', 'Opis zadania')
        ->set('status_task_id', $statusTask->id)
        ->call('addTask');

    $task = Task::first();

    expect($task)
        ->not->toBeNull()
        ->and($task->title)->toBe('Testowe zadanie')
        ->and($task->description)->toBe('Opis zadania')
        ->and($task->statusTask->code)->toBe('open')
        ->and($task->status->code)->toBe('active');
});

it('Edytuje istniejące zadanie', function () {
    $user = User::factory()->create();
    $statusTask = StatusTask::factory()->create(['code' => 'open']);
    $statusActive = Status::factory()->create(['code' => 'active']);

    $task = Task::factory()->create([
        'user_id'        => $user->id,
        'title'          => 'Stare zadanie',
        'description'    => 'Stary opis',
        'status_id'      => $statusActive->id,
        'status_task_id' => $statusTask->id,
    ]);

    $this->actingAs($user);

    Livewire::test(TaskManager::class)
        ->call('editTask', $task->id)
        ->set('title', 'Nowe zadanie')
        ->set('description', 'Nowy opis')
        ->set('status_task_id', $statusTask->id)
        ->call('updateTask');

    $task->refresh();

    expect($task->title)->toBe('Nowe zadanie')
        ->and($task->description)->toBe('Nowy opis')
        ->and($task->statusTask->code)->toBe('open')
        ->and($task->status->code)->toBe('active');
});

it('Usuwa zadanie (oznacza jako unactive)', function () {
    $user = User::factory()->create();
    $statusTask = StatusTask::factory()->create(['code' => 'open']);
    $statusActive = Status::factory()->create(['code' => 'active']);
    Status::factory()->create(['code' => 'unactive']);

    $task = Task::factory()->create([
        'user_id'        => $user->id,
        'status_id'      => $statusActive->id,
        'status_task_id' => $statusTask->id,
    ]);

    $this->actingAs($user);

    Livewire::test(TaskManager::class)
        ->call('deleteTask', $task->id);

    $task->refresh();

    expect($task->status->code)->toBe('unactive');
});
