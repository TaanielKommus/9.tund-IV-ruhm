<?php
class Helper {

  function cleanInput($input) {

		$input = trim($input);

		// võtab välja \
		$input = stripslashes($input);

		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);

		return $input;

	}


}
?>
