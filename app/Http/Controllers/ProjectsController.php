<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectsRequest;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Returns projects.index view with all projects in it.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    /**
     * Save project to DB and returns to projetcs.index view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateReq());

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProjectsRequest $projectsRequest ,Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateReq());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Query concrete project
     *
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * @return array
     */
    public function validateReq()
    {
        $attributes = request()->validate(
            [
                'title' => 'sometimes|required',
                'description' => 'sometimes|required',
                'notes' => 'min:3',
            ]);
        return $attributes;
    }
}
