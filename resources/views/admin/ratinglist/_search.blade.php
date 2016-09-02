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
            @elese
                <option value="0" selected="selected">
                    全选
                </option>
            @endif
            @foreach ($fres as $fre)
                @if ($searchCondition['f_id']==$fre->id)
                    <option value="{{ $fre->id }} " select="selected">
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
        <label for="file_name" class="col-sm-3 control-label">
            收视率类型
        </label>
        <div class="col-sm-4">
            <select name="rt_id" id="rt_id" class="form-control" >
            @if ($searchCondition['rt_id']==0)
                <option value="0" selected="selected">
                    全选
                </option>
            @elese
                <option value="0" selected="selected">
                    全选
                </option>
            @endif
            @foreach ($ratingTypes as $ratingType)
                @if ($searchCondition['rt_id']==$ratingType->id)
                    <option value="{{ $ratingType->id }} " selected="selected">
                         {{ $ratingType->rating_type }}
                    </option>
                @else
                    <option value="{{ $ratingType->id }} ">
                         {{ $ratingType->rating_type }}
                    </option>
                @endif
            @endforeach
            </select>
        </div>
    </div>