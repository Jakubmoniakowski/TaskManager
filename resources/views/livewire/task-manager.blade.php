<div class="w-full">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-9">
            <button wire:click="openModal" class="bg-green-600 text-white px-4 py-2 rounded mb-4">
                Dodaj zadanie
            </button>

            @if($showModal)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded shadow-lg w-1/3">
                        <h2 class="text-lg font-bold mb-4">
                            @if($editMode)
                                Edytuj zadanie
                            @elseif($viewMode)
                                Podgląd zadania
                            @else
                                Dodaj nowe zadanie
                            @endif
                        </h2>

                        @if(!$viewMode)
                            {{-- Formularz dodawania/edycji --}}
                            <form wire:submit.prevent="{{ $editMode ? 'updateTask' : 'addTask' }}" class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tytuł</label>
                                    <input type="text" id="title" wire:model="title"
                                           class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Opis</label>
                                    <textarea id="description" wire:model="description"
                                              class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="observer_id" class="block text-sm font-medium text-gray-700 mb-1">Obserwator</label>
                                    <select id="observer_id" wire:model="observer_id"
                                            class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">-- wybierz obserwatora --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('observer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="status_task_id" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select id="status_task_id" wire:model="status_task_id"
                                            class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <option value="">-- wybierz status --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_task_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Termin</label>
                                    <input type="date" id="due_date" wire:model="due_date"
                                           class="border p-2 w-full rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" wire:click="closeModal" class="px-4 py-2 mr-2 bg-gray-300 rounded">
                                        Anuluj
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                        {{ $editMode ? 'Zapisz zmiany' : 'Dodaj' }}
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="space-y-3">
                                <p><strong>Założyciel:</strong> {{ $currentTask->user?->name ?? '-' }}</p>
                                <p><strong>Tytuł:</strong> {{ $currentTask->title }}</p>
                                <p><strong>Opis:</strong> {{ $currentTask->description }}</p>
                                <p><strong>Obserwator:</strong> {{ $currentTask->observer?->user->name ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ $currentTask->statusTask?->name }}</p>
                                <p><strong>Termin:</strong> {{ $currentTask->due_date ? $currentTask->due_date->format('Y-m-d') : '-' }}</p>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded">Zamknij</button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if (session()->has('message'))
                @php
                    $msg = session('message');
                    $color = $msg['type'] === 'error' ? 'bg-red-500' : 'bg-green-500';
                @endphp

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition.opacity.duration.500ms
                    x-init="setTimeout(() => show = false, 3000)"
                    class="fixed inset-0 flex items-start justify-center mt-20 z-50"
                    style="pointer-events: none;"
                >
                    <div class="{{ $color }} text-white px-6 py-3 rounded-lg shadow-lg text-center">
                        {{ $msg['text'] }}
                    </div>
                </div>
            @endif

            <h2 class="text-lg font-bold text-center mb-1">Twoje zadania</h2>
            <ul class="space-y-1">
                @forelse($tasks as $task)
                    <li class="p-1 bg-white rounded border flex justify-between items-center text-sm">
                    <div>
                            <p class="font-semibold">{{ $task->title }}</p>
                            <p class="text-sm text-gray-600">{{ $task->description }}</p>
                            <p class="text-xs text-gray-400">Termin: {{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</p>
                        </div>
                        <div class="space-x-2">
                            <button type="button" wire:click="viewTask({{ $task->id }})" class="px-2 py-1 bg-blue-500 text-white rounded">
                                Otwórz
                            </button>
                            @if($task->canEdit())
                                <button type="button" wire:click="editTask({{ $task->id }})" class="px-2 py-1 bg-yellow-500 text-white rounded">
                                    Edytuj
                                </button>
                            @endif

                            @if($task->canDelete())
                                <button type="button" wire:click="deleteTask({{ $task->id }})" class="px-2 py-1 bg-red-500 text-white rounded">
                                    Usuń
                                </button>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500 text-center py-4">Brak zadań</li>
                @endforelse
            </ul>

            <div class="mt-6 flex justify-center">
                {{ $tasks->links() }}
            </div>
        </div>

        <div class="col-span-12 lg:col-span-3">
            <h2 class="text-lg font-bold text-center mb-4"></h2>
            <div class="p-0 bg-white shadow rounded space-y-4">
                <input type="text" wire:model.defer="searchTitle"
                       placeholder="Szukaj w tytule"
                       class="w-full border rounded px-3 py-2">

                <input type="text" wire:model.defer="searchDescription"
                       placeholder="Szukaj w opisie"
                       class="w-full border rounded px-3 py-2">

                <select wire:model.defer="status" class="w-full border rounded px-3 py-2">
                    <option value="">Wszystkie statusy</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model.defer="search_due_date"
                       class="w-full border rounded px-3 py-2">

                <div class="flex space-x-2">
                    <button wire:click="applyFilters"
                            class="w-1/2 bg-blue-500 text-white px-3 py-2 rounded">
                        Filtruj
                    </button>

                    <button wire:click="resetFilters"
                            class="w-1/2 bg-gray-200 text-gray-700 px-3 py-2 rounded">
                        Resetuj filtry
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
