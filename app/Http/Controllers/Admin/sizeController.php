<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;

class sizeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data =Size::get();
        return view('admin/Size/size',get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'             => 'required',
            'text'           => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            Size::updateOrCreate(
                ['id' => $request->id],
                ['text' => $request->text,]
            );
            return $this->success(['reload' => true], 'Successfully insert');
        }
    }
}