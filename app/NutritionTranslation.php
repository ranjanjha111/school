<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutritionTranslation extends Model
{
    public $timestamps = true;

    public $fillable = ['name', 'added_by', 'updated_by'];
}
