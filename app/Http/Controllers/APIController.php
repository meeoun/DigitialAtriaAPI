<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function JSON($message = null, $data = null, $code = 200)
    {

        if($message)
        {
            return response()->json(['data'=>['message'=>$message]],$code);
        }
        else{
            return response()->json(['data'=>$data],$code);
        }
    }

}
