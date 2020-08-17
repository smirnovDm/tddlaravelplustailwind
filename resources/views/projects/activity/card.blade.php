<div class="card mt-3">
    <ul class="text-xs">
        @foreach($project->activity as $activity)
            <li>
                @include("projects.activity.{$activity->description}")
                <sapn class="text-gray-500">{{ $activity->created_at->diffForHumans(null, true) }}</sapn>
            </li>
        @endforeach
    </ul>
</div>
