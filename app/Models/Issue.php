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
    'fine_amount',
    'fine_paid',
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

        /**
     * Calculate late fee.
     */
    public function calculateFine(): float
    {
        if (!$this->returned_at) {
            if ($this->due_date->isPast()) {
                $daysLate = $this->due_date->diffInDays(now());
                return $daysLate * config('library.fine_per_day', 5);
            }
            return 0;
        }

        if ($this->returned_at->gt($this->due_date)) {
            $daysLate = $this->due_date->diffInDays($this->returned_at);
            return $daysLate * config('library.fine_per_day', 5);
        }

        return 0;
    }

    /**
     * Get days late.
     */
    public function daysLate(): int
    {
        $endDate = $this->returned_at ?? now();

        if ($endDate->gt($this->due_date)) {
            return $this->due_date->diffInDays($endDate);
        }

        return 0;
    }
}