@extends('layout.header')

@section('content')

<div class="container" style="margin-top: 80px;">
		<table id="student_table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
				</tr>
				
			</thead>
		</table>
</div>
 <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" defer></script>
      
<script type="text/javascript">
		
		$('#student_table').ready(function(){
			$('#student_table').DataTable({
				"processing" : true,
				"serverSide" : true,
				"ajax" : "{{ route('datatable.studentdata') }}",
				"columns" :[
				{ data: "firstname" },
				{ data: "lastname" },
				]
			});
		});

</script>
@endsection