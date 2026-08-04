<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = User::where('id', 1)->first();
    }
    
}
