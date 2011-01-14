<?php

$config = include 'config.php';

header('Content-Type: text/javascript');

require dirname(__FILE__) . '/Packager/packager.php';

$pkg = new Packager($config['sources']);

$components = $_GET['require'];
$files = (empty($components)) ? $pkg->get_all_files() : $pkg->components_to_files(explode(',',$components));

$files = $pkg->complete_files($files);

$exclude_blocks = isset($config['exclude-blocks']) ? $config['exclude-blocks'] : array();
if (isset($_GET['12compat'])) foreach ($exclude_blocks as $i => $block){
	if ($block == '1.2compat') unset($exclude_blocks[$i]);
}

$output = $pkg->build($files, array(), array(), $exclude_blocks);

echo PHP_EOL . '// Required Files'.PHP_EOL;
foreach ($files as $file){
	echo "// - $file: [" . implode(", ", $pkg->get_file_provides($file)) . "]\n";
}
echo PHP_EOL;


echo $output;
