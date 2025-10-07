@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">ADD Product</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ADD Product</li>
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
            	<h6 class="mb-0 text-uppercase">ADD Product</h6>
				<hr/>
                <div class="col">
				<a href="{{ url('manage_product') }}/0"><button type="button" class="btn btn-outline-info px-5 radius-30"> ADD Product</button>
									</div>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>Test</th>
										<th>Image</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data as $list)
									<tr>
                       			<td>{{$list->id}}</td>
									<td>{{$list->name}}</td>
                                         <td>
                                            @if($list->image)
                                                <img src="{{ asset('images/products/0/' . $list->image) }}" alt="Banner Image" width="50px" height="50px" onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="50px" height="50px">
                                            @endif
                                        </td>
                              <td><a href="{{ url('manage_product') }}/{{ $list->id }}"><button type="button" onclick="saveData('{{ $list->id }}','{{ $list->text }}','{{ $list->image }}')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button></a>
                              <button onclick="deleteData('{{ $list->id }}',`products`)" class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>
                                  </tr>
                                  @endforeach
								</tbody>
								<tfoot>
									<tr>
									<th>Id</th>
										<th>Test</th>
										<th>Image</th>
                                        <th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>


        </div>
 
    </div>
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
