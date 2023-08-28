<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class ApiController extends Controller
{
    //
    public function getAccessToken(Request $request){
        $email = $request->header('email');
        $length = 10;    
        $string =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
        $token = hash('sha256', $string);
        session_start();  
        $_SESSION["accToken"] = $token;

        


       if(!empty($email)){
        return response()->json([
            'status' => '20000',
            'message' => 'Access token generated for :'.$email,
            'accessToken'=>$token,
        ],200);
       }else{
        return response()->json([
            'status' => '4000',
            'message' => 'Required credentials are missing: Email'
        ],400);
       }
    }
    public function getGrantedToken(Request $request){
        session_start();
       $accessToken =  $_SESSION["accToken"];  
       $headerAccToken = $request->header('setToken');
       if($accessToken===$headerAccToken){
        $length = 15;    
        $string =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
        $grant = hash('sha256', $string);
        $_SESSION["grant"] = $grant;
        return response()->json([
            'status' => '20000',
            'message' => 'Access token generated for :',
            'accessToken'=>$accessToken,
            'grant'=>$grant,
        ],200);

       }else{
        return response()->json([
            'status' => '4000',
            'message' => 'Please Provide Valid Token'
        ],400);
       }

    }

    public function getListOfData(Request $request){
        session_start();
        $accessToken =  $_SESSION["accToken"];
        $grant = $_SESSION['grant'];
        $headerAccToken = $request->header('setToken');
        $headerGrant = $request->header('grant');

        if($accessToken===$headerAccToken && $grant === $headerGrant){
            $data =array();
            return response()->json([
                'status' => '20000',
                'message' => 'Access token generated for :',
                'data'=>$data
            ],200);

        }else{
            return response()->json([
                'status' => '40000',
                'message' => 'Please Provide Valid Credintial :'
            ],200);
        }
    }
}
