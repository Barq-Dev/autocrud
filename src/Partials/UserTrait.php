<?php
namespace Barqdev\Autocrud\Partials;

use Illuminate\Support\Facades\Storage;

trait UserTrait {
    // protected $appends = ['all_permissions','avatar_link','role'];
    
    protected $files = ['avatar'];

    public function getAvatarLinkAttribute()
    {
        return $this->avatar? Storage::url("uploads/files/$this->avatar") : '/images/autocrud/default.png';
    }

    public function getRoleAttribute()
    {
        return $this->roles[0]['name']?? null;
    }

    public function getAllPermissionsAttribute()
    {   $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach($allPermissions as $p)
        {
            $res[] = $p->name;
        }
        return $res;
    }
}