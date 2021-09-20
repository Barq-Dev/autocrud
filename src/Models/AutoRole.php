<?php

namespace Barqdev\Autocrud\Models;

use Spatie\Permission\Models\Role;
use Barqdev\Autocrud\Partials\LocalScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoRole extends Role
{
    use HasFactory, LocalScopeTrait;
    
    protected $fillable = ['name','guard_name'];
    protected $appends = ['allPermissions','permission_id'];

    public function getPermissionIdAttribute()
    {
        return $this->permissions->pluck('id');
    }

    public function getAllpermissionsAttribute()
    {   $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach($allPermissions as $p)
        {
            $res[] = $p->name;
        }
        return $res;
    }
}
