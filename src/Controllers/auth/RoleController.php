<?php

namespace App\Http\Controllers;

use Barqdev\Autocrud\AutoBase;
use App\Http\Requests\RoleRequest;
use Barqdev\Autocrud\Models\AutoRole;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    use AutoBase;

    public function __construct()
    {
        $this->model = new AutoRole;
        $this->searchFields = ['name']; //Fill with searchable column
        $this->request = new RoleRequest;
    }

    public function customRequestData($request){

        if(!$request->id && $this->model->whereName($request->name)->first())
            throw ValidationException::withMessages(['role' => 'Role has been exists'])->status(422);
        $request['guard_name'] = 'web';
        return $request;
    }
    public function callbackAfterStoreOrUpdate($data, $request)
    {
        if($request['permissions']?? null)
            $data->syncPermissions($request['permissions']);

        return $data;
    }
    public function permissions($name = null)
    {
        return response()->json($name? Permission::findByName($name) : Permission::all());
    }
}
