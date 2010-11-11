<?php

sleep(2);


if (!empty($_GET['html'])){
	echo $_GET['html'];
} elseif (!empty($_POST['html'])){
	echo $_POST['html'];
} elseif (!empty($_GET['jsonp'])){

	header('Content-Type: text/javascript');
	$callback = !empty($_GET['callback']) ? $_GET['callback'] : 'callback';
	echo $callback . '({"some": "jsonp", "data": "data"});';

} else {
	echo 'html';
}
