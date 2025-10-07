<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;
use App\Models\Tax;

class taxController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = Tax::get();
        return view('admin/Tax/tax', get_defined_vars());
    }
    public function store(Request $request)
    {
        // --- 1. Log the start of the request ---
        $requestId = uniqid('category_req_'); // Generate a unique ID for this request
        Log::info("[$requestId] store method started for Tax.", $request->all());

        $validation = Validator::make($request->all(), [
            'id'    => 'nullable|integer', // Added 'id' for update scenarios
            'text'  => 'required|string|max:255',
         
        ]);

        if ($validation->fails()) {
            Log::warning("[$requestId] Validation failed for Tax.", ['errors' => $validation->errors()->first()]);
            return $this->error($validation->errors()->first(), 400, []);
        }

        // Initialize image_name with the existing image name if available
       
        // Determine if it's an update or create operation
        $isUpdate = $request->filled('id');
        $Tax = null;

        if ($isUpdate) {
            $Tax = Tax::find($request->id);
            if ($Tax) {
                Log::info("[$requestId] Attempting to update existing Tax with ID: {$request->id}");
                $Tax->update([
                    'text'  => $request->text,
              
                ]);
                Log::info("[$requestId] Tax ID {$request->id} updated successfully.");
                return $this->success(['reload' => true], 'Tax updated successfully!');
            } else {
                Log::error("[$requestId] Error: Tax with ID {$request->id} not found for update.");
                return $this->error('Record not found for update.', 404, []);
            }
        } else {
            // This is a new record
            Log::info("[$requestId] Attempting to create a new Tax.");
            $Tax = Tax::create([
                'text'  => $request->text,
              
            ]);
            Log::info("[$requestId] New Tax created successfully with ID: {$Tax->id}");
            return $this->success(['reload' => true], 'New Tax created successfully!');
        }
    }
}
