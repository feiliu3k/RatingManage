<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingType extends Model
{
    protected $table = 'ratingtypes';
    protected $primaryKey='id';
    public $timestamps = false;
    protected $fillable = [
              'rating_type','remark'
            ];
}
