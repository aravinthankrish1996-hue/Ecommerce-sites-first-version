<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;
use App\Traits\SaveFile;

class brandController extends Controller
{
      use ApiResponse;
      use SaveFile;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =Brand::get();
        return view('admin/Brand/brands',get_defined_vars());
    }
     public function store(Request $request)
    {
           // --- 1. Log the start of the request ---
       $requestId = uniqid('category_req_'); // Generate a unique ID for this request
        Log::info("[$requestId] store method started for Brand.", $request->all());

        $validation = Validator::make($request->all(), [
            'id'    => 'nullable|integer', // Added 'id' for update scenarios
            'text'  => 'required|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'old_image_name' => 'nullable|string', // Hidden field for existing image name
        ]);

        if ($validation->fails()) {
            Log::warning("[$requestId] Validation failed for Brand.", ['errors' => $validation->errors()->first()]);
            return $this->error($validation->errors()->first(), 400, []);
        }

        // Initialize image_name with the existing image name if available
        $image_name = $request->input('old_image_name');
        $imageDirectory = 'images/Brand'; // Define your specific directory for category images

        // Handle new image upload
        if ($request->hasFile('image')) {
            Log::info("[$requestId] New image detected for upload for Brand.");

            // Call the trait method to save the new image and handle old image deletion
            $image_name = $this->saveImage(
                $request->file('image'),
                $imageDirectory,
                $request->input('old_image_name'), // Pass the old image name for deletion
                $requestId
            );
        } else {
            Log::info("[$requestId] No new image uploaded for Brand. Retaining old image name: {$image_name}");
        }

        // Determine if it's an update or create operation
        $isUpdate = $request->filled('id');
        $Brand = null;

        if ($isUpdate) {
            $Brand = Brand::find($request->id);
            if ($Brand) {
                Log::info("[$requestId] Attempting to update existing Brand with ID: {$request->id}");
                $Brand->update([
                    'text'  => $request->text,
                    'image' => $image_name
                ]);
                Log::info("[$requestId] Brand ID {$request->id} updated successfully.");
                return $this->success(['reload' => true], 'Brand updated successfully!');
            } else {
                Log::error("[$requestId] Error: Brand with ID {$request->id} not found for update.");
                return $this->error('Record not found for update.', 404, []);
            }
        } else {
            // This is a new record
            Log::info("[$requestId] Attempting to create a new Brand.");
            $Brand = Brand::create([
                'text'  => $request->text,
                'image' => $image_name
            ]);
            Log::info("[$requestId] New Brand created successfully with ID: {$Brand->id}");
            return $this->success(['reload' => true], 'New Brand created successfully!');
        }
    }
   
}
