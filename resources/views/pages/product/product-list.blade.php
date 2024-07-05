@extends('layout.CommanNavbarLayout')

@section('content')
    <h5 class="card-header d-flex justify-content-end mb-2 mx-3">
        <a href="#">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add
            </button>
        </a>
    </h5>
    <div class="card">
        <h5 class="card-header">Product List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th class="text-truncate">Id</th>
                        <th class="text-truncate">Image</th>
                        <th class="text-truncate">Name</th>
                        <th class="text-truncate">Price</th>
                        <th class="text-truncate">Category</th>
                        <th class="text-truncate">Status</th>
                        <th class="text-truncate">Action</th>
                    </tr>
                </thead>
                <tbody id="productList" class="table-border-bottom-0 text-center">
                    {{-- show list using ajax --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- add Product model  --}}
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addProduct" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add New Product</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="file" name="productImg" id="productImg"
                                        class="form-control @error('productImg') is-invalid @enderror"
                                        placeholder="Enter Name">
                                    <label for="productImg">Product Image</label>
                                    @error('productImg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="productName" id="productName"
                                        class="form-control @error('productName') is-invalid @enderror"
                                        placeholder="Enter product name">
                                    <label for="productName">Product Name</label>
                                    @error('productName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Enter product price">
                                    <label for="productName">Price</label>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="currentStatus" name="category_id">
                                        <option value="">Select Category</option>
                                        <?php
                                        $categories = App\Models\Category::all();
                                        ?>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                    <label for="currentStatus">Category</label>
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
{{-- add Product model  --}}

    <!-- update Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id">
                        <div class="form-group">
                            <img id="productImagePreview" alt="Product Image"
                                style="max-width: 200px; max-height: 200px;" />
                        </div>
                        <div class="form-group">
                            <label for="productImg">Product Img</label>
                            <input type="file" class="form-control" id="productImg" name="productImg">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="productName">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="amt" name="price">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category_id">
                                <option value="">Select Category</option>
                                <?php
                                $categories = App\Models\Category::all();
                                ?>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
                </div>
                </form>
            </div>
        </div>
    </div>
 <!-- update Product Modal -->
    <script>
        $(document).ready(function() {
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            $('#addProduct').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('add-product') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                            $('#addProduct').trigger('reset');
                            alert(response.message);
                            $('#addProductModal').modal('hide');
                            showProduct();
                    },
                    error: function(error) {
                        console.log(error);
                        alert('An error occurred while adding the product. Please try again.');
                    }
                });
            });

            $('#editProductForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var id = $('input[name="id"]').val();
                console.log(formData);

                $.ajax({
                    url: `{{ url('/product-update') }}/${id}`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#editProductForm').trigger('reset');
                        showProduct();
                        alert('Product updated successfully');
                        $('#editProductModal').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                        alert('update product failed.');
                    }
                });
            });

            function showProduct() {
            $('#productList').html('');
            $.ajax({
                url: "{{ route('product-show') }}",
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.products.length > 0) {
                        for (i = 0; i <= response.products.length; i++) {
                            $('#productList').append(`
                                <tr>
                                    <td>${response.products[i].id}</td>
                                    <td>
                                        <img id="productImg" src="/img/products/${response.products[i].productImg}" alt="Product Image" style="max-width: 200px; max-height: 200px;" />
                                    </td>
                                    <td>${response.products[i].productImg}</td>
                                    <td>${response.products[i].name}</td>
                                    <td>${response.products[i].price}</td>
                                    <td>${response.products[i].category.name}</td>
                                    <td>${response.products[i].status == 1 ? 'Active' : 'Inactive'}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#editProductModal" onclick="editProduct(${response.products[i].id})">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteProduct(${response.products[i].id})">delete</button>
                                    </td>
                                </tr>
                            `);
                        }
                    } else {
                        $('#productTable').html(
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

        showProduct();

        });



        function editProduct(id) {
            $.ajax({
                url: `{{ url('/product-edit') }}/${id}`,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    let imageUrl = `/img/products/${response.product.productImg}`;
                    $('#productImagePreview').attr('src', imageUrl);

                    // $('#productImg').val('');
                    $('#id').val(response.product.id);
                    $('#name').val(response.product.name);
                    $('#amt').val(response.product.price);
                    // Set selected category
                    $('#category').val(response.product.category_id);
                    $('#status').val(response.product.status);
                    $('#editProductModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                    alert('product data loading failed. Please try again.');
                }
            });
        }

        function deleteProduct(id) {
            $.ajax({
                url: '/product-delete/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    console.log(response);
                    showProduct();
                    alert(response.message);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
