<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Basic test
     */

    public function testAUserCanCreateAProject()
    {
        // to see errors 
        $this->withoutExceptionHandling();

        // given what we need to define a Project
        $this->actingAs(factory('App\User')->create());
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];

        // the page to create projects exists
        $this->get('/projects/create')->assertStatus(200);

        // when we call the route to create a Project it gets created
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        // then we see the Project in the database
        $this->assertDatabaseHas('projects', $attributes);

        // and when we get it 
        $this->get('/projects')->assertSee($attributes['title']);
    }

    

    /**
     * @test 
     * Test a user can view a project
     */
    public function an_authenticated_user_can_view_their_project() 
    {


        //given
        $this->be(factory('App\User')->create());

        // to see errors 
        $this->withoutExceptionHandling();
        
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);


        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);

    }
    

    /**
     * @test 
     * Test a user can view a project
     */
    public function an_authenticated_user_cannot_view_others_projects() 
    {


        //given
        $this->be(factory('App\User')->create());

        // to see errors 
        // $this->withoutExceptionHandling();
        
        $project = factory('App\Project')->create();


        $this->get($project->path())->assertStatus(403);

    }


    /**
     * @test 
     * Test for errors when no title
     */
    public function a_project_requires_a_title() 
    {
        $attr = factory('App\Project')->raw(['title' => '']);
        $this->actingAs(factory('App\User')->create());

        // given when then
        $this->post('/projects', $attr)->assertSessionHasErrors('title');

    }

    /**
     * @test 
     * Test for errors when no description
     */
    public function a_project_requires_a_description() 
    {
        $attr = factory('App\Project')->raw(['description' => '']);
        $this->actingAs(factory('App\User')->create());

        // given when then
        $this->post('/projects', $attr)->assertSessionHasErrors('description');

    }

    /**
     * @test 
     * Test for errors when no owner
     */
    public function guest_cannot_create_list_or_view_project() 
    {
        // to see errors 
        // $this->withoutExceptionHandling();

        $attr = factory('App\Project')->raw();
        $project = factory('App\Project')->create();

        // given not loggen in when trying to view a project then redirected to the login page
        $this->get($project->path())->assertRedirect('login');

        // given not loggen in when trying to create a project then redirected to the login page
        $this->post('/projects', $attr)->assertRedirect('login');

        // given not loggen in when trying to create projects then redirected to the login page
        $this->get('/projects/create')->assertRedirect('login');

        // given not loggen in when trying to list projects then redirected to the login page
        $this->get('/projects')->assertRedirect('login');

    }


}
