<ul class="nav navbar-nav">
    <li><a href="/">首页</a></li>
    @if (Auth::check())
        <li @if (Request::is('admin/fre*')) class="active" @endif>
            <a href="{{ url('/admin/fre') }}">频道</a>
        </li>
        <li @if (Request::is('admin/ratingtype*')) class="active" @endif>
            <a href="{{ url('/admin/ratingtype') }}">收视率类型</a>
        </li>
        <li @if (Request::is('admin/ratinglist*')) class="active" @endif>
            <a href="{{ url('/admin/ratinglist') }}">收视率</a>
        </li>
        <li @if (Request::is('admin/adplaylist*')) class="active" @endif>
            <a href="{{ url('/admin/adplaylist') }}">广告播出列表</a>
        </li>
        <li @if (Request::is('admin/statlist*')) class="active" @endif>
            <a href="{{ url('/admin/statlist') }}">广告收视率统计列表</a>
        </li>

        <li @if (Request::is('admin/upload*')) class="active" @endif>
            <a href="{{ url('/admin/upload') }}">上传</a>
        </li>
    @endif
</ul>

<ul class="nav navbar-nav navbar-right">
    @if (Auth::guest())
        <li><a href="{{ url('/login') }}">登陆</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                    aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/resetpassword') }}">修改密码</a></li>
                <li><a href="{{ url('/logout') }}">注销</a></li>
            </ul>
        </li>
    @endif
</ul>