<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatList extends Model
{
    protected $table = 'statlists';
    protected $primaryKey='id';
    public $timestamps = false;
    protected $fillable = [
              'statname', 'r_id', 'a_id'
            ];
}
