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
                <h3>广告播出单 <small>» 列表</small></h3>
            </div>

            <div class="col-md-6 text-right">

                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-adplaylist-create">
                    <i class="fa fa-upload"></i> 新建广告播出单
                </button>

                <a href="{{ url('/admin/adplaylist/fileexplorer') }}" class="btn btn-info btn-md">
                    <i class="fa fa-plus-circle"></i> 导入广告播出单
                </a>

                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-adplaylist-search">
                    <i class="fa fa-plus-circle"></i> 搜索广告播出单
                </button>
                @if ($searchflag)
                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal-adplaylist-deletebycondition">
                    <i class="fa fa-plus-circle"></i> 删除广告播出单
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
                            <th>频道</th>
                            <th>合同号</th>
                            <th>实际长度</th>
                            <th>广告内容</th>
                            <th>带号</th>
                            <th>广告长度</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($adplaylists as $adplaylist)
                        <tr>
                            <td>{{ date('Y-m-d',strtotime($adplaylist->d_date)) }}</td>
                            <td>{{ $adplaylist->b_time }}</td>
                            <th>{{ $adplaylist->fre->fre }}</th>
                            <th>{{ $adplaylist->number }}</th>
                            <th>{{ $adplaylist->len }}</th>
                            <th>{{ $adplaylist->content }}</th>
                            <th>{{ $adplaylist->belt }}</th>
                            <th>{{ $adplaylist->ht_len }}</th>
                            <td>
                                <a href="{{ url('/admin/adplaylist').'/'.$adplaylist->id.'/edit' }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div class="pull-right">
                    @if ($searchflag){!!
                        $adplaylists->appends([
                            'b_date' => $searchCondition['b_date'],
                            'e_date' => $searchCondition['e_date'],
                            'f_id' => $searchCondition['f_id'],
                            'b_time' => $searchCondition['b_time'],
                            'e_time' => $searchCondition['e_time'],
                            'number' => $searchCondition['number'],
                            'content' => $searchCondition['content'],
                        ])->render() !!}
                    @else
                        {!! $adplaylists->render() !!}
                    @endif
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-adplaylist-create">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/admin/adplaylist') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">新建广告播出单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.adplaylist._modals')
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

    <div class="modal fade" id="modal-adplaylist-search">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="get" action="{{ url('/admin/adplaylist/search') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">搜索广告播出单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.adplaylist._search')
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

    <div class="modal fade" id="modal-adplaylist-deletebycondition">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ url('/admin/adplaylist/deletebycondition') }}" class="form-horizontal" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">删除广告播出单</h4>
                    </div>
                    <div class="modal-body">
                        @include('admin.adplaylist._search')
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

            $("#d_date").pickadate({
                format: "yyyy-mm-dd"
            });

            $("#b_date").pickadate({
                format: "yyyy-mm-dd"
            });

            $("#e_date").pickadate({
                format: "yyyy-mm-dd"
            });
        });
    </script>
@stop