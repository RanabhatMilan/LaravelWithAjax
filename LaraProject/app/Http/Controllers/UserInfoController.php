<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Validator;
use Illuminate\Support\Facades\Storage;

class UserInfoController extends Controller
{
    

  public function show(Request $request){

      $datas = DB::table('infos')->orderBy('id','desc')->paginate(4); // To display only 4 datas in a single page
      $total_data = count(DB::table('infos')->get());                 // and create pagination
      return view('showdata',compact('datas'),['total_data' =>$total_data]); 
  }


 public  function storedata(Request $request){

    $validation = Validator::make($request->all(),[
        'first_name' => 'required',
        'last_name' =>  'required',
        'email_address'      => 'required|email',
        'age'        => 'required',
        'gender'     => 'required',
        
    ]);


        $forupdate = null; //To display total number of data in the table or database
        $error_array = array(); //To display error messages
        $success_output = ''; //To display success message
        $newrow = ''; //To add new row or edit the existing row in the table
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $key => $value) {
            $error_array[] = $value;
        }
        }

        else{
         

          if($request->file('upload_image') == ""){
                 $filename = 'noImage.jpg';
                 if($request->old_image != ""){
              $filename = $request->old_image;

            }
          }else{
             if($request->get('old_image') != "" && $request->get('old_image') != 'noImage.jpg'){  Storage::delete('public/UserImage/'.$request->old_image);      
               }
                      $fileextension = $request->file('upload_image')->getClientOriginalExtension();
                      $filename = rand().'_'.time().".".$fileextension;
                      $path = $request->file('upload_image')->storeAs('public/UserImage',$filename); //store images in the folder
                        $path = public_path('/storage/UserImage/'.$data->user_image);
                              if (File::exists($path)) {
                                  File::delete($path);
                              }
                }
                  

        if ($request->get('button_action') == 'insert') {
             $insertedid =   DB::table('infos')->insertGetId([
            'first_name' =>  $request->first_name,
            'last_name'=> $request->last_name,
            'age' => $request->age,
            'gender'=> $request->gender,
            'email' => $request ->email_address,
            'user_image' => $filename

          ]);
          
          $success_output .= '<div class="alert alert-success msg">Data Inserted</div>';
          if ($insertedid) {
            $datas =   DB::table('infos')->where('id',$insertedid)->get();
            foreach($datas as $dataa){
              $data = $dataa;
            }
            $newrow .= '<tr id="'.$data->id.'A" >
              <td><img src="storage/UserImage/'.$data->user_image.'" width="200px" height="150px"><br></td>
              <td>'.ucfirst($data->first_name)." ".$data->last_name.'</td>
              <td>'.$data->age.'</td>
              <td>'.$data->gender.'</td>
              <td>'.$data->email.'</td>
              <td><button class="btn btn-success"  data-toggle="modal" data-target="#showmodal" onclick=\'editData('.json_encode($data).')\'>Edit</button> <button class="btn btn-info ajxdel" onclick=\'deleteData('.$data->id.')\' >DELETE</button></td>
              <td><input type="checkbox" name="multidelete[]" class="multiDelete" value="'.$data->id.'}}"></td></tr>';
          }
        }
        else{
        $insertedid = $request->dataid;
          DB::table('infos')->where('id',$request->dataid)->update([
          'first_name' =>  $request->first_name,
            'last_name'=> $request->last_name,
            'age' => $request->age,
            'gender'=> $request->gender,
            'email' => $request ->email_address,
            'user_image' => $filename
              ]);
                $success_output .= '<div class="alert alert-success msg">Data Updated</div>';
                $forupdate = $insertedid;
            
             if ($insertedid) {
            $datas =   DB::table('infos')->where('id',$insertedid)->get();
            foreach($datas as $dataa){
              $data = $dataa;
            }
            $newrow .= '<td><img src="storage/UserImage/'.$data->user_image.'"width="200px"height="150px"><br></td>
              <td>'.ucfirst($data->first_name)." ".$data->last_name.'</td>
              <td>'.$data->age.'</td>
              <td>'.$data->gender.'</td>
              <td>'.$data->email.'</td>
              <td><button class="btn btn-success"  data-toggle="modal" data-target="#showmodal" onclick=\'editData('.json_encode($data).')\'>Edit</button> <button class="btn btn-info ajxdel" onclick=\'deleteData('.$data->id.')\' >DELETE</button></td>
              <td><input type="checkbox" name="multidelete[]" class="multiDelete" value="'.$data->id.'}}"></td>';
          }
    }

    

   }
    $total_data = count(DB::table('infos')->get());
    $output = array(
      'total_data' => $total_data,
      'error' => $error_array,
      'success'=> $success_output,
      'newrow' => $newrow,
       'forupdate' => $forupdate
       );

    echo json_encode($output);
  
}


    public function removedata(Request $request){
         $datas = DB::table('infos')->where('id',$request->id)->get();
           foreach($datas as $data){
    
            if ($data->user_image != 'noImage.jpg') {
            Storage::delete('public/UserImage/'.$data->user_image); //delete images stored in the folders
        
      }
    } 
        $deleted = DB::table('infos')->where('id',$request->id)->delete();
         $total_data = count(DB::table('infos')->get());
  
        echo $total_data;
    }

}
