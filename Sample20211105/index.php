<?php session_start(); // Sessionスタート ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ連動切替サンプル</title>
</head>

<body>
<!--リセットCSS(必ず最初のCSSとして読み込むこと)-->
<link href="./css/reset.css" rel="stylesheet" type="text/css" >
<!--共通CSS-->
<link href="./css/common.css" rel="stylesheet" type="text/css" >
<!--モーダルウィンドウ用CSS-->
<link rel="stylesheet" type="text/css" href="css/modal.css">
<!--CSS切替はJavaScript内でユーザーエージェント＆画面サイズで実施するため、ここはコメントアウト-->
<!-- ▼CSS スマホ -->
<!--<link href="./css/smallStyle.css" rel="stylesheet" type="text/css" media="(max-width: 750px)" >-->
<!-- ▼CSS PC -->
<!--<link href="./css/pcStyle.css" rel="stylesheet" type="text/css" media="(min-width: 751px)" >-->

<h1><?php echo 'サンプルです'; ?></h1>
<details>
    <summary>▶説明</summary>
    <div id="description">
        <P>ハートマークをクリックするとお気に入りのon/offができます。CSSによる一枚画像の表示領域切替で実装しています。</P>
        <p>商品画像をクリックすると拡大表示のモーダルウィンドウを表示します。別ファイルではなく、同一HTMLファイル中のdiv要素の重ね表示で実現しています</p>
        <p>JavaSciptで動的に画像にonclickイベントやCSS適用を追加しています</p>
        <p>JavaScriptでHTMLドキュメント内にFORM要素を追加し、POST送信を実装しています</p>
        <P>INSERTやDELETのPOST送信の宛先アクションのURLは自分自身「.」になっています</P>
        <p>CSSはJavaScriptによるユーザーエージェント判定でPC/スマホの2通り、さらにPCでもCSSメディアクエリによる画面サイズ取得で2通りの合計3通りのレイアウトが切り替わります</p>
    </div>
</details>
<?php
//session_start(); // ダミーのSessionスタート。本当はセッション判定をする。
$_SESSION['user_id'] = 123456; // ダミーのユーザーID。本当はユーザー入力
$user_id = $_SESSION['user_id'];
// DB接続文字列
$dsn = 'mysql:dbname=ダミーDB名;host=ダミーホスト名';
$user = 'ダミーDBユーザーID';
$password = 'ダミーDBユーザーパスワード';

