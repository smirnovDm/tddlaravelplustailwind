@extends('layouts.app')
    @section('content')

        <header class="flex items-center mb-3 py-4">
            <div class="flex justify-between w-full">

                <p class="text-gray-600 text-sm font-normal">
                    <a href="/projects" class="text-gray-600 text-sm font-normal no-underline">My Projects</a> / {{ $project->title }}
                </p>

                <a href="{{ $project->path() . '/edit' }}" class="button">Edit Project</a>
            </div>
        </header>

        <main>
            <div class="lg:flex -m-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <div class="mb-8">
                        <h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>

                        @foreach($project->tasks as $task)
                            <div class="card mb-2">
                                <form action="{{ $task->path() }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <div class="flex justify-between">
                                        <input value="{{ $task->body }}" name="body" class="w-full {{ $task->completed ? 'text-gray-500' : ''}}">
                                        <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </div>
                        @endforeach

                        <div class="card mb-3">
                            <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                @csrf
                                <input placeholder="Begin adding tasks..." class="w-full" name="body">
                            </form>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>

                        <form action="{{ $project->path() }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea class="card w-full mb-3"
                                      style="min-height: 200px;"
                                      placeholder="Anything special you want to make a note of?"
                                      name="notes"
                                      >
                                {{ $project->notes }}
                            </textarea>
                            <button type="submit" class="button">Save</button>
                        </form>

                    </div>
                </div>
                <div class="lg:w-1/4">
                    @include('projects.card')

                    @include('projects.activity.card')
                </div>
            </div>
        </main>

    @endsection

