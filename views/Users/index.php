<?php
require("views/Templates/header.php");
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <title>Đăng nhập</title>
    <style>
        a{
            cursor: pointer;
        }
    </style>
    <meta name="google-signin-client_id" content="945161652386-ptbvf9j28sp24s3hpmvbpl3fcpmh9crc.apps.googleusercontent.com">
</head>
<h3 class="text-center text-uppercase">Đăng Nhập Hệ Thống</h3>
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
                <div class="alert alert-danger p-1 mt-3">
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
            <form class="row g-3 p-3 needs-validation" action="index.php?controller=user" method="post" novalidate>
                <div class="col-md-12">
                    <label for="email" class="form-label">Email <span class="mark-note">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" required>
                    <div class="invalid-feedback">
                        Hãy nhập email đăng nhập của bạn!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">Mật khẩu <span class="mark-note">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Hãy nhập mật khẩu đăng nhập của bạn!
                    </div>
                </div>
                <div class="col-12 d-flex flex-column">
                    <div class="d-flex justify-content-center mb-2"><button class="btn btn-primary text-uppercase rounded-1" type="submit">Đăng nhập</button></div>
                    <a class="d-flex justify-content-center" onclick="loginGoogle()"><img width="129px" height="37px" alt="google-login-button" src="//bizweb.dktcdn.net/assets/admin/images/login/gp-btn.svg"></a>
                </div>
                <p>Bạn chưa có tài khoản, <a href="index.php?controller=user&action=register">đăng ký tại đây!</a></p>
            </form>
        </div>
    </div>
</div>
<script src="public/js/login.js"></script>
<?php
require("views/Templates/footer.php");
?>