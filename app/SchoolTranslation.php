<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTranslation extends Model
{
    protected $fillable = ['name', 'locality', 'address', 'near_by'];
}
