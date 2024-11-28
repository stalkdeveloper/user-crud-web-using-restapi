    @extends('layouts.admin')
    @section('title', 'Users')

@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .common-table {
            max-height: 708px;
        }
        .common-table table thead {
            background: #f9f9f9;
            position: sticky;
            top: 0;
        }
        .card-body>form, .card-body .innerbody {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
        }
    </style>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-20">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="mb-0">Name</h4>
                        <button id="create-user-button" class="btn btn-success">Create Task</button>
                    </div>
                    <div class="d-flex justify-content-between">
                        <input type="text" id="search-bar" class="form-control" placeholder="Search ....." style="width: 200px;">
                    </div>
                </div>
                <div class="card-body">
                    <div class="innerbody">
                        <div class="table-responsive common-table">
                            <table class="table align-middle mb-0" id="user-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Profile Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="user-list" class="">
                                </tbody>                                    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.users._form')
@endsection

@section('custom_js')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @include('backend.users.script')    
@endsection