<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Project $project)
    {
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }
        request()->validate(
            [
                'body' => 'required',
            ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Project $project, Task $task)
    {
        if(auth()->user()->isNot($task->project->owner)){
            abort(403);
        }

        $task->update([
            'body'      => request('body'),
            'completed' => request()->has('completed'),
        ]);

       return redirect($project->path());
    }
}
