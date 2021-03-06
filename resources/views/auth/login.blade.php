@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">登录</div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form class="form-horizontal" role="form" method="POST"
                            action="{{ url('/login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">用户名</label>
                            <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">密码</label>
                            <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">验证码</label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="captcha" />
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{ captcha_src() }}" style="cursor: pointer;" onclick="this.src='{{captcha_src()}}'+Math.random()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" name="remember"> 记住我
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection