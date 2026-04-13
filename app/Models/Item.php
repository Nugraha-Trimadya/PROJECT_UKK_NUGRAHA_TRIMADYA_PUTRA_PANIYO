<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',
    ];

    protected $appends = ['available', 'active_lending_total'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lendingItems()
    {
        return $this->hasMany(LendingItem::class);
    }

    public function getActiveLendingTotalAttribute(): int
    {
        return (int) $this->lendingItems()
            ->whereHas('lending', function ($query) {
                $query->whereNull('return_date');
            })
            ->sum('qty');
    }

    public function getAvailableAttribute(): int
    {
        return max(0, $this->total - $this->repair - $this->active_lending_total);
    }
}
