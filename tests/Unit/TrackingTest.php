<?php

namespace Tests\Unit;

use App\Models\Tracking;
use App\Services\TrackingService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackingTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_get_data_from_csv()
    {
        config(['app.use_csv' => true]);
        $service = new TrackingService();
        $tracking = $service->find('is_csv_data');
        $this->assertInstanceOf(Tracking::class, $tracking);
    }

        /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_get_data_from_mysql()
    {
        config(['app.use_csv' => false]);

        Tracking::factory(1)->create(['tracking_code' => 'is_mysql_data']);

        $service = new TrackingService();
        $tracking = $service->find('is_mysql_data');
        $this->assertInstanceOf(Tracking::class, $tracking);
    }
}
