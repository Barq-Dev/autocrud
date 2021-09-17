<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barqdev\Autocrud\AutoBase;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AutoBase;

    public function __construct()
    {
        $this->model = new User;
        $this->searchFields = ['name','email']; //Fill with searchable column
        $this->request = new UserRequest;
    }

    public function customRequestData($request)
    {   
        if($request->login){
            $user = $this->model->whereEmail($request->email)->first();
            
            if(!$user || !Hash::check($request->password, $user->password))
                throw new \Exception('Wrong email or password');
            else
                $request['id'] = $user->id;
        }
        
        if($request->has('file'))
            $request['avatar'] = $this->upload('files', $request->file);
        
        $request['password'] = bcrypt($request->password);
        
        return $request;
    }

    public function callbackAfterStoreOrUpdate($data, $request)
    {
        $data['token'] = $data->createToken('wearebarqun')->plainTextToken;
        return $data;
    }
}
