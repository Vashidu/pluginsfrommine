<?php
ob_start();
include('dynmap_access.php');
ob_end_clean();

session_start();

if(isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
}
else {
  $userid = '-guest-';
}

$loggedin = false;
if(strcmp($userid, '-guest-')) {
  $loggedin = true;
}

$path = $_REQUEST['marker'];
if ((!isset($path)) || strstr($path, "..")) {
    header('HTTP/1.0 500 Error');
    echo "<h1>500 Error</h1>";
    echo "Bad marker: " . $path;
    exit();
}

$parts = explode("/", $path);

if(($parts[0] != "faces") && ($parts[0] != "_markers_")) {
    header('HTTP/1.0 500 Error');
    echo "<h1>500 Error</h1>";
    echo "Bad marker: " . $path;
    exit();
}

$db = mysqli_connect('p:' . $dbhost, $dbuserid, $dbpassword, $dbname, $dbport);
if (mysqli_connect_errno()) {
    header('HTTP/1.0 500 Error');
    echo "<h1>500 Error</h1>";
    echo "Error opening database";
	$db->close();
    exit;
}

if ($parts[0] == "faces") {
	if (count($parts) != 3) {
	    header('HTTP/1.0 500 Error');
    	echo "<h1>500 Error</h1>";
    	echo "Bad face: " . $path;
    	exit();
	}
	$ft = 0;
	if ($parts[1] == "8x8") {
		$ft = 0;
	}
	else if ($parts[1] == '16x16') {
	    $ft = 1;
   	}
   	else if ($parts[1] == '32x32') {
   	    $ft = 2;
	}
	else if ($parts[1] == 'body') {
		$ft = 3;
	}
	$pn = explode(".", $parts[2]);
	$stmt = $db->prepare('SELECT Image from Faces WHERE PlayerName=? AND TypeID=?');
	$stmt->bind_param('si', $pn[0], $ft);
	$res = $stmt->execute();
	$stmt->bind_result($timage);
	if ($stmt->fetch()) {
      header('Content-Type: image/png');
	  echo $timage;
	}
	else {
		header('Location: ../images/blank.png');
		exit;
	}
}
else { // _markers_
	$in = explode(".", $parts[1]);
	if (($in[1] == "json") && (strpos($in[0], "marker_") == 0)) {
		$world = substr($in[0], 7);
		$stmt = $db->prepare('SELECT Content from MarkerFiles WHERE FileName=?');
		$stmt->bind_param('s', $world);
		$res = $stmt->execute();
		$stmt->bind_result($timage);
  		header('Content-Type: application/json');
		if ($stmt->fetch()) {
			echo $timage;
		}
		else {
			echo "{ }";
		}
	}
	else {
		$stmt = $db->prepare('SELECT Image from MarkerIcons WHERE IconName=?');
		$stmt->bind_param('s', $in[0]);
		$res = $stmt->execute();
		$stmt->bind_result($timage);
		if ($stmt->fetch()) {
      		header('Content-Type: image/png');
			echo $timage;
		}
		else {
			header('Location: ../images/blank.png');
			exit;
		}
	}
}

$stmt->close();
$db->close();


exit;
?>
