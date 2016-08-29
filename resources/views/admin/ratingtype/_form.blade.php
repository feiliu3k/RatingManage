<div class="form-group">
    <label for="rating_type" class="col-md-3 control-label">
        收视率类型
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="rating_type" id="rating_type" value="{{ $rating_type }}">
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
