    <div class="form-group">
        <label for="b_date" class="col-sm-3 control-label">
            日期范围
        </label>
        <div class="col-sm-3">
            <input type="text" id="b_date" name="b_date" class="form-control" value="{{ $searchCondition['b_date'] }}">
        </div>
        <div class="col-sm-3">
            <input type="text" id="e_date" name="e_date" class="form-control" value="{{ $searchCondition['e_date'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="f_id" class="col-md-3 control-label">
            频道
        </label>
        <div class="col-md-8">
            <select name="f_id" id="f_id" class="form-control" >
            @if ($searchCondition['f_id']==0)
                <option value="0" selected="selected">
                    全选
                </option>
            @else
                <option value="0" >
                    全选
                </option>
            @endif
            @foreach ($fres as $fre)
                @if ($searchCondition['f_id']==$fre->id)
                    <option value="{{ $fre->id }} " selected="selected">
                         {{ $fre->fre }}
                    </option>
                @else
                    <option value="{{ $fre->id }} ">
                         {{ $fre->fre }}
                    </option>
                @endif
            @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="b_time" class="col-sm-3 control-label">
            时间范围
        </label>
        <div class="col-sm-2">
            <input type="text" id="b_time" name="b_time" class="form-control"  value="{{ $searchCondition['b_time'] }}">
        </div>

        <div class="col-sm-2">
            <input type="text" id="e_time" name="e_time" class="form-control" value="{{ $searchCondition['e_time'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="number" class="col-sm-3 control-label">
            合同号
        </label>
        <div class="col-sm-4">
            <input type="text" id="number" name="number" class="form-control" value="{{ $searchCondition['number'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-3 control-label">
            广告内容
        </label>
        <div class="col-sm-4">
            <input type="text" id="content" name="content" class="form-control" value="{{ $searchCondition['content'] }}">
        </div>
    </div>
