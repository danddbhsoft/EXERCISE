//Gọi API đăng nhập vào Google ủy quyền OAUTH2
function loginGoogle() {
    var a = {
        client_id: "945161652386-ptbvf9j28sp24s3hpmvbpl3fcpmh9crc.apps.googleusercontent.com",
        redirect_uri: "http://localhost:80/OAUTH/index.php?controller=user&action=loginWithGoogle",
        scope: "email profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile",
        access_type: "online",
        state: JSON.stringify({
            redirect_url: window.location.href
        }),
        response_type: "code"
    }
      , b = "https://accounts.google.com/o/oauth2/v2/auth" + encodeURIParams(a, !0);
    window.location.href = b
}

function encodeURIParams(a, b) {
    var c = [];
    for (var d in a)
        if (a.hasOwnProperty(d)) {
            var e = a[d];
            null != e && c.push(encodeURIComponent(d) + "=" + encodeURIComponent(e))
        }
    return 0 == c.length ? "" : (b ? "?" : "") + c.join("&")
}