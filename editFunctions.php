<?php

	require_once("../../config.php");

	function getSinglePersonData($edit_id){

        $database = "if16_taankomm";

		//echo "id on ".$edit_id;

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("SELECT age, color FROM tk WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($age, $color);
		$stmt->execute();

		//tekitan objekti
		$p = new Stdclass();

		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$p->age = $age;
			$p->color = $color;


		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: data.php");
			exit();
		}

		$stmt->close();
		$mysqli->close();

		return $p;

	}


	function updatePerson($id, $age, $color){

        $database = "if16_taankomm";


		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("UPDATE tk SET age=?, color=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("isi",$age, $color, $id);

		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}

		$stmt->close();
		$mysqli->close();

	}

	function deletePerson($id){

	        $database = "if16_taankomm";

			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

			$stmt = $mysqli->prepare("UPDATE tk SET deleted=NOW() WHERE id=? AND deleted IS NULL");
			$stmt->bind_param("i",$id);

			if($stmt->execute()){

				echo "Õnnestus!";
			}

			$stmt->close();
			$mysqli->close();

		}

?>
