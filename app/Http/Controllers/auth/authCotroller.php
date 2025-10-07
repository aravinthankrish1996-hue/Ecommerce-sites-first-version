<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User; // This import is correct
use Illuminate\Http\Request;
use Validator; // This import is correct
use Auth; // This import is correct
use App\Traits\ApiResponse;
use App\Models\Role;

class authCotroller extends Controller
{
    use ApiResponse;
    public function updateUser(Request $request) {
         $validation = Validator::make($request->all(), [
        
            'name'           => 'required|string|max:255',
         
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
         Auth::user()->update(['name'=>$request->name]);

            return $this->success(['user' => $request->user()], 'Successfully insert');
    }
}
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:users,name|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ]);
        $customer = Role::where('slug', 'customer')->first();

        $user->roles()->attach($customer);
        return $this->success(['token' => $user->createToken('API TOKEN')->plainTextToken]);
    }


    public function loginUser(Request $request)
    {
        // 1. Validation
        $validation = Validator::make($request->all(), [
            'email'    => 'required|string|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
        } else {
            // 2. Attempt Authentication
            $cred = array('email' => $request->email, 'password' => $request->password);

            if (Auth::attempt($cred, false)) // 'false' means "do not remember me"
            {
                // 3. Check User Role AFTER successful authentication
                // THIS IS THE FIX: Changed hashRole() to hasRole()
                if (Auth::User()->hasRole('admin')) // Using the correct method name
                {
                    return response()->json(['status' => 200, 'message' => 'Admin User', 'url' => '/dashboard']);
                } else {
                    $user = User::where('id',Auth::User()->id)->first();
                    $user['token'] = $user->createToken('API TOKEN')->plainTextToken;

                    return $this->success(
                        [
                            'user' =>$user
                        ],
                        'Successfully Login'
                    );
                }
            } else {
                // 4. Authentication Failed
                return response()->json(['status' => 404, 'message' => 'Wrong Cred']);
            }
        }
    }
}
