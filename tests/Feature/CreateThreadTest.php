<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_guest_user_cannot_see_the_create_new_thread_link()
    {
        $this->get('/threads')
            ->assertDontSee('Create a new thread');
    }

    /** @test */
    function a_guest_user_is_redirected_to_login_when_trying_to_create_a_thread()
    {
        $this->get('/threads/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
    /** @test */
    function an_authenticated_user_is_redirected_to_login_when_trying_to_create_a_thread()
    {
        $this->signIn();
        $this->get('/threads/create')
            ->assertSee('Create a New Thread');
    }

    /** @test */
    function an_authenticated_user_cannot_see_the_create_new_thread_link()
    {
        $this->signIn();
        $this->get('/threads')
            ->assertSee('Create a new thread');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        //$this->withoutExceptionHandling();

        $this->signIn();
        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function a_guest_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path() . '1')
            ->assertDontSee($thread->title)
            ->assertDontSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread( ['title' => null] )
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');


        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * @param array $overrides
     * @return mixed
     */
    private function publishThread( array $overrides = [] ): TestResponse
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
