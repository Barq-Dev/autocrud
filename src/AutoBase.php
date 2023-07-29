<?php

namespace Barqdev\Autocrud;

use Barqdev\Autocrud\Partials\CoreTrait;
use Barqdev\Autocrud\Partials\FileTrait;
use Barqdev\Autocrud\Partials\HelperTrait;
use Illuminate\Support\Facades\Validator;

trait AutoBase
{
    use CoreTrait, FileTrait, HelperTrait;

    public function beforeSave($request)
    {
        return $request;
    }
    public function afterSave($data)
    {
        return $data;
    }
    public function read($data)
    {
        return $data;
    }
    public function appends($data)
    {
        return $data;
    }

    // ^1.0 Deprecated Functions
    public function callbackAfterStoreOrUpdate($data, $request = null)
    {
        return $this->afterSave($data);
    }
    public function customRequestData($request)
    {
        return $this->beforeSave($request);
    }
    public function customJsonData($data)
    {
        return $this->read($data);
    }
    // End ^1.0

}