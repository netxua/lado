<a href="javascript:void(0);" class="navbar-btn sidebar-toggle navbar-btn-mb" data-toggle="offcanvas" role="button">
    <span class="sr-only">
        menu toggle
    </span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<ul class="nav navbar-nav" >
    <li class="dropdown messages-menu">
        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
        </a>
        <ul class="dropdown-menu">
            <li>
                <ul class="menu">
                    <li>
                        <a href="javascript:void(0);" >
                            <div class="pull-left"></div>
                            <h4>
                                Support Team
                                <small>
                                    <i class="fa fa-clock-o"></i> 5 mins
                                </small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" >
                            <div class="pull-left"></div>
                            <h4>
                                AdminLTE Design Team
                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" >
                            <div class="pull-left"></div>
                            <h4>
                                Developers
                                <small><i class="fa fa-clock-o"></i> Today</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" >
                            <div class="pull-left"></div>
                            <h4>
                                Sales Department
                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" >
                            <div class="pull-left"></div>
                            <h4>
                                Reviewers
                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                            </h4>
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="footer">
                <a href="javascript:void(0);" >
                    See All Messages
                </a>
            </li>
        </ul>
    </li> 

    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i>
            <span>
                @if(!empty($current_user['user_name'])){{
                    $current_user['user_name']
                }}@endif
            </span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header bg-light-blue" >
                <a href="{{url(Config::get('app.backendUrl'))}}/dashboard" >
                    <img src="{{ HelperImages::getUrlImage(HelperUser::getAvatar($current_user), 100, 100) }}" class="img-circle" alt="{{ HelperUser::getFullName($current_user) }}" />
                </a>
                <p>
                    @if(!empty($current_user['user_name'])){{
                        $current_user['user_name']
                    }}@endif
                    <small>
                        Member since
                    </small>
                </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
            
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="{{url(Config::get('app.backendUrl'))}}/dashboard" class="btn btn-default btn-flat">
                        Profile
                    </a>
                </div>
                <div class="pull-right">
                    <a href="{{url(Config::get('app.backendUrl'))}}/auth/logout" class="btn btn-default btn-flat">
                        Sign out
                    </a>
                </div>
            </li>
        </ul>
    </li>
</ul>
<style type="text/css" >
.dropdown-search{
    min-width: 300px;
    margin-top: 1px;
    padding: 10px 10px 0 10px;
    font-size: 100%;
}
</style>