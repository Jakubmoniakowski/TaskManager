<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
        'status_task_id',
        'due_date',
        'status_id'
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
        'completed' => 'boolean',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function statusTask()
    {
        return $this->belongsTo(StatusTask::class);
    }

    public function observer()
    {
        return $this->hasOne(ObserverTask::class);
    }

    public static function getActiveQueryForUser(int $userId)
    {
        return self::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhereHas('observer', fn($sub) => $sub->where('user_id', $userId));
            })
            ->whereHas('status', fn($q) => $q->where('code', 'active'))
            ->with('statusTask')
            ->orderBy('created_at', 'desc');
    }

    public static function getActiveByUserPaginated(int $userId, int $perPage = 5)
    {
        return self::getActiveQueryForUser($userId)->paginate($perPage);
    }

    public function canEdit(): bool
    {
        return $this->user_id === Auth::id();
    }

    public function canDelete(): bool
    {
        return $this->user_id === Auth::id();
    }

    public function isObserver(): bool
    {
        return $this->observer && $this->observer->user_id === Auth::id();
    }
}

