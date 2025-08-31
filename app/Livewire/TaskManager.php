<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\StatusTask;
use Livewire\WithPagination;
use App\Filters\TaskFilter;

class TaskManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $title;
    public $description;
    public $status_task_id;
    public $observer_id = null;
    public $due_date;
    public $search_due_date;
    public $showModal = false;
    public $editMode = false;
    public $editTaskId = null;
    public $viewMode = false;
    public $currentTask = null;

    public $searchTitle = '';
    public $searchDescription = '';
    public $status;
    public $search = '';

    protected function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'required|string|max:255',
            'status_task_id' => 'required|exists:status_tasks,id',
            'due_date'       => 'required|date',
            'observer_id'    => 'nullable|exists:users,id',
        ];
    }

    public function addTask()
    {
        $validated = $this->validate();

        $activeStatus = Status::where('code', 'active')->firstOrFail();

        $task = Task::create([
            'user_id'        => Auth::id(),
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? null,
            'status_task_id' => $validated['status_task_id'],
            'status_id'      => $activeStatus->id,
            'due_date'       => $validated['due_date'] ?? null,
        ]);

        if (!empty($validated['observer_id'])) {
            $task->observer()->create([
                'user_id' => $validated['observer_id'],
            ]);
        }

        $this->reset(['title', 'description', 'observer_id', 'status_task_id', 'due_date', 'showModal']);
        $this->resetPage();

        session()->flash('message', [
            'text' => 'Zadanie zostało dodane!',
            'type' => 'success'
        ]);
    }

    public function viewTask($taskId)
    {
        $this->resetValidation();
        $this->editMode = false;
        $this->viewMode = true;

        $this->currentTask = Task::getActiveQueryForUser(Auth::id())
            ->with(['statusTask', 'observer.user'])
            ->findOrFail($taskId);

        $this->showModal = true;
    }


    public function deleteTask($taskId)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($taskId);

        $unactiveStatus = Status::where('code', 'unactive')->firstOrFail();

        $task->update([
            'status_id' => $unactiveStatus->id,
        ]);

        session()->flash('message', [
            'text' => 'Zadanie zostało usunięte!',
            'type' => 'error'
        ]);
        $this->dispatch('$refresh'); // wymusi rerender komponentu
    }

    public function editTask($taskId)
    {
        $this->resetValidation();
        $task = Task::where('user_id', Auth::id())
            ->with('observer')
            ->findOrFail($taskId);

        $this->editMode       = true;
        $this->editTaskId     = $task->id;
        $this->title          = $task->title;
        $this->description    = $task->description;
        $this->status_task_id = $task->status_task_id;
        $this->due_date       = $task->due_date?->format('Y-m-d');
        $this->observer_id    = $task->observer?->user_id;

        $this->showModal = true;
    }

    public function updateTask()
    {
        $validated = $this->validate();

        $task = Task::where('user_id', Auth::id())->findOrFail($this->editTaskId);
        $task->update($validated);

        if ($this->observer_id) {
            $task->observer()->updateOrCreate(
                ['task_id' => $task->id],
                ['user_id' => $this->observer_id]
            );
        }

        $this->resetForm();

        session()->flash('message', [
            'text' => 'Zadanie zostało zaktualizowane!',
            'type' => 'success'
        ]);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->editMode = false;
        $this->viewMode = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'observer_id',
            'status_task_id',
            'due_date',
            'showModal',
            'editMode',
            'editTaskId',
            'viewMode',
            'currentTask',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::withoutCurrent(Auth::id())->get();

        $filter = new TaskFilter(
            $this->searchTitle,
            $this->searchDescription,
            $this->status,
            $this->search_due_date
        );

        $query = Task::getActiveQueryForUser(Auth::id());

        $tasks = $filter->apply($query)
            ->paginate(5)
            ->withPath(route('dashboard'));

        return view('livewire.task-manager', [
            'tasks'    => $tasks,
            'statuses' => StatusTask::all(),
            'users'    => $users,
        ]);
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'searchTitle',
            'searchDescription',
            'status',
            'search_due_date',
        ]);

        $this->resetPage();
    }
}
