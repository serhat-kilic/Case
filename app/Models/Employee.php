<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'surname', 'email', 'sex', 'age'
    ];


    protected static function booted()
    {
        static::deleting(function () {
            Cache::forget('employees');
        });

        static::updated(function () {
            Cache::forget('employees');
        });

        static::created(function () {
            Cache::forget('employees');
        });
    }

    public function car(){
        return $this->hasOne(Car::class);
    }

}
