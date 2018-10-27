@extends('BackEnd::layouts.empty')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html">
                <b>Admin</b>Eagle
            </a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                {{ Session::get('message') }}
            </p>
            @endif
            
            {!! Form::open(array('url' => Config::get('app.backendUrl').'/index' ,'action' =>'index')) !!}
            <div class="form-group has-feedback">
                {!! Form::text('email' , null ,array('class'=>'form-control' , 'placeholder' => 'Email','required'=>'true')) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                {!! Form::password('password' ,array('class'=>'form-control' , 'placeholder' => 'Password','required'=>'true')) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" class="icheck" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    {!! Form::submit('Submit!' ,array('class'=>'btn btn-primary btn-block btn-flat')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop