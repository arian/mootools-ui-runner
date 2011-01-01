<?php

$config = include 'config.php';

header('Content-Type: text/javascript');

require dirname(__FILE__) . '/Packager/packager.php';

$pkg = new Packager($config['sources']);

$components = $_GET['require'];
$files = (empty($components)) ? $pkg->get_all_files() : $pkg->components_to_files(explode(',',$components));

$files = $pkg->complete_files($files);

$exclude_blocks = isset($config['sources']) ? $config['sources'] : array();
if (isset($_GET['1.2compat'])) $exclude_blocks = array_filter($exclude_blocks, function($value){
	return $value != '1.2compat';
});

$output = $pkg->build($files, array(), array(), $exclude_blocks);

echo PHP_EOL . '// Required Files'.PHP_EOL;
foreach ($files as $file){
	echo "// - $file: [" . implode(", ", $pkg->get_file_provides($file)) . "]\n";
}
echo PHP_EOL;


echo $output;
