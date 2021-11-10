// <script type="text/javascript">
'use strict'
// alert("hello");
if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
    // document.write('<link rel="stylesheet" type="text/css" href="./css/smallStyle.css">');
    document.write('<link rel="stylesheet" type="text/css" href="./css/smallStyle.css?ver=1.0.0.2">');
    // alert("small");
} else {
    document.write('<link rel="stylesheet" type="text/css" href="./css/pcStyle.css?ver=1.0.0.1">');
    // alert("pc");
}
