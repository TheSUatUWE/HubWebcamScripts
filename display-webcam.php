<?php
// Get latest camera images
//
// Assumptions
// * We are in the correct folder where the camera uploads images (e.g. ~/images/fr1)
// * The webcam is uploading images and separating them by day and then by hour in folders (e.g. /20161123/1200)

// Settings
$dir = "/home/hubradio/public_html/services.hubradio.co.uk/webcam/images/fr1/";
$pattern = 'Hub-FR([0-9]*)-Cam1_([0-9]*)(\.jpg)';

// Functions

function scan_dir_day($dir, $pattern) {
	$newstamp = 0;
	$newfolder = "";
	$newfile = "";
	
	if ($handle = opendir($dir)) {
	  while (false !== ($fname = readdir($handle)))  {
		// Eliminate current directory, parent directory
		if (ereg('^\.{1,2}$',$fname)) continue;
		
		if(is_dir($dir.$fname)) {
			$timedat = filemtime("$dir/$fname");
			if ($timedat > $newstamp) {
				$newstamp = $timedat;
				$newfolder = $fname;
			}
		}
	  }
	}
	closedir ($handle);
	
	// Check the folder for some hourly hours!
	if($newfolder) {
		$newfile = scan_dir_hour($dir.$newfolder."/", $pattern);
	}
		
	return $newfile;
}

function scan_dir_hour($dir, $pattern) {
	$newstamp = 0;
	$newfolder = "";
	$newfile = "";
	
	if ($handle = opendir($dir)) {
	  while (false !== ($fname = readdir($handle)))  {
		// Eliminate current directory, parent directory
		if (ereg('^\.{1,2}$',$fname)) continue;
		
		if(is_dir($dir.$fname)) {
			$timedat = filemtime("$dir/$fname");
			if ($timedat > $newstamp) {
				$newstamp = $timedat;
				$newfolder = $fname;
			}
		}
	  }
	}
	closedir ($handle);
	
	// Check the folder for some files
	if($newfolder) {
		$newfile = scan_file($dir.$newfolder."/", $pattern);
	}
		
	return $newfile;
}

function scan_file($dir, $pattern) {
	$newstamp = 0;
	$newfile = "";
	
	if ($handle = opendir($dir)) {
	  while (false !== ($fname = readdir($handle)))  {
		// Eliminate current directory, parent directory
		if (ereg('^\.{1,2}$',$fname)) continue;
		// Eliminate other pages not in pattern
		if (! ereg($pattern,$fname)) continue;
		
		$timedat = filemtime("$dir/$fname");
		if ($timedat > $newstamp) {
			$newstamp = $timedat;
			$newfile = $dir . "" . $fname;
		}
	  }
	}
	closedir ($handle);
	return $newfile;
}

function display_image($filename) {
	header('Content-type: image/jpeg');
	header('Content-length: '.filesize($filename));
	
	$file = @ fopen($filename, 'rb');
	if ($file) {
		fpassthru($file);
		exit;
	}
}

// Script go!

$newfile = scan_dir_day($dir, $pattern);
display_image($newfile);
?>
