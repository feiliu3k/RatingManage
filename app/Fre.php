<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fre extends Model
{
    protected $table = 'fres';
    protected $primaryKey='id';
    public $timestamps = false;

    protected $fillable = [
        'fre', 'dm', 'remark', 'xs'
    ];

}
