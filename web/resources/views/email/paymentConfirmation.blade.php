<!DOCTYPE html>
<html>
<head>
	<title>Payment confirmation</title>
</head>
<body>
	<h1>Thank you for purchasing the service {{ $service->name . ' ' . $service->feed }} </h1>
	<p>
		In order to buy the service, please send {{ $service->price }} to our account 
		<strong>886721321343151232</strong>
	</p>
</body>
</html>