<?php

namespace App\Http\Controllers;

use App\Events\RecordUpdateEvent;
use App\Http\Requests\UpdateUserRecordRequest;
use App\Models\User;
use App\Services\RecordUpdateService;
use App\Services\UserService;
use App\Traits\ActivityLogTrait;
use App\Traits\ResponseHandlerTrait;

class UserController extends Controller
{
    use ResponseHandlerTrait;
    use ActivityLogTrait;

    // update user record (an event to create a record in the record update table with the user id as argument)
    public function updateUserRecord(UpdateUserRecordRequest $request, UserService $service)
    {
        $getCurrentUserRecord = $service->getUserById($request->userId);

        $userService = $service->saveUserDetails($request, $getCurrentUserRecord);

        // do we really do batch it? has any field been truly updated
        if ($service->matchUserUpdatedRecords($getCurrentUserRecord, $request)) RecordUpdateEvent::dispatch($userService->id);

        return $this->successResponse('User information updated successfully', $userService);
    }
}
