<!DOCTYPE html>
<html lang="de">
<head>
	<title>>Tag der offenen Tür<</title>
	<link rel="icon" href="https://fsggeldern.de/wp-content/uploads/2020/12/cropped-fsggeldern_icon-32x32.png"/>
	<!--<link rel="stylesheet" href="assets/main.css">
	-->
	<style>
	*{
		font-family: Arial, Helvetica, sans-serif;
		color: #185d9a;
	}

	.ebene{
		line-height: 0px;
	}
	details{
		font-size: 120%
	}
	input{
		font-size: 120%;
	}
	#heading{
		line-height: 0px;
	}
	#code-error{
		font-style: italic;
		font-size: 16px;
		
	}
	#logo{
		position: absolute;
		height: 8%;
		top: 0px;
		text-align: right; 
		right: 0px;
	}
	
	</style>
	
	<?php
	
	$gruppenZahl = 10;			//Anzahl der Gruppen bei änderungen auch was bei #gruppenÄnderung ändern
	$stationZahl = 6;			//Anzahl der Stationen bei änderungen auch was bei #stationenÄnderung ändern
	
	//Init of Station Arrays
	
	{$stationenNamen = [		// Init der Stationen, von Index 0 - Max	#stationenÄnderung
		'Mensa',
		'Kunst/Musik',
		'Gesellschaftswissenschaften',
		'Sprachen',
		'Naturwissenschaften',
		'Unbekannt'
		];}
	{$StationQuiz = [	#stationenÄnderung
		"quiz.php",
		"kreativ.php",
		"gesellschaft.php",
		"sprachen.php",
		"nat.php",
		"ende.php"
		];}
	{$stationenLösung = [	#stationenÄnderung
		'',
		'KULTUR',
		'FSG',
		'851688',
		'129',
		''
		];}
	
	$SchulhofNamen = ["nördlichen Schulhof", "mittleren Schulhof", "oberen Schulhof"];
	$BoxFarben = ["rote", "gelbe", "grüne", "blaue"];
	
	//Reading GET Values
	$error = False;
	$gruppe = -1;
	if(isset($_GET['gruppe'])){
		$gruppe = doubleval($_GET['gruppe']);	
		if($gruppe >= $gruppenZahl) $error = True;	//Check for to high Numbers
		
	}else{
		$error = True;
	}
	$station = 0;
	if(isset($_GET['station'])){
		$station = doubleval($_GET['station']);
		if($station >= $stationZahl) $error = True;	//Check for to high Numbers
	}

	$wort = "";
	if(isset($_GET['wort'])){
		$wort = $_GET['wort'];
	}
	
	$quickLink = isset($_GET['q']);//Wenn die Quick.html verwendet wurde wird kein Codewort gebraucht
	$lGang = isset($_GET['l']);//Beim letzten Durchgang wird die Sporthalle bereits früher Teil der Aufgaben sein
	
	
	if($gruppe < 0){
		$error = True;
	}
	if($station < 0){
		$error = True;
	}
	

	?>
</head>
<body>
<!--	Stationen mit Index					#stationenÄnderung
				Mensa					:	0
			Kunst/Musik 				:	1
		Gesellschaftswissenschaften		:	2
				Sprachen				:	3
			Naturwissenschaften			:	4
		Sporthalle/Mittlerer Schulhof	:	5-->
