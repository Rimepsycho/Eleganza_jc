<?php
session_start();
if (!isset($_SESSION["user"]))
   header("location: login.php");

require_once("../db_connect.php");

$brand = "";
$whereClause = "";

if (isset($_GET["search"])) {

   $search = $_GET["search"];
   $whereClause = "WHERE name LIKE '%$search%' AND valid=1";
} elseif (isset($_GET['brand'])) {

   $brand = $_GET['brand'];
   $whereClause = "WHERE brand='$brand' AND valid=1";
} elseif (isset($_GET['category'])) {

   $category = $_GET['category'];
   $whereClause = "WHERE product_category_id='$category' AND valid=1";
} elseif (isset($_GET['onShelf'])) {

   $onShelf = $_GET["onShelf"];
   $whereClause = "WHERE product.status  = 1 AND valid=1";
} elseif (isset($_GET['offShelf'])) {

   $offShelf = $_GET["offShelf"];
   $whereClause = "WHERE product.status  = 2 AND valid=1";
} elseif (isset($_GET['delete'])) {

   $delete = $_GET["delete"];
   $whereClause = "WHERE valid=0";
} else {
   $whereClause = "WHERE valid=1";
}

//product
$sql = "SELECT product.* , product_status.status AS p_status FROM product JOIN product_status ON product.status = product_status.id $whereClause";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$rowcount = $result->num_rows;

//product cate
$cateSql = "SELECT * FROM product_category";
$cateResult = $conn->query($cateSql);
$cateRows = $cateResult->fetch_all(MYSQLI_ASSOC);

//image
$imgSql = "SELECT * FROM imgs";
$imgResult = $conn->query($imgSql);
$imgRows = $imgResult->fetch_all(MYSQLI_ASSOC);







