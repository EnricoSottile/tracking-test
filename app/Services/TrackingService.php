<?php


namespace App\Services;

use App\Models\Tracking;

final class TrackingService {


    protected function getFromCsv(string $tracking_code) : Tracking {
        $data = array_map('str_getcsv', file('data-example.csv'));
        $data = array_filter($data, fn ($row) => $row[1] === $tracking_code);
        if (!count($data)) {
            abort(404);
        }

        return new Tracking([
            'tracking_code' => $data[0][1],
            'estimated_delivery' => $data[0][2],
        ]);
    }

    /**
     * Returns a tracking instance
     *
     * @param string $tracking_code
     * @return Tracking
     */
    public function find(string $tracking_code) : Tracking {
        $tracking = env('USE_CSV') === true ? 
            $this->getFromCsv($tracking_code) 
            : Tracking::where('tracking_code', $tracking_code)->firstOrFail();

        return $tracking;
    }
}
