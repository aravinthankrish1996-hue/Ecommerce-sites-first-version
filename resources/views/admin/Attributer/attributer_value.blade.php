@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">ADD Attributer Value</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ADD Attributer Value</li>
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
            	<h6 class="mb-0 text-uppercase">ADD Attributer Value</h6>
				<hr/>
                <div class="col">
										<button type="button" onclick="saveData('','','')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal"> ADD Attributer Value</button>
									</div>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>Attribute Namw</th>
										<th>Value</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data as $list)
									<tr>
									<td>{{$list->id}}</td>
									<td>{{$list['singleAttribute']->name}},{{$list['singleAttribute']->slug}}</td>
                                    <td>{{$list->value}}</td>
                                      <td>
                                            <button type="button" onclick="saveData('{{ $list->id }}','{{ $list->attributers_id }}','{{ $list->value }}')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                                        <button onclick="deleteData('{{ $list->id }}',`attribute_values`)" class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>
                                  </tr>
                                  @endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>Id</th>
										<th>Attribute Name</th>
										<th>Value</th>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Attributer Value</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="formSubmit" action="{{ url('update_attributer_value') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-info"></i></div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="enter_text" class="col-sm-3 col-form-label">Attribute Name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="attributers_id" id="attributers_id"> 
                                    @foreach ($attributer as $list1)
                                        <option value="{{ $list1->id }}">{{$list1->name}}({{$list1->slug}})</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="name" class="form-control" id="enter_name" placeholder="Enter name" required data-parsley-required-message="Text field is required."> --}}
                            </div>
                        </div>
                            <div class="row mb-3">
                            <label for="enter_text" class="col-sm-3 col-form-label">Attribute value</label>
                            <div class="col-sm-9">
                                <input type="text" name="value" class="form-control" id="attributer_value" placeholder="Enter value" required data-parsley-required-message="Text field is required.">
                            </div>
                        </div>


                        <input type="hidden" name="id" id="enter_id">

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
function saveData(id,attributers_id,attributer_value) {


    $('#enter_id').val(id);
    $('#attributers_id').val(attributers_id);
     $('#attributer_value').val(attributer_value);



}
</script>
<script>
    // Define the showAlert function to display Bootstrap alerts
    function showAlert(status, message) {
        var alertType = status === 'error' ? 'danger' : 'warning';
        var alertHtml = `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                             ${message}
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                           </div>`;
        // Place the alert in the placeholder div
        $('#alert-container').html(alertHtml);
    }

    $(document).ready(function() {
        $('#formSubmit').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission immediately

            // You can add Parsley validation here if you are using it
            // if (!$(this).parsley().validate()) {
            //    return; // Stop if validation fails
            // }

            var formData = new FormData(this);
            var $submitButton = $('#submitbutton');
            var originalButtonText = $submitButton.html(); // Save original text, e.g., "Save Changes"

            // Show loading state
            $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    // Clear any old alerts from the alert-container
                    $('#alert-container').html('');

                    // Check for the lowercase 'status' from the ApiResponse trait
                    if (result.status === 'success') {
                        SnackBar({
                            status: "success", // SnackBar might use its own status keyword
                            message: result.message,
                            position: "br"
                        });

                        // Optionally, if your Laravel backend returns reload:true
                        // And you want to reload the page on successful submission
                        if (result.data && result.data.reload) {
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Reload after 1 second to allow SnackBar to show
                        }

                    } else if (result.status === 'error') { // Assuming your error response also has a 'status' field
                        // If it's an error from your ApiResponse trait
                        SnackBar({
                            status: "error", // SnackBar might use its own status keyword
                            message: result.message,
                            position: "br"
                        });
                        // Also show a Bootstrap alert for errors, as you have showAlert defined
                        showAlert('error', result.message);
                    }
                    // Handle other potential statuses if necessary
                },
                error: function(xhr) {
                    // This block handles HTTP errors (e.g., 400, 401, 404, 500)
                    // Clear any old alerts
                    $('#alert-container').html('');

                    let errorMessage = 'An unexpected error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showAlert('error', errorMessage);
                    SnackBar({
                        status: "error",
                        message: errorMessage,
                        position: "br"
                    });
                    console.error(xhr.responseText);
                },
                complete: function() {
                    // This runs after success or error, to restore the button
                    $submitButton.prop('disabled', false).html(originalButtonText);
                }
            });
        });
    });
</script>
<script>

  
    function deleteData(id, table) {
        let text = "Are you sure you want to delete this item?";
        if (confirm(text)) { // confirm returns true or false
            $.ajax({
                type: 'GET', // Changed to GET as per your URL structure
                url: "{{ url('deleteData') }}/" + id + "/" + table,
                data: '', // No data needed for GET request
                cache: false,
                contentType: false, // Not needed for GET, but okay if left
                processData: false, // Not needed for GET, but okay if left
                success: function(result) {
                    if (result.status === 'success') {
                        SnackBar({
                            status: "success",
                            message: result.message,
                            position: "br"
                        });
                        // No need to hide exampleModal here, it's for the add/update form
                        // location.reload() is important for delete
                        setTimeout(function() {
                            location.reload();
                        }, 500); // Reload faster after delete
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
                error: function(xhr) {
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
                }
                // Removed 'complete' callback as there's no button state to manage for delete
            });
        }
    }
</script>
@endsection
