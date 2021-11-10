// JavaScript Document
'use strict'
{
    const close = document.getElementById('close');
    const modal = document.getElementById('modal');
    const mask = document.getElementById('mask');

    const openArr = document.getElementsByClassName('open');
    for (let i=0; i<openArr.length; i++) {
        openArr[i].addEventListener('click',()=>{
            modal.classList.remove('hidden');
            mask.classList.remove('hidden');
            // open要素のループ回数確認用
            // alert(i);
        });
    }

    close.addEventListener('click',()=>{
        modal.classList.add('hidden');
        mask.classList.add('hidden');
    });

    mask.addEventListener('click',()=>{
        //modal.classList.add('hidden');
        //mask.classList.add('mask');
        close.click();
    });
}
function setModalItem(fileFullPath, item_id, user_id, mothod_flg) {
    // パラメータ表示確認用
    // alert("fileFullPath: "+fileFullPath+" item_id: "+item_id+" user_id: "+user_id+" mothod_flg: "+mothod_flg);
    // 画像DIV領域(modal_heart)の変数の取得
    let img_element = document.getElementById("img_detail");
    // 画像の再設定
    img_element.setAttribute("src", fileFullPath);
    let modal_heart = document.getElementById("modal_heart");
    // 画像領域(modal_heart)をクリックした時の処理を設定（イベントリスナーの追加）
    if( mothod_flg==="INSERT" ){    // お気に入り追加の場合
        modal_heart.classList.remove('modal_heart_on')
        modal_heart.classList.add('modal_heart_off')
        modal_heart.addEventListener('click',()=>{
            // alert('INSERT');
            execPost( '.', {'method':'INSERT', 'item_id':item_id, 'user_id':user_id});
        });
    }else{    // お気に入り削除の場合
        modal_heart.classList.remove('modal_heart_off')
        modal_heart.classList.add('modal_heart_on')
        modal_heart.addEventListener('click',()=>{
            // alert('DELETE');
            execPost( '.', {'method':'DELETE', 'item_id':item_id, 'user_id':user_id});
        });
    }
    // alert('完了');
}