<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function saveUserDetails($request, $getUserRecord) : User
    {
        $getUserRecord->first_name = $request->first_name;
        $getUserRecord->last_name = $request->last_name;
        $getUserRecord->email = $request->email;
        $getUserRecord->timezone = $request->timezone;
        $getUserRecord->save();

        return $getUserRecord;
    }

    public function getUserById($id)
    {
        return User::where('id', $id)->first();
    }

    public static function matchUserUpdatedRecords($dbRecord, $requestRecord)
    {
        $userRecordUpdated = false;

        if ($requestRecord->first_name) {
            if (strtolower($dbRecord->first_name) == (strtolower($requestRecord->first_name))) $userRecordUpdated = true;
        }

        if ($requestRecord->last_name) {
            if (strtolower($dbRecord->last_name) == strtolower($requestRecord->last_name)) $userRecordUpdated = true;
        }

        if ($requestRecord->email) {
            if (strtolower($dbRecord->email) == (strtolower($requestRecord->email))) $userRecordUpdated = true;
        }

        if ($requestRecord->timezone) {
            if (strtolower($dbRecord->timezone) == (strtolower($requestRecord->timezone))) $userRecordUpdated = true;
        }

        return $userRecordUpdated;
    }
}
