<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory;

    protected $table = 'team_project';

    public $timestamps = false;

    protected $attributes = [
        'state_user' => 1
    ];

    protected $fillable = [
        'projects_id',
        'users_id',
        'activity_idactivity'
    ];

    public static function getProjectActivities($idProject)
    {
        $activities = DB::table('team_project')
            ->join('projects', 'team_project.projects_id', '=', 'projects.id')
            ->join('activity', 'team_project.activity_idactivity', '=', 'activity.idactivity')
            ->select('projects.id as id_project', 'activity.state as state_activity', 'activity.idactivity as id_activity', 'team_project.users_id as id_user',  DB::raw('(SELECT name FROM users WHERE id = team_project.users_id LIMIT 1) as user_info'))
            ->where('projects.id', $idProject)
            ->get();

        return $activities;
    }
}
