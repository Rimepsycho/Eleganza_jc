<?php
session_start();
if (!isset($_SESSION["user"]))
    header("location: ../login.php");

require_once("../db_connect.php");

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$filterBy = isset($_GET["filterBy"]) ? $_GET["filterBy"] : "all";
$filterValue = isset($_GET["filterValue"]) ? $_GET["filterValue"] : "";
$orderBy = isset($_GET["orderBy"]) ? $_GET["orderBy"] : "name";
$orderDirection = isset($_GET["orderDirection"]) ? $_GET["orderDirection"] : "asc";

$filterClause = "";
if ($filterBy != "all" && $filterValue != "") {
    if ($filterBy == "name" || $filterBy == "cancel_date") {
        $filterClause = "AND DATE(`$filterBy`) = '$filterValue'";
    } else {
        $filterClause = "AND `$filterBy` LIKE '%$filterValue%'";
    }
}
$sql = "SELECT `product`.*, `product_category`.*, `product_category_groups`.*
        FROM `product`
        JOIN `product_category` ON `product`.`product_category_id` = `product_category`.`product_category_id`
        LEFT JOIN `product_category_groups` ON `product`.`group_id` = `product_category_groups`.`group_id`
        WHERE (`product`.`name` LIKE '%$search%' OR 
               `product`.`brand` LIKE '%$search%' OR 
               `product`.`price` LIKE '%$search%' OR 
               `product`.`product_category_id` LIKE '%$search%') 
               $filterClause
        ORDER BY $orderBy $orderDirection";



$result = $conn->query($sql);
$userCount = $result->num_rows;
if (isset($_GET["reset"])) {
    $search = "";
    $filterValue = "";
    $sql = "SELECT * FROM `product`";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
}
$sql = "SELECT `product`.*, `product_category`.*
        FROM `product`
        JOIN `product_category` ON `product`.`product_category_id` = `product_category`.`product_category_id`";

