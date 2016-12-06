<?php
	//edit.php
	require("functions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateRun(cleanInput($_POST["id"]), cleanInput($_POST["o_course"]), cleanInput($_POST["distance"]), cleanInput($_POST["duration"]), cleanInput($_POST["maxSpeed"]), cleanInput($_POST["avgSpeed"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
if(isset($_GET["delete"])){
		
		delete($_GET["id"]);
		
		header("Location: data.php");
		exit();
	}
	
	//kui ei ole id-d aadressireal siis suunan data lehele
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
	}
	//saadan kaasa id
	$m = getSinglerun($_GET["id"]);
	//var_dump($m);

	
	
//Name: deleted, Type: date, Default: null
//UPDATE tabel SET delete = NOW() Where id=?
//mysql-i käsk: WHERE deleted IS NULL
	
?>
<br><br>
<a href="data.php"> Tagasi </a>
	<h1>Muuda jooksu andmed:</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >	
<h3>Raja number (1-5)</h3>
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > <br>
	
<!-- o_course see ei tööta praegu. Ei salvesta andmebaasi. Lisaks tuleb lisada kustutamine-->
		
		<input id="o_course" name="o_course" placeholder="Rada" type="text" value="<?php echo $m->o_course;?>"> <br>
		
<h3>Raja pikkus? (km)</h3>

	<input id="distance" name="distance" placeholder="Pikkus" type="text" value="<?php echo $m->distance;?>"> <br><br>
	
<h3>Läbimise kestvus? (hour.min)</h3>

	<input id="duration" name="duration" placeholder="Kestvus" type="text" value="<?php echo $m->duration;?>"> <br><br>

<h3>Läbimise suurim kiirus? (km/h)</h3>
	
	<input id="maxSpeed" name="maxSpeed" placeholder="Max kiirus" type="text" value="<?php echo $m->maxSpeed;?>"> <br><br>

<h3>Läbimise keskmine kiirus? (min/km)</h3>

	<input id="avgSpeed" name="avgSpeed" placeholder="Avg kiirus" type="text" value="<?php echo $m->avgSpeed;?>"> <br><br>

<input type="submit" name="update" value="Sisesta">
<br>
<br>


<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>

</form>