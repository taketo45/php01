<?php

require_once 'config.php';
 
$fp = fopen(DATA_FILE, 'r');

$count = 0;
$array = [];
// whileで行末までループ処理
while (($txt = fgetcsv($fp)) !== FALSE) {
  $cleanedRow = array_map('cleanData', $txt);
  $array[] = $cleanedRow;
 
}

 
// fcloseでファイルを閉じる
fclose($fp);

// echo('<pre>');
// var_dump($array);
// echo('</pre>');


$json = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
// echo $json;


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


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- reset.css destyle -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" href="css/materialize.css">

</head>
<body>

<nav>
  <div class="header nav-wrapper blue accent-2">
    <!-- <div id="header-logo-container">
      <img id="header-logo" src="img/habatanlogo.png" alt="はば単のロゴ">
    </div> -->
    <a href="#!" class="brand-logo">英単語ドリル</a>
    <ul class="right hide-on-med-and-down">
      <li><a href="sass.html"><i class="material-icons left">search</i>単語を検索</a></li>
      <li><a class="waves-effect waves-light btn modal-trigger blue accent-2" href="#modal1">新規登録</a></li>
      <li><a href="badges.html"><i class="material-icons right">view_module</i>メニュー</a></li>
    </ul>
  </div>
</nav>

<!-- <div class="parallax-container">
  <div class="parallax"><img src="img/DSC_2375.jpg"></div>
</div> -->



  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>単語 新規登録</h4>
      <p>
      <form>
        No: <input class="input-field col s6" type="text" id="input-no" disabled>
        英単語: <input class="input-field col s6" type="text" name="englishword" id="englishword">
        <div class="input-field col s12">
        <select name="age" id="wordclass" multiple="multiple" >
          <option value="名">名詞</option>
          <option value="動">動詞</option>
          <option value="形">形容詞</option>
          <option value="副">副詞</option>
          <option value="前">前置詞</option>
          <option value="接">接続詞</option>
        </select>
        <label>品詞: </label>
        </div>

        日本語: <input class="input-field col s6" type="text" name="japaneseword" id="japaneseword">
        用例: <textarea class="materialize-textarea" type="text" name="wordexample" id="wordexample"></textarea>
        <p>
          <label>
            <input type="checkbox" id="iknow"/>
            <span>知ってる</span>
          </label>
        </p>
        </form>
      </p>
    </div>
    <div class="modal-footer">
      <a id="insertbutton" class="waves-effect waves-light btn-small blue accent-2"><i class="material-icons right">add_box</i>単語帳へ追加</a>
    </div>
  </div>


<div class="parallax-container">
  <div class="parallax"><img src="img/milkyway.jpg"></div>
</div>

<!-- //TODO: Collapsibles https://materializecss.com/badges.html -->

<table  class="responsive-table">
  <thead>
    <tr>
      <th class="t-no">No</th>
      <th class="t-eword">英語</th>
      <th class="t-wc">品詞</th>
      <th id="th-jw">日本語</th>
      <th id="th-we">用例</th>
      <th id="th-kw">既知</th>
      <th id="th-func">操作</th>
      <th></th>
    </tr>
  </thead>

	<tbody id="serchresult">
	</tbody>
</table>

<div id="result"></div>

