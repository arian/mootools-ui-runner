<?php

error_reporting(E_ALL);

$config = include 'config.php';

include_once 'libs/Request/Path.php';
include_once 'libs/Template.php';
include_once 'libs/markdown.php';

$rq = new Awf_Request_Path();

$file = $rq->toArray();
$suite = array_shift($file);

$suites = array_keys($config['tests']);
if (empty($suite) || !isset($config['tests'][$suite])) $suite = $suites[0];

$testsPath = $config['tests'][$suite];
$defaultFile = 'intro.html';

// Determine the right file
if (empty($file)){
	$file = $defaultFile;
} else {
	$file = implode('/', $file);
}

//$file = preg_replace('/[^a-zA-Z0-9\-\.\/]+/','',str_replace('../','',$file));
$filePath = $testsPath . '/' . $file . '.html';

if (!file_exists($filePath)){
	$file = $defaultFile;
	$filePath = 'templates/' . $file;
}

// Create template instance
$tpl = new Awf_Template();

$tpl->baseurl 		= $baseurl 		= $_SERVER['SCRIPT_NAME'];
$tpl->basepath 		= $basepath 	= str_replace('index.php', '', $baseurl);
$tpl->title 		= $file;
$tpl->suite			= $suite;
$tpl->appName 		= $config['app-name'];
$tpl->jasmine 		= $config['jasmine'];
$tpl->fireBugLight 	= $config['fireBugLight'];

// Get the content
$content = file_get_contents($filePath);

// Replace urls with the right ones
$content = explode('href="/', $content);
foreach ($content as &$part){
	if (substr($part, 0, 4) == 'asset') $baseurl . '/' . $part;
}
$content = implode('href="/', $content);

// Replace script src attribute
$content = str_replace('/Tests/', $basepath.$testsPath . '/', $content);
$content = str_replace('/depender/build', $basepath . 'build.php', $content);
$content = str_replace('/asset/more/', $basepath . $testsPath . '/_assets/', $content);
$content = preg_replace('/\/ajax_(html_echo)\//', $basepath . 'ajax.php', $content);
$content = preg_replace('/\/echo\/jsonp[\/]?/', $basepath . 'ajax.php?jsonp=1', $content);

$tpl->content = $content;


// Get the menu
$menu = array();
$tests = array(); // all tests
foreach ($config['tests'] as $suiteName => $path){
	$categories = array(); // tests by category
	$dir = new DirectoryIterator($path);
	foreach ($dir as $fileinfo){
		if (!$fileinfo->isDot() && $fileinfo->isDir() && $fileinfo->getFilename() != '_assets'){
	    	$category = array();
			$catName = $fileinfo->getFilename();
	    	$dir2 = new DirectoryIterator($path . '/' . $fileinfo->getFilename());
			foreach ($dir2 as $fileinfo2){
				if ($fileinfo2->isFile() && substr($fileinfo2->getFilename(), -5) == '.html'){
					$test = str_replace('.html', '', $fileinfo2->getFilename());
					$category[] = $test;
					if ($suite == $suiteName) $tests[] = $catName . '/' . $test;
				}
			}
			$categories[$catName] = $category;
		}
	}
	$menu[$suiteName] = $categories;
}
$tpl->menu = $menu;

// Get previous and next test
$testIndex = array_search($file, $tests);
$nextTest = $prevTest = false;
if ($testIndex !== false){
	if (isset($tests[$testIndex + 1])) $nextTest = $tests[$testIndex + 1];
	if (isset($tests[$testIndex - 1])) $prevTest = $tests[$testIndex - 1];
}

$tpl->nextTest = $nextTest;
$tpl->prevTest = $prevTest;


// Fire the page!!
$tpl->display('index.php');

