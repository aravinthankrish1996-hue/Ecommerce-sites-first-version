<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Attributer; // This model doesn't seem to be used in your 'store' method, consider removing if not needed.
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Traits\SaveFile;
use Illuminate\Support\Facades\Log; // For logging
use App\Models\CategoryAttribute;

class CategoryController extends Controller // Corrected case for CategoryController
{
    use ApiResponse;
    use SaveFile; // Use the SaveFile trait

    public function index()
    {
        $data = Category::get();
        return view('admin/Category/category', get_defined_vars());
    }

    public function store(Request $request)
    {
        $requestId = uniqid('category_req_'); // Generate a unique ID for this request
        Log::info("[$requestId] store method started for Category.", $request->all());

        $validation = Validator::make($request->all(), [
            'id'    => 'nullable|integer', // Added 'id' for update scenarios
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|max:255',
            'parent_category_id' => 'nullable|string',
            // 'attributer_id' => 'required|exists:attributers,id', // Uncomment if you need this
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'old_image_name' => 'nullable|string', // Hidden field for existing image name
        ]);

        if ($validation->fails()) {
            Log::warning("[$requestId] Validation failed for Category.", ['errors' => $validation->errors()->first()]);
            return $this->error($validation->errors()->first(), 400, []);
        }

        // Initialize image_name with the existing image name if available
        $image_name = $request->input('old_image_name');
        $imageDirectory = 'images/categories'; // Define your specific directory for category images
        $slug = replaceStr($request->slug);

        // Handle new image upload
        if ($request->hasFile('image')) {
            Log::info("[$requestId] New image detected for upload for Category.");

            // Call the trait method to save the new image and handle old image deletion
            $image_name = $this->saveImage(
                $request->file('image'),
                $imageDirectory,
                $request->input('old_image_name'), // Pass the old image name for deletion
                $requestId
            );
        } else {
            Log::info("[$requestId] No new image uploaded for Category. Retaining old image name: {$image_name}");
        }

        // Determine if it's an update or create operation

        $isUpdate = $request->filled('id');
        $category = null;

        if ($isUpdate) {
            $category = Category::find($request->id);
            if ($category) {
                Log::info("[$requestId] Attempting to update existing Category with ID: {$request->id}");
                $category->update([
                    'name'  => $request->name,
                    'slug'  => $slug,
                    'parent_category_id' => $request->parent_category_id,
                    // 'attributers_id' => $request->attributers_id, // Uncomment if you need this
                    'image' => $image_name
                ]);
                Log::info("[$requestId] Category ID {$request->id} updated successfully.");
                return $this->success(['reload' => true], 'Category updated successfully!');
            } else {
                Log::error("[$requestId] Error: Category with ID {$request->id} not found for update.");
                return $this->error('Record not found for update.', 404, []);
            }
        } else {
            // This is a new record
            Log::info("[$requestId] Attempting to create a new Category.");
            $category = Category::create([
                'name'  => $request->name,
                'slug'  => $slug,
                'parent_category_id' => $request->parent_category_id,

                // 'attributers_id' => $request->attributers_id, // Uncomment if you need this
                'image' => $image_name
            ]);
            Log::info("[$requestId] New Category created successfully with ID: {$category->id}");
            return $this->success(['reload' => true], 'New category created successfully!');
        }
    }



    public function index_category_attribute()
    {
        $data = CategoryAttribute::with('category', 'attributer')->get();
        $category = Category::get();
        $attributer = Attributer::get();

        return view('admin/Category/category_attributer', get_defined_vars());
    }
    public function store_category_attributer(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'attributers_id'           => 'required|exists:attributers,id',
            'category_id'           => 'required|exists:categories,id',
            'value'           => 'string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            // Corrected method name from updateOrCreater to updateOrCreate
            CategoryAttribute::updateOrCreate(
                ['id' => $request->id],
                ['attributers_id' => $request->attributers_id, 'category_id' => $request->category_id,]
            );
            return $this->success(['reload' => true], 'Successfully updated');
        }
    }
}
