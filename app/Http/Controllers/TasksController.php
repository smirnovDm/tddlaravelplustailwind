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
        $this->authorize('update', $project);
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
        $this->authorize('update', $task->project);

        $task->update(['body' => request('body')]);

        request('completed') ? $task->complete() : $task->incomplete();

       return redirect($project->path());
    }
}
