<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $guarded = ['id'];
    use HasFactory, SoftDeletes;

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
