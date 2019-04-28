<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user has projects (ORM)
     *
     * @test
     */
    public function testHasProjects()
    {
        //given a user
        $user = factory('App\User')->create();

        // when then
        $this->assertInstanceOf(Collection::class, $user->projects);
        
    }
}