//ポスト送信パラメーターチェック
$p_action=null; $p_method=null; $p_item_id=null; $p_user_id=null;
print("<div class='checkMsg'>POSTパラメータ：");
//if(isset($_POST['action'])){ if($_POST['action']!=""){ $p_action = $_POST['action']; print($p_action);} }
if(isset($_POST['method'])){ if($_POST['method']!=""){ $p_method = $_POST['method']; print("ポストメソッド： ".$p_method);} }
if(isset($_POST['item_id'])){ if($_POST['item_id']!=""){ $p_item_id = $_POST['item_id']; print("アイテムID： ".$p_item_id); } }
if(isset($_POST['user_id'])){ if($_POST['user_id']!=""){ $p_user_id = $_POST['user_id']; print("ユーザーID： ".$p_user_id); } }
print("</div>");
// DB接続
try{
    $pdo = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

//DB処理切替
try{
    if($p_method!=null){
        if( $p_method=='INSERT' ){
            print("<div class='checkMsg'>insertです");
            // SQL確認
            print("insert into fav (item_id, user_id) VALUES ( {$p_item_id} , {$p_user_id} );");
            print("</div>");
            //
            $stmt = $pdo->prepare("insert into fav (item_id, user_id) VALUES ( ? , ? );");
            //bindValueメソッドでパラメータをセット
            $stmt->bindValue(1,$p_item_id);
            $stmt->bindValue(2,$p_user_id);
            $stmt->execute();
        }else if( $p_method=='DELETE' ){
            print("<div  class='checkMsg'>deleteです");
            // SQL確認用
            print("delete from fav where item_id={$p_item_id} and user_id={$p_user_id} ;");
            print("</div>");
            // $data　からidに該当するカラムのみを取り出す
            $stmt = $pdo->prepare("delete from fav where item_id=? and user_id=? ;");
            //bindValueメソッドでパラメータをセット
            $stmt->bindValue(1,$p_item_id);
            $stmt->bindValue(2,$p_user_id);
            $rt = $stmt->execute();
        }
    }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

// 追加削除後、ユーザーのお気に入りリストを取得
$stmt = $pdo->prepare("select * from fav where user_id = ?");
//bindValueメソッドでパラメータをセット
$stmt->bindValue(1,$user_id);
$stmt->execute();
$data = $stmt->fetchAll(); // 検索全結果を取得
// お気に入りのアイテムidを抽出して配列（お気に入りリスト）を作る
$fav_items = array_column($data, 'item_id');

// 商品一覧を取得
$res = $pdo->query("select * from items");

// 全商品をループして表示
print("<div class='contents'>");
foreach ($res as $row) {
    print("<div class='item'>");
    $item_id = $row['id'];  // 商品ID
    print("商品番号{$item_id}<br>");
    print("{$row['name']}<br>");    // 商品名
    print("{$row['description']}<br>"); // 商品説明
    $price = number_format($row['price'])."円";  // 商品の価格(3桁カンマ区切りフォーマット)
    print("{$price}<br>");
    // 該当商品がお気に入りかどうかでハートの表示を切り替え、クリック時のJavaScriptPOST送信メソッドをパラメーターを変えて呼出し
    $mothod_flg=""; // お気に入り追加か削除にするかのフラグ
    if( in_array( $row['id'], $fav_items ) ){   // 取得したお気に入りリストの中に該当のアイテムIDが含まれるか判定
        print("<div class='small_heart_on' "); // 含まれていたらお気に入り状態
        $mothod_flg='DELETE'; // お気に入り状態から解除
        // ハートをクリックしたらポスト送信をする自作JavaScriptメソッドを呼び出すようにonClickプロパティを設定する
        // パラメーターはお気に入りフラグ（DELETE）、無名オブジェクト（アイテムID、ユーザーIDが入っている）
        print("onclick="."\"execPost( '.', {'method':'{$mothod_flg}', 'item_id':{$row['id']}, 'user_id':{$user_id}});return false;\">");
        print("</div><br>");
    }else{
        print("<div class='small_heart_off' "); // お気に入り状態でない
        $mothod_flg='INSERT'; // お気に入り状態へ追加
        // ハートをクリックしたらポスト送信をする自作JavaScriptメソッドを呼び出すようにonClickプロパティを設定する
        // パラメーターはお気に入りフラグ（INSERT）、無名オブジェクト（アイテムID、ユーザーIDが入っている）
        print("onclick="."\"execPost( '.', {'method':'{$mothod_flg}', 'item_id':{$row['id']}, 'user_id':{$user_id}});return false;\">");
        print("</div><br>");
    }
    // 該当商品の写真を表示（DBからファイル名を取り出して表示する）
    print("<img src='img/${row['filepath']}' class='items_img open' width='80px' height='100px' alt='' ");
    $fileFullpath = "./img/{$row['filepath']}";
    print("onclick=\"setModalItem('$fileFullpath', '$item_id', '$user_id', '$mothod_flg'); \"");
    print(">");
    print("</div>");
}
print("</div>");
?>
<!--<div class="open" id="open"> 詳細をみる </div>-->
<div id="mask" class="hidden"></div>
<div id="parent">
    <div id="modal" class="hidden"  style="text-align: center">
<?php
    print("<div id='modal_heart' class='modal_heart_on'></div>");
//    print("<img src='' id='modal_heart' class='modal_heart_on' />");
?>
<!--        <a onclick="execPost('.', {'fuga':'fuga_val', 'piyo':'piyo_val'});return false;" href="#">POST送信</a>-->
    <p>モータルウィンドウのテストです。<br>閉じるのボタンをおしたらウィンドが閉じます</p>
        <p>モータルウィンドウのテストです。<br>閉じるのボタンをおしたらウィンドが閉じます</p>
        <p>モータルウィンドウのテストです。<br>閉じるのボタンをおしたらウィンドが閉じます</p>
        <img src="" id="img_detail" width="400" height="400"/>
        <div id="close">
            閉じる
        </div>
    </div>
</div>
<script type="text/javascript" src="./js/userAgent.js"></script>
<script type="text/javascript" src="./js/modal.js"></script>
<script type="text/javascript" src="./js/post.js"></script>
<!--以下は直接JavaScript処理をファイル内に書く場合　※コメントアウト中-->
<!--    <script type="text/javascript">alert("hello??");</script>-->
</body>
</html>