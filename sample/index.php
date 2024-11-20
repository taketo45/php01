<?php

// ファイルを変数に格納
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
 
// fcloseでファイルを閉じる
fclose($fp);

// var_dump($array);
$json = json_encode($array);
// echo $json;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
<form>
	お名前: <input type="text" name="name" id="inputname">
	EMAIL: <input type="text" name="mail" id="inputmail">
	<select name="age" id="inputage">
		<option value="10">10代</option>
		<option value="20">20代</option>
		<option value="30">30代</option>
		<option value="40">40代</option>
		<option value="50">50代</option>
	</select>
	<input id="insertbutton" type="submit" value="追加">
</form>
<table>
	<tbody id="serchresult">
		<tr>
			<td>日時</td>
			<td>名前</td>
			<td>メール</td>
			<td>年齢</td>
      <td></td>
      <td></td>
		</tr>
	</tbody>
</table>

<div id="result"></div>

  <script>

      window.onload = function() {
        const objData = JSON.parse('<?= $json ?>');
        console.log(objData);
        for(let row in objData){
          let tr = $('<tr>');
          for(let col in objData[row]){
            let td = $('<td>');
            if(col == 0){
              td.text(objData[row][col]);
              tr.append(td);
            }
            if(col == 1 || col == 2){
              td.html(`<input type="text" id="serchresult${row}${col}" value="${objData[row][col]}">`);
              tr.append(td);
            }
            if(col == 3){
              $options=[];
              for(let i = 10; i <= 50; i+=10){
                $options.push(`<option value="${i}" ${objData[row][col] == i ? 'selected':''}>${i}代</option>`);
              }
              td.html(`
              <select id="serchresult${row}${col}">
                ${$options[0]}
                ${$options[1]}
                ${$options[2]}
                ${$options[3]}
                ${$options[4]}
              </select>
              <button key="${row}" class="updatebutton">更新</button>
              <button onclick="deleteRecord(${row})">削除</button>
              `);
              tr.append(td);
            }

            $('#serchresult').append(tr);
          }
        }

        $('#insertbutton').on('click', function(){
          let name = $('#inputname').val();
          let mail = $('#inputmail').val();
          let age = $('#inputage').val();
          console.log(name, mail, age);
          insert(name, mail, age);
        });

        $('.updatebutton' ).on('click', function(){
          let key = $(this).attr('key');
          let name = $('#serchresult' + key + '1').val();
          let mail = $('#serchresult' + key + '2').val();
          let age = $('#serchresult' + key + '3').val();
          console.log(key, name, mail, age);
          update(key, name, mail, age);
        });

        xhr = new XMLHttpRequest();

        // サーバからのデータ受信を行った際の動作
        xhr.onload = function (e) {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              $('#result').text(xhr.responseText);
              //:TODO: ここで画面を再読み込み
              window.location.href = 'index.php';
            } else {
              console.error(xhr.statusText);
              $('#result').text(xhr.statusText);
            }
          }
        };
      };

      function deleteRecord(key) {
        xhr.open('POST', 'delete.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        // フォームに入力した値をリクエストとして設定
        let request = "key=" + key;
        console.log(request);
        try {
          xhr.send(request);

        } catch (error) {
          console.log(error);
        }
      }


      function update(key, name, mail, age) {
        xhr.open('POST', 'update.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        // フォームに入力した値をリクエストとして設定
        let request = "key=" + key + "&name=" + name + "&mail=" + mail + "&age=" + age;
        console.log(request);
        try {
          xhr.send(request);

        } catch (error) {
          console.log(error);
        }
      }

      function insert(name, mail, age) {
        xhr.open('POST', 'insert.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        // フォームに入力した値をリクエストとして設定
        let request = "name=" + name + "&mail=" + mail + "&age=" + age;
        console.log(request);
        try {
          xhr.send(request);

        } catch (error) {
          console.log(error);
        }
      }


  </script>
</body>
</html>
