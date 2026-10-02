<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    protected $fillable = [
        'book_id',
        'accession_number',
        'status',
        'notes',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Scopes
    public function scopeAvailable($q) { return $q->where('status', 'available'); }
    public function scopeIssued($q)    { return $q->where('status', 'issued'); }
    public function scopeDamaged($q)   { return $q->where('status', 'damaged'); }
    public function scopeLost($q)      { return $q->where('status', 'lost'); }

    // Helper
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    // Status badge color
    public function statusColor(): string
    {
        return match($this->status) {
            'available' => 'success',
            'issued'    => 'warning',
            'damaged'   => 'secondary',
            'lost'      => 'danger',
            default     => 'secondary',
        };
    }

    public function issues()
{
    return $this->hasMany(Issue::class);
}

public function activeIssue()
{
    return $this->hasOne(Issue::class)->whereNull('returned_at');
}
}