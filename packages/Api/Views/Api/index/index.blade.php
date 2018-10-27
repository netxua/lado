@extends('FrontEnd::layouts.default')

@section('content')
<div class="container-fluid masthead">
    <div class="container">
        <div class="row">
            <h1>
                convert
                <strong class="dropdown inputformat">
                    <a class="dropdown-toggle" data-toggle="dropdown">anything</a>
                </strong>
                to
                <strong class="dropdown outputformat">
                    <a class="dropdown-toggle" data-toggle="dropdown">anything</a>
                </strong>
            </h1>
        </div>
    </div>
</div>
<div class="container convert">
    <div class="row">
        <div class="col-sm-12">
            @if(empty($is_upload))
            <div class="selectfiles text-center">
                <div class="btn-group">
                    <div class="box red-custom-input">
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                {{ Session::get('message') }}
                            </p>
                        @endif
                        {!! Form::open(array('url' => 'index' ,'action' =>'','id'=>'frm-input-file','enctype'=>'multipart/form-data')) !!}
                            <input type="file" name="eagle-file[]" id="eagle-file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @elseif(!empty($is_upload))
                <div id="converterTable" style="">
                    <table role="presentation" class="table table-hover converterTable">
                        <tbody>
                        @foreach($data_upload as $key => $value)
                            <tr class="process">
                                <td class="icon">
                                    <i class="ss-icon icongroup-video"></i>
                                </td>
                                <td class="name span5">
                                    <div class="span5">
                                        <strong>{{$value['name']}}</strong>
                                    </div>
                                </td>
                                <td class="format span1">
                                    <div class="btn-group">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                            mp4
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                            <li class="dropdown-submenu">
                                                <a class="format" tabindex="-1" href="#">audio<span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                                                    <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                                                </ul>
                                            </li>

                                            <li class="dropdown-submenu">
                                                <a>image</a>

                                                <ul class="dropdown-menu">
                                                </ul>
                                            </li>

                                            <li class="dropdown-submenu">
                                                <a>video</a>

                                                <ul class="dropdown-menu">
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn options" data-loading-text="loading...">
                                            <i class="ss-icon ss-wrench"></i>

                                        </button>
                                    </div>
                                </td>


                                <td class="message span4">

                                    <span class="label label-info">ready</span>

                                    <span class="message">Ready (5 MB)</span></td>

                                <td class="percent">

                                </td>

                                <td class="buttons span3">
                                    <button type="button" class="close delete" rel="tooltip" data-toggle="tooltip" title="Delete" data-placement="right">×</button>
                                </td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#eagle-file').change(function(){
             $('#frm-input-file').submit();
        });
        $('.dropdown-submenu a.format').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>



@endsection

