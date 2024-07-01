<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            $projects = Project::all();
            return new JsonResponse(['projects' => $projects], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Projects not found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user' => 'required|numeric',
                'name' => 'required|string|max:255',
                'date_start' => 'required|date_format:"Y-m-d"',
                'date_end' => 'required|date_format:"Y-m-d"',
                'state' => 'numeric',
            ]);
            $request['created_at'] = now();
            $project = Project::create($request->all());
            return new JsonResponse(['project' => $project], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response(['message' => 'Project not saved'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     */
    public function show(Project $project)
    {
        try {
            return new JsonResponse(['project' => $project], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Project not found'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     */
    public function update(Request $request, Project $project)
    {
        try {
            $request->validate([
                'id_user' => 'numeric',
                'name' => 'string|max:255',
                'date_start' => 'date_format:"Y-m-d H:i:s"',
                'date_end' => 'date_format:"Y-m-d H:i:s"',
                'state' => 'numeric',
            ]);
            $project->update($request->all());
            return new JsonResponse(['project' => $project->refresh()], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response(['message' => 'Project not updated'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
