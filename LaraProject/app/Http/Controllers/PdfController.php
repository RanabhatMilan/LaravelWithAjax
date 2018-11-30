<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; //To use pdf class need to install package called DomPDF for that run -> composer require barryvdh/laravel-dompdf
use DB;  //after that go to app/config.php then add in providers: Barryvdh/DomPDF/ServiceProvider::class, and in
class PdfController extends Controller  // aliases: 'PDF' => Barryvdh/DomPDF/Facade::class,
{
    public function pdf(){
    	$pdf = \App::make('dompdf.wrapper');
    	$pdf->loadHTML($this->convert_customer_data_to_html());
    	return $pdf->stream();
    }

    public function convert_customer_data_to_html(){
    	$players_data = DB::table('infos')->orderBy('id','desc')->get();
    	$output = '<h3 align="center">Customer Data</h3>
    	<table width ="100%" style="border-collapse; border:0px;">
    	<tr>
    	<th style="border: 1px solid; padding:12px;" width="35%">Country Image</th>
    	<th style="border: 1px solid; padding:12px;" width="15%">Name</th>
    	<th style="border: 1px solid; padding:12px;" width="15%">Age</th>
    	<th style="border: 1px solid; padding:12px;" width="15%">Gender</th>
    	<th style="border: 1px solid; padding:12px;" width="20%">Email</th>
    	</tr>';
    	foreach($players_data as $data){
    		$output .= '<tr>
    				<td style="border: 1px solid; padding:12px;"><img src="storage/UserImage/'.$data->user_image.'" width="200px" height="150px"><br></td>
    				<td style="border: 1px solid; padding:12px;">'.ucfirst($data->first_name)." ".$data->last_name.'</td>
    				<td style="border: 1px solid; padding:12px;">'.$data->age.'</td>
    				<td style="border: 1px solid; padding:12px;">'.$data->gender.'</td>
    				<td style="border: 1px solid; padding:12px;">'.$data->email.'</td>   				
    		</tr>';
    	}
    	$output .= '</table>';
    	return $output;
    }
}
