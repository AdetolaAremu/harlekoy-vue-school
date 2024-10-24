<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use App\Models\LogActivity;
use App\Traits\ActivityLogTrait;
use Closure;
use Illuminate\Http\Request;

class LogInfo
{
    use ActivityLogTrait;

    public function handle(Request $request, Closure $next)
    {
        $action = $request->route()->getAction();

        $controllerAction = class_basename($action['controller']);
        $getControllerName =  explode('@', $controllerAction);

        $response = $next($request);

        $decodeContent = json_decode($response->content(), true);

        $makeNameLookGood = Helper::splitCamelCase($getControllerName[1]);

        $this->logRequest($makeNameLookGood, $decodeContent['status'] ?? 'fail');
    }
}
