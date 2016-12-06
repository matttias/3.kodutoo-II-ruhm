<?php

require("../../config.php");
require("functions.php");

$o_course = ""; //<---orienteerumis raja number
$distance = "";
$duration = "";
$maxSpeed = "";
$avgSpeed = "";
$o_courseError = "";
$distanceError = "";
$durationError = "";
$maxSpeedError = "";
$avgSpeedError = "";

//$searching = "r";
//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){
	//suunan sisselogimise lehele
	header("Location: login.php");	
	exit();
}

//kui on ?logout aadressireal siis login välja
if (isset($_GET["logout"])) {
	session_destroy();
	header("Location: login.php");
	exit();
}

if(!isset($_POST["o_course"])){
	//if(empty( $_POST["o_course"] ) ){
		$o_courseError = "See väli on kohustuslik";
	}else{
		$o_course = $_POST["o_course"];
		//}
} 

if(isset($_POST["distance"])){
	if(empty($_POST["distance"])){
		$distanceError = "See väli on kohustuslik";	
	} else {
		$_POST["distance"] = cleanInput($_POST["distance"]);
		$distance = $_POST["distance"];
	}
}

if(isset($_POST["duration"])){
	if(empty($_POST["duration"])){
		$durationError = "See väli on kohustuslik";	
	} else {
		$_POST["duration"] = cleanInput($_POST["duration"]);
		$duration = $_POST["duration"];
	}
}

if(isset($_POST["maxSpeed"])){
	if(empty($_POST["maxSpeed"])){
		$maxSpeedError = "See väli on kohustuslik";	
	} else {
		$_POST["maxSpeed"] = cleanInput($_POST["maxSpeed"]);
		$maxSpeed = $_POST["maxSpeed"];
	}
}

if(isset($_POST["avgSpeed"])){
	if(empty($_POST["avgSpeed"])){
		$avgSpeedError = "See väli on kohustuslik";	
	} else {
		$_POST["avgSpeed"] = cleanInput($_POST["avgSpeed"]);
		$avgSpeed = $_POST["avgSpeed"];
	}
}

if (isset($_POST["o_course"]) && isset($_POST["distance"]) && isset($_POST["duration"]) && isset($_POST["maxSpeed"])&& isset($_POST["avgSpeed"]) &&
!empty($_POST["o_course"]) && !empty($_POST["distance"]) && !empty($_POST["duration"]) && !empty($_POST["maxSpeed"]) && !empty($_POST["avgSpeed"]))
	{
		run($_SESSION["userName"], $o_course, $distance, $duration, $maxSpeed, $avgSpeed);
	}

//$runData = getRun($searching);


	// sorteerib
if(isset($_GET["sort"]) && isset($_GET["direction"])){
	$sort = $_GET["sort"];
	$direction = $_GET["direction"];
}else{
	// kui ei ole määratud siis vaikimis id ja ASC
	$sort = "id";
	$direction = "ascending";
}


//kas kasutaja otsib
if(isset($_GET["searching"])){
	$searching = cleanInput($_GET["searching"]);
		$runData = getRun($searching, $sort, $direction);
	} else {
		$searching = "";
		$runData = getRun($searching, $sort, $direction);
}


?>
<h1>DATA<h1>
	
<p>Tere tulemast <?=$_SESSION["firstName"];?> <?=$_SESSION["lastName"];?>!</p>
<p>Kasutajanimi: <a href="user.php"><?=$_SESSION["userName"];?></a></p>
<p>E-mail: <?=$_SESSION["userEmail"];?></p>
<p>Sugu: <?=$_SESSION["gender"];?></p>
<a href="?logout=1">Logi välja</a>  <br> <br>

	<h1>Sisesta enda jooksu andmed:</h1>

<h3>Rada number</h3>
<form method="POST">

		<?php if($o_course == "1") { ?>
			<input name="o_course" value="1" type="radio" checked> 1 <br>
		<?php }else { ?> <!--Tühikud peavad olema-->
			<input name="o_course" value="1" type="radio"> 1 <br>
		<?php } ?>	
		
		
		<?php if($o_course == "2") { ?>
			<input name="o_course" value="2" type="radio" checked> 2 <br>
		<?php }else { ?>
			<input name="o_course" value="2" type="radio"> 2 <br>
		<?php } ?>
		
		
		<?php if($o_course == "3") { ?>
			<input name="o_course" value="3" type="radio" checked> 3 <br>
		<?php }else { ?> 
			<input name="o_course" value="3" type="radio"> 3 <br>
		<?php } ?>
		
		
		<?php if($o_course == "4") { ?>
			<input name="o_course" value="4" type="radio" checked> 4 <br>
		<?php }else { ?> 
			<input name="o_course" value="4" type="radio"> 4 <br>
		<?php } ?>
		
		
		<?php if($o_course == "5") { ?>
			<input name="o_course" value="5" type="radio" checked> 5 <br>
		<?php }else { ?> 
			<input name="o_course" value="5" type="radio"> 5 <br>
		<?php } ?>
		
		<?=$o_courseError; ?> <br>

<h3>Raja pikkus? (km)</h3>

	<input name="distance" placeholder="Pikkus" type="text" value="<?=$distance;?>"> <?=$distanceError; ?> <br><br>
	
<h3>Läbimise kestvus? (hour.min)</h3>
	
	<input name="duration" placeholder="Kestvus" type="text" value="<?=$duration;?>" > <?=$durationError; ?> <br><br>

<h3>Läbimise suurim kiirus? (km/h)</h3>
	
	<input name="maxSpeed" placeholder="Max kiirus" type="text" value="<?=$maxSpeed;?>" > <?=$maxSpeedError; ?> <br><br>

<h3>Läbimise keskmine kiirus? (min/km)</h3>

	<input name="avgSpeed" placeholder="Avg kiirus" type="text" value="<?=$avgSpeed;?>" > <?=$avgSpeedError; ?> <br><br>

<input type="submit" value="Sisesta">

</form>

<?php
	
	//<a href='?searching=".$searching."&sort=o_course&direction=".$direction."'>o_course</a>
	//<a href='?searching=".$searching."&sort=username&direction=".$direction."'>username</a>
	$direction = "ascending";
	if (isset($_GET["direction"])){
		if ($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}
	
	$html = "<table>";
	$html .="<tr>";
		$html .= "<th><a href='?searching=".$searching."&sort=id&direction=".$direction."'>id</a></th>";
		$html .= "<th>username</th>";
		$html .= "<th>o_course</th>";
		$html .= "<th>distance(km)</th>";
		$html .= "<th>duration(hour.min)</th>";
		$html .= "<th>maxspeed(km/h)</th>";
		$html .= "<th>avgspeed(min/km)</th>";
		$html .= "<th>date</th>";
	$html .="</tr>";
	
	foreach($runData as $m) {
	
	$html .="<tr>";
		$html .= "<td>".$m->id."</td>";
		$html .= "<td>".$m->userName."</td>";
		$html .= "<td>".$m->o_course."</td>";
		$html .= "<td>".$m->distance."</td>";
		$html .= "<td>".$m->duration."</td>";
		$html .= "<td>".$m->maxSpeed."</td>";
		$html .= "<td>".$m->avgSpeed."</td>";
		$html .= "<td>".$m->date."</td>";
		$html .= "<td><a href='edit.php?id=".$m->id."'>edit.php</a></td>";
	$html .="</tr>";
	
	}
$html .="</table>";
echo $html;

?>

<br>
<br>

<form>
	<input type="search" name="searching" value="<?=$searching;?>">
	<input type="submit" value="Otsi">
</form>



</body>
</html>


<br>
<br>
<br>