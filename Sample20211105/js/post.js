'use strict'
/**
 * データをPOST送信する
 * @param String アクション（送信先URL）
 * @param Object POSTデータ連想配列用オブジェクト
 */
function execPost(action, dataObject) {
    // HTMLフォームオブジェクトの生成
    var form = document.createElement("form");
    form.setAttribute("action", action);    // 送信先指定
    form.setAttribute("method", "post");    // メソッド指定
    form.style.display = "none";
    document.body.appendChild(form);    // HTMLドキュメントへ追加
    // 第2パラメタがあれば、設定
    if (dataObject !== undefined) {
        // オブジェクトの中につまった連想配列をすべてinput hidden パラメータとして設定
        for (var paramName in dataObject) {
            var input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', paramName);
            input.setAttribute('value', dataObject[paramName]);
            form.appendChild(input);    // FORMへインプットパラメータとして追加
        }
    }
    // submit送信する
    form.submit();
}