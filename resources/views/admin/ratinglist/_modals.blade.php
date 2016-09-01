    <div class="form-group">
        <label for="s_date" class="col-sm-3 control-label">
            日期
        </label>
        <div class="col-sm-4">
            <input type="text" id="s_date" name="s_date" class="form-control" value="{{ $fields['s_date'] }}">
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
        <label for="b_time" class="col-sm-3 control-label">
            时间
        </label>
        <div class="col-sm-2">
            <input type="text" id="b_time" name="b_time" class="form-control" value="{{ $fields['b_time'] }}">
        </div>

        <div class="col-sm-2">
            <input type="text" id="e_time" name="e_time" class="form-control" value="{{ $fields['e_time'] }}">
        </div>
    </div>
    <div class="form-group">
        <label for="file_name" class="col-sm-3 control-label">
            收视率类型
        </label>
        <div class="col-sm-4">
            <select name="rt_id" id="rt_id" class="form-control" >
            @foreach ($ratingTypes as $ratingType)
                @if ($fields['rt_id']==$ratingType->id)
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
    <div class="form-group">
        <label for="a_rating" class="col-sm-3 control-label">
            收视率
        </label>
        <div class="col-sm-4">
            <input type="text" id="a_rating" name="a_rating" class="form-control" value="{{ $fields['a_rating'] }}">
        </div>
    </div>