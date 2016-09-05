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

    public function adplaylist()
    {
        return $this->hasOne('App\ADPlayList','id','a_id');
    }

    public function rating()
    {
        return $this->hasOne('App\Rating','rid','r_id');
    }

}
