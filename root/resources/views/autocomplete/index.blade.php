<html>
<head>
<title>Bootstrap Example</title>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<!-- 	<div class="dropdown-menu" style="display:block; position:absolute">
		 <li><a href="#">Hello</a></li>
		 <li><a href="#">Hello</a></li>
	 </div> -->
	<div class="container box">
		<h3 align="center">Ajax Autocomplete</h3>
	<div class="form-group"> 
	<input type="text" name="country_name" id="country_name" class="form-control input-lg" placeholder="Enter coutry"> 
	<div id="countrylist"></div>
	{{ csrf_field() }}
	</div>
</div>	  
</body>
</html>

<script>
$(document).ready(function(){
	$('#country_name').keyup(function(){
		var query = $(this).val();
		if(query != '')
		{
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url:"{{ route('autocomplete.fetch') }}",
				method: "POST",
				data:{query:query, _token:_token},
				success:function(data)
				{
					$('#countrylist').fadeIn();
					$('#countrylist').html(data);
				}
			})
		}
	});

	$(document).on('click', 'li', function(){
		$('#country_name').val($(this).text());
		$('#countrylist').fadeOut();
	});
});
	</script>