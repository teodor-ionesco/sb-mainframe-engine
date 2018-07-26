<html>
	<head>
	</head>
	<body>
		<input type="text" id="string">
		<input type="button" id="send" value="send">

		<div id="div_id">
			
		</div>

		<script src="jquery.min.js"></script>
		<script>
			var gCHL = null;

			function ___ehandler()
			{

			}

			$('#send').click(function()
			{
				$.ajax ({
					url: 'index.php',
					method: 'POST',

					data: {
						cbhid: 'aaa',
						cbchl: gCHL,
						string: $('#string').val(),
					},
					
					accepts: {
						json: 'application/json'
					},

					statusCode:{
						200: function (r)
						{
							gCHL = r['response']['cbchl'];

							alert(r);
						},

						500: function()
						{
							alert("Error 500. Please contact the Webmaster.");
						},
					}
				});
			});
		</script>
	</body>
</html>