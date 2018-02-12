<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Poster extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'poster';
    }
}
