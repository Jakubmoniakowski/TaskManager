<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class TaskFilter
{
    private ?string $searchTitle;
    private ?string $searchDescription;
    private ?int $status;
    private ?string $dueDate;

    public function __construct(?string $searchTitle, ?string $searchDescription, ?int $status, ?string $dueDate)
    {
        $this->searchTitle       = $searchTitle;
        $this->searchDescription = $searchDescription;
        $this->status            = $status;
        $this->dueDate           = $dueDate;
    }

    public function apply(Builder $query): Builder
    {
        // 🔹 filtr po tytule
        if (!empty($this->searchTitle)) {
            $query->where('title', 'like', '%' . $this->searchTitle . '%');
        }

        // 🔹 filtr po opisie
        if (!empty($this->searchDescription)) {
            $query->where('description', 'like', '%' . $this->searchDescription . '%');
        }

        // 🔹 filtr po statusie
        if (!empty($this->status)) {
            $query->where('status_task_id', $this->status);
        }

        // 🔹 filtr po dacie
        if ($this->dueDate) {
            try {
                $query->whereDate('due_date', \Carbon\Carbon::parse($this->dueDate));
            } catch (\Exception $e) {
                // Ignorujemy niepoprawny format
            }
        }

        return $query;
    }
}
