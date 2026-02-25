<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'year',
        'engine',
        'code',
        'air_condition',
        'plan',
        'height_cm',
        'body_fat_percentage',
        'photo_path',
    ];
}
