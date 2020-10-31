<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Fillable fields for a course
     *
     * @return array
     */
    protected $fillable = ['name','comment','reply_id','page_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function replies()
    {
        return $this->hasMany('App\Comment','id','reply_id');
    }
}
