<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Traits\ApiResponse;
class homeBannerController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =HomeBanner::get();
        return view('admin/HomeBanner/home_banners',get_defined_vars());
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
           // --- 1. Log the start of the request ---
        $requestId = uniqid('banner_req_'); // Generate a unique ID for this request
        Log::info("[$requestId] updateHomeBanner method started.", $request->all());

        $validation = Validator::make($request->all(), [
            'id'             => 'nullable|integer',
            'text'           => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'image'          => 'nullable|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            'old_image_name' => 'nullable|string', // The hidden field from frontend
        ]);

        if ($validation->fails()) {
            Log::warning("[$requestId] Validation failed for Home Banner.", ['errors' => $validation->errors()->first()]);
            return $this->error($validation->errors()->first(), 200, []);
        }

        // Initialize image_name with the existing image name if available
        $image_name = $request->input('old_image_name');

        // Handle new image upload
        if ($request->hasFile('image')) {
            Log::info("[$requestId] New image detected for upload.");
            // A new image has been uploaded, so delete the old one if it exists
            if ($request->filled('old_image_name')) { // Check if old_image_name was sent and is not empty
                $oldImagePath = public_path('images/' . $request->old_image_name);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    Log::info("[$requestId] Old image deleted: {$request->old_image_name}");
                } else {
                    Log::info("[$requestId] Old image not found at path: {$oldImagePath}");
                }
            }

            // Move the new image to the public/images directory
            $uploadedImage = $request->file('image');
            $image_name = time() . '.' . $uploadedImage->extension();
            $uploadedImage->move(public_path('images/'), $image_name);
            Log::info("[$requestId] New image uploaded: {$image_name}");
        } else {
            Log::info("[$requestId] No new image uploaded. Retaining old image name: {$image_name}");
        }

        // --- 2. Explicitly determine if it's an update or create ---
        $isUpdate = $request->filled('id');
        $banner = null;

        if ($isUpdate) {
            $banner = HomeBanner::find($request->id);
            if ($banner) {
                Log::info("[$requestId] Attempting to update existing banner with ID: {$request->id}");
                $banner->update([
                    'text'  => $request->text,
                    'link'  => $request->link,
                    'image' => $image_name
                ]);
                Log::info("[$requestId] Home Banner ID {$request->id} updated successfully.");
                return $this->success([], 'Banner updated successfully!'); // Specific message for update
            } else {
                // This means an ID was provided but the record doesn't exist
                Log::error("[$requestId] Error: Home Banner with ID {$request->id} not found for update.");
                return $this->error('Record not found for update.', 404, []); // 404 is more appropriate for "not found"
            }
        } else {
            // This is a new record
            Log::info("[$requestId] Attempting to create a new Home Banner.");
            $banner = HomeBanner::create([
                'text'  => $request->text,
                'link'  => $request->link,
                'image' => $image_name
            ]);
            Log::info("[$requestId] New Home Banner created successfully with ID: {$banner->id}");
            return $this->success([], 'New banner created successfully!'); 
        }
    }
    

    /**
     * Display the specified resource.
     */
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
