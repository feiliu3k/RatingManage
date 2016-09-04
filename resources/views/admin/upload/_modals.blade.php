{{-- 创建目录 --}}
<div class="modal fade" id="modal-folder-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/upload/folder') }}" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">创建目录</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_folder_name" class="col-sm-3 control-label">
                            文件夹
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="new_folder_name" name="new_folder" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        新建文件夹
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 删除文件 --}}
<div class="modal fade" id="modal-file-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">确认</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    你是否要删除此
                    <kbd><span id="delete-file-name1">file</span></kbd>
                    文件?
                </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ url('/admin/upload/file') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <input type="hidden" name="del_file" id="delete-file-name2">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-danger">
                        删除文件
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- 删除目录 --}}
<div class="modal fade" id="modal-folder-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">确认</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                        你是否要删除此
                        <kbd><span id="delete-folder-name1">folder</span></kbd>
                        目录?
                 </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ url('/admin/upload/folder') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <input type="hidden" name="del_folder" id="delete-folder-name2">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-danger">
                        删除文件夹
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- 上传文件 --}}
<div class="modal fade" id="modal-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/upload/file') }}" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">上传新文件</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">
                            文件
                        </label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_name" class="col-sm-3 control-label">
                            可选文件名
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="file_name" name="file_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        上传文件
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if (strpos($folder,'rating'))
{{-- 导入收视率 --}}
<div class="modal fade" id="modal-rating-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/ratinglist/import') }}" class="form-horizontal" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">导入收视率</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rt_id" class="col-sm-3 control-label">
                            收视率类型
                        </label>
                        <div class="col-sm-8">
                            <select name="rt_id" id="rt_id" class="form-control" >
                            @foreach ($ratingTypes as $ratingType)
                                <option value="{{ $ratingType->id }} ">
                                     {{ $ratingType->rating_type }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rating_filename" class="col-sm-3 control-label">
                            文件名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="rating_filename" name="rating_filename" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        导入
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if (strpos($folder,'adplaylist'))
{{-- 导入广告播出单 --}}
<div class="modal fade" id="modal-adplaylist-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/adplaylist/import') }}" class="form-horizontal" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">广告播出单</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="adplaylist_filename" class="col-sm-3 control-label">
                            文件名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="adplaylist_filename" name="adplaylist_filename" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        导入
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if (strpos($folder,'statlist'))
{{-- 导出收视率统计单 --}}
<div class="modal fade" id="modal-statlist-download">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/stat/download') }}" class="form-horizontal" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">广告播出单</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="stat_filename" class="col-sm-3 control-label">
                            文件名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="stat_filename" name="stat_filename" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        下载
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif