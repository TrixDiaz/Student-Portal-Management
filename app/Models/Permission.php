<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name', 'group_by'];

    public static function getRecord()
    {
        $getPermission = Permission::groupBy('group_by')->get();
        $result = array();
        foreach ($getPermission as $permission) {
            $gerPermissionGroup = Permission::getPermissionGroup($permission->group_by);
            $data = array();
            $data['id'] = $permission->id;
            $data['name'] = $permission->name;
            $data['group_by'] = $permission->group_by;
            $group = array();
            foreach ($gerPermissionGroup as $valueGroup) {
                $dataGroup[] = array();
                $dataGroup['id'] = $valueGroup->id;
                $dataGroup['name'] = $valueGroup->name;
                $group[] = $dataGroup;
            }
            $data['group'] = $group;
            $result[] = $data;
        }
        return $result;
    }

    static public function getPermissionGroup($group_by)
    {
        return Permission::where('group_by', $group_by)->get();
    }
}
