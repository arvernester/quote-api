<?php

namespace App\Contracts;

interface Quote
{
    /**
     * Import single quote from API.
     */
    public function import();
}
