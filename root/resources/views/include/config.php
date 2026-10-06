<?php
	$conn = new PDO(
		"mysql:host=".config('database.connections.mysql.host').";dbname=".config('database.connections.mysql.database'), 
		config('database.connections.mysql.username'), 
		config('database.connections.mysql.password')
	);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>