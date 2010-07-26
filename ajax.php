<?php

sleep(2);


if(!empty($_GET['html'])){
	echo $_GET['html'];
}elseif(!empty($_POST['html'])){
	echo $_POST['html'];
}else {
	echo 'html';
}
