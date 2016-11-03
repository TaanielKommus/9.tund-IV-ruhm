<?php
class Helper {

  private $connection;

  //käivitatakse siis kui on = new User(see j6uab siia)
  function __construct($mysqli) {
    //this viitab sellele klassile ja selle klassi muutujale

    $this->connection = $mysqli;
  }


  function cleanInput($input) {

		// input = "  romil  ";
		$input = trim($input);
		// input = "romil";

		// võtab välja \
		$input = stripslashes($input);

		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);

		return $input;

	}


}
?>
