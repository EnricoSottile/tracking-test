<?php


namespace App\Services;

use App\Models\Tracking;

/**
 * I usually extract the "logic" away from the controller, which I only use to route data across the application
 * In this case I've provided a simple mechanism to switch between mysql and csv using the .env file /config
 * 
 * I've decided to throw the 404 exception directly in this class with the abort() helper, 
 * and since we have Laravel doing the heavy lifting, there's no need to catch it in the controller. 
 * 
 * It's overkill right now, but this should implement an interfaces (for example a find() method)
 * and every "data source" should be a child class extending this one so that we achieve more abstraction
 */
final class TrackingService {

    /**
     * A very simple method to find the code in the provided CSV
     *
     * @param string $tracking_code
     * @return Tracking
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getFromCsv(string $tracking_code) : Tracking {
        $data = array_map('str_getcsv', file(public_path('data-example.csv')));
        $data = array_filter($data, fn ($row) => $row[1] === $tracking_code);
        
        if (!count($data)) abort(404);

        return new Tracking([
            'tracking_code' => current($data)[1],
            'estimated_delivery' => current($data)[2],
        ]);
    }

    /**
     * Returns a tracking instance based on the data source enabled in config
     *
     * @param string $tracking_code
     * @return Tracking
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function find(string $tracking_code) : Tracking {
        $tracking = config('app.use_csv') === true ? 
            $this->getFromCsv($tracking_code) 
            : Tracking::where('tracking_code', $tracking_code)->firstOrFail();

        return $tracking;
    }
}
