
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
		{!! $datas->links() !!}
