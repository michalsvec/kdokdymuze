<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);


	define('START_MON', 6);
	define('END_MON', 9);
	define('HIST_HEIGHT', 20);

	$weekList = Array('Po', 'Út', 'St', 'Čt', 'Pá', 'So', 'Ne');
	$monthList = Array(5=> 'Květen', 6=>'Červen', 7=> 'Červenec', 8=>'Srpen', 9=>'Září');

	function pr($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	function getHistDiv($items, $max) {
		if(empty($items)) return "";
		
		return '<img src="'.((count($items)==$max) ? 'progressbar_red.png' : 'progressbar.png').'" width="10" height="'.(HIST_HEIGHT*(count($items)/$max)).'" alt="'.join(", ", $items).'">';
	
	}
	
	$GLOBALS['configuration']['db'] = "isotop";
	$GLOBALS['configuration']['host'] = "localhost";
	$GLOBALS['configuration']['user'] = "isotop";
	$GLOBALS['configuration']['pass'] = "isotop";

	include_once('objects/class.database.php');
	include_once('objects/class.pog_base.php');
	include_once('objects/class.kdokdymuze_date.php');
	include_once('objects/class.kdokdymuze_user.php');
	
	// odhlaseni
	if(isset($_GET['logout'])) { 
		unset($_SESSION['email']); 
		unset($_SESSION['id']); 
		header('Location: index.php');
		die();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>kdokdymuze 0.1</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<style>
		td { text-align:center; width: 20px; }
		.weekEnd { border-right: 1px solid black;}
	</style>
</head>
<body>
<?php

	setlocale(LC_ALL, 'cs_CZ');
	
	// pokus o prihlaseni
	if(empty($_SESSION['email']) && !empty($_POST) && $_POST['type'] == "notnew") {
		$object = new kdokdymuze_user();
		$list = $object->Getlist(array(array("email", "=", mysql_escape_string($_POST['email']))));
		
		if(!empty($list)) {
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['id'] = $list[0]->kdokdymuze_userId;
			$_SESSION['name'] = $list[0]->jmeno;
		}
	}
	// novy uzivatel
	if(empty($_SESSION['email']) && !empty($_POST) && $_POST['type'] == "new") {
		$object = new kdokdymuze_user();

		$list = $object->Getlist(array(array("email", "=", mysql_escape_string($_POST['email']))));
		if(!empty($list)) {
			$msg = "Tento email uz si nekdo zamluvil. Zkus jinej!!";
		} else {
	
			$object->email = $_POST['email'];
			$object->jmeno = $_POST['name'];
			$object->Save();

			$_SESSION['email'] = $_POST['email'];
			$_SESSION['name'] = $_POST['name'];
			$_SESSION['id'] = $object->kdokdymuze_userId;
		}
	}

	//echo "<pre>"; print_r($_SESSION); echo "</pre>";

	/*
	 * nekdo znamy - vypiseme jeho volby
	 */
	if(isset($_SESSION['email'])) {
		
		
		echo '<h1>A hele! '.$_SESSION['name'].'! Zdravim!</h1>';
		echo '<a href="?logout">Odhlasit</a>';
		
		if($_POST['save'] == "jjulozto") {
			$date_obj = new kdokdymuze_date();
			$date_obj->DeleteList(array(array('kdokdymuze_userid', '=', $_SESSION['id'])));

			$datesave = new kdokdymuze_date();
			foreach($_POST['kdymuzu'] as $date) {
				$datesave -> kdokdymuze_userId = $_SESSION['id'];
				$datesave -> date = $date;
				$datesave->SaveNew();
			}
		}

		/**
		 * Zjisteni voleb prave prihlaseneho uzivatele
		 */
		$date = new kdokdymuze_date();
		$list = $date->Getlist(array(array('kdokdymuze_userid', '=', $_SESSION['id'])));
		$userDates = array();
		foreach($list as $date) {
			$userDates[$date->date] = true;
		}

		/**
		 * Parsnuti histogramu
		 */
		$sql = "SELECT * FROM  `kdokdymuze_date` AS D LEFT JOIN kdokdymuze_user AS U ON D.`kdokdymuze_userid` = U.`kdokdymuze_userid` 
			ORDER BY `date`";
		$query = mysql_query($sql);
		$histogram = array();
		while($data = mysql_fetch_array($query)) {
			$histogramData[$data['date']][] = $data['jmeno'];
		}
		// nalezeni maxima z histogramu
		$hist_max=0;
		foreach($histogramData as $k=>$v) {
			if(count($histogramData[$k]) > $hist_max)
				$hist_max = count($histogramData[$k]);
		}
		

		// zobrazeni radku jednotlivych mesicu
		echo '<form action="" method="post"><input type="hidden" name="save" value="jjulozto">';
		for($mon = START_MON; $mon <= END_MON; $mon++) {
			$mon_time = strtotime("1.$mon.2010");
			$month = $monthList[$mon];
			$mon_num = date("m", $mon_time);
			$daycount = date("t", $mon_time);
			
			$offset = date("N", $mon_time)-2;
			//echo "$mon: $daycount - $month<br>";

			/**
			 * Vypis tabulky s dny a checkboxy
			 */
			$text = "";
			$histogram = "";
			for($i=1; $i<=$daycount; $i++) {
				$form_date = '2010-'.$mon_num.'-'.($i < 10 ? str_pad($i, 2, "0", STR_PAD_LEFT) : $i);

				$text .= '<td '.($i%7==0 ? 'class="weekEnd"' : '').'>'.$weekList[($i+$offset)%7]."<br>".$i.'<br><input type="checkbox" name="kdymuzu[]" value="'.$form_date.'" '.($userDates[$form_date] ? 'checked="checked"' : '').'></td>';
				
				
				$histogram .= '<td valign="bottom">'.getHistDiv($histogramData[$form_date], $hist_max).'</td>';
			}

			echo "<h2>$month</h2>";
			echo '<table>';
			echo '<tr>'.$histogram.'</tr><tr>'.$text.'</td>';
			echo '</tr></table>';
		}
		
		
		echo '<button type="submit" onclick=\'javascript: confirm("Sure????")\'>Už jsem se rozhodl/a a chci to uložit</button></form>';
	
	} 
	//----------------------------------------------------------------------------------------
	/*
	 * neznamy clovek = prihlasovaci form
	 */
	else {	
?>
	<h2>Ještě jsem nic nevyplňoval/a</h2>
<?php
	if(!empty($msg)) echo '<h2 style="color: red">'.$msg.'</h2>';
?>
	<form action="" method="post">
		<input type="hidden" name="type" value="new" />
		<label for="name">Ctěné jméno: </label><input type="text" name="name" id="name" /><br />
		<label for="email">E-mail:</label><input type="text" name="email" id="email" /><br />
		<button type="submit">Přihlaš mě simtě!</button>
	</form>
	<hr />
	<h2>Už jsem tam něco náhodně naklikal/a a chci to změnit</h2>
	<form action="" method="post">
		<input type="hidden" name="type" value="notnew" />
		<label for="email">E-mail:</label><input type="text" name="email" id="email" /><br />
		<button type="submit">Přihlaš mě simtě!</button>
	</form>
<?php
	}
?>

</body>
</html>