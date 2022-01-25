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
            </ul><!--End Level-one-tree-->
        </li>
        {{-- <li>
            <a href="countries.html">
                <i class="fa fa-map-marker"></i>
                <span>الدول والمدن</span>
            </a>
        </li>
        <li>
            <a href="contact-us.html">
                <i class="fa fa-envelope-open"></i>
                <span>تواصل معنا</span>
            </a>
        </li>
        <li>
            <a href="subscription.html">
                <i class="fa fa-check-square-o"></i>
                <span>الإشتراكات</span>
            </a>
        </li>
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
