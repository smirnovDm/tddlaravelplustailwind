<?php


namespace Tests\Feature;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_manage_project()
    {
        $project = factory(Project::class)->create();

        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path(). '/edit')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');

    }

    /**
     * @test
     */
    public function guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guests_cannot_view_a_single_project()
    {
        $project = factory(Project::class)->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title'       => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes'       => 'General notes here.',
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
             ->assertSee(\Str::limit($attributes['title'], 35))
             ->assertSee($attributes['description'])
             ->assertSee($attributes['notes']);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create([ 'owner_id' => auth()->id() ]);

        $this->patch($project->path(), $attributes = [
            'title'       => 'Changed',
            'description' => 'Changed',
            'notes'       => 'Changed',
        ])->assertRedirect($project->path());

        $this->get($project->path(). '/edit')->assertStatus(200);

        $this->assertDatabaseHas('projects', $attributes);

    }

    /**
     * @test
     */
    public function a_user_can_update_a_projects_general_notes()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create([ 'owner_id' => auth()->id() ]);

        $this->patch($project->path(), $attributes = [
            'notes'       => 'Changed',
        ]);

        $this->assertDatabaseHas('projects', $attributes);

    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create([ 'owner_id' => auth()->id() ]);

        $this->get($project->path())
             ->assertSee(\Str::limit($project->title, 35))
             ->assertSee(\Str::limit($project->description, 100) );
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }

}
