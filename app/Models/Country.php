<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'title', 'title_en', 'code'
    ];
}
