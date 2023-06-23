$(document).ready(function () {
    //Hàm thu thập dữ liệu từ form và xác thực email và các trường khác và dùng OAUTH hoặc Basic Auth để ủy quyền Ajax gọi API từ PHP
    //Bắt sự kiện khi các insert, update form được submit.
    $("#insertForm, #updateForm").submit(function (event) {
        event.preventDefault();
        let form_datas = new FormData();
        var formId = event.target.id;
            var function_ = '', error = '';
        if (formId === "insertForm") {
            function_ = 'insert';
        } else if (formId === "updateForm") {
            function_ = 'update';
            error = '-';
            form_datas.append('id', $("#"+function_+"_id").val());
        }

        let fullname = $("#"+function_+"_fullname").val();
        let email = $("#"+function_+"_email").val();
        let address = $("#"+function_+"_address").val();
        let gender = $("input[name="+function_+"_gender]:checked").val();
        var filter_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var filter_string = /^[a-zA-Z\s]+$/;
        let check = 0;
        form_datas.append('fullname', fullname);
        form_datas.append('email', email);
        form_datas.append('address', address);
        form_datas.append('gender', gender);

        var token = getToken();
        
        if (email != "" && filter_email.test(email) && old_email != email) {
            $.ajax({
                async: false,
                url: 'index.php?controller=client&action=checkMail',
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
                    if (res == 1) {
                        check++;
                    } else {
                        isInvalid(function_+"_email");
                        $("#email"+error+"Error").text("Email đã tồn tại trong hệ thống rồi");
                        changeInput(function_+"_email");
                    }
                    if (filter_string.test(fullname)) check++;
                    else {
                        isInvalid(function_+"_fullname");
                        $('#fullname'+error+'Error').text("Họ và tên không được trống và chỉ được chứa ký tự chữ cái!");
                        changeInput(function_+"_fullname");
                    }
                    if (address != "" && gender != "" && gender == 'female' || gender == 'male') {
                        check++;
                    }
                    if (check == 3) {
                        handleClient(function_, token, form_datas, insertUpdate);
                        table.ajax.reload();
                    }
                }
            });
        } else if(old_email == email){
            if (filter_string.test(fullname)) check++;
            else {
                isInvalid(function_+"_fullname");
                $('#fullname'+error+'Error').text("Họ và tên không được trống và chỉ được chứa ký tự chữ cái!");
                changeInput(function_+"_fullname");
            }
            if (address != "" && gender != "" && gender == 'female' || gender == 'male') {
                check++;
            }
            if (check == 2) {
                handleClient(function_, token, form_datas, insertUpdate);
                table.ajax.reload();
            }
        } else {
            isInvalid(function_+"_email");
            $('#email'+error+'Error').text("Email không được để trống và phải để đúng định dạng!");
            changeInput(function_+"_email");
        }
    })

    //Hiển thị thông báo thêm hoặc cập nhật dữ liệu thành công và cập nhật bảng dữ liệu.
    function insertUpdate(res, method){
        if (res) {
            if(method == 'insert')   toastShow("Thêm thành công!", 'Thêm khách hàng vào hệ thống thành công!');
            else    toastShow("Sửa thành công!", 'Sửa thông tin cho khách hàng thành công!');
            var currentPage = table.page.info().page;
            table.ajax.reload(function(){
                table.page(currentPage).draw(false);
            }, false);
            $(".close"+method.charAt(0).toUpperCase()+method.slice(1)+"Client").click();
        } else {
            if(method == 'insert')   toastShow("Thêm không thành công!", 'Thêm khách hàng vào hệ thống không thành công!');
            else    toastShow("Sửa không thành công!", 'Sửa thông tin cho khách hàng không thành công!');
        }
    }

    //Reset form khi đóng insert form.
    $(".closeInsertClient").click(function () {
        $('#insertForm')[0].reset();
        $('#insertForm').removeClass('was-validated');
        $('#insert_email').removeClass('is-invalid').css('border-color', "#dee2e6");
        $('#insert_fullname').removeClass('is-invalid').css('border-color', "#dee2e6");
    })

    //Reset form khi đóng update form.
    $(".closeUpdateClient").click(function () {
        $('#updateForm')[0].reset();
        $('#updateForm').removeClass('was-validated');
        $('#update_email').removeClass('is-invalid').css('border-color', "#dee2e6");
        $('#update_fullname').removeClass('is-invalid').css('border-color', "#dee2e6");
    })

    //Xử lý sự kiện khi nhấn vào button cập nhật ở dòng dữ liệu trên datatable
    $('#myTable').on('click', '.btn-update', function() {
        var row = $(this).closest('tr');
        var rowData = table.row(row).data();
        var arr = {0: 'id', 1:'fullname', 2:'email', 3:'address', 4:'gender'}
        var ind = 0;
        $('#updateForm input').each(function() {
            if(arr[ind] != 'gender'){
                $(this).val(rowData[arr[ind]]);
                ind++;
            }
        })
        if(rowData['gender'] == 1){
            $("#update_male").prop("checked", true);
        }else{
            $("#update_female").prop("checked", true);
        }
        old_email = rowData['email'];
    })
})

//Xác thực hành động xóa khách hàng và dùng ajax xử lý nó
function confirmDelete(event) {
    if (confirm("Bạn có chắc chắn muốn xóa câu hỏi này?")) {
        var id = event.target.closest('button').value;
        let form_datas = new FormData();
        form_datas.append('id', id);
        var token = getToken();
        handleClient('delete', token, form_datas, delete_);
    } else {

    }
}

function delete_(res, method){
    if (res) {
        toastShow("Xóa thành công!", 'Xóa khách hàng khỏi hệ thống thành công!');
        var currentPage = table.page.info().page;
        table.ajax.reload(function(){
            table.page(currentPage).draw(false);
        }, false);
    } else {
        toastShow("Xóa không thành công!", 'Xóa khách hàng khỏi hệ thống không thành công!');
    }
}

//End xóa khách hàng