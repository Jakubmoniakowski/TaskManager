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
        if (!empty($this->searchTitle)) {
            $query->where('title', 'like', '%' . $this->searchTitle . '%');
        }

        if (!empty($this->searchDescription)) {
            $query->where('description', 'like', '%' . $this->searchDescription . '%');
        }

        if (!empty($this->status)) {
            $query->where('status_task_id', $this->status);
        }

        if ($this->dueDate) {
            try {
                $query->whereDate('due_date', \Carbon\Carbon::parse($this->dueDate));
            } catch (\Exception $e) {
            }
        }

        return $query;
    }
}
