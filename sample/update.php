<?php

$key = $_POST['key'];
$name = $_POST['name'];
$mail = $_POST['mail'];
$age = $_POST['age'];
$br = '<br>';
$c = ',';

$filename = 'data/data.txt';
 
// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen($filename, 'r');
 
$count = 0;
$array = array();
// whileで行末までループ処理
while (!feof($fp)) {
 
  // fgetsでファイルを読み込み、変数に格納
  $txt = fgets($fp);
  $txt = trim($txt);
  if(!empty($txt)){
    $array[$count] = explode(",", $txt);
    $count++;

  }
}
fclose($fp);

$date = date("Y-m-d H:i:s");
$array[$key] = [$date, $name, $mail, $age];

$str = '';
foreach($array as $line){
  $str .=implode(",", $line);
  $str .= "\n";
}

//File書き込み
$file = fopen("data/data.txt","w");	// ファイル読み込み
fwrite($file, $str);
fclose($file);


// $json = json_encode($array);



echo '更新完了';

?>