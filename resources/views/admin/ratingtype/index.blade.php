@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>收视率类型 <small>» 列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('/admin/ratingtype/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新建收视率类型
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
                            <th>收视率类型</th>
                            <th class="hidden-md">备注</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($ratingTypes as $ratingType)
                        <tr>
                            <td>{{ $ratingType->id }}</td>
                            <td>{{ $ratingType->rating_type }}</td>
                            <td class="hidden-sm">{{ $ratingType->remark}}</td>

                            <td>
                                <a href="{{ url('/admin/ratingtype').'/'.$ratingType->id.'/edit' }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $("#fres-table").DataTable({
            });
        });
    </script>
@stop