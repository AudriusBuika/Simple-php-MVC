<?php

$classesDir = [
		__DIR__ .'/Controllers/',
		__DIR__ .'/Models/',
		__DIR__ .'/class/',

	];
$classEnds = [
		'.php',
	];
spl_autoload_register(function($ClassName) {
	global $classesDir, $classEnds;
		foreach ($classesDir as $directory) {
			foreach ($classEnds as $ends) {
				if(file_exists($directory .''. $ClassName .''. $ends)) {
					require $directory .''. $ClassName .''. $ends;
					//echo $directory .''. $ClassName .''. $ends .'<br/>';
				}
			}
		}
});