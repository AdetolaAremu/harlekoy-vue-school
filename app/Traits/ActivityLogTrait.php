<?php

namespace App\Traits;

use App\Models\LogActivity;

trait ActivityLogTrait
{
    public function logRequest($message, $result)
    {
        LogActivity::create([ 'activity' => $message, 'result' => $result ]);
    }
}
