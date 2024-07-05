@extends('layout.CommanNavbarLayout')
@section('content')
    <div class="row gy-4">
        <?php
        $userId = session('login_admin_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        // dd($userId);
        $user = DB::table('admins')->where('id', $userId)->first();
        ?>

        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1">Congratulations @if ($user->name)
                            {{ $user->name }}
                        @endif 🎉</h4>
                    <p class="mb-2 pb-1 mt-4" style="margin-right:20%">
                        We are thrilled to announce a significant milestone this month. Our recent growth reflects the hard
                        work, dedication, and trust of our community. 🚀
                    </p>
                </div>
            </div>
        </div>

        <!-- Overview -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Overview</h5>

                    </div>
                    <p class="mt-3">Total Product and Category Overview 😎 </p>

                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-primary rounded shadow">
                                        <i class="mdi mdi-trending-up mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    @php
                                        $totalUser = App\Models\Admin::count();
                                    @endphp
                                    <div class="small mb-1">Total User</div>
                                    <h5 class="mb-0">{{ $totalUser }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-success rounded shadow">
                                        <i class="mdi mdi-account-outline mdi-24px"></i>
                                    </div>
                                </div>

                                <div class="ms-3">
                                    @php
                                        $totalProduct = App\Models\Product::count();
                                    @endphp
                                    <div class="small mb-1">Total Product</div>
                                    <h5 class="mb-0">{{ $totalProduct }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-warning rounded shadow">
                                        <i class="mdi mdi-cog-outline mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    @php
                                        $totalCategory = App\Models\Category::count();
                                    @endphp
                                    <div class="small mb-1">Total Category</div>
                                    <h5 class="mb-0">{{ $totalCategory }}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Users Tables -->
        <div class="card">
            <h5 class="card-header">Recent Users</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-truncate">User Id</th>
                            <th class="text-truncate">Name</th>
                            <th class="text-truncate">Email</th>
                            <th class="text-truncate">Created at</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $index => $user)
                            @php
                                $classes = [
                                    'table-default',
                                    'table-active',
                                    'table-primary',
                                    'table-secondary',
                                    'table-success',
                                    'table-danger',
                                    'table-warning',
                                    'table-info',
                                    'table-light',
                                ];
                                $class = $classes[$index % count($classes)];
                            @endphp
                            <tr class="{{ $class }}">
                                <td class="text-truncate">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="text-truncate">{{ $user->email }}</td>
                                <td class="text-truncate">{{ $user->created_at }}</td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!--/ USers Tables -->

    </div>
@endsection
