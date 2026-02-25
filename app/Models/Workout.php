<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workouts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'date',
        'grade',
        'description',
        'trainer',
        'member',
    ];
}
