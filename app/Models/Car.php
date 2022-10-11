<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Car extends Model
{
    use HasFactory;


    protected $fillable = [
        'brand', 'model', 'employee_id', 'plate',
    ];

    protected static function booted()
    {
        static::deleting(function () {
            Cache::forget('cars');
        });

        static::updated(function () {
            Cache::forget('cars');
        });

        static::created(function () {
            Cache::forget('cars');
        });
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
