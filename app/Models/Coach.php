<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['field_name'];
    use HasFactory, SoftDeletes;

    public function getFieldNameAttribute()
    {
        return $this->field ? $this->field->name : '-';
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
