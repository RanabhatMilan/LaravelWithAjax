<!DOCTYPE html>
<html>
<head>
	<title>Laravel Database Handling</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<script src="{{ asset('js/app.js') }}"></script>

</head>
<body>
	@yield('content')
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
	setTimeout(function(){
		$('.msg').slideUp('slow');
        $('.msg').html('');
        $('.msg').addClass('hidden');
      },4000);

</script>
</body>
</html>	