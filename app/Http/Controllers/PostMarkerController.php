<?php

namespace App\Http\Controllers;

use App\Post_marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostMarkerController extends Controller
{
    public function postMarker(Request $request)
    {
        
        $domain = 'http://127.0.0.1:8000/';

        if ($request->submit AND $request->authtoken) {

            $token = $request->authtoken;

            if($request->hasFile('marker')){
                $valid_formats = ["png","jpeg","jpg"];
                $marker = $_FILES['marker']['name'];
                $photoSize = $_FILES['marker']['size'];
                if(strlen($marker)) {
                    $extension = explode(".", $marker)[1];
                    if(in_array($extension,$valid_formats)) {
                        if($photoSize<(10240*10240)) {
                            $markerName = time().".".$extension;
                            move_uploaded_file($_FILES['marker']['tmp_name'],public_path('uploads/marker/').$markerName);
                            $getMarker=$domain.'uploads/marker/'.$markerName;
                        }
                        else{
                            return ['errormessage'=>'File size limit exceeded. Marker is too large.'];
                        }
                    }
                    else{
                        return ['errormessage'=>'Invalid File.'];
                    }
                }
            }
            else {
                $getMarker = '';
            }

            if($request->hasFile('patt')){
                $valid_formats = ["patt"];
                $patt = $_FILES["patt"]["name"];
                $patt_size = $_FILES["patt"]["size"];
                if(strlen($patt)){
                    $extension = explode(".", $patt)[1];
                    if(in_array($extension,$valid_formats)){
                        if ($patt_size<(10240*10240)) {
                            $patt_name = time().".".$extension;
                            move_uploaded_file($_FILES['patt']['tmp_name'],public_path('uploads/pattern/').$patt_name);
                            $getPatt = $domain.'uploads/pattern/'.$patt_name;
                        }
                        else{
                            return ['errormessage'=>'File size limit exceeded. Marker is too large.'];
                        }
                    }
                    else{
                        return ['errormessage'=>'Invalid File.'];
                    }
                }
            }
            else {
                $getPatt = '';
            }
        
            $projectName = $request->name;
            $tags = $request->tags;    
            $description = $request->description;
            $experienceid = $request->experienceid;

            //create post marker
            $data = [
                'authtoken'=>$token,
                'marker'=>$getMarker,
                'linkpatt'=>$getPatt,
                'name'=>$projectName,
                'tags'=>$tags,
                'description'=>$description,
                'experienceid'=>$experienceid
            ];
            
            $post = Post_marker::create($data);

            if (empty($post)){
                $response['message']='Marker not Uploaded.';
                $response['msg_code']=0;
            } 
            else {
                $response['message']='Marker uploaded successfully';
                $response['msg_code']=1;
                $response['Data']=$post;
            }
        }
        else{
            $response["message"] = "Invalid Request";
            $response["msg_code"] = 0;
        }
        return response()->json($response,201);

    }
    public function fetchMarker(Request $request){
        if ($request->submit AND $request->authtoken){
            $authtoken = $request->authtoken;
            $markers = DB::table('post_markers')->where('authtoken','=',$authtoken)->orderBy('id','desc')->get();
            $response['Data']=$markers;
        }
        else {
            $response['message']='Invalid Request.';
            $response['msg_code']=0;
        }
        return json_encode($response);
    }
}
