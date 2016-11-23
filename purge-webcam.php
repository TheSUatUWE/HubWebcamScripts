<?php
// Purge old images

// Settings
$dir = "/home/hubradio/public_html/services.hubradio.co.uk/webcam/images/";
$keepfor = 60 * 60 * 24 * 60;
$pattern = 'Hub-FR([0-9]*)-Cam1_([0-9]*)(\.jpg)';

// Script go!
$newstamp = 0;
$newname = "";
$now = time();


function scan_dir($dir, $pattern, $keepfor) {
	if ($handle = opendir($dir)) {
	  while (false !== ($fname = readdir($handle)))  {
		// Eliminate current directory, parent directory
		if (ereg('^\.{1,2}$',$fname)) continue;
		// Eliminate other pages not in pattern
		if (! ereg($pattern,$fname)) continue;
		// If we need to recurse folders, so be it.
		if(is_dir($dir.$fname)) {
			scan_dir($dir.$fname."/");
		}
		// Check the file. If too old, time to unlink!
		if($now - filemtime($file) >= $keepfor) {
		  unlink($file);
		}
	  }
	}
	closedir ($handle);
}

scan_dir($dir, $pattern, $keepfor);
?>