?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Product</title>
   <link href="../css/wupsStyles.css" rel="stylesheet" />
   <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <?php include("../css/css.php") ?>

   <style>
      .img {
         width: auto;
         height: 100px;
      }

      .pic a {
         width: 100px;
         height: 100px;
      }

      .align-img {
         width: 100px;
      }

      .toggle-input {
         display: none;
      }

      p {
         margin: 0;
      }

      .form-control {
         padding: 0.275rem;
         margin: 0;
      }

      .editBtnArea {
         width: fit-content;
         margin-left: auto;
      }

      .editBtn,
      .deleteBtn {
         pointer-events: padding-box;
      }

      .editBtn:hover,
      .deleteBtn:hover {
         cursor: pointer;
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

      <!-- main content -->
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4">
               <div class="d-flex justify-content-between align-items-center my-4">
                  <div>
                     <h1 class="mb-2">PRODUCT LIST</h1>
                     <div class="d-flex align-content-center align-items-center">
                        <?php if (isset($_GET["search"]) || isset($_GET["brand"]) || isset($_GET["category"]) || isset($_GET["onShelf"]) || isset($_GET["OffShelf"]) || isset($_GET["delete"])) : ?>
                           <div class="py-2">
                              <a name="" id="" class="btn btn-outline" href="./product-list.php" role="button"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
                           </div>
                        <?php endif; ?>
                        <form action="" method="get">
                           <div class="input-group">
                              <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
                                 <span class="visually-hidden">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu " id="filterDropdown">
                                 <li><a class="dropdown-item" href="#" data-filter="name" name="name">Name</a></li>
                                 <li class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Brand</a>
                                    <ul class="dropdown-menu">
                                       <?php
                                       $sqlB = "SELECT * FROM product";
                                       $resultB = $conn->query($sqlB);
                                       $brandArr = $resultB->fetch_all(MYSQLI_ASSOC);
                                       $uniqueBrands = array_unique(array_column($brandArr, 'brand'));
                                       // print_r($uniqueBrands);
                                       foreach ($uniqueBrands as $brand) :
                                       ?>
                                          <li><a class="dropdown-item" href="product-list.php?brand=<?= $brand ?>" data-filter="<?= $brand ?>" name="brand"><?= $brand ?></a></li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </li>
                                 <li class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Category</a>
                                    <ul class="dropdown-menu">
                                       <?php foreach ($cateRows as $cate) : ?>
                                          <li><a class="dropdown-item" href="product-list.php?category=<?= $cate["product_category_id"] ?>" data-filter="<?= $cate["type"] ?>" name="category"><?= $cate["type"] ?></a></li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </li>
                                 <li class="dropdown dropend">
                                    <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Status</a>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="product-list.php?onShelf=1" data-filter="onShelf" name="onShelf">ON shelf</a></li>
                                       <li><a class="dropdown-item" href="product-list.php?offShelf=2" data-filter="offShelf" name="offShelf">OFF shelf</a></li>
                                    </ul>
                                 </li>
                                 <li><a class="dropdown-item" href="product-list.php?delete=0" data-filter="delete" name="delete">Deleted</a></li>
                              </ul>

                              <input type="text" class="form-control" name="search" <?php
                                                                                    if (isset($_GET["search"])) :
                                                                                       $searchValue = $_GET["search"]; ?> value="<?= $searchValue ?>" <?php endif; ?> <?php
                                                                                                            if (isset($_GET["brand"])) :
                                                                                                               $brand = $_GET["brand"]; ?> value="<?= $brand ?>" <?php endif; ?> <?php
                                                                                                if (isset($_GET["category"])) :
                                                                                                   $category = $_GET["category"]; ?> <?php if ($category == 1) : ?> value="小提琴" <?php elseif ($category == 2) : ?> value="小提琴盒" <?php elseif ($category == 3) : ?> value="提琴弓" <?php elseif ($category == 4) : ?> value="松香" <?php endif; ?> <?php endif; ?> <?php
                                                                                                                                                                                                                                                                                          if (isset($_GET["status"])) :
                                                                                                                                                                                                                                                                                             $status = $_GET["status"]; ?> value="<?= $status ?>" <?php endif; ?>>
                              <button type="submit" class="btn btn-outline-secondary">
                                 <i class="bi bi-search fs-5"></i>
                              </button>
                           </div>
                        </form>
                     </div>
                     <!-- </div> -->
                  </div>
                  <div class="d-flex justify-content-end align-items-center flex-grow-1">
                     <div data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-plus-lg fs-1 m-2"></i>
                     </div>
                  </div>
               </div>

               <!-- ADD -->
               <div class="collapse" id="collapseExample">

                  <div id="accordionExample">
                     <ul class="nav nav-tabs">
                        <?php foreach ($cateRows as $cate) : ?>
                           <li class="nav-item">
                              <a class="nav-link" style="border-radius:0.375rem ;" data-bs-toggle="collapse" href="#cateCollapse<?= $cate["type"] ?>"><?= $cate["type"] ?></a>
                           </li>
                        <?php endforeach; ?>

                     </ul>
                     <div class="accordion mt-3">
                        <?php foreach ($cateRows as $cate) : ?>
                           <form action="./product-add.php" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="addId" value="<?= $cate["product_category_id"] ?>">

                              <div class="collapse" id="cateCollapse<?= $cate["type"] ?>" data-bs-parent="#accordionExample">

                                 <div class="row g-2">
                                    <!-- product detail -->
                                    <div class="col">
                                       <?php if ($cate["product_category_id"] == 1) : ?>
                                          <div class="form-floating mb-2">
                                             <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="nameAdd">
                                             <label for="floatingInput">Product Name :</label>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="priceAdd">
                                                   <label for="floatingInput">Price :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="numAdd">
                                                   <label for="floatingInput">Num :</label>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="brandAdd">
                                                   <label for="floatingInput">Brand :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="sizeAdd">
                                                   <label for="floatingInput">Size :</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="topAdd">
                                                   <label for="floatingInput">Top :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="basAdd">
                                                   <label for="floatingInput">Bas :</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="neckAdd">
                                                   <label for="floatingInput">Neck :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="fingerAdd">
                                                   <label for="floatingInput">Fb :</label>
                                                </div>
                                             </div>
                                          </div>
                                       <?php elseif ($cate["product_category_id"] == 2) : ?>
                                          <div class="form-floating mb-2">
                                             <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="nameAdd">
                                             <label for="floatingInput">Product Name :</label>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="priceAdd">
                                                   <label for="floatingInput">Price :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="numAdd">
                                                   <label for="floatingInput">Num :</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="brandAdd">
                                                   <label for="floatingInput">Brand :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="sizeAdd">
                                                   <label for="floatingInput">Size :</label>
                                                </div>
                                             </div>
                                          </div>
                                       <?php elseif ($cate["product_category_id"] == 3) : ?>
                                          <div class="form-floating mb-2">
                                             <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="nameAdd">
                                             <label for="floatingInput">Product Name :</label>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="priceAdd">
                                                   <label for="floatingInput">Price :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="numAdd">
                                                   <label for="floatingInput">Num :</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="brandAdd">
                                                   <label for="floatingInput">Brand :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="bowAdd">
                                                   <label for="floatingInput">Bow :</label>
                                                </div>
                                             </div>
                                          </div>
                                       <?php elseif ($cate["product_category_id"] == 4) : ?>
                                          <div class="form-floating mb-2">
                                             <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="nameAdd">
                                             <label for="floatingInput">Product Name :</label>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="priceAdd">
                                                   <label for="floatingInput">Price :</label>
                                                </div>
                                             </div>
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control" id="floatingInput" placeholder="0000" name="numAdd">
                                                   <label for="floatingInput">Num :</label>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row g-2">
                                             <div class="col">
                                                <div class="form-floating mb-2">
                                                   <input type="text" class="form-control h-100" id="floatingInput" placeholder="0000" name="brandAdd">
                                                   <label for="floatingInput">Brand :</label>
                                                </div>
                                             </div>
                                          </div>
                                       <?php endif; ?>
                                    </div>

                                    <!-- intro -->
                                    <div class="col" style="height: 100%;">
                                       <div class="form-floating mb-2">
                                          <textarea type="text" class="form-control" style="height: 100%;" id="floatingInput" placeholder="0000" name="introAdd"></textarea>
                                          <label for="floatingInput">Introduction :</label>
                                       </div>
                                       <div class="d-flex flex-colnum justify-content-between h-100 align-items-center">
                                          <div>
                                             <input type="file" name="images[]" id="images" multiple accept="image/*">
                                          </div>
                                          <div>
                                             <button type="submit" class="btn btn-outline text-end ">
                                                Add
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        <?php endforeach; ?>
                     </div>
                  </div>
               </div>

               <div class="py-2">
                  <?= $rowcount ?> Products
               </div>

               <!-- title -->
               <div class="row col-12  py-2  pe-3">
                  <div class="col ">
                     <h5>Image</h5>
                  </div>
                  <div class="col-3 ps-4 pe-2">
                     <h5>Name</h5>
                  </div>
                  <div class="col ps-3">
                     <h5>Price</h5>
                  </div>
                  <div class="col">
                     <h5>Num</h5>
                  </div>
                  <div class="col">
                     <h5>Status</h5>
                  </div>
               </div>

               <?php foreach ($rows as $product) : ?>


                  <?php /* if ($product["num"] == 0) {
                     $product["p_status"] == 2;
                  } */


                  ?>

                  <form action="product-edit.php" method="post" enctype="multipart/form-data">

                     <!-- product -->
                     <div class="accordion" id="accordion<?= $product["product_id"] ?>">
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="heading<?= $product["product_id"] ?>">
                              <button class="accordion-button collapsed p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $product["product_id"] ?>" aria-expanded="false" aria-controls="collapse<?= $product["product_id"] ?>">

                                 <input type="hidden" name="editId" value="<?= $product["product_id"] ?>">

                                 <!-- product -->
                                 <div class="row d-flex col-12 align-items-center" style="height: 100px;">
                                    <div class="col text-start">
                                       <div class="align-img text-center">
                                          <img class="objf-cover img" src="../images/product_images/<?= $product["img"] ?>" alt="">
                                       </div>
                                    </div>
                                    <div class="col-3 pe-5">
                                       <div class="w-75">
                                          <p id="nameText<?= $product["product_id"] ?>">
                                             <?= $product["name"] ?>
                                          </p>
                                          <input placeholder="Name" value="<?= $product["name"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="nameEdit">
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="w-50">
                                          <p id="priceText<?= $product["product_id"] ?>">
                                             $<?= number_format($product["price"]) ?>
                                          </p>
                                          <input placeholder="Price" value="<?= $product["price"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="priceEdit">
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="w-25">
                                          <p id="numText<?= $product["product_id"] ?>">
                                             <?= $product["num"] ?>
                                          </p>
                                          <input placeholder="num" value="<?= $product["num"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="numEdit">
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div>
                                          <p id="statusText<?= $product["product_id"] ?>">
                                             <?= $product["p_status"] ?>
                                          </p>
                                          <select class="form-select w-50 toggle-input" aria-label="Default select example" data-product-id="<?= $product["product_id"] ?>" name="statusEdit">
                                             <option value="1">On Shelf</option>
                                             <option value="2">Off Shelf</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </button>
                           </h2>

                           <!-- accordion body -->
                           <div id="collapse<?= $product["product_id"] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $product["product_id"] ?>" data-bs-parent="#accordion<?= $product["product_id"] ?>">
                              <div class="accordion-body px-3 py-4 position-relative">

                                 <div class="row">
                                    <div class="col">
                                       <!-- for the img -->

                                       <div class="row">
                                          <div class="col">
                                             <!-- for the img -->
                                             <h5>All images</h5>

                                             <div class="d-flex flex-wrap">
                                                <?php foreach ($imgRows as $img) : ?>
                                                   <?php if ($img["product_id"] == $product["product_id"]) { ?>
                                                      <div class="me-3 mt-2 mb-1 position-relative" style="width: 100px;">
                                                         <img class="img img-thumbnail" src="../images/product_images/<?= $img["pic"] ?>" alt="">
                                                         <div class="delete-btn text-center border rounded" data-img-id="<?= $img["imgs_id"] ?>" data-href="./product-delete.php" data-method="post">
                                                            <i class="d-inline-block bi bi-dash fs-3 text-danger"></i>
                                                         </div>
                                                      </div>
                                                   <?php } ?>
                                                <?php endforeach; ?>



                                                <!-- add img -->
                                                <div class="d-flex justify-content-center align-content-center mt-3" style="width: 100px; height: 100px">
                                                   <div class="d-flex justify-content-center align-items-center uploadBtn" id="uploadBtn<?= $product["product_id"] ?>">
                                                      <i class="bi bi-plus fs-1"></i>
                                                   </div>
                                                   <input type="file" name="images[]" id="fileInput<?= $product["product_id"] ?>" multiple accept="image/*" style="display: none;">
                                                </div>

                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col border-start ps-3">
                                       <div class="row col-12">
                                          <div class="col-6">
                                             <div class="mb-3">
                                                <h5>Introduction</h5>
                                                <div class="pe-3">
                                                   <div style="height: 100%;">
                                                      <p id="introText<?= $product["product_id"] ?>">
                                                         <?= $product["introduction"] ?>
                                                      </p>
                                                      <textarea placeholder="introduction" value="<?= $product["introduction"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="introEdit"><?= $product["introduction"] ?></textarea>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="col-6 ps-3">
                                             <!-- Details -->
                                             <h5>Details</h5>
                                             <ul class="list-unstyled pe-3">
                                                <?php if ($product["product_category_id"] == 1) : ?>
                                                   <li class="">
                                                      <span id="brandText<?= $product["product_id"] ?>">
                                                         Brand : <?= $product["brand"] ?>
                                                      </span>
                                                      <input placeholder="brand" value="<?= $product["brand"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="brandEdit">
                                                   </li>
                                                   <li class="">
                                                      <span id="sizeText<?= $product["product_id"] ?>">
                                                         Size : <?= $product["size"] ?>
                                                      </span>
                                                      <input placeholder="Size" value="<?= $product["size"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="sizeEdit">
                                                   </li>
                                                   <li class="">
                                                      <span id="topText<?= $product["product_id"] ?>">
                                                         Top : <?= $product["top"] ?>
                                                      </span>
                                                      <input placeholder="Top" value="<?= $product["top"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="topEdit">
                                                   </li>
                                                   <li class="">
                                                      <span id="basText<?= $product["product_id"] ?>">
                                                         BAS : <?= $product["back_and_sides"] ?>
                                                      </span>
                                                      <input placeholder="BAS" value="<?= $product["back_and_sides"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="basEdit">
                                                   </li>
                                                   <li class="">
                                                      <span id="neckText<?= $product["product_id"] ?>">
                                                         Neck : <?= $product["neck"] ?>
                                                      </span>
                                                      <input placeholder="Neck" value="<?= $product["neck"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="neckEdit">
                                                   </li>
                                                   <li class="">
                                                      <span id="fingerText<?= $product["product_id"] ?>">
                                                         FB : <?= $product["fingerboard"] ?>
                                                      </span>
                                                      <input placeholder="Fingerboard" value="<?= $product["fingerboard"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="fingerEdit">
                                                   </li>
                                                <?php elseif ($product["product_category_id"] == 2) : ?>
                                                   <ul class="list-unstyled">
                                                      <li class="">
                                                         <span id="brandText<?= $product["product_id"] ?>">
                                                            Brand : <?= $product["brand"] ?>
                                                         </span>
                                                         <input placeholder="Brand" value="<?= $product["brand"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="brandEdit">
                                                      </li>
                                                      <li class="">
                                                         <span id="sizeText<?= $product["product_id"] ?>">
                                                            Size : <?= $product["size"] ?>
                                                         </span>
                                                         <input placeholder="Size" value="<?= $product["size"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="sizeEdit">
                                                      </li>
                                                   </ul>
                                                <?php elseif ($product["product_category_id"] == 3) : ?>
                                                   <ul class="list-unstyled">
                                                      <li class="">
                                                         <span id="brandText<?= $product["product_id"] ?>">
                                                            Brand : <?= $product["brand"] ?>
                                                         </span>
                                                         <input placeholder="Brand" value="<?= $product["brand"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="brandEdit">
                                                      </li>
                                                      <li class="">
                                                         <span id="bowText<?= $product["product_id"] ?>">
                                                            bow : <?= $product["bow"] ?>
                                                         </span>
                                                         <input placeholder="Bow" value="<?= $product["bow"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="bowEdit">
                                                      </li>
                                                   </ul>
                                                <?php elseif ($product["product_category_id"] == 4) : ?>
                                                   <ul class="list-unstyled">
                                                      <li class="">
                                                         <span id="brandText<?= $product["product_id"] ?>">
                                                            Brand : <?= $product["brand"] ?>
                                                         </span>
                                                         <input placeholder="Brand" value="<?= $product["brand"] ?>" type="text" class="form-control toggle-input" data-product-id="<?= $product["product_id"] ?>" name="brandEdit">
                                                      </li>
                                                   </ul>
                                                <?php endif; ?>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Edit btn -->
                                 <div class="editBtnArea d-flex justify-content-between align-items-start position-absolute fixed-top">
                                    <!-- Check -->
                                    <button class="checkBtn border-0 bg-white bi bi-check2 fs-3 px-3 p-2 pb-1" data-product-id="<?= $product["product_id"] ?>" type="submit"></button>
                                    <!-- Edit -->
                                    <i class="editBtn border-0 bg-white bi bi-pencil fs-4 px-3 p-2" id="fileEdit<?= $product["product_id"] ?>" data-product-id="<?= $product["product_id"] ?>"></i>

                                    <!-- Delete -->
                                    <i class="deleteBtn bi border-0 bg-white bi-trash3 text-danger fs-4 px-3 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $product["product_id"] ?>"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal<?= $product["product_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title"><?= $product["name"] ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                              Delete?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a href="./product-delete.php?product_id=<?= $product["product_id"] ?>" type="button" class="btn btn-danger">Delete</a>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         </main>
         <footer class="py-3 bg-light mt-auto">
            <div class="container-fluid px-4">
               <div class="d-flex align-items-center justify-content-end small">
                  <div class="text-muted">Copyright &copy; ELEGANZA Studio 2024</div>
               </div>
            </div>
         </footer>
      </div>
   </div>

   <script>
      $(document).ready(function() {
         // 事件代理，監聽 document 上的點擊事件
         $(document).on("focus", ".toggle-input", function(event) {
            // 阻止事件冒泡
            event.stopPropagation();
         });

         // 其他點擊事件處理程序
         $(".editBtn").click(function(event) {
            // 阻止事件冒泡
            event.stopPropagation();

            const productId = $(this).data("product-id");
            const inputElements = $(`.toggle-input[data-product-id="${productId}"]`);
            const spanElements = $(`[id^="brandText${productId}"], [id^="sizeText${productId}"], [id^="topText${productId}"], [id^="basText${productId}"], [id^="neckText${productId}"], [id^="fingerText${productId}"], [id^="bowText${productId}"], [id^="nameText${productId}"], [id^="numText${productId}"], [id^="introText${productId}"], [id^="priceText${productId}"], [id^="statusText${productId}"]`);

            inputElements.toggle();
            spanElements.toggle();
         });

         $(".uploadBtn").click(function(event) {
            // 阻止事件冒泡
            event.stopPropagation();

            $("#" + this.id.replace("uploadBtn", "fileInput")).click();
         });
         $(".accordion-button").click(function(event) {
            // 阻止事件冒泡
            event.stopPropagation();
         });
      });


      //delete img
      $(document).ready(function() {
         $(document).on("click", ".delete-btn", function(event) {
            console.log("click");


            // 獲取圖片 ID 和相關信息
            const imgId = $(this).data("img-id");
            const href = $(this).data("href");
            const method = $(this).data("method");

            $.ajax({
               url: "./product-delete.php",
               type: "POST",
               data: {
                  img_id: imgId
               }, // 將圖片 ID 傳遞給後端
               success: function(response) {
                  // 在這裡處理後端返回的結果
                  console.log(response);
                  if (response.success) {
                     $(`.delete-btn[data-img-id="${imgId}"]`).closest('.position-relative').remove();
                  }
               },
               error: function(error) {
                  console.error(error);
               }
            });
         });
      });
   </script>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   <script src="../js/scripts.js"></script>
</body>

</html>