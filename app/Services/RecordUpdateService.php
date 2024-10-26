<?php

namespace App\Services;

use App\Models\RecordUpdateTracker;
use App\Traits\ActivityLogTrait;
use Illuminate\Support\Facades\Http;

class RecordUpdateService
{
    use ActivityLogTrait;

    public function getNewBatch()
    {
        return RecordUpdateTracker::where('update_batched', false)->with('user')
            ->orderBy('id')
            ->limit(1000)
            ->get();
    }

    public function batchAllUpdatesAndUpload($recordUpdateRecords)
    {
        $batches = [
            "batches" => [
                [
                    "subscribers" => []
                ]
            ]
        ];

        $count = 0;
        $saveRecordIds = [];

        foreach ($recordUpdateRecords as $record) {
            $batches["batches"][0]["subscribers"][] = [
                'email' => $record->user->email,
                'name' => $record->user->first_name . ' '. $record->user->last_name,
                'time_zone' => $record->user->time_zone
            ];

            $saveRecordIds[] = $record->id;
            $count++;
        }

        $headers = [
            'Accept' => 'application/json'
        ];

        $apiURL = 'https://test.vueschool.com';

        Http::fake([
            $apiURL => Http::response(['status' => 'success'], 200),
        ]);

        $apiResponse = Http::post($apiURL, $batches);
        // ->withHeaders($headers)->withBasicAuth(config('app.username'), config('app.password'));
        $response = json_decode($apiResponse->body());

        return [
            'response' => $response,
            'count' => $count,
            'saveRecordIds' => $saveRecordIds
        ];
    }

    public function massUpdateRecordUpdate($ids)
    {
        RecordUpdateTracker::whereIn('id', $ids)->update(['update_batched' => true]);
    }

    public function uploadService()
    {
        $recordUpdateRecords = $this->getNewBatch();

        $uploadService = $this->batchAllUpdatesAndUpload($recordUpdateRecords);

        $time = now();

        if ($uploadService['response']->status == 'success') {
            // Log it as success
            $message = 'Uploaded and updated batch to the API service at '. $time .' And a total of '. $uploadService['count'] . ' of users data were sent';
            $this->logRequest($message, 'success');

            // update the record to true in DB (mass update)
            $this->massUpdateRecordUpdate($uploadService['saveRecordIds']);
        } else {
            // Log it as error
            $error = 'Failed to run batch upload successfully due to: '. $uploadService['response']['message'];
            $this->logRequest($error, 'fail');
        }
    }
}
