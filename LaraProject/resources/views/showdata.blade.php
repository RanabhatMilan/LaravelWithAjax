<!DOCTYPE html>
<html>
<head>
	<title>Laravel Project</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet"  href="css/app.css">
	<script type="text/javascript" src="js/app.js"></script>
</head>
<body>
<div class="container" style="margin-top: 50px;">
	           
<div class="">
		<div class="form-group">
		  <input type="text" name="search" id="search" class="form-control" placeholder="Search Customer Data" value="" />
    	 </div>
		<div class="pull-right"><button id="addData" data-toggle="modal" data-target="#showmodal" class="btn btn-success">Add Data</button></div><br>
</div>
			
						<div class="" align="right">
					     <a href="{{ url('showdata/pdf') }}" class="btn btn-danger">Convert into PDF</a>
			 		    </div>
					
                       <h3 align="center">Total Data : <span id="total_records">{{ isset($total_data)?$total_data:"" }}</span></h3>

<!-- Table to display data start from here -->            
<div id="table_data">
	<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Country Image</th>
					<th>Name</th>
					<th>Age</th>
					<th>Gender</th>
					<th>Email</th>
					<th>Action</th>
					<th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Delete</i></button></th>
				</tr>
			</thead>
			<tbody class="newrow">

				
				@if($datas)
				
				@foreach($datas as $data )
				<tr id="{{ $data->id.'A' }}">
				<td><img src="storage/UserImage/{{ $data->user_image }}" width="200px" height="150px"><br></td>
				<td>{{ ucfirst($data->first_name)." ".$data->last_name }}</td>
				<td>{{ $data->age }}</td>
				<td>{{ $data->gender }}</td>
				<td>{{ $data->email }}</td>
				<td><button class="btn btn-success" data-toggle="modal" data-target="#showmodal"  onclick='editData( <?php echo json_encode($data); ?> )'>Edit</button>
					<button class="btn btn-info ajxdel" onclick='deleteData( <?php echo $data->id; ?> )' >DELETE</button></td>
					<td><input type="checkbox" name="multidelete[]" class="multiDelete" value="{{ $data->id }}"></td>
			</tr>
				@endforeach
			
				@endif
			</tbody>
		</table>
	{!! $datas->links() !!}	 <!-- Here it creates pagination links -->
</div>

</div>
	
				<!--Modal for adding and deleting data starts from here -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="showmodal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"> <h5 align="center" id="addedit">Fill the form below:</h5>
				<button type="button" id="closemodal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<span id="form_output"></span>
				<form method="post"  id="tableid" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" name="first_name" id="first_name" value="" class="form-control" placeholder="First Name">
					</div>
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" value="" class="form-control" placeholder="Last Name">
					</div>
					<div class="form-group">
						<input type="number" name="age" id="age" value="" class="form-control" placeholder="Age">
					</div>
					<div class="form-group">
						 <select name="gender" id="gender" class="form-control">
						 	<option value="0">--Select Gender--</option>
						 	<option value="M">Male</option>
						 	<option value="F">Female</option>
						 </select>
					</div>
					<div class="form-group">
						<input type="email" name="email_address" id="email" class="form-control" placeholder="Email Address">
					</div>
					<div class="form-group">
						<input type="file" name="upload_image" id="upload_image" accept="image/*" onchange="viewThumbnail(this)">
						<div class="col-sm-4">
				            <img src="" id="thumbnail_img" alt="" class="img img-thumbnail" width="300px;" height="200px;">
				          </div>
					</div>
					<div class="form-group">
						<input type="hidden" name="old_image" id="old_image" value="">
						<input type="hidden" name="dataid" id="dataid" value="">
						<input type="hidden" name="button_action" value="insert" id="button_action">
						<input type="submit" name="submit" id="action" value="Add" class="btn btn-info">
						<button type="button" id="closemodal" data-dismiss="modal" class="btn btn-default">Close</button>
					</div>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>


