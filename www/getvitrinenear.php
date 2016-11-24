<?php
	require_once('includes/db_login.php');

	$lat = $_GET['lat'];
	$long = $_GET['long'];

	$sql ="SELECT *, ( 6371 * acos ( cos ( radians(".$lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$long.") ) + sin ( radians(".$lat.") ) * sin( radians( latitude ) ) ) ) AS distance
		FROM vitrine
		ORDER BY distance
		LIMIT 0 , 20";
	// ON PEUT AJOUTER HAVING distance < X (en km)
		
	try
	{
		$reponse = $conn->query($sql);
	}
	catch (PDOException $e)
	{
		print($e);
	}

	echo ("{ \"vitrines\":[");
	while ($donnees = $reponse->fetch())
	{
		//Create json object
		echo (json_encode($donnees));
		echo (",");
	}
	echo("]}");
	$reponse->closeCursor();
?>