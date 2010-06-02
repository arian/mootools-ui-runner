<?php

header('Content-Type: text/javascript');

require dirname(__FILE__) . '/Packager/packager.php';

$pkg = new Packager(array('mootools-core','mootools-more'));

$components = $_GET['require'];
$files = (empty($components)) ? $pkg->get_all_files() : $pkg->components_to_files(explode(',',$components));

$files = $pkg->complete_files($files);

$compat = false;
if(isset($_GET['1.2compat'])) $compat = true;

$output = $pkg->build($files, array(), array(), ($compat) ? array() : array("1.2compat"));

echo PHP_EOL.'// Required Files'.PHP_EOL;
foreach ($files as $file){
	echo "// - $file: [" . implode(", ", $pkg->get_file_provides($file)) . "]\n";
}
echo PHP_EOL;


echo $output;
