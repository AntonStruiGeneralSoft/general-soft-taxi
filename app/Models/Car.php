<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Car extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cars'; 

    protected $fillable = [ 
        'user_id',
        'make',
        'model',
        'year',
        'color'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
