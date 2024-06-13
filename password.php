<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>找回密碼-Eleganza</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php include("css/css.php") ?>
</head>

<body class="loginbodybg">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 text-white bg-dark bg-opacity-75">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">找回密碼</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3">Enter your email address and we will send you a link to reset your password.</div>
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input class="form-control bg-dark text-white" id="inputEmail" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">email</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small nav-link text-info" href="login.php">返回登入</a>
                                            <a class="btn btn-secondary" href="login.php">重設密碼</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a class="nav-link text-info" href="register.php">註冊帳號</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-dark text-white mt-auto bg-opacity-50">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="">Eleganza studio (阿爾扎工作室) &copy; Website 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>