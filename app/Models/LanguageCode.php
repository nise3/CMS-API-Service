<?php

namespace App\Models;


/**
 * Class LanguageCode
 * @package App\Models
 * @property int id
 * @property string name
 * @property string native_name
 * @property string code
 */
class LanguageCode extends BaseModel
{

    protected $guarded = ['id'];

    public $timestamps = false;

}
