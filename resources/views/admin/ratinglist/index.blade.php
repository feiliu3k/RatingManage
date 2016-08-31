@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>收视率 <small>» 列表</small></h3>
            </div>

            <div class="col-md-6 text-right">

                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-rating-create">
                    <i class="fa fa-upload"></i> 新建收视率
                </button>
                <a href="{{ url('/admin/ratinglist/fileexplorer') }}" class="btn btn-info btn-md">
                    <i class="fa fa-plus-circle"></i> 导入收视率
                </a>
                <a href="{{ url('/admin/ratinglist/search') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 搜索收视率
                </a>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="fres-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>日期</th>
                            <th>频道</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>收视率类型</th>
                            <th>收视率</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($ratings as $rating)
                        <tr>
                            <td>{{ $rating->id }}</td>
                            <td>{{ $rating->s_date }}</td>
                            <th>{{ $rating->fre()->fre }}</th>
                            <th>{{ $rating->b_time }}</th>
                            <th>{{ $rating->e_time }}</th>
                            <th>{{ $rating->ratingType()->rating_type }}</th>
                            <th>{{ $rating->a_rating }}</th>
                            <td>
                                <a href="{{ url('/admin/ratinglist').'/'.$rating->id.'/edit' }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pull-right">

                        {!! $ratings->render() !!}

                </div>
            </div>
        </div>
    </div>

    @include('admin.ratinglist._modals')

@stop

@section('scripts')
       <script src="{{ URL::asset('assets/pickadate/picker.js') }}"></script>
    <script src="{{ URL::asset('assets/pickadate/picker.date.js') }}"></script>
    <script src="{{ URL::asset('assets/pickadate/picker.time.js') }}"></script>
    <script src="{{ URL::asset('assets/selectize/selectize.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.form.js') }}"></script>
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

        $("#s_date").pickadate({
            format: "yyyy-mm-dd"
        });
    });
    </script>
@stop