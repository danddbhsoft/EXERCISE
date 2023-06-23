<?php
require("views/Templates/header.php");
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['LoginOK'])) {
    ?>

    <head>
        <title>Danh sách khách hàng</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            tfoot input {
                width: 100%;
                padding: 3px;
                box-sizing: border-box;
            }

            a {
                cursor: pointer;
            }
        </style>
    </head>
    <h3 class="text-center text-uppercase">Danh sách khách hàng trong hệ thống</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#insertClient">Thêm khách
                    hàng</button>
                <div class="table-responsive">
                    <table id="myTable" class="table table-centered w-100 dt-responsive nowrap display"
                        id="products-datatable mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Mã khách hàng</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Giới tính</th>
                                <th>Tạo bởi</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>not</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Insert -->
    <div class="modal fade" id="insertClient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content needs-validation" id="insertForm" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5 font-weight-bold" id="staticBackdropLabel">Thêm khách hàng</h1>
                    <button type="button" class="btn-close closeInsertClient" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="insert_fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="insert_fullname" name="insert_fullname"
                                    required>
                                <div id="fullnameError" class="invalid-feedback">
                                    Hãy điền họ và tên khách hàng!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="insert_email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="insert_email" name="insert_email" required>
                                <div id="emailError" class="invalid-feedback">
                                    Hãy điền email của khách hàng!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="insert_address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="insert_address" name="insert_address" required>
                                <div class="invalid-feedback">
                                    Hãy điền địa chỉ của khách hàng!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="insert_gender" class="form-label">Giới tính</label> <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="insert_gender" id="insert_male"
                                        value="male" required>
                                    <label class="form-check-label" for="insert_male">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="insert_gender" id="insert_female"
                                        value="female" required>
                                    <label class="form-check-label" for="insert_female">Nữ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeInsertClient" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Update -->
    <div class="modal fade" id="updateClient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content needs-validation" id="updateForm" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5 font-weight-bold" id="staticBackdropLabel">Cập nhật khách hàng</h1>
                    <button type="button" class="btn-close closeUpdateClient" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="text" id="update_id" name="update_id" hidden readonly required>
                            <div class="col-md-6 mt-2">
                                <label for="update_fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="update_fullname" name="update_fullname"
                                    required>
                                <div id="fullname-Error" class="invalid-feedback">
                                    Hãy điền họ và tên khách hàng cần cập nhật!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="update_email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="update_email" name="update_email" required>
                                <div id="email-Error" class="invalid-feedback">
                                    Hãy điền email của khách hàng cần cập nhật!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="update_address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="update_address" name="update_address" required>
                                <div class="invalid-feedback">
                                    Hãy điền địa chỉ của khách hàng cần cập nhật!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="update_gender" class="form-label">Giới tính</label> <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="update_gender" id="update_male"
                                        value="male" required>
                                    <label class="form-check-label" for="update_male">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="update_gender" id="update_female"
                                        value="female" required>
                                    <label class="form-check-label" for="update_female">Nữ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeUpdateClient" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#007aff"></rect>
                </svg>
                <strong class="me-auto toast-title">Hệ thống</strong>
                <small>Vừa xong</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
    <?php
    require("views/Templates/footer.php");
    ?>
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/r-2.4.1/rg-1.3.1/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/datatables.min.css"
        rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/date-1.4.1/fc-4.2.2/fh-3.3.2/r-2.4.1/rg-1.3.1/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/datatables.min.js"></script>
    <script src="public/js/isValidated.js"></script>
    <script src="public/js/home.js"></script>
    <script src="public/js/indexClient.js"></script>
    <script>
        var table;
        var old_email;
        $(document).ready(function () {
            var token = getToken();
            $('#myTable tfoot th').each(function () {
                if ($(this).html() !== "not")
                    $(this).html('<input type="text"/>');
                else {
                    $(this).html('');
                }
            });

            table = $('#myTable').DataTable({
                dom: 'Blfrtip',
                buttons: [

                ],
                select: true,
                lengthMenu: [10, 15, 25, 50, 75, 100],
                "ajax": {
                    "url": "index.php?controller=client&action=getClient",
                    "error": function (xhr, error, thrown) {
                        if (error == "parsererror") {
                            alert("Lấy dữ liệu thất bại do không thể xác thực!");
                        }
                    },
                    "headers": { 'Authorization': 'Bearer ' + token },
                },
                "columns": [{
                    "data": "id", "filter": true
                },
                {
                    "data": "fullname", "filter": true
                },
                {
                    "data": "email", "filter": true
                },
                {
                    "data": "address", "filter": true
                },
                {
                    "data": "gender", "filter": true,
                    "render": function (data, type, row) {
                        if (data == true) {
                            return '<span class="badge bg-success">Nam</span>';
                        } else {
                            return '<span class="badge bg-black">Nữ</span>';
                        }
                    }
                },
                {
                    "data": "CreatedBy", "filter": true
                },
                {
                    data: 'id', "filter": true,
                    targets: 6,
                    render: function (data, type, row, meta) {
                        return `<button style="border:0; width:24px; height:24px; position: relative;" data-bs-toggle="modal" data-bs-target="#updateClient" data-toggle="tooltip" title="Chỉnh sửa thông tin khách hàng" class="btn-update"><span class="material-icons bg-success text-white btn-tmp-update" style="position: absolute; left:0; top: 0">drive_file_rename_outline</span></button>
                                        <button value='${data}' style="border:0; width:24px; height:24px; position: relative;" onclick="confirmDelete(event)" data-toggle="tooltip" title="Xóa khách hàng" class="btn-delete"><span class="material-icons bg-danger text-white btn-tmp-delete" style="position: absolute; left:0; top: 0">delete_outline</span></button>`;
                    }
                },
                ],
                "language": {
                    "url": '//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json',
                    "zeroRecords": "Không có khách hàng nào trong hệ thống"
                },
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var that = this;
                            $('input', this.footer()).on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
            });
        });
    </script>
    <?php
} else {
    header("location: index.php");
}
?>