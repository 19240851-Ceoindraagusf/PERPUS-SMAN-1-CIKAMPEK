<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_home_page_contains_class_search_fields(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('name="q"', false)
            ->assertSee('name="class"', false)
            ->assertSee('Semua kelas')
            ->assertSee('XII');
    }
}
