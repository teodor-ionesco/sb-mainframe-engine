<html>
	<head>
	</head>
	<body>
		<input type="text" id="string">
		<input type="button" id="send" value="send">
		<br>

		<div id="div_id">
			
		</div>

		<script src="jquery.min.js"></script>
		<script>
			var gCHL = null;
			var gErrorGen = "An unexpected error occurred and this Chatbot can't properly reply to your inquiry. Please try again later. If you are a developer check Browser Console.";
			var gReplyDiv = {};
				gReplyDiv[0] = "<div>";
				gReplyDiv[1] = "</div><br>";

			function ___ehandler(s)
			{
				switch(s['success'])
				{
					case 0: {
						console.log(s['note']);
						return false;
					};

					case 1: {
						return true;
					};

					default: {
						console.log("Undefined success code: '"+s['success']+"'. Please contact the Webmaster.");
						return false;
					};
				}
			}

			function ___print(s)
			{
				$("#div_id").last().after().append(gReplyDiv[0] + s + gReplyDiv[1]);
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

					statusCode: {
						200: function (r)
						{
							gCHL = r['response']['cbchl'];

							(___ehandler(r) === true) ? ___print(r['response']['reply']) : ___print(gErrorGen);
						},

						500: function(r)
						{
							console.log("Error 500 - Internal Server Error. Please contact the Webmaster.");

							___print(gErrorGen);
						},

						503: function(r)
						{
							console.log("Error 503 - Service unavailable. Please try again later.");

							___print(gErrorGen);
						}
					}
				});
			});
		</script>
	</body>
</html>