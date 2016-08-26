<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fre extends Model
{
    protected $table = 'fres';
    protected $primaryKey='id';

    protected $fillable = [
        'fre', 'dm', 'remark', 'xs'
    ];

}
