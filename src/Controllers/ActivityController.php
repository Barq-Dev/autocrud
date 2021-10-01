<?php

namespace App\Http\Controllers;

use Barqdev\Autocrud\AutoBase;
use Barqdev\Autocrud\Models\Activity;
use Barqdev\Autocrud\Requests\ActivityRequest;

class ActivityController extends Controller
{
    use AutoBase;

    public function __construct()
    {
        $this->model = new Activity;
        $this->searchFields = ['description', 'causer.name']; //Fill with searchable column
        $this->request = new ActivityRequest;
    }

    public function callbackAfterStoreOrUpdate($data)
    {
        return $data;    
    }
    
}
