<?php
require_once 'config.php';

$key = $_POST['key'];
$no = $_POST['no'];
$eword = $_POST['eword'];
$wordclass = $_POST['wordclass'];
$jword = $_POST['jword'];
$wexample = $_POST['wexample'];
$iknow = $_POST['iknow'];
$c = ',';




// $filename = 'data/data.txt';
 
// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen(DATA_FILE, 'r');
 
$count = 0;
$array = [];

while (($txt = fgetcsv($fp)) !== FALSE) {
 
  $cleanedRow = array_map('cleanData', $txt);
  $array[] = $cleanedRow;
 
}
fclose($fp);

// $date = date("Y-m-d H:i:s");
$array[$key] = [$no, $eword, $wordclass, $jword, $wexample, $iknow? 1 : ""];

echo('<pre>');
var_dump($array);
echo('</pre>');

$str = '';
foreach($array as $line){
  $str .=implode(",", $line);
  $str .= "\n";
}

//File書き込み
$file = fopen(DATA_FILE,"w");	// ファイル読み書き
fwrite($file, $str);
fclose($file);

// $json = json_encode($array);

echo '更新完了';

function cleanData($str) {
  // 不要な制御文字を削除
  $str = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $str);
  // 改行を特定の文字列に置換
  $str = str_replace(["\r\n", "\n", "\r"], " ", $str);
  // 連続する空白を1つに
  $str = preg_replace('/\s+/', ' ', $str);
  return trim($str);
}

?>