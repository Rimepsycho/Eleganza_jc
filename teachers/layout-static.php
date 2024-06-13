<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: ../login.php");

require_once("../db_connect.php");


$sql = "SELECT * FROM teacher ";
$result = $conn->query($sql);
$total_records = $result->num_rows;

// 定義每頁顯示的記錄數
$recordsPerPage = 5;

// 從 URL 參數中獲取當前頁面
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 計算 SQL 查詢的偏移量
$offset = ($current_page - 1) * $recordsPerPage;

// SQL 查詢以檢索特定範圍的記錄
$sql = "SELECT * FROM teacher LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);

// 獲取總記錄數
$total_records = $conn->query("SELECT COUNT(*) as count FROM teacher")->fetch_assoc()['count'];

// 計算總頁數
$total_pages = ($total_records > 0) ? ceil($total_records / $recordsPerPage) : 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>所有師資-Eleganza</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .page-item {
            color: grey;
        }
    </style>
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
                <div class="container-fluid px-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mt-4 text-center">所有師資</h1>
                        <p class="mt-4"><a class="btn" href="layout-static2.php"><i class="text-secondary fa-solid fa-user-plus "></i></a></p>
                    </div>
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item active">所有老師</li>
                    </ol>
                    <p>目前老師人數共<?php echo $total_records; ?>人</p>
                    <!-- <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="layout-static2.php">新增師資</a></li>
                        <li class="breadcrumb-item active">目前老師人數<?php echo $total_records; ?></li>
                    </ol> -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="layout-static.php" class="me-2">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-arrow-left"></i> <!-- 更换成您想要的图标 -->
                                        </span>
                                    </a>
                                    <div class="input-group" style="max-width: 200px;">
                                        <input type="search" class="form-control" id="searchInput" placeholder="Search" aria-label="Search" aria-describedby="searchButton">
                                        <button class="btn" type="button" id="searchButton"><i class=" text-secondary fas fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                            <table class="table align-middle">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">id</th>
                                        <th scope="col">姓名</th>
                                        <th scope="col">圖片</th>
                                        <th scope="col">介紹</th>
                                        <th scope="col">狀態</th>
                                        <th scope="col">功能</th>
                                        <!-- 如果有其他師資相關的欄位，可以在這裡添加 -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rows = $result->fetch_all(MYSQLI_ASSOC);
                                    foreach ($rows as $teacher) :
                                        $imgFileName = !empty($teacher["img"]) ? $teacher["img"] : "default_image.jpg";
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $teacher["teacher_id"] ?></td>
                                            <td class="text-center" style="max-width:50px;"><?= $teacher["name"] ?></td>

                                            <td class="text-center" style="width:200px;">
                                                <img src="../images/teacher_images/<?= $imgFileName ?>" class="img-fluid img-thumbnail" alt="" style="max-width:200px; max-height:200px;">
                                            </td>

                                            <td style="max-width:200px;"><?= $teacher["introduction"] ?></td>
                                            <td class="text-center"><?php if ($teacher["valid"] == 0) : ?>
                                                    <!-- 如果老師是隱藏的，顯示一個 icon 來顯示老師 -->
                                                    <a class="btn" href="unhide_teacher.php?id=<?= $teacher["teacher_id"] ?>">
                                                        <i class="text-secondary fa-solid fa-plus"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <!-- <?php
                                                        if ($teacher["valid"] == 0) {
                                                            echo "隱藏";
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?> -->
                                            </td>
                                            <td class="text-center">
                                                <a class="btn" href="view_teacher2.php?id=<?= $teacher["teacher_id"] ?>"><i class="text-secondary fa-solid fa-eye"></i></a>
                                                <a class="btn" href="edit_teacher2.php?id=<?= $teacher["teacher_id"] ?>">
                                                    <i class="text-secondary fa-solid fa-pen"></i></a>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#teacher<?= $teacher["teacher_id"] ?>">
                                                    <i class="text-danger fa-solid fa-user-xmark"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="teacher<?= $teacher["teacher_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">提醒</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                確認要隱藏這位老師嗎?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="confirmDelete(<?= $teacher['teacher_id'] ?>)">
                                                                    確認
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function confirmDelete(teacherId) {
            window.location.replace("softdel_teacher.php?id=" + teacherId);
            /* var confirmDelete = confirm("確定要刪除嗎？");

            if (confirmDelete) {
                // 如果確定要刪除，可以執行相應的刪除操作，例如導向到刪除的 PHP 文件
                window.location.replace("del_teacher.php?id=" + teacherId);
            } else {
                // 如果取消刪除，可以不執行任何操作或執行相應的取消操作
                // 例如：alert("取消刪除");
            } */
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#searchButton').on('click', function() {
                var search_query = $('#searchInput').val();

                // 清空表格內容
                $('tbody').empty();

                // 發送 AJAX 請求
                $.ajax({
                    url: 'search_teacher.php',
                    method: 'GET',
                    data: {
                        query: search_query
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log('成功獲得數據:', data);

                        if (data.length > 0) {
                            // 在表格中顯示搜尋結果
                            $.each(data, function(index, teacher) {
                                var imgFileName = teacher["img"] !== null ? teacher["img"] : "default_image.jpg";
                                var row = '<tr>' +
                                    '<td class="text-center">' + teacher["teacher_id"] + '</td>' +
                                    '<td class="text-center" style="max-width:50px;">' + teacher["name"] + '</td>' +
                                    '<td class="text-center" style="width:200px;">' +
                                    '<img src="../images/teacher_images/' + imgFileName + '" class="img-fluid img-thumbnail" alt="" style="max-width:200px; max-height:200px;">' +
                                    '</td>' +
                                    '<td style="max-width:200px;">' + teacher["introduction"] + '</td>' +
                                    '<td class="text-center">' + (teacher["valid"] == 0 ? '<a class="btn btn-secondary" href="unhide_teacher.php?id=' + teacher["teacher_id"] + '"><i class="fa-solid fa-plus"></i></a>' : '') + '</td>' +
                                    '<td class="text-center">' +
                                    '<a class="btn btn-secondary" href="view_teacher.php?id=' + teacher["teacher_id"] + '"><i class="fa-solid fa-eye"></i></a>' +
                                    '<a class="btn btn-secondary" style="margin-left: 5px; href="edit_teacher.php?id=' + teacher["teacher_id"] + '"><i class="fa-solid fa-pen"></i></a>' +
                                    '<button type="button" class="btn btn-danger" style="margin-left: 5px;  data-bs-toggle="modal" data-bs-target="#teacher' + teacher["teacher_id"] + '"><i class="fa-solid fa-user-xmark"></i></button>' +
                                    '</td>' +
                                    '</tr>';
                                $('tbody').append(row);
                            });
                        } else {
                            // 如果沒有找到結果，顯示一條消息
                            $('tbody').append('<tr><td colspan="6" class="text-center">沒有找到結果</td></tr>');
                        }
                    },
                    error: function(error) {
                        // 處理錯誤
                        console.error('AJAX 錯誤:', error);
                        // 如果需要，在頁面上顯示錯誤消息
                    }
                });
            });
        });
    </script>


</body>

</html>