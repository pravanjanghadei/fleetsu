<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use GuzzleHttp\Client as GuzzleClient;

class DeviceController extends Controller
{

/*
This is to render the search page in the web 
*/


    public function getSearch(){
    	return view('device.search');
    }

    public function postSearch(Request $request){
    	//print_r($_POST);exit;	
    	if($request->ajax()){
    		//$querystr	=	$_POST['devicename'];//.'/'.$_POST['_token'];

    		$url		=	"http://localhost/pravanjan/public/devices";
    		$client 	= 	new GuzzleClient();

	        $response 	= 	$client->get($url
        								,['allow_redirects' => true,
									            'headers' => $_POST,
									            //'form_params'=>$_POST,
									    ])
	        						->getBody();
	        print $response;
    	}else{
    		$res 			=	array();
    		$res['msg']		=	'No Search Found!!!';
    		$res['fail']	=	1;
    		print json_encode($res);
    	}
    }

    public function devices(Request $request){
    	
    	$cond	=	'';
    	$cond	=	$request->header()['devicename'][0]!=''	?	" WHERE device_name LIKE '%".$request->header()['devicename'][0]."%'"	:	'';
    	
    	$sql	=	"	SELECT 
    						id
    						,device_name
    						,last_status
    						,CASE 
    							WHEN TIMESTAMPDIFF( HOUR , last_status, NOW( ) )  > 24 
    								THEN 'red' ELSE 'green' 
    							END as background 
    						,CASE 
    							WHEN TIMESTAMPDIFF( HOUR , last_status, NOW( ) )  > 24 
    								THEN 'offline' ELSE 'ok' 
    							END as status
    					FROM devices".$cond;
    	$res 	=	DB::select($sql);
    	if(count($res)==0){
    		$res 			=	array();
    		$res['msg']		=	'No Search Found!!!';
    		$res['fail']	=	1;
    		return $res;
    	}

    	return json_encode($res);
    }
}
