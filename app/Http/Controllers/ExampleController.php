<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    // <!-- php artisan make:controller ExampleController -->

    public function myController(){
        return "Hello World! This is My First Controller";
    }
}
