<?php

$name = $_POST["name"];
$mail = $_POST["mail"];
$age = $_POST["age"];
$c = ",";


//文字作成
$str = date("Y-m-d H:i:s");
$str .= $c.$name.$c.$mail.$c.$age;
//File書き込み
$file = fopen("data/data.txt","a");	// ファイル読み込み
fwrite($file, $str."\n");
fclose($file);

echo '追加完了';
?>


