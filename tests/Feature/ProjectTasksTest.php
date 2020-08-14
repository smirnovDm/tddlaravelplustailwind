<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {

        $this->signIn();

        $project = auth()->user()->projects()->create(

            factory(Project::class)->raw()

        );

        $this->post($project->path(). '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');

    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(

            factory(Project::class)->raw()
        );

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
             ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {

        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body'      => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body'      => 'changed',
        ]);
    }


    /**
     * @test
     */
    public function a_task_can_be_completed()
    {

        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body'      => 'changed',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body'      => 'changed',
            'completed' => true,
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_marked_as_incomplete()
    {

        $project = app(ProjectFactory::class)
            ->ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body'      => 'changed',
            'completed' => true,
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body'      => 'changed',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body'      => 'changed',
            'completed' => false,
        ]);
    }

    /**
     * @test
     */
    public function adding_a_task_if_you_are_not_the_project_owner()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post($project->path(). '/tasks', ['body' => 'Test task'])
             ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /**
     * @test
     */
    public function updating_a_task_if_you_are_not_the_project_owner()
    {
      $this->signIn();

      $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
           'body' => 'Changed',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'Changed',
        ]);
    }
}
