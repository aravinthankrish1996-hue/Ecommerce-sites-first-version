@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">ADD Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ADD Category</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-uppercase">ADD Category</h6>
            <hr />
            <div class="col">
                <button type="button" onclick="saveData('', '', '', '', '')" class="btn btn-outline-info px-5 radius-30"
                    data-bs-toggle="modal" data-bs-target="#exampleModal"> ADD Category</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $list)
                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}}</td>
                                        <td>{{$list->slug}}</td>
                                          <td>
                                            @if($list->image)
                                                <img src="{{ asset('images/categories/' . $list->image) }}" alt="Banner Image" width="50px" height="50px" onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="50px" height="50px">
                                            @endif
                                        </td>
                                        <td>{{$list->created_at}}</td>
                                        <td>{{$list->updated_at}}</td>
                                        <td>
                                            <button type="button"
                                                onclick="saveData('{{ $list->id }}','{{ $list->name }}','{{ $list->slug }}','{{ $list->image }}','{{ $list->parent_category_id }}')"
                                                class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Update</button>
                                            <button onclick="deleteData('{{ $list->id }}',`categories`)"
                                                class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSubmit" action="{{ url('update_category') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="border p-4 rounded">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-info"></i></div>
                                <h5 class="mb-0 text-info">Category Details</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <label for="enter_name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" id="enter_name"
                                        placeholder="Enter name" required
                                        data-parsley-required-message="Category name is required.">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="enter_slug" class="col-sm-3 col-form-label">Slug</label>
                                <div class="col-sm-9">
                                    <input type="text" name="slug" class="form-control" id="enter_slug"
                                        placeholder="Enter slug" required
                                        data-parsley-required-message="Category slug is required.">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="parent_category_id" class="col-sm-3 col-form-label">Parent Category</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="parent_category_id" id="parent_category_id">
                                        <option value="">Select parent category (optional)</option>
                                        @foreach ($data as $list1)
                                            <option value="{{ $list1->id }}">{{$list1->name}} ({{$list1->slug}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="photo" class="col-sm-3 col-form-label">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" class="form-control" id="photo"
                                        onchange="previewImage(event)" data-parsley-filemaxsize="5120"
                                        data-parsley-filemaxsize-message="File size must be less than 5MB."
                                        data-parsley-filemimetypes="image/jpeg,image/png,image/jpg,image/gif"
                                        data-parsley-filemimetypes-message="Only JPEG, PNG, JPG, GIF images are allowed.">
                                    <small class="form-text text-muted">Max file size: 5MB. Allowed types: jpg, jpeg, png,
                                        gif.</small>
                                </div>
                                <div class="col-sm-12 text-center mt-2" id="image_preview_container">
                                    <img src="{{ asset('images/upload.png') }}" id="imgPreview" alt="Image Preview"
                                        height="200px" width="200px"
                                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                </div>
                            </div>

                            <input type="hidden" name="id" id="enter_id">
                            <input type="hidden" name="old_image_name" id="old_image_name">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <span id="submitbutton">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="alert-container"></div> {{-- Added for displaying general alerts --}}

    <script>
        let isSubmitting = false;

        const IMAGES_BASE_URL = "{{ asset('images/categories') }}"; // Assuming images are stored in storage/app/public/images and symlinked
        const DEFAULT_UPLOAD_PLACEHOLDER = "{{ asset('images/upload.png') }}";
        const NO_IMAGE_FALLBACK = "{{ asset('images/no-image.png') }}";
        var checkId = 0;

        // Populate modal with data for add/edit
        function saveData(id, name, slug, imageFileName, parent_category_id) {
            $('#alert-container').empty(); // Clear any previous alerts
            $('#formSubmit').parsley().reset(); // Reset Parsley validation messages

            // Show all options in parent_category_id dropdown before hiding the current one
            if (checkId !== 0) {
                $('#parent_category_id option[value="' + checkId + '"]').show();
            }

            $('#enter_id').val(id);
            $('#enter_name').val(name);
            $('#enter_slug').val(slug);
            $('#old_image_name').val(imageFileName);
            
            // Set the parent_category_id dropdown value
            $('#parent_category_id').val(parent_category_id || ''); // Use empty string for null/undefined to select "Select parent category"

            // Hide the current category from the parent category dropdown to prevent self-referencing
            if (id) { // Only hide if it's an update, not a new category
                $('#parent_category_id option[value="' + id + '"]').hide();
            }
            checkId = id; // Update checkId for the next call

            // Set image preview
            const imgPath = imageFileName ? `${IMAGES_BASE_URL}/${imageFileName}` : DEFAULT_UPLOAD_PLACEHOLDER;
            $('#imgPreview').attr('src', imgPath);
            $('#photo').val(''); // Clear the file input
        }

        // Image preview function
        function previewImage(event) {
            const output = document.getElementById('imgPreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => output.src = e.target.result;
                reader.readAsDataURL(file);
            } else {
                output.src = DEFAULT_UPLOAD_PLACEHOLDER;
            }
        }

        // Reset modal on close
        $('#exampleModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('#imgPreview').attr('src', DEFAULT_UPLOAD_PLACEHOLDER);
            $('#alert-container').empty();
            $('#formSubmit').parsley().reset();
            // Ensure all parent category options are visible again
            $('#parent_category_id option').show();
            checkId = 0; // Reset checkId
        });

        $(document).ready(function () {
            $('#formSubmit').parsley();

            // Fix broken images
            $('img').each(function () {
                const $img = $(this);
                $img.on('error', function () {
                    if ($img.attr('src') !== NO_IMAGE_FALLBACK) {
                        $img.attr('src', NO_IMAGE_FALLBACK);
                    }
                });
                if (this.complete && (!this.naturalWidth || this.naturalWidth === 0)) {
                    if ($img.attr('src') !== NO_IMAGE_FALLBACK) {
                        $img.attr('src', NO_IMAGE_FALLBACK);
                    }
                }
            });

            // Prevent duplicate form submission
            $(document).off('submit', '#formSubmit').on('submit', '#formSubmit', function (e) {
                e.preventDefault();

                if (isSubmitting) {
                    console.warn('Duplicate submission prevented.');
                    return;
                }

                const form = this;
                if (!$(form).parsley().validate()) {
                    SnackBar({
                        status: "error",
                        message: "Please correct the highlighted form errors.",
                        position: "br"
                    });
                    return;
                }

                isSubmitting = true;
                const $submitButton = $('#submitbutton button[type="submit"]');
                const originalHtml = $submitButton.html();

                $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

                const formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status === 'success') {
                            SnackBar({
                                status: "success",
                                message: result.message,
                                position: "br"
                            });
                            $('#exampleModal').modal('hide');
                            location.reload();
                        } else {
                            const msg = result.message || 'Server error.';
                            showAlert('error', msg);
                            SnackBar({
                                status: "error",
                                message: msg,
                                position: "br"
                            });
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Unexpected error. Please try again.';
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            errorMessage = "Please fix the following:<br>";
                            for (const field in xhr.responseJSON.errors) {
                                errorMessage += `- ${xhr.responseJSON.errors[field].join(', ')}<br>`;
                            }
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showAlert('error', errorMessage);
                        SnackBar({
                            status: "error",
                            message: errorMessage,
                            position: "br"
                        });
                    },
                    complete: function () {
                        $submitButton.prop('disabled', false).html(originalHtml);
                        isSubmitting = false;
                    }
                });
            });

            function showAlert(status, message) {
                const alertType = status === 'error' ? 'danger' : 'success';
                const alertHtml = `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                $('#alert-container').html(alertHtml);
            }
        });
    </script>
    <script>
        function deleteData(id, table) {
            let text = "Are you sure you want to delete this record?";
            if (confirm(text) == true) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('deleteData') }}/" + id + "/" + table,
                    data: '',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status === 'success') {
                            SnackBar({
                                status: "success",
                                message: result.message,
                                position: "br"
                            });
                            // No need to hide modal here as delete doesn't use the modal
                            location.reload();
                        } else {
                            const msg = result.message || 'Server error.';
                            SnackBar({
                                status: "error",
                                message: msg,
                                position: "br"
                            });
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Unexpected error. Please try again.';
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            errorMessage = "Please fix the following:<br>";
                            for (const field in xhr.responseJSON.errors) {
                                errorMessage += `- ${xhr.responseJSON.errors[field].join(', ')}<br>`;
                            }
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        SnackBar({
                            status: "error",
                            message: errorMessage,
                            position: "br"
                        });
                    }
                });
            }
        }
    </script>
@endsection