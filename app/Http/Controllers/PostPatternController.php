<?php

namespace App\Http\Controllers;

use App\Post_marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostPatternController extends Controller
{
    public function postPattern(Request $request)
    {
        $domain = 'http://127.0.0.1:8000/';

        if ($request->submit AND $request->marker_id AND $request->authtoken) {

            $token = $request->authtoken;
            $id = $request->marker_id;

            if($request->hasFile('patt')){
                $valid_formats = ["patt"];
                $patt = $_FILES["patt"]["name"];
                if(strlen($patt)) {
                    $extension = explode(".", $patt)[1];
                    if(in_array($extension,$valid_formats)) {
                            $pattName = time().".".$extension;
                            move_uploaded_file($_FILES['patt']['tmp_name'],public_path('uploads/pattern/').$pattName);
                            $getPatt = $domain.'uploads/pattern/'.$pattName;
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

            //update post pattern
            $postpattern = DB::table('post_marker')->where([
                ['id','=',$id],
                ['authtoken','=',$token]
            ])->update(
                ['linkpatt'=>$getPatt],
                ['name'=>$projectName],
                ['tags'=>$tags],
                ['description'=>$description],
                ['experienceid'=>$experienceid]
            );

            if (empty($postpattern)){
                $response['message']='Pattern not Uploaded.';
                $response['msg_code']=0;
            } 
            else {
                $response['message']='Pattern uploaded successfully';
                $response['msg_code']=1;
                $response['Data']=$postpattern;
            }
        }
        else{
            $response["message"] = "Invalid Request";
            $response["msg_code"] = 0;
        }
        return response()->json($response,201);

    }
}
