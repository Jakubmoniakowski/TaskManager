<?php

use App\Livewire\TaskManager;
use App\Models\User;
use App\Models\Status;
use App\Models\StatusTask;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->statusTask = StatusTask::factory()->create(['code' => 'open']);
    $this->statusActive = Status::factory()->create(['code' => 'active']);
    $this->actingAs($this->user);
});

it('Nie można dodać zadania bez tytułu', function () {
    Livewire::test(TaskManager::class)
        ->set('title', '')
        ->set('status_task_id', $this->statusTask->id)
        ->call('addTask')
        ->assertHasErrors(['title' => 'required']);
});

it('Nie można dodać zadania ze zbyt długim tytułem', function () {
    Livewire::test(TaskManager::class)
        ->set('title', str_repeat('a', 260))
        ->set('status_task_id', $this->statusTask->id)
        ->call('addTask')
        ->assertHasErrors(['title' => 'max']);
});

it('Nie można dodać zadania ze złym statusem zadania', function () {
    Livewire::test(TaskManager::class)
        ->set('title', 'Poprawny tytuł')
        ->set('status_task_id', 9999)
        ->call('addTask')
        ->assertHasErrors(['status_task_id' => 'exists']);
});

it('Nie można dodać zadania z błędną datą', function () {
    Livewire::test(TaskManager::class)
        ->set('title', 'Testowe zadanie')
        ->set('status_task_id', $this->statusTask->id)
        ->set('due_date', '2025-99-99')
        ->call('addTask')
        ->assertHasErrors(['due_date' => 'date']);
});
