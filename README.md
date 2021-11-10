# web-php-js-css-20211109
php/js/cssのwebページテクニックのサンプルです
よく質問をもらうwebページのサンプルを作りました。

動作デモ：
http://aso-kuga.watson.jp/Sample20211105/

1. お気に入りか否かなど要素の状態でDBレコードへの追加や削除を切り分けます。
ブラウザのユーザーエージェントでスマホかPCを判定し、PCではさらにメディアクエリで画面サイズによるレイアウト切り替えを行います。
https://www.site-convert.com/archives/2188

1. DBからファイル名を取得しファイルパスを組み立てて商品画像を表示しています。
https://codeforfun.jp/save-images-php-and-mysql-3/

1. お気に入りアイコンなどオンオフの状態を持つものをCSSで切り替えています。
https://html-coding.co.jp/knowhow/tips/rollover/

1. 画像のクリックイベントで商品詳細のモーダルウィンドウを表示します。
今回はCSSのみで実装しましたが、JavaScriptなら「Micromodal.js」などライブラリが色々あります。
https://www.willstyle.co.jp/blog/3646/

1. JavaScriptでDIVタグ領域に好きなイベントや属性を追加します。
onClickを追加する: https://qiita.com/mzmz__02/items/873118fbd8723c44956d
クラス属性を追加削除する: https://techacademy.jp/magazine/27026

