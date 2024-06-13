<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: ../login.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>新增師資-Eleganza</title>
    <link href="../css/styles.css" rel="stylesheet" />
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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-6" style="max-width:700px;">
                    <p class="mt-4"><a class="btn" href="layout-static.php"><i class="text-secondary fa-solid fa-arrow-left"></i></a></p>
                    <h1 class="mt-4">新增老師</h1>

                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="layout-static.php">所有老師</a></li>
                        <li class="mx-3 breadcrumb-item active">新增老師</li>
                    </ol>
                    <div class="card mb-4 mx-auto" style="max-width:800px;">
                        <!-- <h2 class="card-header text-center">新增老師</h2> -->
                        <div class="card-body">
                            <form action="add_teacher2.php" method="post" enctype="multipart/form-data" style="max-width: 500px; margin: auto;" onsubmit="return validateForm();">
                                <!-- <table class="mx-auto" class="border" cellpadding="10"> -->
                                <div class="mb-3">
                                    <label for="teacher_name" class="form-label">姓名</label>
                                    <input type="text" class="form-control" id="teacher_name" name="teacher_name">
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_gender" class="form-label">性別</label>
                                    <input type="text" class="form-control" id="teacher_gender" name="teacher_gender">
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_phone" class="form-label">電話</label>
                                    <input type="tel" class="form-control" id="teacher_phone" name="teacher_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_email" class="form-label">電子郵件</label>
                                    <input type="email" class="form-control" id="teacher_email" name="teacher_email">
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_img" class="form-label">圖片</label>
                                    <img src="../images/teacher_images/<?= $row["img"] ?>" class="img-fluid img-thumbnail" id="preview" style="max-width:500px; max-height:500px;" alt="">
                                    <input type="file" class="form-control" id="teacher_img_upload" name="teacher_img_upload" onchange="previewImage(this)">
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_introduction" class="form-label">介紹</label>
                                    <textarea class="form-control" name="teacher_introduction" id="teacher_introduction" rows="10"></textarea>
                                </div>

                                <!-- <tr>
                                        <td>姓名</td>
                                        <td><input type="text" id="teacher_name" name="teacher_name" required><br></td>
                                    </tr>
                                    <tr>
                                        <td>電話</td>
                                        <td><input type="tel" id="teacher_phone" name="teacher_phone" required><br></td>
                                    </tr>
                                    <tr>
                                        <td>電子郵件</td>
                                        <td><input type="email" id="teacher_email" name="teacher_email" required><br></td>
                                    </tr>
                                    <tr>
                                        <td>圖片</td>
                                        <td><input type="file" id="teacher_img" name="teacher_img"><br></td>
                                    </tr>
                                    <tr>
                                        <td>介紹</td>
                                        <td><textarea id="textarea" rows="3" cols="20" name="teacher_introduction"></textarea></td>
                                    </tr> -->
                                <div class="mb-3 text-center">
                                    <input type="submit" class="btn btn-outline-primary" name="button" value="新增資料">
                                    <input type="reset" class="btn btn-secondary" name="button2" value="重新填寫" onclick="clearPreview()">
                                </div>


                                <!-- <tr>
                                        <td colspan="2" class="text-center">
                                            <input type="submit" class="btn btn-secondary" name="button" value="新增資料">
                                            <input type="reset" class="btn btn-secondary" name="button2" value="重新填寫">
                                        </td>
                                    </tr> -->
                                <!-- </table> -->
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
    <script>
        function validateForm() {
            // 獲取使用者輸入的 email 和 phone
            var email = document.getElementById("teacher_email").value;
            var phone = document.getElementById("teacher_phone").value;

            // 檢查 email 是否為有效的格式
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("請輸入有效的電子郵件地址");
                return false;
            }

            // 檢查 phone 是否為有效的格式，這裡只是一個簡單的檢查方式，實際中可能需要更複雜的驗證邏輯
            var phoneRegex = /^\d{10}$/; // 這裡假設電話是 10 位數字
            if (!phoneRegex.test(phone)) {
                alert("請輸入有效的電話號碼");
                return false;
            }



            // 如果通過了上述檢查，返回 true，提交表單
            return true;
        }
        //重置預覽圖片
        function previewImage(input) {
            var preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearPreview() {
            var preview = document.getElementById('preview');
            preview.src = "";
        }

        // function previewImage(input) {
        //     var preview = document.getElementById('preview');
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();

        //         reader.onload = function(e) {
        //             preview.src = e.target.result;
        //         }

        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }
    </script>
</body>

</html>