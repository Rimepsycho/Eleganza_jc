<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: ../login.php");

require_once("../db_connect.php");

// $perPage=4; //定義變數 

// $sqlAll="SELECT * FROM course WHERE valid=1";
// $resultAll = $conn->query($sqlAll); 
// $userTotalCount = $resultAll->num_rows; //新：看多少筆數量來算需多少頁 本來：不是在搜尋的情況下應顯示總共有多少人 搜尋後頁面也顯示共多少人

// $pageCount= ceil($userTotalCount / $perPage); //多一筆要多一頁 相除後是小數點就無條件進位 JS:ceil()
// // echo $pageCount;

$sqlCategory = "SELECT * FROM course_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

// $sql = "SELECT course.*, course_category.level AS course_category_level, teacher.name AS course_teacher_name, course_style.style_name AS course_style_name FROM course
//         JOIN course_category ON course.course_category_id = course_category.course_category_id 
//         JOIN teacher ON course.teacher_id = teacher.teacher_id 
//         JOIN course_style ON course.style_id = course_style.style_id
//         ORDER BY course.course_id";

$sql = "SELECT course.*, course_category.level AS course_category_level, teacher.name AS course_teacher_name FROM course 
        JOIN course_category ON course.course_category_id = course_category.course_category_id 
        JOIN teacher ON course.teacher_id = teacher.teacher_id 
        WHERE course.valid = 0
        ORDER BY course.course_id";

$result = $conn->query($sql);
$rowCount = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>下架課程-Eleganza</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="index.php">
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">已下架課程列表</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item active">已下架課程列表</li>
                    </ol>
                    <div class="d-flex justify-content-between">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active " aria-current="page" href="course_list.php">全部課程</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">初階個別課</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">中階個別課</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">高階個別課</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">團體課</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">大師班</a>
                            </li>
                        </ul>
                        <a class="btn btn-dark" href="course-upload.php">新增課程</a>
                    </div>
                    <div class="py-2">
                        <form action="">
                            <div class="row g-3 align-items-center">
                                <!-- 增加一個回去的按鈕 -->
                                <?php if (isset($_GET["min"]) && isset($_GET["max"])) : ?>
                                    <div class="col-auto">
                                        <a href="course_management.php" name="" id="" class="btn" role="button"><i class="text-primary fa-solid fa-arrow-left"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <!-- 為何按回去是not found? -->
                                <div class="col-auto">
                                    <?php $minvalue = 0;  //當最小值為0的時候
                                    if (isset($_GET["min"])) {
                                        $minValue = $min;
                                    }
                                    ?>
                                    <input type="number" class="form-control" name="min" value="<?= $minValue ?>" min="0">
                                </div>
                                <div class="col-auto">
                                    ~
                                </div>
                                <div class="col-auto">
                                    <input type="number" class="form-control" name="max" value="<?= $maxValue ?>" min="0">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-dark" type="submit">搜尋</button>
                                </div>
                            </div>
                        </form>


                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                課程清單
                            </div>
                            <div class="card-body">
                                <table class="table" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>課程名稱</th>
                                            <th>課程種類</th>
                                            <th>指導教師</th>
                                            <th>費用</th>
                                            <th>限額</th>
                                            <th>課程時間</th>
                                            <th>開始日期</th>
                                            <th>結束日期</th>
                                            <th>編輯</th>
                                            <th>上架</th>
                                            <th>刪除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $course_list) : ?>
                                            <tr>

                                                <td><a class="text-decoration-none" href="course.php?id=<?= $course_list["course_id"] ?>"><?= $course_list["name"] ?></a></td>
                                                <td><?= $course_list["course_category_level"] ?></td>
                                                <td><?= $course_list["course_teacher_name"] ?></td>
                                                <td><?= $course_list["price"] ?></td>
                                                <td><?= $course_list["quota"] ?></td>
                                                <td><?= $course_list["time"] ?></td>
                                                <td><?= $course_list["start_date"] ?></td>
                                                <td><?= $course_list["end_date"] ?></td>
                                                <td><a class="text-decoration-none" href="course-edit.php?id=<?= $course_list["course_id"] ?>">編輯圖標</a></td>
                                                <td><a class="text-decoration-none" href="#">上架圖標</a></td>
                                                <td><a class="text-decoration-none" href="#">刪除圖標</a></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
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
</body>

</html>