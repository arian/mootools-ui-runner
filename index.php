<?php

include_once 'libs/Request/Path.php';
include_once 'libs/Template.php';
include_once 'libs/markdown.php';

$rq = new Awf_Request_Path();

$docsPath = 'mootools-more/Tests';
$defaultFile = 'Class/Chain.Wait';

// Determine the right file
$file = $rq->toArray();
if(empty($file)){
	$file = $defaultFile;
}else{
	$file = (string) $rq;
}

//$file = preg_replace('/[^a-zA-Z0-9\-\.\/]+/','',str_replace('../','',$file));
$filePath = $docsPath.'/'.$file.'.html';

if(!file_exists($filePath)){
	$file = $defaultFile;
	$filePath = $docsPath.'/'.$file;
}


// Create template instance
$tpl = new Awf_Template();

$tpl->baseurl = $baseurl = $_SERVER['SCRIPT_NAME'];
$tpl->basepath = $basepath = str_replace('index.php','',$baseurl);
$tpl->title = $file;

// Get the content
$content = file_get_contents($filePath);

// Replace urls with the right ones
$content = str_replace('href="/','href="'.$baseurl.'/',$content);

// Replace script src attribute
$content = str_replace('/depender/build',$basepath.'build.php',$content);


$tpl->content = $content;


// Get the menu
$categories = array();
$dir = new DirectoryIterator($docsPath);
foreach ($dir as $fileinfo){
	if(!$fileinfo->isDot() && $fileinfo->isDir()){
    	$category = array();
    	$dir2 = new DirectoryIterator($docsPath.'/'.$fileinfo->getFilename());
		foreach($dir2 as $fileinfo2){
			if($fileinfo2->isFile() && strpos($fileinfo2->getFilename(),'.tmp') === false){
				$category[] = str_replace('.html','',$fileinfo2->getFilename());
			}
		}
		$categories[$fileinfo->getFilename()] = $category;
	}
}
$tpl->menu = $categories;


$tpl->display('index.php');

