@extends('layouts.app')
    @section('content')
        <form method="POST" action="/projects" class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            @csrf
            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Title</label>
                <div class="control">
                    <input type="text" class="input bg-transparent border border-gray-300 rounded p-2 text-xs w-full" name="title" placeholder="Title">
                </div>
            </div>

            <div class="field">
                <label for="description" class="label text-sm mb-2 block">Description</label>
                <div class="control">
                    <textarea name="description" class="textarea bg-transparent border border-gray-300 p-2 text-xs w-full" style="min-height: 200px"></textarea>
                </div>
            </div>

            <div class="field">

                <div class="control">
                    <button type="submit" class="button is-link">Create Project</button>
                    <a href="/projects">Cancel</a>
                </div>
            </div>
        </form>
    @endsection


