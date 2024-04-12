<?php
namespace App\Helpers;

use App\Models\Appointments;
use App\Models\User;
use App\Models\UserType;
use App\Models\HealthCare;
use App\Models\Specializations;
use Illuminate\Support\Facades\Storage;

class Helper
{

    public static function checkUserPermission($permissionName)
    {
        $permissions = self::userPermissions();
        return ($permissions->{$permissionName} == 1) ? true : false;
    }

    public static function userPermissions()
    {
        $userTypeId = auth()->user()->user_type_id;
        $permissions = UserType::select('permissions')->where('id', $userTypeId)->first()->permissions;

        return json_decode($permissions);
    }
    public static function fetchUserType()
    {
        return UserType::select('id','name')->pluck('name','id')->toArray();
    }

    public static function imageUpload($file, $existingFile = '')
    {
        $path = $file->store('public/images');
        return Storage::url($path);
    }
    public static function deleteFiles(array $filePaths)
    {
        foreach ($filePaths as $filePath)
        {
            $filePath = str_replace('/storage/', '', $filePath);
            if (Storage::disk('public')->exists($filePath))
            {
                Storage::disk('public')->delete($filePath);
            }
        }
    }
}
?>
