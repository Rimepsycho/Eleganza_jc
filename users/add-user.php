<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: login.php");

require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 0; //自己設定預設值
} else {
    $id = $_GET["id"];
}



$sql = "SELECT * FROM users WHERE user_id=$id AND valid=1";
$result = $conn->query($sql);

$rowCount = $result->num_rows;


if ($rowCount != 0) {
    $row = $result->fetch_assoc();
}
// var_dump($row);

?>

<!doctype html>
<html lang="en">

< <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>新增會員-Eleganza</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <?php include("../css/css.php") ?>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="../index.php">Eleganza studio (阿爾扎工作室)</a>
            <!-- Sidebar Toggle-->
            <button class="hidden btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION["user"]["name"] ?><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">設定</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../logout.php">登出</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="../index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                總覽
                            </a>
                            <div class="sb-sidenav-menu-heading">資訊欄位</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#users" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                會員
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="users" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../users/user-list.php">會員資料</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#products" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                產品
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="products" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../products/product-list.php">產品管理</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#teacher" aria-expanded="false" aria-controls="courses">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                老師
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="teacher" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../teachers/layout-static.php">老師管理</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#courses" aria-expanded="false" aria-controls="courses">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                課程
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="courses" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../courses/course_list.php">課程列表</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#discounts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                折扣
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="discounts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../discounts/discounts.php">折扣管理</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#orders" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                訂單
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="orders" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../orders/orders.php">訂單管理</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#groups" aria-expanded="false" aria-controls="groups">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                群組
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="groups" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../groups/product_group.php">商品群組</a>
                                    <a class="nav-link" href="../groups/course_group.php">課程群組</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container px-4">
                        <h1 class="mt-4">新增會員</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                            <li class="breadcrumb-item"><a class="nav-link link-primary" href="user-list.php">會員資料</a></li>
                            <li class="mx-3 breadcrumb-item active">新增會員</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="container">
                                <div class="py-2">
                                    <a class="btn" href="user-list.php" role="button">
                                        <i class="text-secondary fa-solid fa-chevron-left"></i>
                                    </a>
                                </div>
                                <form action="doAddUser.php" method="post">
                                    <div class="mb-3">
                                        <label for="">姓名</label>
                                        <input type="name" class="form-control" name="name" minlength="3" maxlength="30" required placeholder="請輸入真實姓名">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">帳號</label>
                                        <input type="account" class="form-control" name="account" minlength="3" maxlength="12" required placeholder="請輸入3~12字元">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">密碼</label>
                                        <input type="password" class="form-control" name="password" id="password" minlength="5" maxlength="12" required placeholder="請輸入5~12字元">
                                        <div type="button" onclick="showPassword" id="show"><i class="fa-solid fa-eye fa-fw ms-2 mt-2"></i></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">電子郵件</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">電話</label>
                                        <input type="tel" class="form-control" name="phone" minlength="8" maxlength="12" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">生日(西元)</label>
                                        <input type="date" class="form-control" name="birth" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-outline-primary">新增</button>
                                    </div>
                                    <?php if (isset($_SESSION["error"]["message"])) : ?>
                                        <div class="pt-2">
                                            <div class="text-danger"><?= $_SESSION["error"]["message"] ?></div>
                                        </div>
                                    <?php endif;
                                    unset($_SESSION["error"]["message"]);
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-center small">
                            <div class="">Eleganza studio (阿爾扎工作室) &copy; Website 2024</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        <script>
            // 顯示密碼的JS
            let checkbox = document.querySelector("#show")
            let password = document.querySelector("#password")
            checkbox.addEventListener("click", () => {
                if (password.type == "password") {
                    password.type = "text";
                } else {
                    password.type = "password";
                }
            })
        </script>
    </body>

</html>