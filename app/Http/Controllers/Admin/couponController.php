<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Coupon;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;

class couponController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = Coupon::get();
        return view('admin/Coupon/coupon', get_defined_vars());
    }

    public function store(Request $request) 
    {
        $validation = Validator::make($request->all(), [

            'name'           => 'required|string|max:255',
            'type'           => 'required|numeric|in:1,2',
            'value'           => 'required|numeric',
            'minValue'        => 'required|numeric',
            // 'id' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            Coupon::updateOrCreate(
                ['id' => $request->id],
                ['name' => $request->name, 'type' => $request->type, 'value' => $request->value, 'minValue' => $request->minValue,]
            );
            return $this->success(['reload' => true], 'Successfully insert');
        }
    }
}
