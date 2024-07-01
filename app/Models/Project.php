<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Define acccess to attribute
    protected $dates = ['date_update'];

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'name',
        'date_start',
        'date_end',
        'state',
        'date_update',
        'created_at'
    ];

    protected $attributes = ["state" => 1];

    // Model event
    protected static function boot()
    {
        parent::boot();

        // Event before updating model
        static::updating(function ($project) {
            $project->date_update = now(); // Sets the current date
        });
    }
}