$query = "SELECT * FROM product_category_groups";
$groupStatement = $conn->query($query);
$groups = $groupStatement->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM product_category";
$categoryResult = $conn->query($query);
$categories = $categoryResult->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM product";
$productResult = $conn->query($query);
$products = $productResult->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['create_group']) && isset($_POST['group_name'])) {
        $groupName = $_POST['group_name'];

        $existingGroups = array_column($groups, 'group_name');
        if (in_array($groupName, $existingGroups)) {
            echo "群組名稱已存在，請選擇其他名稱。";
        } else {

            $insertQuery = "INSERT INTO product_category_groups (group_name) VALUES (?)";
            $insertStatement = $conn->prepare($insertQuery);
            $insertStatement->bind_param('s', $groupName);
            $insertStatement->execute();
        }
    } elseif (isset($_POST['delete_group']) && isset($_POST['group_id'])) {
        $groupId = $_POST['group_id'];

        $deleteQuery = "DELETE FROM product_category_groups WHERE group_id = ?";
        $deleteStatement = $conn->prepare($deleteQuery);
        $deleteStatement->bind_param('i', $groupId);
        $deleteStatement->execute();
    } elseif (isset($_POST['rename_group']) && isset($_POST['group_id']) && isset($_POST['new_group_name'])) {
        $groupId = $_POST['group_id'];
        $newGroupName = $_POST['new_group_name'];

        $updateQuery = "UPDATE product_category_groups SET group_name = ? WHERE group_id = ?";
        $updateStatement = $conn->prepare($updateQuery);
        $updateStatement->bind_param('si', $newGroupName, $groupId);
        $updateStatement->execute();
    } elseif (isset($_POST['add_to_group']) && isset($_POST['product_id']) && isset($_POST['group_id'])) {
        $productId = $_POST['product_id'];
        $groupId = $_POST['group_id'];

        $updateQuery = "UPDATE product SET group_id = ? WHERE product_id = ?";
        $updateStatement = $conn->prepare($updateQuery);
        $updateStatement->bind_param('ii', $groupId, $productId);
        $updateStatement->execute();
    } elseif (isset($_POST['remove_from_group']) && isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        $updateQuery = "UPDATE product SET group_id = NULL WHERE product_id = ?";
        $updateStatement = $conn->prepare($updateQuery);
        $updateStatement->bind_param('i', $productId);
        $updateStatement->execute();
    }
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>商品群組-Eleganza</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
                    <h1 class="mt-4">商品群組</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item active">商品群組</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">已有群組名稱
                            <ul class="list-unstyled">
                                <?php foreach ($groups as $group) : ?>
                                    <li><?= $group['group_name'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div>群組操作
                        <form method="post">
                            <label for="group_name">建立群組：</label>
                            <input type="text" name="group_name" required>
                            <button class="btn" type="submit" name="create_group"><i class="text-secondary fa-solid fa-plus"></i></button>
                        </form>

                        <form method="post">
                            <label for="group_id">刪除群組：</label>
                            <select name="group_id" required>
                                <option value="">選擇群組</option>
                                <?php foreach ($groups as $group) : ?>
                                    <option value="<?= $group['group_id'] ?>"><?= $group['group_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn" type="submit" name="delete_group"><i class="text-secondary fa-solid fa-trash"></i></button>
                        </form>
                        <form method="post">
                            <label for="group_id">重新命名群組：</label>
                            <select name="group_id" required>
                                <option value="">選擇群組</option>
                                <?php foreach ($groups as $group) : ?>
                                    <option value="<?= $group['group_id'] ?>"><?= $group['group_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="new_group_name">新群組名稱：</label>
                            <input type="text" name="new_group_name" required>
                            <button class="btn" type="submit" name="rename_group"><i class="text-secondary fa-solid fa-pen"></i></button>
                        </form>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            商品群組列表
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div>
                                    <input type="search" class="col" placeholder="搜尋" aria-label="就是搜尋" aria-describedby="button-addon2" name="search" value="<?= htmlspecialchars($search) ?>">
                                </div>
                                <div>
                                    <select name="filterBy">
                                        <option value="all">---詳細篩選---</option>
                                        <option value="name" <?= ($filterBy == "name") ? "selected" : "" ?>>名稱</option>
                                        <option value="price" <?= ($filterBy == "price") ? "selected" : "" ?>>價錢</option>
                                        <option value="product_category_id" <?= ($filterBy == "product_category_id") ? "selected" : "" ?>>類型</option>
                                        <option value="brand" <?= ($filterBy == "brand") ? "selected" : "" ?>>廠商</option>
                                        <option value="group_name" <?= ($filterBy == "group_name") ? "selected" : "" ?>>群組</option>
                                    </select>
                                    <input type="text" name="filterValue" placeholder="搜尋" value="<?= htmlspecialchars($filterValue) ?>">
                                </div>
                                <div>
                                    <button type="submit" id="button-addon2" class="btn btn-outline-primary">搜尋</button>
                                    <button type="submit" name="reset" class="btn btn-secondary">重置</button>
                                    <select class="" name="orderBy">
                                        <option value="name" <?= ($orderBy == "name") ? "selected" : "" ?>>名稱</option>
                                        <option value="price" <?= ($orderBy == "price") ? "selected" : "" ?>>價錢</option>
                                        <option value="product_category_id" <?= ($orderBy == "product_category_id") ? "selected" : "" ?>>類型</option>
                                        <option value="brand" <?= ($orderBy == "brand") ? "selected" : "" ?>>廠商</option>
                                        <option value="group_name" <?= ($orderBy == "group_name") ? "selected" : "" ?>>群組</option>
                                    </select>
                                    <select class="" name="orderDirection">
                                        <option value="asc" <?= ($orderDirection == "asc") ? "selected" : "" ?>>遞增</option>
                                        <option value="desc" <?= ($orderDirection == "desc") ? "selected" : "" ?>>遞減</option>
                                    </select>
                                </div>
                            </form>
                            <table class="datatable-table" id="order">
                                <thead>
                                    <tr>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                名稱
                                            </a>
                                        </th>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                價錢
                                            </a>
                                        </th>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                類型
                                            </a>
                                        </th>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                廠商
                                            </a>
                                        </th>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                群組
                                            </a>
                                        </th>
                                        <th data-sortable="true" style="width:15%;" style="width: 15.004840271055178%;">
                                            <a href="#">
                                                群組操作
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                                    foreach ($rows as $product) :
                                    ?>
                                        <tr>
                                            <td><?= $product["name"] ?></td>
                                            <td><?= $product["price"] ?></td>
                                            <td>
                                                <?php
                                                $category_id = $product["product_category_id"];
                                                $category_name = "";

                                                if ($category_id == 1) {
                                                    $category_name = "小提琴";
                                                } elseif ($category_id == 2) {
                                                    $category_name = "小提琴盒";
                                                } elseif ($category_id == 3) {
                                                    $category_name = "提琴弓";
                                                } elseif ($category_id == 4) {
                                                    $category_name = "松香";
                                                } elseif ($category_id == 5) {
                                                    $category_name = "譜架";
                                                }
                                                echo $category_name;
                                                ?>
                                            </td>
                                            <td><?= $product["brand"] ?></td>
                                            <td>
                                                <?php if ($product['group_id'] !== null) : ?>
                                                    <?php
                                                    $group_id = $product['group_id'];
                                                    $group_name = '';
                                                    foreach ($groups as $group) {
                                                        if ($group['group_id'] == $group_id) {
                                                            $group_name = $group['group_name'];
                                                            break;
                                                        }
                                                    }
                                                    echo $group_name;
                                                    ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <form method="post">
                                                    <select name="group_id">
                                                        <option value="">選擇群組</option>
                                                        <?php foreach ($groups as $group) : ?>
                                                            <option value="<?= $group['group_id'] ?>"><?= $group['group_name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                                    <button class="my-2 btn btn-outline-primary" type="submit" name="add_to_group">加入群組</button>
                                                    <button class="btn btn-secondary" type="submit" name="remove_from_group">移出群組</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="datatable-bottom">
                            <div class="datatable-primary">
                                共 <?= $userCount ?> 筆資料
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
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>