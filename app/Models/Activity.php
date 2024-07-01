<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = "idactivity";

    protected $table = 'activity';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'date_start',
        'date_end',
        'state'
    ];

    protected $attributes = ["state" => 1];

    protected static function booted()
    {
        static::creating(function ($project) {
            $project->created_at = Carbon::now();
        });
    }
}
