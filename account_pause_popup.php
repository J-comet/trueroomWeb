<html>
<head>
    <title>popup</title>
<script>
<!--
function change(form) {
    if (form.url.selectedIndex !=0)
        parent.location = form.url.options[form.url.selectedIndex].value
    }

function setCookie( name, value, expiredays ){
    var todayDate = new Date();
        todayDate.setDate( todayDate.getDate() + expiredays );
        document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function getCookie( name ){
    var nameOfCookie = name + "=";
    var x = 0;
        while ( x <= document.cookie.length ) {
            var y = (x+nameOfCookie.length);
                if ( document.cookie.substring( x, y ) == nameOfCookie ) {
                if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                    endOfCookie = document.cookie.length;
                return unescape( document.cookie.substring( y, endOfCookie ) );
            }
        x = document.cookie.indexOf( " ", x ) + 1;
        if ( x == 0 )
        break;
    }
    return "";
}


    if ( getCookie( "Notice" ) != "done" ) {
    noticeWindow  =  window.open('notice.html','경고','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=250');
    noticeWindow.opener = self;
}
// -->
</script>
</head>
<BODY>
팝업창이 실행됐는지 확인하세요...
</BODY>
</HTML>
