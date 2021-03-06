@extends('admin.layout')
@section('styles')
    <link href="{{ URL::asset('assets/pickadate/themes/default.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/pickadate/themes/default.time.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/upload.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>收视率统计单 <small>» 列表</small></h3>
            </div>

            <div class="col-md-6 text-right">

                <a href="{{ url('/admin/statlist/fileexplorer') }}" class="btn btn-info btn-md">
                    <i class="fa fa-plus-circle"></i> 下载
                </a>

                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-statlist-search">
                    <i class="fa fa-plus-circle"></i> 搜索
                </button>

                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-statlist-stat">
                    <i class="fa fa-plus-circle"></i> 统计
                </button>

                @if ($exportExcel)
                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-statlist-save">
                    <i class="fa fa-plus-circle"></i> 保存
                </button>
                @endif

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>播出日期</th>
                            <th>播出时间</th>
                            <th>播出频道</th>
                            <th>合同号</th>
                            <th>广告长度</th>
                            <th>广告内容</th>
                            <th>收视率</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($statlists as $statlist)
                        <tr>
                            <td>{{ $statlist->d_date }}</td>
                            <td>{{ $statlist->b_time }}</td>
                            <th>{{ $statlist->fre }}</th>
                            <th>{{ $statlist->number }}</th>
                            <th>{{ $statlist->ht_len }}</th>
                            <th>{{ $statlist->content }}</th>
                            <th>{{ $statlist->a_rating }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="pull-right">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-statlist-stat">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ url('/admin/statlist/stat') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">统计收视率统计单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.statlist._search')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-primary">
                            统计
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-statlist-save">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ url('/admin/statlist/save') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">保存收视率统计表</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.statlist._search')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-primary">
                            保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-statlist-search">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="get" action="{{ url('/admin/statlist/search') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">搜索收视率统计单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.statlist._search')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-primary">
                            搜索
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-statlist-deletebycondition">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ url('/admin/statlist/deletebycondition') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">删除收视率统计单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.statlist._search')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-danger">
                            删除
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@stop

@section('scripts')
    <script src="{{ URL::asset('assets/pickadate/picker.js') }}"></script>
    <script src="{{ URL::asset('assets/pickadate/picker.date.js') }}"></script>
    <script src="{{ URL::asset('assets/pickadate/picker.time.js') }}"></script>
    <script src="{{ URL::asset('assets/selectize/selectize.min.js') }}"></script>

    <script>
        $(function() {
            jQuery.extend( jQuery.fn.pickadate.defaults, {
                monthsFull: [ '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月' ],
                monthsShort: [ '一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二' ],
                weekdaysFull: [ '星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六' ],
                weekdaysShort: [ '日', '一', '二', '三', '四', '五', '六' ],
                today: '今日',
                clear: '清除',
                close: '关闭',
                firstDay: 1,
                format: 'yyyy 年 mm 月 dd 日',
                formatSubmit: 'yyyy-mm-dd'
            });

            jQuery.extend( jQuery.fn.pickatime.defaults, {
                clear: '清除'
            });


            $(".b_date").pickadate({
                format: "yyyy-mm-dd"
            });

            $(".e_date").pickadate({
                format: "yyyy-mm-dd"
            });
        });


    </script>
@stop