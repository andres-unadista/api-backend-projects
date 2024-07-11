<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $activities = Activity::all();
            return new JsonResponse(['activities' => $activities], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Activities not found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function projectActivities($idProject)
    {
        try {
            $activities = Team::getProjectActivities($idProject);
            return new JsonResponse(['activities' => $activities], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Activities not found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'id_project' => 'required|numeric',
                'name' => 'required|string|max:255',
                'date_start' => 'required|date_format:"Y-m-d"',
                'date_end' => 'required|date_format:"Y-m-d"',
            ]);
            $activity = Activity::create($request->all())->toArray();
            $team = Team::create([
                'projects_id' => $request->input('id_project'),
                'users_id' => $request->input('user_id'),
                'activity_idactivity' => $activity['idactivity']
            ])->toArray();
            DB::commit();

            return new JsonResponse(["activity" => $activity, "team" => $team], Response::HTTP_OK);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response(['message' => 'Activity not saved'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        try {
            return new JsonResponse(['activity' => $activity], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Activity not found'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        try {
            $request->validate([
                'id_project' => 'numeric',
                'name' => 'string|max:255',
                'date_start' => 'date_format:"Y-m-d"',
                'date_end' => 'date_format:"Y-m-d"',
                'state' => 'numeric'
            ]);
            $activity->update($request->all());

            if($request->input('user_id') !== null ){
                $activity_id = $activity['idactivity'];
                $user_id = $request->input('user_id');
                Team::where('activity_idactivity', $activity_id)
                ->update(['users_id' => $user_id]);
            }
           

            return new JsonResponse(['activity' => $activity->refresh()], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Activity not updated'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
