@extends('layouts.app')
    @section('content')

        <header class="flex items-center mb-3 py-4">
            <div class="flex justify-between w-full">
                <h1 class="text-gray-600 text-sm font-normal">My Projects</h1>
                <a href="/projects/create" class="button">New Project</a>
            </div>
        </header>

        <main class="lg:flex lg:flex-wrap -mx-3">
            @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="card" style="height: 200px">
                    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-400 pl-4">
                        <a href="{{ $project->path() }}" class="text-black">{{ Str::limit($project->title, 35) }}</a>
                    </h3>
                    <div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
                </div>
            </div>
            @empty
            <div>There is no projects yet.</div>
            @endforelse
        </main>
    @endsection

