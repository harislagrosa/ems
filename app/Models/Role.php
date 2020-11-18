<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $hidden = [
        'updated_at',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('F d, Y');
    }
}
