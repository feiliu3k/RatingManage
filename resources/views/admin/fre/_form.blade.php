<div class="form-group">
    <label for="fre" class="col-md-3 control-label">
        频道
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="fre" id="fre" value="{{ $fre }}">
    </div>
</div>

<div class="form-group">
    <label for="dm" class="col-md-3 control-label">
        目标
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="dm" id="dm" value="{{ $dm }}">
    </div>
</div>

<div class="form-group">
    <label for="remark" class="col-md-3 control-label">
       备注
    </label>
    <div class="col-md-8">
        <textarea class="form-control" id="remark" name="remark" rows="3">
            {{ $remark }}
        </textarea>
    </div>
</div>

<div class="form-group">
    <label for="xs" class="col-md-3 control-label">
        类型
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="xs" id="xs" value="{{ $xs }}">
    </div>
</div>