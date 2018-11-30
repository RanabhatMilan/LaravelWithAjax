<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class LiveSearchController extends Controller
{
    function search_action(Request $request){
      $query = $request->get('query');
        if ($request->ajax()) {
          $output = '';
            $datas = DB::table('infos')->where('first_name','like','%'.$query.'%')
                                        ->orWhere('last_name','like','%'.$query.'%')  
                                        ->orWhere('email','like','%'.$query.'%') 
                                        ->orWhere('gender','like','%'.$query.'%') 
                                         ->orWhere('age','like','%'.$query.'%')        
                                         ->orderBy('id','desc')
                                         ->get();
            
          $total_data = count($datas);
          if ($total_data > 0) {
            foreach ($datas as $data) {
                $output .= '<tr id="'.$data->id.'A"> 
                              <td><img src="storage/UserImage/'.$data->user_image.'"width="200px"height="150px"><br></td>
                              <td>'.ucfirst($data->first_name)." ".$data->last_name.'</td>
                              <td>'.$data->age.'</td>
                              <td>'.$data->gender.'</td>
                              <td>'.$data->email.'</td>
                             <td><button class="btn btn-success"  data-toggle="modal" data-target="#showmodal" onclick=\'editData('.json_encode($data).')\'>Edit</button> <button class="btn btn-info ajxdel" onclick=\'deleteData('.$data->id.')\' >DELETE</button></td>
                              <td><input type="checkbox" name="multidelete[]" class="multiDelete" value="'.$data->id.'"></td></tr>';
            }
          }else{
            $output = '<tr><td align="center" colspan="7" >No Data found.</tr>';
          }
          $dataa = array(
            'table_data' => $output,
            'total_data' => $total_data
          );
          echo json_encode($dataa);
        } 
  }
}
