<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class MultipleDeleteController extends Controller
{
      public function multidelete(Request $request){
        $array_id = $request->id;
       
        $dataas = DB::table('infos')->whereIn('id',$array_id)->get(); //whereIn method is used to fetch all data 
        if ($dataas) {                                                //that match with datas in array_id array
            foreach($dataas as $data){                                //variable
    
            if ($data->user_image != 'noImage.jpg') {
            Storage::delete('public/UserImage/'.$data->user_image);
        
      }
    }  
      $dataaa = DB::table('infos')->whereIn('id',$array_id)->delete();

    if($dataaa){ 
        $total_data = count(DB::table('infos')->get());

       $output = "Data deleted successfully!!";
       $msg = array(
              'total_data' => $total_data,
              'output' => $output
                ) ;
       echo json_encode($msg);
    }else{
          echo "Data cannot be deleted!!";
        }
        }else{
          echo "Data cannot be deleted!!";
        }
   
  }
}