</body>
<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript">

	//ajax code for live search of data
		$('#search').keyup(function(){
			var query = $('#search').val();
			console.log(query);
			fetch_data_search(query);
		});
         function  fetch_data_search(query){
         	$.ajax({
         			url:"{{ route('showdata.search_action')}}",
         			method:"GET",
         			data:{query:query},
         			dataType:"JSON",
         			success:function(data){
         				$('tbody').html(data.table_data);
         				$('#total_records').text(data.total_data);
         			}

         	});
         }
	
         //ajax code for multiple delete of data
		$('#bulk_delete').click(function(){
			var id = [];
			if (confirm('Are you sure u want to delete this data?')) {
				$('.multiDelete:checked').each(function(){
					id.push($(this).val());
				});
				if (id.length > 0) {
					$.ajax({
						url:"{{ route('userinfo.multidelete') }}",
						method:"GET",
						data:{id:id},
						dataType:"JSON",
						success:function(data){
							alert(data.output);
							$('#total_records').text(data.total_data);
							id.forEach((delid,index)=>{
							$('#'+delid+'A').html('');
						});
					}
					});
				}else{
					alert('Please select atleast one checkbox!!');
				}
			}else{
				return false;
			}
		});
		

		$('#addData').click(function(e){
			$('#form_output').html('');
			$('#tableid')[0].reset();
			$('#thumbnail_img').attr('src','');
			
			$('#action').val('Add');
			$('#button_action').val('insert');
			$('#old_image').val('');
			$('#dataid').val('');
		});

		$('#tableid').on('submit',function(e){
			e.preventDefault();
			$.ajax({
				url: "{{ route('userinfo.storedata') }}",
				method: "POST",
				data: new FormData(this),
				dataType:"JSON",
				contentType:false,
				cache: false,
				processData: false,
				success:function(data){

						if (data.error.length > 0) {
							var error_html = '';
							for(var count = 0; count < data.error.length; count++){
								error_html +='<div class="alert alert-danger msg">'+data.error[count]+'</div>';
							}
							$('#form_output').html(error_html);
						}else{
							if (data.forupdate) {

								$('#'+data.forupdate+'A').html(data.newrow);
							}else{
							var rownew = $('.newrow').html(); 
							$('.newrow').html(data.newrow+rownew);
							} 
						
							$('#total_records').text(data.total_data);
							$('#form_output').html(data.success);
							$('#tableid')[0].reset();
							$('#action').val('Add');
							$('#button_action').val('insert');
							$('#thumbnail_img').attr('src','');
							$('#addedit').html('Fill the form below:');
						
						}
				}
			});
		});
		
		function deleteData(deldata){
			console.log(deldata);
			var delid = deldata;
			if (confirm('Are you sure U want to delete this data?')) {
				$.ajax({
					url: "{{ route('userinfo.removedata') }}",
					method: "GET",
					data:{id:delid},
					success:function(data){
						$('#total_records').text(data);
						$('#'+delid+'A').html('');
					}
				});
			}else{	
				return false;
			}

		}
		
		function editData(info){
			$('#form_output').html('');
			$('#tableid')[0].reset();
			console.log(info);
			$('#old_image').val(info.user_image);
			$('#dataid').val(info.id);
			$('#button_action').val('edit');
			$('#addedit').html('Edit the form below:');
			$('#action').val('Edit');
			$('#first_name').val(info.first_name);
			$('#last_name').val(info.last_name);
			$('#age').val(info.age);
			$('#gender').val(info.gender);
			$('#email').val(info.email);
			$('#thumbnail_img').attr('src','storage/UserImage/'+info.user_image);
		}

   function viewThumbnail(input, thumbnail_id = 'thumbnail_img'){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            $('#'+thumbnail_id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
	}
        setTimeout(function(){
        $('.msg').slideUp('slow');
        $('.msg').html('');
        $('.msg').addClass('hidden');
      },4000);

	</script>

</html>