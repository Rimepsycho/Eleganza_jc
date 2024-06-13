<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: login.php");

require_once("../pdo-conncetion.php");

$coursesql = "SELECT * FROM course_category";
$coursestmt = $db_host->prepare($coursesql);
$productsql = "SELECT * FROM product_category";
$productstmt = $db_host->prepare($productsql);

try {
    $coursestmt->execute();
    $courserows = $coursestmt->fetchAll(PDO::FETCH_ASSOC);
    $productstmt->execute();
    $productrows = $productstmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "預處理陳述式失敗<br>";
    echo "Error: " . $e->getMessage();
    $db_host = null;
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>折扣管理-Eleganza</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php include("../css/css.php") ?>
</head>

<body>
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
        <div class="" id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mt-4">類別管理</h1>
                        </div>
                        <div><a href="newcategory.php" class="btn"><i class="fa-solid fa-plus text-secondary"></i></a></div>

                    </div>
                    <!-- <div id="accordionExample">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" style="border-radius:0.375rem ;" data-bs-toggle="collapse" href="#cateCollapseproduct">商品</a>
                            </li>

                        </ul>

                        <div class="accordion mt-3">
                            <form action="./product-add.php" method="post" enctype="multipart/form-data">
                                <div class="collapse" id="collapseExample">
                                    <div class="collapse" id="cateCollapseproduct" data-bs-parent="#accordionExample">
                                        <div class="row g-2">
                                            <div class="col">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="nameAdd">
                                                    <label for="floatingInput">類別名稱 :</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item active">類別管理</li>
                    </ol>

                    <div class="row">
                        <div class="col-12">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            商品類別
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="table-responsive">
                                                        <table id="example" class="display" style="min-width: 845px">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>類別名稱</th>
                                                                    <th>狀態</th>
                                                                    <th>修改</th>
                                                                    <th>刪除</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($productrows as $productrow) : ?>
                                                                    <tr>
                                                                        <td><?= $productrow["product_category_id"] ?></td>
                                                                        <td><?= $productrow["type"] ?></td>
                                                                        <td class="text-danger"><?php if ($productrow["valid"] == 0) echo "下架" ?></td>
                                                                        <td><a href="recategory.php?id=<?= $productrow["product_category_id"] ?>&cate=product" class="btn"><i class="fa-solid fa-pen text-secondary"></i></a></td>

                                                                        <td><button type="button" class="btn getid" data-bs-toggle="modal" data-id="<?= $productrow["product_category_id"] ?>" data-category="product" data-bs-target="#staticBackdrop"><i class="fa-solid fa-trash text-danger"></i></button></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            課程類別
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="table-responsive">
                                                        <table id="example" class="display" style="min-width: 845px">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>類別名稱</th>
                                                                    <th>狀態</th>
                                                                    <th>修改</th>
                                                                    <th>刪除</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($courserows as $courserow) : ?>
                                                                    <tr>
                                                                        <td><?= $courserow["course_category_id"] ?></td>
                                                                        <td><?= $courserow["level"] ?></td>
                                                                        <td class="text-danger"><?php if ($courserow["valid"] == 0) echo "下架" ?></td>
                                                                        <td><a href="recategory.php?id=<?= $courserow["course_category_id"] ?>&cate=course" class="btn"><i class="fa-solid fa-pen text-secondary"></i></a></td>

                                                                        <td><button type="button" class="btn getid" data-bs-toggle="modal" data-id="<?= $courserow["course_category_id"] ?>" data-category="course" data-bs-target="#staticBackdrop"><i class="fa-solid fa-trash text-danger"></i></button></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">刪除類別</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    是否刪除類別?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                    <button onclick="express()" class="btn btn-danger">確定</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-center small">
                    <div class="">Eleganza studio (阿爾扎工作室) &copy; Website 2024</div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script>
        const getid = document.querySelectorAll(".getid");
        let id = "";
        let category = "";

        for (let i = 0; i < getid.length; i++) {
            getid[i].addEventListener("click", function() {
                id = this.dataset.id;
                category = this.dataset.category;
                console.log(category);
            })
        }

        function express() {
            window.location.replace("doDeletecategory.php?id=" + id + "&cate=" + category);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>

    <!-- Required vendors -->
    <script src="../vendor/global/global.min.js"></script>

    <!-- Datatable -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../js/plugins-init/datatables.init.js"></script>
</body>

</html>