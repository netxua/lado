<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-cog"></i>
                    <h3 class="box-title">Permission Denied</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <p class="text-danger">
                        {{trans('BackEnd::auth.permission_denied')}}
                    </p>
                    <a class="" href="{{url(config('app.backendUrl').'/index')}}"> <i class="fa fa-backward"></i> Back To Home Page </a>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>