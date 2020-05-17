<?php

if (isset($_POST["buildFlux"])) {
	// Get data
	$buildName = $_POST["buildName"];
	$buildGate = $_POST["buildGate"];
	// Read
	$file = file_get_contents("builds/main.build");
	// Replace
	$file = str_replace("{buildGate}", $buildGate, $file);
	$file = str_replace("{buildName}", $buildName, $file);

	// Check for ..
	if (strpos($buildName, '.') !== false) {
		die("Permission denied >> .");
	}
	// If name is main.build
	if ($buildName == 'main.build') {
		die("Permission denied!");
	} 
	// Write
	if (file_put_contents("builds/$buildName.js", $file)) {
		die("Build created!");
	} else {
		die("Failed to create build");
	}
}

?>