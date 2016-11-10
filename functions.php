<?php

	require("/home/taankomm/config.php");

	// see fail peab olema siis seotud kõigiga kus
	// tahame sessiooni kasutada
	// saab kasutada nüüd $_SESSION muutujat
	session_start();

	$database = "if16_taankomm";
	// functions.php
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);

?>
