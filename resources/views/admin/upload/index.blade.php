@extends('admin.layout')

@section('content')
<div class="container-fluid">

    {{-- 顶部工具栏 --}}
    <div class="row page-title-row">
        <div class="col-md-6">
            <h3 class="pull-left">上传 </h3>
            <div class="pull-left">
                <ul class="breadcrumb">
                    @foreach ($breadcrumbs as $path => $disp)
                        <li><a href="{{ url('/admin/upload?folder=').$path }}">{{ $disp }}</a></li>
                    @endforeach
                    <li class="active">{{ $folderName }}</li>
                </ul>
            </div>
        </div>
        @if (!(strpos($folder,'statlist')))
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
                <i class="fa fa-plus-circle"></i> 新建文件夹
            </button>
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                <i class="fa fa-upload"></i> 上传
            </button>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('admin.partials.errors')
            @include('admin.partials.success')

            <table id="uploads-table" class="table table-striped table-bordered" data-order='[[ 3, "desc" ]]' data-page-length='25'>
                <thead>
                    <tr>
                        <th>名字</th>
                        <th>类型</th>
                        <th>时间</th>
                        <th>大小</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                </thead>
                <tbody>

                {{-- 子目录 --}}
                @foreach ($subfolders as $path => $name)
                    <tr>
                        <td>
                            <a href="{{ url('/admin/upload?folder=').$path }}">
                                <i class="fa fa-folder fa-lg fa-fw"></i>
                                {{ $name }}
                            </a>
                        </td>
                        <td>文件夹</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-danger" onclick="delete_folder('{{ $name }}')">
                                <i class="fa fa-times-circle fa-lg"></i>
                                删除
                            </button>
                         </td>
                    </tr>
                @endforeach

                {{-- 所有文件 --}}
                @foreach ($files as $file)
                    <tr>
                        <td>
                            <a href="{{ $file['webPath'] }}">
                                @if (is_image($file['mimeType']))
                                <i class="fa fa-file-image-o fa-lg fa-fw"></i>
                                @else
                                <i class="fa fa-file-o fa-lg fa-fw"></i>
                                @endif
                                {{ $file['name'] }}
                            </a>
                        </td>
                        <td>{{ $file['mimeType'] or 'Unknown' }}</td>
                        <td>{{ $file['modified']->format('Y-m-d H:i:s') }}</td>
                        <td>{{ human_filesize($file['size']) }}</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{ $file['name'] }}')">
                                <i class="fa fa-times-circle fa-lg"></i>
                                删除
                            </button>
                            @if (is_image($file['mimeType']))
                                <button type="button" class="btn btn-xs btn-info" onclick="preview_image('{{ $file['webPath'] }}')">
                                    <i class="fa fa-eye fa-lg"></i>
                                    预览
                                </button>
                            @endif

                            @if (strpos($folder,'adplaylist'))
                                <button type="button" class="btn btn-xs btn-primary" onclick="import_adplaylist('{{ $folder.'/'.$file['name'] }}')">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                    导入广告播出单
                                </button>
                            @endif

                            @if (strpos($folder,'rating'))
                                <button type="button" class="btn btn-xs btn-success" onclick="import_rating('{{ $folder.'/'.$file['name'] }}')">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                    导入收视率
                                </button>
                            @endif

                            @if (strpos($folder,'statlist'))
                                <a class="btn btn-xs btn-success" href="{{ url('admin/statlist/download?statlist_filename=').$file['name'] }}" >
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                    下载收视率统计单
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>

@include('admin.upload._modals')

@stop

@section('scripts')
<script>

    // 确认文件删除
    function delete_file(name) {
        $("#delete-file-name1").html(name);
        $("#delete-file-name2").val(name);
        $("#modal-file-delete").modal("show");
    }

    // 确认目录删除
    function delete_folder(name) {
        $("#delete-folder-name1").html(name);
        $("#delete-folder-name2").val(name);
        $("#modal-folder-delete").modal("show");
    }

     // 导入收视率
    function import_rating(path) {
        $("#rating_filename").val(path);
        $("#modal-rating-import").modal("show");
    }

     // 导入广告播出单
    function import_adplaylist(path) {
        $("#adplaylist_filename").val(path);
        $("#modal-adplaylist-import").modal("show");
    }

    // 初始化数据
    $(function() {
        $("#uploads-table").DataTable();
    });
</script>
@stop