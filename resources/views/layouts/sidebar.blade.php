<aside class="main-sidebar">
    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
        <img class="logo-mini" src="{{asset('assets/images/logo.png')}}">
      <!-- logo for regular state and mobile devices -->
        <img class="logo-lg" src="{{asset('assets/images/logo.png')}}">
    </a>
    <ul class="sidebar-links">
        <li @if(Request::route()->getName() == 'home') class="active" @endif>
            <a href="{{route('home')}}">
                <i class="fa fa-dashboard"></i>
                <span>الرئيسية</span>
            </a>
        </li>
        {{-- <li>
            <a href="categories.html">
                <i class="fa fa-database"></i>
                <span>الأقسام وأنواعها</span>
            </a>
        </li> --}}
        <li @if(Request::route()->getName() == 'products') class="active" @endif>
            <a href="{{route('products')}}">
                <i class="fa fa-cubes"></i>
                <span>المنتجات</span>
            </a>
        </li>

        <li @if(Request::route()->getName() == 'product-tree' || Request::route()->getName() == 'get-add-product-tree' || Request::route()->getName() == 'get-product-tree-details') class="active" @endif>
            <a href="{{route('product-tree')}}">
                <i class="fa fa-tree"></i>
                <span>شجرة المُنتج</span>
            </a>
        </li>

        <li @if(Request::route()->getName() == 'all-paths' || Request::route()->getName() == 'get-add-path' || Request::route()->getName() == 'get-path-details') class="active" @endif>
            <a href="{{route('all-paths')}}">
                <i class="fa fa-road"></i>
                <span>مسارات الإنتاج</span>
            </a>
        </li>

        <li @if(Request::route()->getName() == 'standard-cost') class="active" @endif>
            <a href="{{ route('standard-cost') }}">
                <i class="fa fa-dollar"></i>
                <span>التكلفة المعيارية</span>
            </a>
        </li>

        <li @if(Request::route()->getName() == 'daily-report') class="active" @endif>
            <a href="{{ route('daily-report') }}">
                <i class="fa fa-file"></i>
                <span>التقرير اليومي</span>
            </a>
        </li>

        <li class="treeview" @if(Request::route()->getName() == 'all-sectors') class="active" @endif>
            <a href="">
                <i class="fa fa-gears"></i>
                <span>الإعدادات</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{route('all-sectors')}}"  @if(Request::route()->getName() == 'all-sectors') class="active" @endif>
                        <span>الأقسام</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('all-equipments')}}"  @if(Request::route()->getName() == 'all-equipments') class="active" @endif>
                        <span>المُعدات</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('all-stocks')}}"  @if(Request::route()->getName() == 'all-stocks') class="active" @endif>
                        <span>المخازن</span>
                    </a>
                </li>
            </ul><!--End Level-one-tree-->
        </li>

        <li class="treeview" @if(Request::route()->getName() == 'products-report' || Request::route()->getName() == 'product-tree-report' || Request::route()->getName() == 'path-report') class="active" @endif>
            <a href="">
                <i class="fa fa-bell"></i>
                <span>التقارير</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{route('products-report')}}"  @if(Request::route()->getName() == 'products-report') class="active" @endif>
                        <span>المنتجات اليومية</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('product-tree-report')}}"  @if(Request::route()->getName() == 'product-tree-report') class="active" @endif>
                        <span>شجرة منتج</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('path-report')}}"  @if(Request::route()->getName() == 'path-report') class="active" @endif>
                        <span>مسار إنتاج</span>
                    </a>
                </li>
            </ul><!--End Level-one-tree-->
        </li>


        {{--

        <li>
            <a href="notifications.html">
                <i class="fa fa-bell"></i>
                <span>الإشعارات</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cogs"></i>
                <span>الإعدادات</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="site-settings.html">
                        <span>بيانات الموقع</span>
                    </a>
                </li>
                <li>
                    <a href="about-site.html">
                        <span>عن الموقع</span>
                    </a>
                </li>
                <li>
                    <a href="tags.html">
                        <span>الكلمات الإفتتاحية</span>
                    </a>
                </li>
            </ul><!--End Level-one-tree-->
        </li> --}}
    </ul><!--End sidebar-->
</aside><!--End Main-aside-->
