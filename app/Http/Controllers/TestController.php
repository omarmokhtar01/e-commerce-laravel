<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 class TestController
{
    //
    public function myTest(){
        return "Solid response";
    }
    public function myParams(Request $req , $n){
        return "Params + " .$n;
    }
}
