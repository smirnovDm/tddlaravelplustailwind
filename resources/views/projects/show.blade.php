@extends('layouts.app')
    @section('content')

        <header class="flex items-center mb-3 py-4">
            <div class="flex justify-between w-full">
                <h1 class="text-gray-600 text-sm font-normal">My Projects</h1>
                <a href="/projects/create" class="button">New Project</a>
            </div>
        </header>

        <main>
            <div>
                <div></div>
                <div></div>
            </div>
        </main>

        <h1>Birdboard</h1>
        <p>
            title: {{ $project->title }}
        </p>
        <p>
            description: {{ $project->description }}
        </p>
        <a href="/projects">Go Back</a>
    @endsection

