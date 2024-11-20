<?php
require_once 'config.php';

$no = $_POST["no"];
$eword = $_POST["eword"];
$wordclass = $_POST["wordclass"];
$jword = $_POST["jword"];
$wexample = $_POST["wexample"];
$iknow = $_POST["iknow"];

$c = ",";


//文字作成
// $str = date("Y-m-d H:i:s");
$str = $no.$c.$eword.$c.$wordclass.$c.$jword.$c.$wexample.$c.$iknow;
//File書き込み


$file = fopen(DATA_FILE,"a");	// ファイル読み込み
fwrite($file, $str."\n");
fclose($file);

echo '追加完了';
?>


