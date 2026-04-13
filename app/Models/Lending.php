<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_name',
        'borrower_phone',
        'note',
        'lend_date',
        'due_date',
        'return_date',
        'created_by',
    ];

    protected $casts = [
        'lend_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details()
    {
        return $this->hasMany(LendingItem::class);
    }

    public function getTotalItemsAttribute(): int
    {
        return (int) $this->details()->sum('qty');
    }
}
