<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajax App</title>
    <style>
        body {
            font-family: monospace !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    {{-- fontawesome css --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    {{-- toastr css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- sweetalert2  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.8/sweetalert2.min.css"
        integrity="sha512-NvuRGlPf6cHpxQqBGnPe7fPoACpyrjhlSNeXVUY7BZAj1nNhuNpRBq3osC4yr2vswUEuHq2HtCsY2vfLNCndYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center shadow-lg">
        <div class="col-10 shadow-lg p-3 table-responsive" id="main">
            <h1 class="display-5 fw-bolder py-3 text-center">
                The All Users Information
            </h1>
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cout = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $cout++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <a type="button" id="{{ $user->id }}"
                                        class="btnEdit btn-sm btn btn-outline-info">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </a>
                                    <a type="button" id="{{ $user->id }}"
                                        class="btnDel btn-sm btn btn-outline-danger">
                                        <i class="fa-solid fa-user-xmark"></i>
                                    </a>
                                    <a type="button" id="{{ $user->id }}"
                                        class="btnView btn-sm btn btn-outline-dark">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-notify modal-info" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog rounded-0">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">User Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <input class="form-control mod_id shadow-sm" type="hidden" name="id" id="id"
                                placeholder="id">
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control mod_name shadow-sm" type="text" name="name" id="name"
                                placeholder="Name">
                            <small class="text-danger err_name mt-1"></small>
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control mod_email shadow-sm" type="email" name="email" id="email"
                                placeholder="email@hotmail.com">
                            <small class="text-danger err_email mt-1"></small>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnUpdate">Update Info</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-notify modal-info" id="modalView" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog rounded-0">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">User View Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <input class="form-control modView_id shadow-sm" type="text" disabled name="id"
                                id="id" placeholder="id">
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control modView_name shadow-sm" type="text" disabled name="name"
                                id="name" placeholder="Name">
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control modView_email shadow-sm" type="email" disabled
                                name="email" id="email" placeholder="email@hotmail.com">
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control modView_created_at shadow-sm" type="text" disabled
                                name="created_at" id="created_at" placeholder="Created At">
                        </div>
                        <div class="col-12 mb-2">
                            <input class="form-control modView_updated_at shadow-sm" type="text" disabled
                                name="updated_at" id="updated_at" placeholder="Updated At">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    {{-- fontawesome js --}}
    <script src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- toastr js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- sweetalert2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.8/sweetalert2.min.js"
        integrity="sha512-c1AfYKag4intaizqJC0Zx1NxImYP7B2namyOLbpFW3P12oYkZjQGQ/8r6N75SlWidbm7oQElnVZqBzRvFtU0Hw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btnEdit').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url: `users/${id}/edit`,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response.user.id);
                        $('.mod_id').val(response.user.id);
                        $('.mod_name').val(response.user.name);
                        $('.mod_email').val(response.user.email);
                    }
                });

                $('#modalEdit').modal('show');
            });

            $('.btnView').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url: `users/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        $('.modView_id').val(response.id);
                        $('.modView_name').val(response.name);
                        $('.modView_email').val(response.email);
                        $('.modView_created_at').val(response.created_at);
                        $('.modView_updated_at').val(response.updated_at);
                    }
                });

                $('#modalView').modal('show');
            });



            $('.btnUpdate').click(function(e) {
                e.preventDefault();
                var id = $('.mod_id').val();
                var name = $('.mod_name').val();
                var email = $('.mod_email').val();
                var data = {
                    'name': name,
                    'email': email,
                };


                $.ajax({
                    type: "PUT",
                    url: `users/${id}`,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        $('.err_email').html("");
                        $('.err_name').html("");
                        $('#name').removeClass("is-invalid");
                        $('#email').removeClass("is-invalid");
                        if (response.errors) {
                            if (response.errors.name) {
                                $('#name').addClass("is-invalid");
                                $('.err_name').append(response.errors.name);
                            }
                            if (response.errors.email) {
                                $('#email').addClass("is-invalid");
                                $('.err_email').append(response.errors.email);
                            }
                        } else {
                            $('#modalEdit').modal('hide');
                            // window.top.location.reload(true);
                            if (response.success) {
                                toastr.success(response.success);
                            }
                            if (response.error) {
                                toastr.error(response.error);
                            }
                            setTimeout(function() {
                                location.reload(1);
                            }, 1000);

                        }

                    }
                });

            });

            $('.btnDel').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `/users/${id}`,
                            dataType: "JSON",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.success,
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Deleted!',
                                        response.error,
                                        'error'
                                    )
                                }

                            }
                        });

                    }
                    setTimeout(function() {
                        location.reload(1);
                    }, 1000);
                })
            });
        });
    </script>

</body>

</html>