<?php
if($error == 0){
	
	
	$stationen = [];	//Liste mit den Stationen wird im Folgenden switch befüllt
	switch($gruppe){	#gruppenÄnderung
		case 0:	//gruppe 1
			$stationen = [0,1,2,3,4,5];	#stationenÄnderung
		break;
		case 1:	//gruppe 2
			$stationen = [0,2,1,4,3,5];	#stationenÄnderung
		break;
		case 2:	//gruppe 3
			$stationen = [0,3,4,1,2,5];	#stationenÄnderung
		break;
		case 3:	//gruppe 4
			$stationen = [0,4,3,2,1,5];	#stationenÄnderung
		break;
		case 4: //gruppe 5
			$stationen = [0,2,3,4,1,5];	#stationenÄnderung
		break;
		case 5:	//gruppe 6
			$stationen = [0,1,2,4,3,5];	#stationenÄnderung
		break;
		case 6:	//gruppe 7
			$stationen = [0,2,4,3,1,5];	#stationenÄnderung
		break;
		case 7:	//gruppe 8
			$stationen = [0,4,3,1,2,5];	#stationenÄnderung
		break;
		case 8:	//gruppe 9
			$stationen = [0,3,4,2,1,5];	#stationenÄnderung
		break;
		case 9:	//gruppe 10
			$stationen = [0,1,4,3,2,5];	#stationenÄnderung
		break;
	}
	
	if($lGang){
		$stationen[0] = 5;	#stationenÄnderung
		$stationen[5] = 0;	#stationenÄnderung
	}
	
	$correctPW = True;
	$reload = False;
	do{
	
	$doneStations = 0;
	$nextStation = -1;
	for($i = 0; $i < $stationZahl; $i++){
		if($stationen[$i] == $station){
			break;
		}
		$doneStations++;		
	}
	if($doneStations < $stationZahl -1){
		$nextStation = $stationen[$doneStations+1];
	}
	if(!$reload && $doneStations > 1){
		if($stationenLösung[$stationen[$doneStations-1]] != $wort && $quickLink == False){
			$reload = True;
			$correctPW = False;
			$station = $stationen[$doneStations-1];
		}
	}else{
		$reload = False;
	}
	
	}while($reload);
	
	
	
	$StationenComplete = [];
	//Berechung welche Stationen gemacht wurden
	for($i=0;$i<$stationZahl;$i++){
		$StationenComplete[$i] = False;
	}
	for($i=0;$i < $doneStations;$i++){
		$StationenComplete[$stationen[$i]] = True;
	}
	
	if($station == 5){ #stationÄnderung 
		$schulhof = $SchulhofNamen[$gruppe%3];
		if($gruppe == 9){	#gruppenÄnderung
			$farbe = $BoxFarben[0];
		}else{
			$farbe = $BoxFarben[$gruppe%3];
		}
	}

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///	HTML COMMENTARY	//////// HTML COMMENTARY	///// HTML COMMENTARY	///
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
	echo "<!-- ------------------------------------------------------- 
		HTML Kommentare für verschiedene Werte und Infos aus PHP
	";
	$HTMLcomments = [
		'Gruppen NR:',
		'Stationen Index: ',
		'Stationen ID:'
		];
	$HTMLcomments[0] = $HTMLcomments[0].strval($gruppe);
	$HTMLcomments[1] = $HTMLcomments[1].strval($doneStations);
	$HTMLcomments[2] = $HTMLcomments[2].strval($station);
	
	echo "
		";
	for($i = 0; $i < count($HTMLcomments); $i++){
		echo $HTMLcomments[$i];
		echo "
		";
	}

	if($lGang){
		echo "Letzter Durchgang, die Sporthalle ist nicht am Ende.
		";
	}
	if($quickLink){
		echo "Weiterleitung durch quick.html";
	}
	echo "--------------------------------- -->
		";
	
	
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///		VISUAL		 //////		VISUAL		 //////		VISUAL		 /////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
	
	//Überschrift
	$line = "<div id='headline' class='top'><h1>Die aktuelle Station ist: ";
	$line = $line.$stationenNamen[$station]."</h1>";
	$line = $line."<img src='assets/logo.jpeg' id='logo'/></div>
	";
	echo $line;

	
	//Info wenn das Codewort nicht richtig eingegeben wurde
	if(!$correctPW){
		echo "		
		<h3 id='heading'> Bitte versuche das Rätsel nochmal und denk an die Schreibweise </h3>
		<div id='code-error heading'>(Keine Leerzeichen und nur Großbuchstaben ODER Zahlen).</div>	
		
		";#stationenÄnderung
	}
	
	echo "<section id='ebenen'>  <!-- Ebenen Section & Button Article-->
	";
	
	
	//Anzeige der Bilder für die Map			#stationenÄnderung
	
	
	//EG genenrierung 		#stationenÄnderung
	{
		echo "<article class='ebene' id='EG-article'>";
	
		if($station == 1){	//Kust/Musik
			echo "<img src='assets/EG/L1_rot.png' alt'Z1' width='100%' class='EG'>
			";
		}elseif($StationenComplete[1]){
			echo "<img src='assets/EG/L1_gruen.png' alt'Z1' width='100%' class='EG'>
			";
		}else{
			echo "<img src='assets/EG/L1_grau.png' alt'Z1' width='100%' class='EG'>
			";
		}
		echo "<br>";
		if($station == 2){	//Gesellschaftswissenschaften
			echo "<img src='assets/EG/L2_S1_rot.png' alt'Z2' width='50%' class='EG'>";
		}elseif($StationenComplete[2]){
			echo "<img src='assets/EG/L2_S1_gruen.png' alt'Z2' width='50%' class='EG'>";
		}else{
			echo "<img src='assets/EG/L2_S1_grau.png' alt'Z2' width='50%' class='EG'>";
		}
		if($station == 3){	//Sprachen
			echo "<img src='assets/EG/L2_S2_rot.png' alt'z2_S1' width='50%' class='EG'>
			";
		}elseif($StationenComplete[3]){
			echo "<img src='assets/EG/L2_S2_gruen.png' alt'Z2_S1' width='50%' class='EG'>
			";
		}else{
			echo "<img src='assets/EG/L2_S2_grau.png' alt'Z2_S1' width='50%' class='EG'>
			";
		}
		
		echo "<br>";
		if($station == 4){	//Gesellschaftswissenschaften
			echo "<img src='assets/EG/L3_rot.png' alt'Z1' width='100%' class='EG'>
			";
		}elseif($StationenComplete[4]){
			echo "<img src='assets/EG/L3_gruen.png' alt'Z2' width='100%' class='EG'>
			";
		}else{
			echo "<img src='assets/EG/L3_grau.png' alt'Z2' width='100%' class='EG'>
			";
		}
		echo "</article>"
		;
	}
	
	echo "</section> <!-- Ende der Ebenen Section -->
	";
	
	
	if(!$lGang && $station == 5){
		$line = "<h3> Finde eine ";
		$line = $line.$farbe." Box auf dem ".$schulhof;
		echo $line; #stationenÄnderung
	}
	
	//Formular
	
	if($doneStations < $stationZahl -1){
		
		//Eingabe & Formular
		echo "
		
		<!-- Formular zur nächsten Station -->
		";
		echo "<form action='index.php' method='GET' class='senden'>
		";
		echo "<input type='hidden' name='gruppe' value='".strval($gruppe)."'>
		";
		echo "<input type='hidden' name='station' value='".strval($nextStation)."'>
		";
		if($lGang){
			echo "<input type='hidden' name='l' value='1'>
			";
		}
		if($stationenLösung[$station] != ""){
			echo "<h3>Code Wort:</h3>";
			
			echo "	<details id='hinweis'>
					<summary> Hinweis </summary>
			";
			$line = "Die Lösung besteht aus ".strval(strlen($stationenLösung[$station]));
			if(is_numeric($stationenLösung[$station])){	#stationenÄnderung
				$line = $line." Zahlen.";
			}else{
				$line = $line." Großbuchstaben.";
			}
			echo $line;
			echo "
			</details>
			";
			
			echo "<input type='text' name='wort' >
			";
			echo "<input type='submit' value='Eingabe Prüfen'>
			";
		}else{
			echo "<input type='submit' value='LOS GEHT´S!!!' style='width: 150px'>	
			";	#stationenÄnderung
		}
		echo "</form>
		";
	}
	
	
	
	
	

}else{
	echo "
	<!--Keine Gruppe und Station angegeben.-->
	";
	
	echo "<h1 id='heading'>Plan des FSG</h1>
	";
	echo '<h3>
	<button onclick="EG()">Erdgeschoss</button>
	<button onclick="OG()">Obergeschoss</button></h3><br>
	';
	echo "<h3> Erdgeschoss </h3><img src='assets/EG/EG.PNG' alt='Karte des Ergeschosses'>
	";
	echo "<h3> Obergeschoss </h3><img src='assets/OG/OG.PNG' alt='Karte des Ergeschosses'>
	";
}	
?>


</body>
</html>