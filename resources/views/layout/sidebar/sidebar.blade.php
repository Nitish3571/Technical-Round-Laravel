    <!-- Sidebar -->
    <nav id="sidebarMenu" class=" d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{route('dashboard')}}" class="list-group-item list-group-item-action py-2 ripple {{ Request::routeIs('dashboard') ? 'active' : '' }}" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="{{route('product-list')}}" class="list-group-item list-group-item-action py-2 ripple {{ Request::routeIs('product-list') ? 'active' : '' }}"><i
                        class="mdi mdi-shopping-outline me-3"></i><span>Product</span></a>
                <a href="{{route('category-list')}}" class="list-group-item list-group-item-action py-2 ripple {{ Request::routeIs('category-list') ? 'active' : '' }}"><i
                        class="mdi mdi-store-cog me-3"></i><span>Category</span></a>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->