<footer class="page-footer  blue accent-2">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">本英単語集の特長</h5>
                <p class="grey-text text-lighten-4">・中学校の英語教科書で使用されている英単語の中から1700語を収録</p>
                <p class="grey-text text-lighten-4">・見出し語を使った連語や慣用句、用例を提示</p>
                <p class="grey-text text-lighten-4">・兵庫県や自分が住んでいる地域の魅力を英語で発信できる例文付き</p>

              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="https://www2.hyogo-c.ed.jp/hpe/gimu/english/habatan">「兵庫県中学生のための英単語集」～はばたけ世界へ！『はば単』
                  </a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2024 Copyright Transform Navi
            <a class="grey-text text-lighten-4 right" href="#!">Links</a>
            </div>
          </div>
        </footer>

  <script>
      window.onload = function() {

        const wordData = <?php echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
        
        const objData = JSON.parse(wordData);
        console.log("objData" + objData);
        console.log("objData.length: " + objData.length);
        const lastnum = objData.length;
        // console.log("firstindex: " + firstindex);
        // let lastnum = objData[firstindex];
        // console.log('lastnum: ' + lastnum);

        for(let row in objData){
          let tr = $('<tr>');
          for(let col in objData[row]){
            let td = $('<td>');
            if(col == 0){
              td.attr('class', 't-no');
              td.html(`<div id="t-no${row}">${objData[row][col]}</div>`);
              tr.append(td);
              // lastnum = objData[row][col];
            }
            if(col == 1 ){
              td.attr('class', 't-eword');
              td.html(`<div id="t-eword${row}">${objData[row][col]}</div>`);
              tr.append(td);
            }
            if(col == 2){
              td.attr('class', 't-wc');
              td.html(`<input class="input-field col s6" type="text" id="t-wclass${row}" value="${objData[row][col]}">`);
              tr.append(td);
            }
            if(col == 3){
              td.html(`<input class="input-field col s6" type="text" id="t-japanesew${row}" value="${objData[row][col]}">`);
              tr.append(td);
            }
            if(col == 4){
              td.html(`<textarea class="materialize-textarea t-we" type="text" id="t-wexample${row}">${objData[row][col]}</textarea>
              `);
              tr.append(td);
              let tdcheck = $('<td>');
              if(Number(objData[row][col]) == 1){
                tdcheck.html(`
              <p class="td-func">
                <label>
                  <input id="t-iknow${row}" type="checkbox"  checked="checked"/>
                  <span></span>
                </label>
              </p>
                `);
              } else {
                tdcheck.html(`
              <p class="td-func">
                <label>
                  <input id="t-iknow${row}" type="checkbox" />
                  <span></span>
                </label>
              </p>
                `);
              }
              tr.append(tdcheck);
              let tdfunc = $('<td>');
              tdfunc.html(`
                <ul class="ul-func">
                  <li><a class="updatebutton btn-floating btn-small blue accent-2" key="${row}"><i class="material-icons" >mode_edit</i></a></li>
                  <li><a class="btn-floating btn-small blue accent-2"><i class="material-icons" onClick="deleteRecord(${row})">delete</i></a></li>
                </ul>
              `);
              tr.append(tdfunc);
            }

            $('#serchresult').append(tr);
          }
          $('#input-no').val(lastnum + 1);
        }

        

        $('#insertbutton').on('click', function(){
          let no = $('#input-no').show().val();
          console.log('no: ' + no);
          let eword = $('#englishword').val();
          let wordclass = $('#wordclass').val();
          let jword = $('#japaneseword').val();
          let wexample = $('#wordexample').val();
          let iknow = "";
          $('#iknow').prop('checked')? iknow = 1: iknow = "";
          // console.log(no, eword, wordclass, jword, wexample, iknow);
          joinedwc = wordclass.join('・');

          insert(no ,eword, joinedwc, jword, wexample, iknow);
        });

        $('.updatebutton' ).on('click', function(){
          let key = $(this).attr('key');
          let no = $('#t-no' + key).text();
          let englishword = $('#t-eword' + key).text();
          let wordclass = $('#t-wclass' + key).val();
          let jword = $('#t-japanesew' + key).val();
          let wexample = $('#t-wexample' + key).val();
          let iknow = $('#t-iknow' + key).prop('checked');
          console.log(key, no, englishword, wordclass, jword, wexample, iknow);
          update(key, no,  englishword, wordclass, jword, wexample, iknow);
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

      //	Materializeの初期化
      $(document).ready(function(){
        //  セレクトボックスの初期化
        $('select').formSelect();
        //  パララックスの初期化
        $('.parallax').parallax();
        //  モーダルの初期化
        $('.modal').modal();
        //  タブの初期化
        $('.tabs').tabs();
        //  サイドナビの初期化
        $('.sidenav').sidenav();
        //  フローティングアクションボタンの初期化
        $('.fixed-action-btn').floatingActionButton();

      });

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


      function update(key, no,  englishword,wordclass, jword, wexample, iknow) {
        xhr.open('POST', 'update.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        // フォームに入力した値をリクエストとして設定
        let request = "key=" + key + "&no=" + no + "&eword=" + englishword + "&wordclass=" + wordclass + "&jword=" + jword + "&wexample=" + wexample + "&iknow=" + iknow;
        console.log('update() request:  ' + request);
        try {
          xhr.send(request);

        } catch (error) {
          console.log(error);
        }
      }

      function insert(no, eword, wordclass, jword, wexample, iknow) {
        xhr.open('POST', 'insert.php', true);
        xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
        // フォームに入力した値をリクエストとして設定
        let request = "no" + no + "&eword=" + eword + "&wordclass=" + wordclass + "&jword=" + jword + "&wexample=" + wexample + "&iknow=" + iknow;
        // console.log(request);
        try {
          xhr.send(request);

        } catch (error) {
          console.log(error);
        }
      }


  </script>
</body>
</html>
