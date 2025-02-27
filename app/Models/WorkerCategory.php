<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relasi yang benar untuk one-to-many
    public function workers()
    {
        return $this->hasMany(User::class, 'worker_category_id');
    }
}
