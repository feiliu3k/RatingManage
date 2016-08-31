<div class="modal fade" id="modal-rating-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admin/ratinglist') }}" class="form-horizontal" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">新建收视率</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="s_date" class="col-sm-3 control-label">
                            日期
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="s_date" name="s_date" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="proid" class="col-md-3 control-label">
                            频道
                        </label>
                        <div class="col-md-8">
                            <select name="proid" id="proid" class="form-control" >
                            @foreach ($fres as $fre)
                                <option value="{{ $fre->id }} ">
                                    {{ $fre->fre }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="b_time" class="col-sm-3 control-label">
                            开始时间
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="b_time" name="b_time" class="form-control" placeholder="00:00" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e_time" class="col-sm-3 control-label">
                            结束时间
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="e_time" name="e_time" class="form-control"placeholder="00:00" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_name" class="col-sm-3 control-label">
                            收视率类型
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="file_name" name="file_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_name" class="col-sm-3 control-label">
                            收视率
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
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>