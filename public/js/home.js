//Hàm khởi tạo token_tmp
function generateToken(length) {
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var token = '';
    for (var i = 0; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * characters.length);
        token += characters.charAt(randomIndex);
    }
    return token;
}

//Hàm khởi tạo cookie
function createCookie(name, value, minutes) {
    var expires = "";
    if (minutes) {
        var date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

//Hàm lấy token ủy quyền từ cơ sở dữ liệu và cũng dùng token_tmp lưu trong cookie để xác thực hành động tạm thời.
function getToken() {
    var token = generateToken(32);
    var token_main;
    createCookie('token_tmp', token, 5);
    $.ajax({
        async: false,
        url: 'index.php?controller=client&action=getToken',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        type: 'post',
        success: function (res) {
            token_main = res;
        }
    })
    return token_main;
}

//Hàm ajax xử lý các hành động như Insert, Update, Delete
function handleClient(method, token, form_datas, callback) {
    var token = getToken();
    $.ajax({
        async: false,
        url: 'index.php?controller=client&action=' + method,
        headers: {
            'Authorization': 'Bearer ' + token
        },
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_datas,
        type: 'post',
        success: function (res) {
            callback(res, method);
        }
    })
}

//Hiển thị thông báo lên màn hình
function toastShow(title, body) {
    $('.toast .toast-header .toast-title').text(title);
    $('.toast .toast-body').text(body);
    $('.toast').toast({
        delay: 5000,
        autohide: true
    }).toast('show');
}