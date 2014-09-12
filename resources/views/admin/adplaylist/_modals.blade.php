    <div class="form-group">
        <label for="d_date" class="col-sm-3 control-label">
            日期
        </label>
        <div class="col-sm-4">
            <input type="text" id="d_date" name="d_date" class="form-control" value="{{ $fields['d_date'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="b_time" class="col-sm-3 control-label">
            时间
        </label>
        <div class="col-sm-2">
            <input type="text" id="b_time" name="b_time" class="form-control" value="{{ $fields['b_time'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="f_id" class="col-md-3 control-label">
            频道
        </label>
        <div class="col-md-8">
            <select name="f_id" id="f_id" class="form-control" >
            @foreach ($fres as $fre)
                @if ($fields['f_id']==$fre->id)
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
        <label for="number" class="col-sm-3 control-label">
            合同号
        </label>
        <div class="col-sm-4">
            <input type="text" id="number" name="number" class="form-control" value="{{ $fields['number'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="len" class="col-sm-3 control-label">
            实际长度
        </label>
        <div class="col-sm-4">
            <input type="text" id="len" name="len" class="form-control" value="{{ $fields['len'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-3 control-label">
            广告内容
        </label>
        <div class="col-sm-4">
            <input type="text" id="content" name="content" class="form-control" value="{{ $fields['content'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="belt" class="col-sm-3 control-label">
            带号
        </label>
        <div class="col-sm-4">
            <input type="text" id="belt" name="belt" class="form-control" value="{{ $fields['belt'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="ht_len" class="col-sm-3 control-label">
            广告长度
        </label>
        <div class="col-sm-4">
            <input type="text" id="ht_len" name="ht_len" class="form-control" value="{{ $fields['ht_len'] }}">
        </div>
    </div>