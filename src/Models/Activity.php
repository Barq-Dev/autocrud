<?php

namespace Barqdev\Autocrud\Models;

use Barqdev\Autocrud\Partials\LocalScopeTrait;
use Spatie\Activitylog\Models\Activity as Model;

class Activity extends Model
{
    use LocalScopeTrait;
    
    public function getCreatedAtAttribute()
    {
        return date('d-m-Y H:i:s', strtotime($this->attributes['created_at']));
    }
}
