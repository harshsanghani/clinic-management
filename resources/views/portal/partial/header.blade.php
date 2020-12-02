<div class="page-loader data_loader hide">
    <div class="page-loader__spinner">
        <svg viewBox="25 25 50 50">
        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<header class="header">
    <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
        <div class="navigation-trigger__inner">
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
        </div>
    </div>

    <div class="header__logo hidden-sm-down">
        <h1><a href="javascript:void(0);">Hetvi Clinic Portal</a></h1>
    </div>
    <script type="application/javascript">
        var  portal_url    = "{{asset('/portal')}}";
    </script>
     <searchbox></searchbox>
<!--    <div class="search">
        <form class="search">
            <div class="search__inner">
                <input type="text" class="search__text" autocomplete="off" id="search" placeholder="Search for patients....">
                <i class="zmdi zmdi-search search__helper" data-ma-action="search-close"></i>
            </div>       
        </form>
        <div class="patient_search_result" style="display: none;"></div>
    </div>-->
    <ul class="top-nav">
        <li class="hidden-xl-up"><a href="#" data-ma-action="search-open"><i class="zmdi zmdi-search"></i></a></li>
            <li class="">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="zmdi zmdi-power zmdi-hc-fw"></i>
                    </button>
                </form>
            </li>
        </ul>
</header>

<aside class="sidebar">
    <div class="scrollbar-inner">
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="{{asset('assets/portal-side/img/avatar.png')}}" alt="">
                <div>
                    <div class="user__name"><?php echo isset( auth()->user()->username) ?  auth()->user()->username : 'Admin' ?></div>
                    <div class="user__email"><?php echo isset( auth()->user()->email) ?  auth()->user()->email : '' ?></div>
                </div>
            </div>
        </div>

        <ul class="navigation">
            <li class="{{ (request()->is('portal/home*')) ? 'navigation__active' : '' }}">
                <a href="{{asset('portal/home')}}"><i class="zmdi zmdi-view-week"></i> Calendar</a>
            </li>
            <li class="{{ (request()->is('portal/patient*')) ? 'navigation__active' : '' }}">
                <a href="{{asset('portal/patient')}}"><i class="zmdi zmdi-assignment-account"></i> Patients</a>
            </li>
            <li class="{{ (request()->is('portal/invoice*')) ? 'navigation__active' : '' }}">
                <a href="{{asset('portal/invoice')}}"><i class="zmdi zmdi-collection-pdf"></i> Invoice</a>
            </li>
            <li class="{{ (request()->is('portal/listpatient')) ? 'navigation__active' : '' }}">
                <a href="{{asset('portal/listpatient')}}"><i class="zmdi zmdi-assignment-account"></i> Patients list</a>
            </li>
            <li class="{{ (request()->is('portal/prescription*')) ? 'navigation__sub navigation__sub--toggled' : 'navigation__sub' }}">
                <a href="#"><i class="zmdi zmdi-view-week"></i>Certificates</a>
                <ul style="{{ (request()->is('portal/certificate*')) ? 'display:block' : 'display:none' }}">
                    @foreach(getReports() as $row ) 
                        <li class="{{ (request()->is('portal/certificate*') && \Request::segment(3) == $row['id'] ) ? 'navigation__active' : '' }}">
                             <a href="{{portal_url().'/certificate/'.$row['id']}}"> {{$row['name']}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="{{ (request()->is('portal/tool*') || request()->is('portal/investigation*')) ? 'navigation__sub navigation__sub--toggled' : 'navigation__sub' }}">
                <a href="#"><i class="zmdi zmdi-view-week"></i>Other</a>
                <ul style="{{ (request()->is('portal/tool*') || request()->is('portal/investigation*') ) ? 'display:block' : 'display:none' }}">
                    <li class="{{ (request()->is('portal/tool*')) ? 'navigation__active' : '' }}">
                        <a href="{{asset('portal/tool')}}"> Tools</a>
                    </li>
                    <li class="{{ (request()->is('portal/investigation*')) ? 'navigation__active' : '' }}">
                        <a href="{{asset('portal/investigation')}}"> Investigation Type</a>
                    </li>
                </ul>
            </li>
            
        </ul>
    </div>
</aside>