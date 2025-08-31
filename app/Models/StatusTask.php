<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusTask extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
