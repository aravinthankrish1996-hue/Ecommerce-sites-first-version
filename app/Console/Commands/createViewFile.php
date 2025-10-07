<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class createViewFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:adminTableview {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new view file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Corrected: Change $this->argument('viewI') to $this->argument('view')
        $viewname = $this->argument('view');

        // Ensure the view name ends with .blade.php
        if (!str_ends_with($viewname, '.blade.php')) {
            $viewname = $viewname . '.blade.php';
        }

        $pathname = "resources/views/{$viewname}";

        // Normalize path to handle "admin/HomeBanner/home_banners" correctly
        $dir = dirname($pathname);

        if (File::exists($pathname)) {
            $this->error("File ({$pathname}) already exists.");
            return; // Stop execution if file exists
        }

        if (!File::isDirectory($dir)) { // Use File::isDirectory for clarity
            File::makeDirectory($dir, 0777, true, true); // Use File::makeDirectory
        }

        $content = '@extends("admin/layout")
@section("content")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">ADD NAME</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">ADD NAME<</li>
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
            	<h6 class="mb-0 text-uppercase">ADD NAME<</h6>
				<hr/>
                <div class="col">
										<button type="button" class="btn btn-outline-info px-5 radius-30">Add ADD NAME</button>
									</div>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>Test</th>
										<th>Link</th>
										<th>Image</th>
										<th>Created_at</th>
										<th>Updated_at</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data as $list)
									<tr>
                                        <td>1</td>
									<td>test</td>
                                    <td>link</td>
                                    <td>image</td>
                                    <td>12-12-12</td>
									<td>12-12-12</td>


									{{-- <td>{{$list->id}}</td>
									<td>{{$list->text}}</td>
                                    <td>{{$list->link}}</td>
                                    <td>{{$list->image}}</td>
                                    <td>{{$list->created_at}}</td>
									<td>{{$list->updated_at}}</td> --}}
                                  </tr>
                                  @endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>Name</th>
										<th>Position</th>
										<th>Office</th>
										<th>Age</th>
										<th>Start date</th>
										<th>Salary</th>
                                        <th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

        </div>
 
    </div>
@endsection
';

        File::put($pathname, $content);

        $this->info("File {$pathname} is created successfully.");
    }
}