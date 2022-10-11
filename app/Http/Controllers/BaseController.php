<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseMessage($status,$message,$data=array(),$statusCode=200){
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'data'=>$data
        ],$statusCode);
    }
}
