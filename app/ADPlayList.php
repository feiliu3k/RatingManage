<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ADPlayList extends Model
{
    protected $table = 'adplaylists';
    protected $primaryKey='id';
    public $timestamps = false;

    protected $fillable = [
              'd_date', 'b_time', 'f_id', 'number', 'len', 'content','belt','ht_len'
            ];

    public function fre()
    {
        return $this->belongsTo('App\Fre','f_id','id');
    }

     public function statlists()
    {
        return $this->hasMany('App\StatList','a_id','id');
    }
}
