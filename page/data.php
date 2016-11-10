
<?php
	//ühendan sessiooniga
	require("../functions.php");

	require("../class/Helper.class.php");
	$Helper = new Helper();

	require("../class/Event.class.php");
	$Event = new Event($mysqli);

	//kui ei ole sisseloginud, suunan login lehele
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	//kas aadressireal on logout
	if (isset($_GET["logout"])) {

		session_destroy();

		header("Location: login.php");
		exit();

	}


	if ( isset($_POST["age"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["age"]) &&
		 !empty($_POST["color"])
	) {


		$color = $Helper->cleaninput($_POST["color"]);

		$Event->saveEvent($Helper->cleaninput($_POST["age"]), $color);
	}

	if(isset($_GET["q"])) {
		$q = $_GET["q"];

	} else {
		//ei otsi
		$q = "";
	}

	$sort = "id";
	$order = "ASC";

	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];

	}

	$people = $Event->getAllPeople($q, $sort, $order);

	echo "<pre>";
	var_dump($people[5]);
	echo "</pre>";

?>

<?php require("../header.php"); ?>

<h1>Data</h1>

<?php echo$_SESSION["userEmail"];?>

<?=$_SESSION["userEmail"];?>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
</p>

<h2>Salvesta sündmus</h2>
<form method="POST" >

	<label>Vanus</label><br>
	<input name="age" type="number">

	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color">

	<br><br>

	<input type="submit" value="Salvesta">

</form>


<h2>Arhiiv</h2>

<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>

<?php


	$html = "<table class='table table-striped table-condensed'>";

		$html .= "<tr>";

		$orderId = "ASC";
		$arr="&darr;";
		if (isset($_GET["order"]) &&
		$_GET["order"] == "ASC" &&
		$_GET["sort"] == "id") {

			$orderId = "DESC";
			$arr="&uarr;";
		}


			$html .= "<th>
			<a href='?q=".$q."&sort=id&order=".$orderId."'>

			ID ".$arr."

			</a>

			</th>";


			$orderAge = "ASC";
			$arr="&darr;";

			if (isset($_GET["order"]) &&
			$_GET["order"] == "ASC" &&
			$_GET["sort"] == "age") {

				$orderAge = "DESC";
				$arr="&uarr;";
			}

				$html .= "<th>
				<a href='?q=".$q."&sort=age&order=".$orderAge."'>

				Vanus ".$arr."
				</a>

				</th>";
				$orderColor = "ASC";
				if (isset($_GET["order"]) &&
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "color") {

					$orderColor = "DESC";

				}


					$html .= "<th>
					<a href='?q=".$q."&sort=color&order=".$orderColor."'>

					Värv
					</a>

					</th>";

		$html .= "</tr>";

		//iga liikme kohta massiivis
		foreach ($people as $p) {

			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->age."</td>";
				$html .= "<td>".$p->lightColor."</td>";
        $html .= "<td>
							<a class='btn btn-default btn xs' href='edit.php?id=".$p->id."'>
							edit.php
							<span class='glyphicon glyphicon-pencil'></span>
							</a>
							</td>";

			$html .= "</tr>";

		}

	$html .= "</table>";

	echo $html;

?>

<h2>Midagi huvitavat</h2>

<?php


	foreach($people as $p) {

		$style = "

		    background-color:".$p->lightColor.";
			width: 40px;
			height: 40px;
			border-radius: 20px;
			text-align: center;
			line-height: 39px;
			float: left;
			margin: 10px;
		";

		echo "<p style ='  ".$style."  '>".$p->age."</p>";

	}


?>

<?php require("../footer.php"); ?>
