<?php
class Event {

  private $connection;

  //käivitatakse siis kui on = new User(see j6uab siia)
  function __construct($mysqli) {
    //this viitab sellele klassile ja selle klassi muutujale

    $this->connection = $mysqli;
  }

  function deletePerson($id){

			$stmt = $this->connection->prepare("UPDATE tk SET deleted=NOW() WHERE id=? AND deleted IS NULL");
			$stmt->bind_param("i",$id);

			if($stmt->execute()){

				echo "Õnnestus!";
			}

			$stmt->close();

		}

    function getAllPeople() {

  		$stmt = $this->connection->prepare("
  			SELECT id, age, color
  			FROM tk
  			WHERE deleted IS NULL
  		");
  		$stmt->bind_result($id, $age, $color);
  		$stmt->execute();

  		$results = array();

  		// tsükli sisu tehakse nii mitu korda, mitu rida
  		// SQL lausega tuleb
  		while ($stmt->fetch()) {

  			$human = new StdClass();
  			$human->id = $id;
  			$human->age = $age;
  			$human->lightColor = $color;


  			//echo $color."<br>";
  			array_push($results, $human);

  		}

  		return $results;

  	}

    function getSinglePersonData($edit_id){

  		$stmt = $this->connection->prepare("SELECT age, color FROM tk WHERE id=? AND deleted IS NULL");

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

  		return $p;

  	}

    function saveEvent($age, $color) {

  		$stmt = $this->connection->prepare("INSERT INTO tk (age, color) VALUE (?, ?)");
  		echo $this->connection->error;

  		$stmt->bind_param("is", $age, $color);

  		if ( $stmt->execute() ) {
  			echo "õnnestus";
  		} else {
  			echo "ERROR ".$stmt->error;
  		}

  	}

    function updatePerson($id, $age, $color){

  		$stmt = $this->connection->prepare("UPDATE tk SET age=?, color=? WHERE id=? AND deleted IS NULL");
  		$stmt->bind_param("isi",$age, $color, $id);

  		// kas õnnestus salvestada
  		if($stmt->execute()){
  			// õnnestus
  			echo "salvestus õnnestus!";
  		}

  		$stmt->close();

  	}

}
?>
