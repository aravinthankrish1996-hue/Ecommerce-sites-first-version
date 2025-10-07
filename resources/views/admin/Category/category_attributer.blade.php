@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">ADD Category Attribute</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ADD Category Attribute</li>
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
            	<h6 class="mb-0 text-uppercase">ADD Category Attribute</h6>
				<hr/>
                <div class="col">
										<button type="button" onclick="saveData('', '', '')" class="btn btn-outline-info px-5 radius-30"
                    data-bs-toggle="modal" data-bs-target="#exampleModal"> ADD Category Attribute</button>
									</div>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>Category</th>
										<th>Attribute</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data as $list)
									<tr>
                                <td>{{$list->id}}</td>
                                    <td>{{$list['category']->name}}</td>
                                   <td>{{$list['attributer']->name}}</td>
                                      <td>
                                            <button type="button"
                                                onclick="saveData('{{ $list->id }}','{{ $list->category_id }}','{{ $list->attributers_id }}')"
                                                class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Update</button>
                                            <button onclick="deleteData('{{ $list->id }}',`category_attribute`)"
                                                class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>
                                  </tr>
                                  @endforeach
								</tbody>
								<tfoot>
									<tr>
											<th>Id</th>
										<th>Category</th>
										<th>Attribute</th>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Category Attribute</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="formSubmit" action="{{ url('update_category_attributer') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-info"></i></div>
                        </div>
                        <hr>
                       <div class="row mb-3">
                                <label for="category_id" class="col-sm-3 col-form-label">Category Id</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="">Select Category (optional)</option>
                                        @foreach ($category as $list1)
                                            <option value="{{ $list1->id }}">{{$list1->name}} ({{$list1->slug}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                              <div class="row mb-3">
                                <label for="attributers_id" class="col-sm-3 col-form-label">Attribute Id</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="attributers_id" id="attributers_id">
                                        <option value="">Select Attribute (optional)</option>
                                        @foreach ($attributer as $list2)
                                            <option value="{{ $list2->id }}">{{$list2->name}} ({{$list2->slug}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                  
{{-- 
                        <input type="hidden" name="id" id="enter_id">
                        <input type="hidden" name="old_image_name" id="old_image_name"> --}}

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

<script>
    let isSubmitting = false;

// Populate modal
function saveData(id,category_id,attributers_id) {


    $('#enter_id').val(id);
      $('#category_id').val(category_id);
    $('#attributers_id').val(attributers_id);
  
}

// Reset modal on close
$('#exampleModal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $('#imgPreview').attr('src', DEFAULT_UPLOAD_PLACEHOLDER);
    $('#alert-container').empty();
    $('#formSubmit').parsley().reset();
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

    // Prevent duplicate form handler
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

    function deleteData(id,table)
    {
        let text="Are you sure want delete";
        if(confirm(text)== true){
            $.ajax({
            type: 'GET',
            url: "{{ url('deleteData') }}/"+id+"/"+table+"",
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
        }else{
        
        }
       
    }
</script>


@endsection
