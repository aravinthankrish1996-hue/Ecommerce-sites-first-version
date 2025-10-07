@extends("admin/layout")
@section("content")
    @push('head_scripts')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    <script src="{{ asset('ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Product Management</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Form</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                            <a class="dropdown-item" href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:;">Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-uppercase">Product Details</h6>
            <hr />

            <div class="mt-3" id="alert-container"></div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 mx-auto">
                            <h6 class="mb-0 text-uppercase">Product Form</h6>
                            <hr>
                            <div class="card border-top border-0 border-4 border-info">
                                <form id="productForm" action="{{ url('updateProduct') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $data->id }}">
                                    <div class="card-body">
                                        <div class="border p-4 rounded">
                                            <div class="card-title d-flex align-items-center">
                                                <div><i class="bx bxs-box me-1 font-22 text-info"></i></div>
                                                <h5 class="mb-0 text-info">Product Information</h5>
                                            </div>
                                            <hr>
                                            <input type="hidden" name="id" value="{{ $id }}">

                                            <div class="row mb-3">
                                                <label for="productName" class="col-sm-3 col-form-label">Product
                                                    Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="productName" name="name"
                                                        value="{{ $data->name }}" placeholder="Enter Product Name">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="productSlug" class="col-sm-3 col-form-label">Product
                                                    Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="productSlug"
                                                        placeholder="Enter slug" name="slug" value="{{ $data->slug }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="productImage" class="col-sm-3 col-form-label">Main Product
                                                    Image</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="image" id="productImage">
                                                    @if($data->image)
                                                        <img src="{{ asset('images/products/0/' . $data->image) }}"
                                                            alt="Current Product Image"
                                                            style="max-width: 100px; margin-top: 10px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="itemCode" class="col-sm-3 col-form-label">Item Code</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="item_code"
                                                        value="{{ $data->item_code }}" id="itemCode"
                                                        placeholder="Enter code">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="keywords" class="col-sm-3 col-form-label">Keywords</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="keywords"
                                                        value="{{ $data->keywords }}" id="keywords"
                                                        placeholder="Enter Keywords">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="category" class="col-sm-3 col-form-label">Category</label>
                                                <div class="col-sm-9">
                                                    <select name="category_id" id="category" class="form-control">
                                                        <option value="">Select a Category</option>
                                                        @foreach ($category as $catList)
                                                            <option value="{{ $catList->id }}"
                                                                @if($data->category_id == $catList->id) selected @endif>
                                                                {{ $catList->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3" id="attributeSelectionRow">
                                                <label for="attributer_id" class="col-sm-3 col-form-label">Category
                                                    Attributes</label>
                                                <div class="col-sm-9">
                                                    <span id="multiAttr">
                                                        @if(isset($data['attributer']) && count($data['attributer']) > 0)
                                                            <select name="attributer_id[]" id="attributer_id"
                                                                class="form-control" multiple>
                                                                @foreach ($data['attributer'] as $attributerList)
                                                                    <option value="{{ $attributerList->id }}" selected>
                                                                        {{$attributerList['attribute_values']->value}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="brand" class="col-sm-3 col-form-label">Brand</label>
                                                <div class="col-sm-9">
                                                    <select name="brand_id" id="brand" class="form-control">
                                                        <option value="">Select a Brand</option>
                                                        @foreach ($brand as $brandList)
                                                            <option value="{{ $brandList->id }}"
                                                                @if($data->brand_id == $brandList->id) selected @endif>
                                                                {{ $brandList->text }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="tax" class="col-sm-3 col-form-label">Tax</label>
                                                <div class="col-sm-9">
                                                    <select name="tax_id" id="tax" class="form-control">
                                                        <option value="">Select Tax Rate</option>
                                                        @foreach ($tax as $taxList)
                                                            <option value="{{ $taxList->id }}" @if($data->tax_id == $taxList->id)
                                                            selected @endif>
                                                                {{ $taxList->text }}%
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="desc" class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description" class="form-control" id="desc" rows="3"
                                                        placeholder="Short description"
                                                        required>{{ $data->description }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Product Variants/Attributes Section -->
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Product Attributes</label>
                                                <div class="col-sm-9">
                                                    <button type="button" id="addAttributeButton" class="btn btn-info mb-3">
                                                        Add Attribute
                                                    </button>

                                                    <div id="productVariantsContainer">
                                                        @if(isset($data->productAttributer) && $data->productAttributer->count() > 0)
                                                            @foreach($data->productAttributer as $loopIndex => $variant)
                                                                <div class="row mb-3 border p-3 rounded dynamic-variant-row"
                                                                    id="variant_row_{{ $loopIndex }}">
                                                                    <input type="hidden" name="variant_id[]"
                                                                        value="{{ $variant->id }}">

                                                                    <div class="col-sm-6 mb-2">
                                                                        <label for="color_id_{{ $loopIndex }}">Color</label>
                                                                        <select name="color_id[]" id="color_id_{{ $loopIndex }}"
                                                                            class="form-control">
                                                                            <option value="">Select a color</option>
                                                                            @foreach ($color as $colorItem)
                                                                                <option value="{{ $colorItem->id }}"
                                                                                    @if($variant->color_id == $colorItem->id) selected
                                                                                    @endif>
                                                                                    {{ $colorItem->text }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6 mb-2">
                                                                        <label for="size_id_{{ $loopIndex }}">Size</label>
                                                                        <select name="size_id[]" id="size_id_{{ $loopIndex }}"
                                                                            class="form-control">
                                                                            <option value="">Select a size</option>
                                                                            @foreach ($size as $sizeItem)
                                                                                <option value="{{ $sizeItem->id }}"
                                                                                    @if($variant->size_id == $sizeItem->id) selected
                                                                                    @endif>
                                                                                    {{ $sizeItem->text }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="sku_{{ $loopIndex }}">SKU</label>
                                                                        <input type="text" name="sku[]" class="form-control"
                                                                            id="sku_{{ $loopIndex }}" placeholder="Enter SKU"
                                                                            value="{{ $variant->sku }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="mrp_{{ $loopIndex }}">MRP</label>
                                                                        <input type="text" class="form-control" name="mrp[]"
                                                                            id="mrp_{{ $loopIndex }}" placeholder="Enter MRP"
                                                                            value="{{ $variant->mrp }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="price_{{ $loopIndex }}">Price</label>
                                                                        <input type="text" name="price[]" class="form-control"
                                                                            id="price_{{ $loopIndex }}" placeholder="Enter PRICE"
                                                                            value="{{ $variant->price }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="qty_{{ $loopIndex }}">Quantity</label>
                                                                        <input type="text" name="qty[]" class="form-control"
                                                                            id="qty_{{ $loopIndex }}" placeholder="Enter QUANTITY"
                                                                            value="{{ $variant->qty }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="length_{{ $loopIndex }}">Length</label>
                                                                        <input type="text" name="length[]" class="form-control"
                                                                            id="length_{{ $loopIndex }}" placeholder="Enter LENGTH"
                                                                            value="{{ $variant->length }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="breadth_{{ $loopIndex }}">Breadth</label>
                                                                        <input type="text" name="breadth[]" class="form-control"
                                                                            id="breadth_{{ $loopIndex }}"
                                                                            placeholder="Enter BREADTH"
                                                                            value="{{ $variant->breadth }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="height_{{ $loopIndex }}">Height</label>
                                                                        <input type="text" name="height[]" class="form-control"
                                                                            id="height_{{ $loopIndex }}" placeholder="Enter HEIGHT"
                                                                            value="{{ $variant->height }}">
                                                                    </div>

                                                                    <div class="col-sm-4 mb-2">
                                                                        <label for="weight_{{ $loopIndex }}">Weight</label>
                                                                        <input type="text" name="weight[]" class="form-control"
                                                                            id="weight_{{ $loopIndex }}" placeholder="Enter WEIGHT"
                                                                            value="{{ $variant->weight }}">
                                                                    </div>

                                                                    <div class="col-12 mt-3">
                                                                        <h6>Product Images</h6>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-info add-variant-image-button"
                                                                            data-variant-index="{{ $loopIndex }}">Add Image for this
                                                                            Product</button>
                                                                        <div class="row mt-2 variant-images-container"
                                                                            id="variant_images_container_{{ $loopIndex }}">
                                                                            @if(isset($variant->productAttrImages) && $variant->productAttrImages->count() > 0)
                                                                                @foreach($variant->productAttrImages as $image)
                                                                                    <div class="col-sm-4 mb-2 d-flex align-items-center dynamic-image-input"
                                                                                        id="image_input_{{ $image->id }}">
                                                                                        <input type="hidden"
                                                                                            name="variant_image_id[{{ $loopIndex }}][]"
                                                                                            value="{{ $image->id }}">
                                                                                        <input type="file"
                                                                                            name="variant_image_file[{{ $loopIndex }}][]"
                                                                                            class="form-control">
                                                                                        <img src="{{ asset('images/productsAttr/' . $image->image) }}"
                                                                                            alt="Variant Image"
                                                                                            style="max-width: 50px; margin-left: 10px;">
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-danger remove-image-button ms-2"
                                                                                            data-image-id="{{ $image->id }}">Remove</button>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 text-end mt-3">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-variant-button"
                                                                            data-row-id="variant_row_{{ $loopIndex }}">Remove
                                                                            Attribute</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    {{-- <span id="submitbutton"> --}}
                                                        <button type="submit" class="btn btn-info px-5">Submit</button>
                                                        {{-- </span> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var editor = CKEDITOR.replace('desc');
        CKFinder.setupCKEditor(editor);

        // Global counters for dynamic elements
        var variantCount = {{ isset($data->productAttributer) ? $data->productAttributer->count() : 0 }};
        var globalImageCount = 0;

        // Function to remove a dynamic row (variant or image)
        function removeElement(elementId) {
            $('#' + elementId).remove();
        }

        // Function to add a new image input for a specific variant
        function addVariantImage(variantIndex) {
            globalImageCount++;
            var imageInputId = 'dynamic_image_input_' + variantIndex + '_' + globalImageCount;
            var html = `
                    <div class="col-sm-4 mb-2 d-flex align-items-center dynamic-image-input" id="${imageInputId}">
                        <input type="file" name="variant_image_file[${variantIndex}][]" class="form-control">
                        <button type="button" class="btn btn-sm btn-danger remove-image-button ms-2" onclick="removeElement('${imageInputId}')">Remove</button>
                    </div>
                `;
            $('#variant_images_container_' + variantIndex).append(html);
        }

        // Add Variant Button Click Handler
        $("#addAttributeButton").click(function () {
            var newVariantIndex = variantCount++;

            // Build color options
            var colorOptions = `<option value="">Select a color</option>`;
            @foreach ($color as $colorList)
                colorOptions += `<option value="{{ $colorList->id }}">{{ $colorList->text }}</option>`;
            @endforeach

                // Build size options
                var sizeOptions = `<option value="">Select a size</option>`;
            @foreach ($size as $sizeList)
                sizeOptions += `<option value="{{ $sizeList->id }}">{{ $sizeList->text }}</option>`;
            @endforeach

                var newVariantHtml = `
                    <div class="row mb-3 border p-3 rounded dynamic-variant-row" id="variant_row_${newVariantIndex}">
                        <input type="hidden" name="variant_id[]" value="">

                        <div class="col-sm-6 mb-2">
                            <label for="color_id_${newVariantIndex}">Color</label>
                            <select name="color_id[]" id="color_id_${newVariantIndex}" class="form-control">
                                ${colorOptions}
                            </select>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label for="size_id_${newVariantIndex}">Size</label>
                            <select name="size_id[]" id="size_id_${newVariantIndex}" class="form-control">
                                ${sizeOptions}
                            </select>
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="sku_${newVariantIndex}">SKU</label>
                            <input type="text" name="sku[]" class="form-control" id="sku_${newVariantIndex}" placeholder="Enter SKU">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="mrp_${newVariantIndex}">MRP</label>
                            <input type="text" class="form-control" name="mrp[]" id="mrp_${newVariantIndex}" placeholder="Enter MRP">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="price_${newVariantIndex}">Price</label>
                            <input type="text" name="price[]" class="form-control" id="price_${newVariantIndex}" placeholder="Enter PRICE">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="qty_${newVariantIndex}">Quantity</label>
                            <input type="text" name="qty[]" class="form-control" id="qty_${newVariantIndex}" placeholder="Enter QUANTITY">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="length_${newVariantIndex}">Length</label>
                            <input type="text" name="length[]" class="form-control" id="length_${newVariantIndex}" placeholder="Enter LENGTH">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="breadth_${newVariantIndex}">Breadth</label>
                            <input type="text" name="breadth[]" class="form-control" id="breadth_${newVariantIndex}" placeholder="Enter BREADTH">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="height_${newVariantIndex}">Height</label>
                            <input type="text" name="height[]" class="form-control" id="height_${newVariantIndex}" placeholder="Enter HEIGHT">
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label for="weight_${newVariantIndex}">Weight</label>
                            <input type="text" name="weight[]" class="form-control" id="weight_${newVariantIndex}" placeholder="Enter WEIGHT">
                        </div>

                        <div class="col-12 mt-3">
                            <h6>Product Images</h6>
                            <button type="button" class="btn btn-sm btn-info add-variant-image-button" data-variant-index="${newVariantIndex}">
                                Add Image for this Product
                            </button>
                            <div class="row mt-2 variant-images-container" id="variant_images_container_${newVariantIndex}">
                            </div>
                        </div>

                        <div class="col-12 text-end mt-3">
                            <button type="button" class="btn btn-danger remove-variant-button" onclick="removeElement('variant_row_${newVariantIndex}')">
                                Remove Attribute
                            </button>
                        </div>
                    </div>
                `;
            $('#productVariantsContainer').append(newVariantHtml);
        });

        // Event delegation for "Add Image for this Variant" button
        $(document).on('click', '.add-variant-image-button', function () {
            var variantIndex = $(this).data('variant-index');
            addVariantImage(variantIndex);
        });

        // Event delegation for "Remove Image" button
        $(document).on('click', '.remove-image-button', function () {
            var imageId = $(this).data('image-id');
            if (imageId) {
                console.log('Attempting to remove image with ID:', imageId);
                // Add AJAX call here to delete from server if needed
            }
            var elementId = $(this).closest('.dynamic-image-input').attr('id');
            if (elementId) {
                removeElement(elementId);
            }
        });

        $(document).ready(function () {
            function showAlert(type, message) {
                var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                $('#alert-container').html(alertHtml);
            }

            $('#productForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission immediately

                // CRITICAL FIX: Update CKEditor content before submitting
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                var formData = new FormData(this);
                var $submitButton = $(this).find('button[type="submit"]'); // Fixed selector
                var originalButtonText = $submitButton.html();

                // Show loading state
                $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        $('#alert-container').html('');

                        if (result.status === 'success') {
                            SnackBar({
                                status: "success",
                                message: result.message,
                                position: "br"
                            });

                            if (result.data && result.data.reload) {
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }

                        } else if (result.status === 'error') {
                            SnackBar({
                                status: "error",
                                message: result.message,
                                position: "br"
                            });
                            showAlert('danger', result.message);
                        }
                    },
                    error: function (xhr) {
                        $('#alert-container').html('');

                        let errorMessage = 'An unexpected error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        showAlert('danger', errorMessage);
                        SnackBar({
                            status: "error",
                            message: errorMessage,
                            position: "br"
                        });
                        console.error(xhr.responseText);
                    },
                    complete: function () {
                        $submitButton.prop('disabled', false).html(originalButtonText);
                    }
                });
            });

            // Category Change Event - Load Attributes
            $('#category').change(function (e) {
                var category_id = $(this).val();
                var html = '';
                var ajaxUrl = "{{ url('getAttributes') }}";
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $('#multiAttr').empty();

                if (category_id) {
                    $.ajax({
                        url: ajaxUrl,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            'category_id': category_id,
                        },
                        type: 'post',
                        success: function (result) {
                            console.log(result);
                            if (result.status === 'success') {
                                html += '<select name="attributer_id[]" id="attributer_id" class="form-control" multiple>';
                                if (result.data && result.data.data) {
                                    jQuery.each(result.data.data, function (key, val) {
                                        if (val.values) {
                                            jQuery.each(val.values, function (attrKey, attrVal) {
                                                html += '<option value="' + attrVal.id + '">' + val.attributer.name + '(' + attrVal.Value + ')</option>';
                                            });
                                        }
                                    });
                                }
                                html += '</select>';
                                $('#multiAttr').html(html);

                                if ($.fn.multiSelect) {
                                    $('#attributer_id').multiSelect();
                                } else {
                                    console.warn("multiSelect() function not found. Ensure the multi-select plugin is loaded.");
                                }
                            } else {
                                console.error("AJAX success with status: " + result.status + ", Message: " + result.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", status, error, xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection