<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Attributer;
use App\Models\AttributeValue;
use Attribute;
use Illuminate\Support\Facades\Validator;

class attributeController extends Controller
{
    use ApiResponse;

    public function index_attributer_name()
    {
        $data =Attributer::get();
        return view('admin/Attributer/attributer',get_defined_vars());
    }


    public function store_attributer_name(Request $request)
    {
        $validation = Validator::make($request->all(), [
        
            'name'           => 'required|string|max:255',
              'slug'           => 'string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            Attributer::updateOrCreate(
                ['id' => $request->id],
                ['name' => $request->name,'slug' => $request->slug,]
            );
            return $this->success(['reload' => true], 'Successfully insert');
        }
    }
         public function index_attributer_value()
    {
        $data =AttributeValue::with('singleAttribute')->get();
        // echo"<pre>";print_r($data);die();
        $attributer=Attributer::get();
        return view('admin/Attributer/attributer_value',get_defined_vars());
    }
     public function store_attributer_value(Request $request)
    {
        $validation = Validator::make($request->all(), [
        
            'attributers_id'           => 'required|exists:attributers,id',
              'value'           => 'string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            AttributeValue::updateOrCreate(
                ['id' => $request->id],
                ['attributers_id' => $request->attributers_id,'value' => $request->value,]
            );
            return $this->success(['reload' => true], 'Successfully insert');
        }
    }

}
