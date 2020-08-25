<?php

namespace App\Module\Acl\Support;

use App\Module\Acl\Api\Data\RolePermissionInterface;
use Illuminate\Support\Facades\Config;

class ResourceConfig
{
    /**
     * @return array
     */
    public static function getAll()
    {
        $res = [];
        $resConfig = Config::get('acl');
        foreach ($resConfig as $module => $resources) {
            foreach ($resources['resources'] as $resource) {
                $res[] = $module . '::' . $resource . '::' . RolePermissionInterface::READ;
                $res[] = $module . '::' . $resource . '::' . RolePermissionInterface::WRITE;
            }
        }
        return $res;
    }
}
