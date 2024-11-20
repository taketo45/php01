<?php
require_once 'config.php';

$key = $_POST['key'];
 
// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen(DATA_FILE, 'r');
 
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

array_splice($array, $key, 1);
var_dump($array);

// $array[$key] = [$date, $name, $mail, $age];

$str = '';
foreach($array as $line){
  $str .=implode(",", $line);
  $str .= "\n";
}

//File書き込み
$file = fopen(DATA_FILE,"w");	// ファイル読み込み
fwrite($file, $str);
fclose($file);


// $json = json_encode($array);



echo '削除完了';

?>