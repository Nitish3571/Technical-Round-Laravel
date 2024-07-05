@extends('layout.CommanNavbarLayout')

@section('content')
    <h5 class="card-header d-flex justify-content-end mb-2 mx-3">
        <a href="#">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                Add
            </button>
        </a>
    </h5>
    <div class="card">
        <h5 class="card-header">Category List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-truncate">ID</th>
                        <th class="text-truncate">Name</th>
                        <th class="text-truncate">Status</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="CategoryList">
                    {{-- using ajax show category list  --}}
                </tbody>
            </table>
        </div>
    </div>


    <!-- add Category Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addCategory" action="{{ route('category-store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add New Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="name" id="category"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter Category Name">
                                    <label for="category">Category Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="currentStatus" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <label for="currentStatus">Status</label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- add Category Modal -->


    <!-- Update Category Modal -->
    <div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="categoryEditModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="updateCategoryForm" action="{{ url('/category-update') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Update Category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <input type="hidden" name="id" id="id" class="form-control">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="name" id="categoryName" class="form-control"
                                        placeholder="Enter Name">
                                    <label for="categoryName">Category Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="status" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <label for="editCategoryStatus">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Update Category Modal -->

    <script>
        $(document).ready(function() {
            $('#addCategory').submit(function(e) {
                console.log('click');
                e.preventDefault();

                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).attr('method');

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        alert('Category added successfully');
                        $('#addCategory')[0].reset();
                        showCategory();
                        $('#basicModal').modal('hide');

                    },
                    error: function(error) {
                        console.error(error);
                        alert('Category added failed please try again');
                    }
                });
            });
        });

        function showCategory() {
            $('#CategoryList').html('');
            $.ajax({
                url: "{{ route('category-show') }}",
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.categories.length > 0) {
                        for (i = 0; i <= response.categories.length; i++) {
                            $('#CategoryList').append(`
                                <tr>
                                    <td>${response.categories[i].id}</td>
                                    <td>${response.categories[i].name}</td>
                                    <td>${response.categories[i].status == 1 ? 'Active' : 'Inactive'}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#editProductModal" onclick="editCategory(${response.categories[i].id})">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteCategory(${response.categories[i].id})">delete</button>
                                    </td>

                                </tr>
                            `);
                        }
                    } else {
                        $('#CategoryList').html(
                            '<tr><td colspan="5" class="text-center">No products found.</td></tr>'
                        );
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('Error loading products. Please try again.');
                }
            });
        }
        showCategory();

        function editCategory(id) {
            $.ajax({
                url: '/category-edit/' + id,
                type: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#id').val(response.id);
                    $('#categoryName').val(response.name);
                    $('#status').val(response.status);

                    $('#categoryEditModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $('#updateCategoryForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');

            $.ajax({
                url: url,
                method: method,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    alert('Category Updated successfully');
                    showCategory();
                    $('#categoryEditModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        function deleteCategory(id) {
            $.ajax({
                url: '/category-delete/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    console.log(response);
                    alert(response.message);
                    showCategory();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
