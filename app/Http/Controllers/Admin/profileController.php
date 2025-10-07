<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class profileController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $userId = Auth::user()->id;

        $validation = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            // Corrected unique email validation to ignore the current user
            'email'     => 'required|string|email|max:255|unique:users,email,' . $userId,
            'phone'     => 'required|nullable|string|max:255', // Changed to nullable as phone might not be required
            'image'     => 'nullable|mimes:jpeg,png,jpg,gif|max:5120', // Changed to nullable and max 5MB
            'address'   => 'required|string|max:255',
            'x_link'    => 'required|nullable|string|max:255', // Added 'url' rule and nullable
            'fb_link'   => 'required|nullable|string|max:255', // Added 'url' rule and nullable
            'insta_link' => 'required|nullable|string|max:255', // Added 'url' rule and nullable
        ]);

        if ($validation->fails()) {
               return $this->error($validation->errors()->first(),200,[]);
            // return response()->json(['status' => 400, 'message' => ]);
        } else {
            $user = Auth::user(); // Get the authenticated user instance

            // Handle image upload
            if ($request->hasFile('image')) {
                // Generate a unique image name
                $image_name = $user->name . time() . '.' . $request->file('image')->extension();
                // Move the uploaded image
                $request->file('image')->move(public_path('images/'), $image_name);
                // Update the user's image field
                $user->image = $image_name;
            }

            // Update other user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->x_link = $request->x_link;
            $user->fb_link = $request->fb_link;
            $user->insta_link = $request->insta_link;

            $user->save(); // Save the changes to the database

            // return response()->json(['status' => 200, 'message' => 'Profile updated successfully!']);
            return $this->success([],'Profile updated successfully');
        }
    }
    
    

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
