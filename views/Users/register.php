<?php
require("views/Templates/header.php");
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <title>Đăng ký</title>
</head>
<h3 class="text-center text-uppercase">Đăng Ký Tài Khoản</h3>
<div class="row mb-2">
    <div class="col-sm-12">
        <?php
        if (isset($_GET['success'])) {
            echo '<p class="text-success text-center">' . $_GET['success'] . '</p>';
        } else if (isset($_GET['error'])) {
            echo '<p class="text-danger text-center">' . $_GET['error'] . '</p>';
        }
        ?>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-5 shadow-lg ms-auto me-auto rounded">
            <?php
            if(count($errorArr) > 0){
            ?>
            <div class="alert alert-danger mt-3">
                <ul>
                    <?php
                    foreach($errorArr as $item){
                        if($item != ''){
                    ?>
                    <li><?php echo $item ?></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php
            }
            ?>
            <form class="row g-3 p-3 needs-validation" id="registerForm"
                action="index.php?controller=user&action=register" method="post" novalidate>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email <span class="mark-note">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" required>
                    <div id="emailError" class="invalid-feedback">
                        Hãy nhập email đăng ký của bạn!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">Mật khẩu <span class="mark-note">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div id="passwordError" class="invalid-feedback">
                        Hãy nhập mật khẩu đăng ký và tối thiểu 8 ký tự!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="fullname" class="form-label">Họ và tên <span class="mark-note">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                    <div class="invalid-feedback">
                        Hãy nhập đầy đủ họ tên của bạn!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="address" class="form-label">Địa chỉ <span class="mark-note">*</span></label>
                    <input type="text" class="form-control" id="address" name="address" required>
                    <div class="invalid-feedback">
                        Hãy nhập địa chỉ của bạn!
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button class="btn btn-primary text-uppercase" id="btnSubmit" type="submit">Đăng Ký</button>
                </div>
                <p>Bạn đã có tài khoản, <a href="index.php">đăng nhập tại đây!</a></p>
            </form>
        </div>
    </div>
</div>
<script src="public/js/isValidated.js"></script>
<script src="public/js/register.js"></script>
<?php
require("views/Templates/footer.php");
?>