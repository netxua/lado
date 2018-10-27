<a href="javascript:void(0);" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">
        menu toggle
    </span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<div class="box-save-w" >
    <div class="clearfix in-box-save-w" >
        <div class="user-panel" >
            <div class="image" >
                <a href="{{url(Config::get('app.backendUrl'))}}/dashboard" >
                    <img src="{{ HelperImages::getUrlImage(HelperUser::getAvatar($current_user), 200) }}" class="img-reponsive" alt="User Image" />
                </a>
            </div>
            <div class="info">
                <div class="clearfix" >
                    <p>
                        Chào bạn,
                        <a href="{{url(Config::get('app.backendUrl'))}}/dashboard" >
                            {{ HelperUser::getFullName($current_user) }}
                        </a>
                    </p>
                </div>
                <div class="clearfix lang-status" >
                    <div class="row" >
                        <div class="col-sm-6" >
                            <a href="#" class="user-status" >
                                <i class="fa fa-circle"></i> 
                                online
                            </a>
                        </div>
                        <div class="col-sm-6" >
                            <select id="coz-language-global" class="form-control input-sm">
                                @foreach( $languages as $key => $lang )
                                <option value="{{ $lang['id'] }}" {{ $lang['id'] == $langId ? 'selected' : '' }} >
                                    {{ $lang['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{url(Config::get('app.backendUrl'))}}/search" method="get" class="sidebar-form" >
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Bạn muốn tìm gì ?" />
                <span class="input-group-btn">
                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>

<ul class="sidebar-menu" data-widget="tree" >
    @if ( HelperCommon::hasPermission('backend', 'dashboard', 'index') )
    <li class="@if(!empty($current_controller) and ($current_controller == 'dashboard' ) ){{'active'}}@endif">
        <a href="{{url(Config::get('app.backendUrl'))}}/dashboard" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/dashboard.svg" width="20" class="icon-menu" >
            <span>
                Dashboard
            </span>
        </a>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'sectors', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'sectors' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon//san-pham.svg" width="20" class="icon-menu" >
            <span>
                Ngành
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/sectors" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách ngành
                </a>
            </li>

            @if ( HelperCommon::hasPermission('backend', 'sectors', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/sectors/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo ngành
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'categories-articles', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'categories-articles' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/danh-muc-bai-viet.svg" width="20" class="icon-menu" >
            <span>
                Danh mục tin tức
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-articles" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách danh mục
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'categories-articles', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-articles/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo danh mục
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'articles', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'articles' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/bai-viet.svg" width="20" class="icon-menu" >
            <span>
                Tin tức
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/articles" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách tin tức
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'articles', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/articles/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo tin tức
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'feels', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'feels' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/feel.svg" width="20" class="icon-menu" >
            <span>
                Cảm nhận
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/feels" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách cảm nhận
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'feels', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/feels/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo cảm nhận
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'clients', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'clients' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/khach-hang.svg" width="20" class="icon-menu" >
            <span>
                Khách hàng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/clients" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách khách hàng
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'clients', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/clients/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo khách hàng
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'categories-functions', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'categories-functions' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/stock.svg" width="20" class="icon-menu" >
            <span>
                Nhóm chức năng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-functions" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách nhóm
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'categories-functions', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-functions/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo nhóm
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'functions', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'functions' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/dac-tinh-san-pham.svg" width="20" class="icon-menu" >
            <span>
                Chức năng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/functions" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách chức năng
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'functions', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/functions/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo chức năng
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'attributes', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'attributes' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/ma-giam-gia.svg" width="20" class="icon-menu" >
            <span>
                Thuộc tính
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/attributes" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách thuộc tính
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'attributes', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/attributes/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo thuộc tính
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'categories-packages', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'categories-packages' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Sản phẩm
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-packages" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách sản phẩm
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'categories-packages', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-packages/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo sản phẩm
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'packages', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'packages' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Gói
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/packages" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách gói
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'packages', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/packages/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo gói
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'number-user', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'number-user' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Số lượng người dùng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/number-user" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'number-user', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/number-user/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo số lượng người dùng
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'packages-plus', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'packages-plus' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Plus
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/packages-plus" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách plus
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'packages-plus', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/packages-plus/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo plus
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'invoices', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'invoices' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/invoice.svg" width="20" class="icon-menu" >
            <span>
                Hoá đơn
            </span>
            @if( !empty($totalInvoicesNew) )
            <span class="alert-menu" >
                {{ $totalInvoicesNew }} mới
            </span>
            @endif
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/invoices" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách hoá đơn
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'try', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'try' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/invoice.svg" width="20" class="icon-menu" >
            <span>
                Dùng thử
            </span>
            @if( !empty($totalTryingNew) )
            <span class="alert-menu" >
                {{ $totalTryingNew }} mới
            </span>
            @endif
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/try" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'schedules', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'schedules' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Lịch hẹn
            </span>
            @if( !empty($totalSchedulesNew) )
            <span class="alert-menu" >
                {{ $totalSchedulesNew }} mới
            </span>
            @endif
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/schedules" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách lịch hẹn
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'contacts', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'contacts' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/contact.svg" width="20" class="icon-menu" >
            <span>
                Liên hệ
            </span>
            @if( !empty($totalContactsNew) )
            <span class="alert-menu" >
                {{ $totalContactsNew }} mới
            </span>
            @endif
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/contacts" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách liên hệ
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'newleters', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'newleters' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/menu.svg" width="20" class="icon-menu" >
            <span>
                Email newleter
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/newleters" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách email newleter
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'faqs', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'faqs' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Faqs
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/faqs" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách faqs
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'faqs', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/faqs/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo faqs
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'categories-features', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'categories-features' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Danh mục tính năng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-features" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách danh mục
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'categories-features', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/categories-features/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo danh mục
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'features', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'features' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Tính năng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/features" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách tính năng
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'features', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/features/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo tính năng
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'sliders-hooks', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'sliders-hooks' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/banner.svg" width="20" class="icon-menu" >
            <span>
                Túi chứa sliders
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/sliders-hooks" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'sliders', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'sliders' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/banner.svg" width="20" class="icon-menu" >
            <span>
                Sliders
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/sliders" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách sliders
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'sliders', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/sliders/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo sliders
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'users', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'users' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Người dùng
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/users" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách người dùng
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'users', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/users/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo người dùng
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'modules', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'modules' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/categories.png" width="20" class="icon-menu" >
            <span>
                Modules
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/modules" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách modules
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'modules', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/modules/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo modules
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'groups', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'groups' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/quan-li-nhom-quyen.svg" width="20" class="icon-menu" >
            <span>
                Nhóm modules
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/groups" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách nhóm
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'groups', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/groups/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo nhóm
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'roles', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'roles' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/quan-li-nhom-quyen.svg" width="20" class="icon-menu" >
            <span>
                Quyền
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/roles" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách quyền
                </a>
            </li>
            @if ( HelperCommon::hasPermission('backend', 'roles', 'add') )
            <li class="@if(!empty($current_action) and ($current_action == 'edit' or $current_action == 'add')){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/roles/add" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Tạo quyền
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'languages', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'languages' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/language.svg" width="20" class="icon-menu" >
            <span>
                Languages
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/languages" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'keywords', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'keywords' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/language.svg" width="20" class="icon-menu" >
            <span>
                Keywords
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and $current_action == 'index'){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/keywords" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/list.png" width="15" class="icon-menu" >
                    Danh sách
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if ( HelperCommon::hasPermission('backend', 'website', 'index') )
    <li class="treeview @if(!empty($current_controller) and ($current_controller == 'website' ) ){{'active'}}@endif">
        <a href="javascript:void(0);" >
            <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/website.svg" width="20" class="icon-menu" >
            <span>
                Website
            </span>
            <i class="fa fa-angle-right pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="@if(!empty($current_action) and ($current_action == 'index' )){{'active'}}@endif">
                <a href="{{url(Config::get('app.backendUrl'))}}/website" data-pjax="true" data-container="Main" >
                    <img src="{{url(Theme::find(config('backend_config.current_theme'))->themesPath)}}/icon/create.png" width="15" class="icon-menu" >
                    Cấu hình
                </a>
            </li>
        </ul>
    </li>
    @endif

</ul>