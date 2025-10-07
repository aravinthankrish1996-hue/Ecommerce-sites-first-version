<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;

class colourController extends Controller
{
     use ApiResponse;

    public function index()
    {
        $data =Colour::get();
        return view('admin/Colour/colour',get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
        
            'text'           => 'required|string|max:255',
              'value'           => 'string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            Colour::updateOrCreate(
                ['id' => $request->id],
                ['text' => $request->text,'value' => $request->value,]
            );
            return $this->success(['reload' => true], 'Successfully insert');
        }
    }
}
