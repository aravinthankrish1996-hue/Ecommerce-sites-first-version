<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Colour;
use App\Models\ProductAttr;
use App\Models\ProductAttrImages;
use App\Models\CategoryAttribute;
use App\Models\Tax;
use App\Models\Size;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;
use App\Traits\SaveFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

use App\Models\Attributer;
use App\Models\ProductAttribute;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Str;

class productController extends Controller
{
    use ApiResponse;
    use SaveFile;

    public function index()
    {
        $data = Product::get();
        return view('admin/Product/product', get_defined_vars());
    }

    public function view_product($id = 0)
    {
        $category = Category::get();
        $color = Colour::get();
        $brand = Brand::get();
        $size = Size::get();
        $tax = Tax::get();

        $data = null; // Initialize data to null
        $product_attr = new ProductAttr(); // Initialize as new instances

        // Always fetch categories, colours, sizes, and taxes

        if ($id == 0) {
            // New product
            $data = new Product();
            $product_attr_images = new ProductAttrImages(); // Initialize as new instances
        } else {
            // Update product - Load with all necessary relationships
            $validation = Validator::make(['id' => $id], [
                'id' => 'required|exists:products,id',
            ]);

            if ($validation->fails()) {
                return Redirect::back();
            } else {
                // Load product with all relationships including variants (productAttributer) and images
                $data = Product::where('id', $id)
                    ->with([
                        'attributer.attribute_values',
                        'productAttributer.productAttrImages'
                    ])
                    ->first();

                // If no productAttributer exists, initialize as empty collection
                if (!$data->productAttributer) {
                    $data->productAttributer = collect();
                }
            }
        }

        return view('admin/Product/manage_product', get_defined_vars());
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $requestId = uniqid('category_req_');
            Log::info("[$requestId] store method started for Category.", $request->all());

            $validation = Validator::make($request->all(), [
                'id'    => 'nullable|integer',
                'name'  => 'required|string|max:255',
                'slug'  => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
                

                // Fixed validation for array inputs
                'attributer_id' => 'nullable|array',
                'variant_id'    => 'nullable|array',
                'sku'           => 'nullable|array',
                'color_id'      => 'nullable|array',  // Changed to array
                'size_id'       => 'nullable|array',  // Changed to array
                'mrp'           => 'nullable|array',
                'price'         => 'nullable|array',
                'qty'           => 'nullable|array',
                'length'        => 'nullable|array',
                'breadth'       => 'nullable|array',
                'height'        => 'nullable|array',
                'weight'        => 'nullable|array',
            ]);

            $cleanImageName = $this->clean($request->name);

            if ($validation->fails()) {
                return $this->error($validation->errors()->first(), 400, []);
            }

            $slug = replaceStr($request->slug);
            $image_name = null;

            if ($request->hasFile('image')) {
                if ($request->id > 0) {
                    $existingProduct = Product::find($request->id);
                    if ($existingProduct && $existingProduct->image) {
                        $Image_path = "images/products/" . $existingProduct->image;
                        if (File::exists($Image_path)) {
                            File::delete($Image_path);
                        }
                    }
                }
                $image_name = $cleanImageName . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/products/' . $request->id), $image_name);
            } elseif ($request->id > 0) {
                $image_name = Product::where('id', $request->id)->value('image');
            }

            $product = Product::updateOrCreate(
                ['id' => $request->id],
                [
                    'name'        => $request->name,
                    'slug'        => $slug,
                    'category_id' => $request->category_id,
                    'brand_id'    => $request->brand_id,
                    'tax_id'      => $request->tax_id,
                    'description' => $request->description,
                    'item_code'   => $request->item_code,
                    'keywords'    => $request->keywords,
                    'image'       => $image_name,
                ]
            );

            $productId = $product->id;

            // Handle product attributes (category attributes)
            ProductAttribute::where('product_id', $productId)->delete();

            if ($request->has('attributer_id')) {
                foreach ($request->input('attributer_id', []) as $val) {
                    ProductAttribute::create([
                        'product_id' => $productId,
                        'category_id' => $request->category_id,
                        'attribute_values_id' => $val
                    ]);
                }
            }

            // Handle product variants/attributes with better logic
            if ($request->has('sku') && is_array($request->sku)) {
                // If updating, handle existing variants
                if ($request->id > 0) {
                    $existingVariantIds = $request->input('variant_id', []);
                    // Delete variants that are not in the update list
                    ProductAttr::where('product_id', $productId)
                        ->whereNotIn('id', array_filter($existingVariantIds))
                        ->delete();
                }

                foreach ($request->input('sku', []) as $key => $skuValue) {
                    // Skip if SKU is empty
                    if (empty($skuValue)) continue;

                    $variantId = $request->input('variant_id.' . $key);

                    $productAttr = ProductAttr::updateOrCreate(
                        ['id' => $variantId ?: null, 'product_id' => $productId],
                        [
                            'product_id' => $productId,
                            'color_id'   => $request->input('color_id.' . $key) ?: null,
                            'size_id'    => $request->input('size_id.' . $key) ?: null,
                            'sku'        => $skuValue,
                            'mrp'        => $request->input('mrp.' . $key) ?: null,
                            'price'      => $request->input('price.' . $key) ?: null,
                            'qty'        => $request->input('qty.' . $key) ?: null,
                            'length'     => $request->input('length.' . $key) ?: null,
                            'breadth'    => $request->input('breadth.' . $key) ?: null,
                            'height'     => $request->input('height.' . $key) ?: null,
                            'weight'     => $request->input('weight.' . $key) ?: null,
                        ]
                    );

                    $productAttrId = $productAttr->id;

                    // Handle variant images
                    $imageKey = "variant_image_file." . $key;

                    if ($request->hasFile($imageKey)) {
                        // Only delete existing images if new ones are being uploaded
                        if (!$variantId) {
                            ProductAttrImages::where('product_attr_id', $productAttrId)->delete();
                        }

                        foreach ($request->file($imageKey) as $file) {
                            $attrImageName = $this->getRandomValue() . time() . '.' . $file->extension();
                            $file->move(public_path('images/productsAttr/'), $attrImageName);

                            ProductAttrImages::create([
                                'product_id' => $productId,
                                'product_attr_id' => $productAttrId,
                                'image' => $attrImageName
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return $this->success([], 'Product saved successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Product store error: ' . $th->getMessage());
            return response()->json(['error' => 'Something went wrong.', 'details' => $th->getMessage()], 500);
        }
    }

    private function clean($name)
    {
        return Str::slug($name);
    }

    public function getAttributes(Request $request)
    {
        $categoryId = $request->input('category_id');

        // IMPORTANT: Eager load the 'attributer' relationship on CategoryAttribute,
        // and 'values' relationship on the 'attributer' model itself.
        $categoryAttributes = CategoryAttribute::where('category_id', $categoryId)
            ->with(['attributer', 'values']) // Eager load attributer and its values
            ->get();

        $formattedAttributes = $categoryAttributes->map(function ($categoryAttribute) {
            // Check if the attributer relationship exists and is loaded
            if ($categoryAttribute->attributer) {
                return [
                    'id' => $categoryAttribute->attributer->id, // Use the attributer's ID for the option value
                    'attributer' => [
                        'name' => $categoryAttribute->attributer->name, // The actual attributer's name
                    ],
                    'values' => $categoryAttribute->attributer->values->map(function ($value) {
                        return ['id' => $value->id, 'Value' => $value->value];
                    })->toArray()
                ];
            }
            return null; // Handle cases where attributer might be null (though ideally it shouldn't happen with proper foreign keys)
        })->filter()->values()->toArray(); // Filter out nulls and re-index the array

        return response()->json([
            'status' => 'success',
            'message' => 'Attributes fetched successfully',
            'data' => [
                'data' => $formattedAttributes
            ]
        ]);
    }

    public function getRandomValue()
    {
        $random = rand(1111111, 9999999);
        return $random;
    }

    public function edit($id)
    {
        $product = Product::with(['variants.images'])->findOrFail($id);
        $colors = Colour::all();
        $sizes = Size::all();

        return view('admin.product.edit', compact('product', 'colors', 'sizes'));
    }

    public function attrDummyData()
    {
        $data[0]['id'] = 0;
        $data[0]['color_id'] = 0;
        $data[0]['size_id'] = 0;
        $data[0]['sku'] = 0;
        $data[0]['mrp'] = 0;
        $data[0]['price'] = 0;
        $data[0]['qty'] = 0;
        $data[0]['length'] = 0;
        $data[0]['breadth'] = 0;
        $data[0]['weight'] = 0;
        return $data;
    }
}
