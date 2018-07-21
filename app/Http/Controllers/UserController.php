<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Facades\Input;


class UserController extends Controller
{
    public $successStatus = 200;
    public function login(Request $request)
    {
        //return $request->all();
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            //return 'a';
            $user = Auth::user();
            $success['token'] =  $user->createToken('API_Login')->accessToken;
            return response()->json(['success' => $success,'user' => $user], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }


}
