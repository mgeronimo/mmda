<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TNav extends Model
{
    protected $table = 'mmda';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['road1', 'road2', 'way', 'description', 'pubDate'];
}
