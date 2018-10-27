@extends('BackEnd::layouts.empty')
@section('content')
<style type="text/css" >
    .canvas-wrap {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1
    }
</style>
<section class="canvas-wrap" >
    <div id="canvas" class="gradient" ></div>
</section>
<div class="form-box" id="login-box" style="position: relative;z-index: 9" >
    <div class="header">
        Sign In            
    </div>
    {!! Form::open(array('url' => Config::get('app.backendUrl').'/auth/login' ,'action' =>'login', 'id' => 'form-login')) !!}
    <div class="body">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" class="form-control" value="">                
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control" value="">                
        </div>
        <div class="form-group" >
            <label for="rememberme" style="font-weight: normal;" >
                <input type="hidden" name="rememberme" value="0" >
                <input type="checkbox" name="rememberme" id="rememberme" placeholder="Remember&#x20;me" class="" value="1" > 
                Remember me                    
            </label>
        </div>
    </div>
    <div class="footer">
        <button type="submit" class="btn bg-olive btn-block">
            Sign me in                
        </button>
        <p class="text-center" >
            <a href="{{url(Config::get('app.backendUrl'))}}" style="color: #333" >
                I forgot my password                    
            </a>
        </p>
    </div>
    {!! Form::close() !!}       
</div>
@stop