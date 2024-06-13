<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: ../login.php");

require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 0;
} else {
    $id = $_GET["id"];
}
// var_dump($id);

$sql = "SELECT * FROM course WHERE course_id = $id"; //把GET存到id裡去
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<?php
// $category_id = $row["course_category_id"];WHERE course_category_id = $category_id
$sql_course_category = "SELECT * FROM course_category ";
$result_course_category = $conn->query($sql_course_category);
$course_categories = $result_course_category->fetch_all();

?>

<?php
// $teacher_id = $row["teacher_id"]; WHERE $teacher_id
$sql_teacher = "SELECT * FROM teacher";
$result_teacher = $conn->query($sql_teacher);
$teachers = $result_teacher->fetch_all();

?>
<?php
$sql_style = "SELECT * FROM course_style";
$result_style = $conn->query($sql_style);
$styles = $result_style->fetch_all();
?>

<?php
// $domain = "http://localhost";
// $imgFolder = "./course_images/";
// $imgNameFromDB = $row["img"]; // 假設資料表 img 欄位保存的是圖片的名稱和副檔名

// // 完整的圖片 URL
// $fullImagePath = $domain . '/' . $imgFolder . $imgNameFromDB;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>編輯課程-Eleganza</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#start-datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script>
        $(function() {
            $("#end-datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/timePlugin.js"></script>
    <?php include("../css/css.php") ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#start-timePicker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });

            flatpickr("#end-timePicker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
        });
    </script>
    <style>
        #imagePreview img {
            max-width: 100%;
            max-height: 500px;
        }
    </style>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">編輯課程</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="course_list.php">課程列表</a></li>
                        <li class="breadcrumb-item active">編輯課程</li>
                    </ol>
                    <div class="container">
                        <form class="col-lg-6 col-md-9 col-sm-12" action="DoEditCourse.php" method="post" enctype="multipart/form-data">
                            <div class="py-2">
                                <a class="btn" href="course_list.php" role="button"><i class="text-dark fa-solid fa-chevron-left"></i></a>
                            </div>
                            <div class="mb-2">
                                <input type="hidden" name="course_id" value=<?= $row["course_id"] ?>>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">課程名稱</label>
                                <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">課程圖片</label>
                                <img class="mb-3" style="max-height: 300px;" name="original_img" src="../images/course_images/<?= $row["img"] ?>" alt="課程圖片">
                                <input type="file" class="form-control" name="course_images" id="imageInput" accept="image/*" onchange="previewImage()">
                                <div id="imagePreview"></div>
                            </div>
                            <select class="form-select mt-3" name="course_category_level" aria-label="Default select example">
                                <option disabled hidden>課程類别</option>
                                <?php foreach ($course_categories as $category) : ?>
                                    <option name="course_category_level" value="<?= $category[0] ?>" <?php if ($row["course_category_id"] == $category[0]) echo "selected"; ?>><?= $category[1] ?></option>
                                <?php endforeach; ?>
                            </select>

                            <select class="form-select mt-3" name="course_teacher_name" aria-label="Default select example">
                                <option disabled hidden>授課老師</option>
                                <?php foreach ($teachers as $teacher) : ?>
                                    <option name="course_teacher_name" value="<?= $teacher[0] ?>" <?php if ($row["teacher_id"] == $teacher[0]) echo "selected"; ?>><?= $teacher[1] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-select mt-3" name="style" aria-label="Default select example">
                                <option disabled hidden>課程音樂風格</option>
                                <?php foreach ($styles as $style) : ?>
                                    <option name="style" value="<?= $style[0] ?>" <?php if ($row["style_id"] == $style[0]) echo "selected"; ?>><?= $style[1] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mb-2 mt-3">
                                <label for="" class="form-label">學費</label>
                                <input type="text" class="form-control" name="price" value="<?= ($row["price"]) ?>">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">限額</label>
                                <input type="text" class="form-control" name="quota" value="<?= $row["quota"] ?>">
                            </div>
                            <div class="inputgroup my-3 d-flex jutify-center-start">
                                <div>上下架選擇：</div>
                                <input class="mx-2" type="radio" name="valid" value="1" <?php echo ($row["valid"] == 1) ? "checked" : ""; ?>> 上架
                            </div>
                            <p class="fs-5 mt-3">個別課不需選擇課程日期、時間，自行與教師商議</ㄣ>
                            <p>課程開始日期 <input class="mt-3 mx-2" type="text" id="start-datepicker" name="start_date" value="<?= $row["start_date"] ?>"></p>
                            <p>課程結束日期 <input class="mt-1 mx-2" type="text" id="end-datepicker" name="end_date" value="<?= $row["end_date"] ?>"></p>
                            <p>上課開始時間 <input class="mx-2" type="text" id="start-timePicker" name="start_time" placeholder="選擇時間" value="<?= $row["start_time"] ?>"></p>
                            <p>上課結束時間 <input class="mx-2" type="text" id="end-timePicker" name="end_time" placeholder="選擇結束時間" value="<?= $row["end_time"] ?>"></p>
                            <div class="mb-3">
                                <label for="courseAddIntro" class="form-label mt-3">描述</label>
                                <textarea class="form-control" id="courseAddIntro" rows="3" name="des"><?= $row["description"] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="courseAddIntro" class="form-label mt-3">備註</label>
                                <textarea class="form-control" id="courseAddIntro" rows="3" name="comment"><?= $row["comment"] ?></textarea>
                            </div>

                            <button class="btn btn-dark mb-3" type="submit">完成編輯</button>
                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <!-- <script>
         document.addEventListener("DOMContentLoaded", function() {
         var backendImagePath = "http://localhost/midterm/violin/course_images/<?= $row["img"] ?>";
        
         if (backendImagePath) {
            var preview = document.getElementById('imagePreview');
             var img = document.createElement('img');
             img.src = backendImagePath;
             preview.appendChild(img);
         }
     });
     </script> -->
    <!-- 選擇新圖片時的預覽函數 -->
    <script>
        function previewImage() {
            var input = document.getElementById('imageInput');
            var preview = document.getElementById('imagePreview');

            while (preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }

            if (input.files && input.files.length > 0) {
                var reader = new FileReader();
                var img = document.createElement('img');

                reader.onload = function(e) {
                    img.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
                preview.appendChild(img);
            }
        }
    </script>
</body>

</html>
</body>

</html>