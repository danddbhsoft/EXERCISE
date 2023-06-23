//Kiểm tra xác thực các thẻ input thông tin từ form đăng ký như email không được trùng, mật khẩu phải dài tối thiểu 8 ký tự,...
$("#registerForm").submit(function(event) {
    event.preventDefault();
    let email = $("#email").val();
    let password = $("#password").val();
    let fullname = $("#fullname").val();
    let address = $("#address").val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var flag = 0;
    if(email!="" && filter.test(email)){
        let form_datas = new FormData();
        form_datas.append('email', email);
        $.ajax({
            async: false,
            url: 'index.php?controller=user&action=checkMail',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_datas,
            type: 'post',
            success: function(res){
                if(res == 1){
                    flag++;
                }else{
                    isInvalid('email');
                    $('#emailError').text("Email đã tồn tại trong hệ thống rồi");
                }
            }
        });
    }else{
        isInvalid('email');
        $('#emailError').text("Định dạng email không hợp lệ và không được để trống!");
    }
    if(password != "" && password.length >= 8 && fullname != "" && address != ""){
        flag++;
    }
    else{
        if(password.length < 8){
            isInvalid("password");
        }
    }
    if(flag==2){
        $("#registerForm").off("submit").submit();
    }
})