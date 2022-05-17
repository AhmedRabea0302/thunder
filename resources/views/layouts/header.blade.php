<header class="main-header">
    <button class="btn btn-responsive-nav" >
        <i class="fa fa-bars"></i>
    </button>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu">
                    <form class="search-head-form">
                        <input type="text" class="form-control" placeholder="البحث">
                        <button class="btn-head">
                            <i class="fa fa-search"></i>
                        </button>
                    </form><!--End search-head-form-->
                </ul>
            </li>
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header">لديك 10 إشعارات جديدة</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">5 أعضاء جدد انضموا اليوم</a>
                            </li>
                            <li>
                                <a href="#">وصف طويل جدا هنا قد لا يصلح في الصفحة وقد يسبب مشاكل التصميم</a>
                            </li>
                            <li>
                                <a href="#">انضم 5 أعضاء جدد</a>
                            </li>
                            <li>
                                <a href="#">25 المبيعات المقدمة</a>
                            </li>
                            <li>
                                <a href="#">لقد غيرت اسم المستخدم</a>
                            </li>
                        </ul>
                    </li>
                  <li class="dropdown-footer"><a href="#">عرض الكل</a></li>
                </ul>
            </li>
            <li class="dropdown user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="{{asset('assets/images/avatar.png')}}" class="user-image" alt="User Image">
                  <span>أبوالفضل</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                    <li class="user-header">
                        <img src="{{asset('assets/images/avatar.png')}}" class="img-circle" alt="User Image">
                        <p>
                            أحمد أبوالفضل - مهندس برمجيات
                          <small>عضو منذ يناير 2022</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="dropdown-btn">حسابى</a>
                        </div>
                        <div class="pull-right">
                          <a href="{{ route('logout') }}" class="dropdown-btn">خروج</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div><!--End search-head-->
</header><!--End main-Header-->
