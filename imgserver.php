<?php

$basePath = "/var/www/html/imgserver";

$fetchList = file_get_contents("$basePath/priv/fetchList");
$imgList = explode("\n", $fetchList);
$imgCount = count($imgList)-1;

if (!$_GET['cmd']) {
	http_response_code(400);
	die();
}

$c = $_GET['cmd'];

if ($c == 'cnt') {
	echo $imgCount;
	die();
} else if ($c == 'descs') {
	echo "[";

	for ($i = 0; $i < $imgCount; $i++) {
		$imgLine = explode(":", $imgList[$i], 2);
		echo "\"" . $imgLine[0] . "\"";
		if ($i < $imgCount-1) echo ",";
	}

	echo "]";
	die();
} else if ($c == 'img') {
	$imgNum = $_GET['num'];

	if (!is_numeric($imgNum) || $imgNum < 0 || $imgNum >= $imgCount) {
		http_response_code(400);
		die();
	}

	if (!$_GET['res']) {
		$res = 'HD';
	} else {
		$res = $_GET['res'];
	}

	switch ($res) {
		case 'SD':
			$destWidth = 640;
			$destHeight = 480;
			break;
		case 'FHD':
			$destWidth = 1920;
			$destHeight = 1080;
			break;
		default:
			$destWidth = 1280;
			$destHeight = 720;
			break;
	}

	$imgLine = explode(":", $imgList[$imgNum], 2);
	$url = $imgLine[1];
	shell_exec("$basePath/priv/do-fetch $url $destWidth $destHeight");
	$img = file_get_contents("$basePath/img.png");

	if (!$img) {
		http_response_code(500);
		die();
	} else {
		if (!$_GET['nodl']) header("Content-Disposition: attachment; filename=\"img.png\"");
		header("Content-Type: image/png");
		echo $img;
	}
}

http_response_code(400);
die();

?>
