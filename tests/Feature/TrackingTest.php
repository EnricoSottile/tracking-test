<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackingTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_page_is_reachable()
    {
        $response = $this->get(route('tracking.index'));
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_4xx_errors()
    {
        $response = $this->get(route('tracking.show'));
        $response->assertStatus(400);

        $response = $this->get(route('tracking.show', ['tracking_code' => null]));
        $response->assertStatus(400);

        $response = $this->get(route('tracking.show', ['tracking_code' => 'AAA']));
        $response->assertStatus(404);
    }
}


