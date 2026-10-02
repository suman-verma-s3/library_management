<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'student_id',
        'book_copy_id',
        'issued_by',
        'issued_at',
        'due_date',
        'returned_at',
        'returned_by',
    ];

    protected $casts = [
        'issued_at'   => 'datetime',
        'due_date'    => 'date',
        'returned_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function isOverdue(): bool
    {
        return !$this->isReturned() && $this->due_date->isPast();
    }

    public function statusLabel(): string
    {
        if ($this->isReturned()) return 'Returned';
        if ($this->isOverdue())   return 'Overdue';
        return 'Issued';
    }

    public function statusColor(): string
    {
        if ($this->isReturned()) return 'success';
        if ($this->isOverdue())   return 'danger';
        return 'warning';
    }
}