<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';
    protected $primaryKey='id';
    public $timestamps = false;

    protected $fillable = [
              's_date','f_id','b_time','e_time','rt_id','a_rating'
            ];

    public function fre()
    {
        return $this->belongsTo('App\Fre','f_id','id');
    }

    public function ratingType()
    {
        return $this->belongsTo('App\RatingType','rt_id','id');
    }


}
