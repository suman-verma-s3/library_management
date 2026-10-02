<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone',
        'course',
        'address',
        'status',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function statusColor(): string
    {
        return $this->status === 'active' ? 'success' : 'secondary';
    }
    public function issues()
{
    return $this->hasMany(Issue::class);
}
}