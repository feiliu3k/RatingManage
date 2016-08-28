@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>频道 <small>» 列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('/admin/fre/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新建频道
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
                            <th>频道名称</th>
                            <th class="hidden-sm">目标</th>
                            <th class="hidden-md">备注</th>
                            <th class="hidden-md">类型</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($fres as $fre)
                        <tr>
                            <td>{{ $fre->id }}</td>
                            <td>{{ $fre->fre }}</td>
                            <td class="hidden-sm">{{ $fre->dm }}</td>
                            <td class="hidden-md">{{ $fre->remark }}</td>
                            <td class="hidden-md">{{ $fre->xs }}</td>
                            <td>
                                <a href="{{ url('/admin/fre').'/'.$fre->id.'/edit' }}" class="btn btn-xs btn-info">
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