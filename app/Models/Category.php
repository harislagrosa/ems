<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $table = 'expense_categories';

    protected $hidden = [
        'updated_at',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('F d, Y');
    }
}
