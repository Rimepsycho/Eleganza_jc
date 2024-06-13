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
    <title>新增折扣-Eleganza</title>
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
                    <h1 class="mt-4">新增折扣</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="../index.php">總覽</a></li>
                        <li class="breadcrumb-item"><a class="nav-link link-primary" href="discounts.php">折扣管理</a></li>
                        <li class="breadcrumb-item mx-3 active">新增折扣</li>
                    </ol>
                    <div class="card py-3 px-5">
                        <table class="table table-width">
                            <tr>
                                <th><label for="form-label">優惠券活動名稱</label></th>
                                <td><input type="text" for="form-control" id="main"></td>
                            </tr>
                            <tr>
                                <th><label for="form-label">序號</label></th>
                                <td><input type="text" for="form-control" id="serial_number">
                                    <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" class="btn btn-secondary mx-3">隨機序號</button>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body my-3">
                                            <div class="d-flex align-items-center">
                                                <div class="mx-3">序號開頭</div>
                                                <div><input type="text" id="number" class="nmuber"></div>
                                                <div class="mx-3">序號長度</div>
                                                <div><select name="" id="no">
                                                        <option value="8">8</option>
                                                        <option value="10" selected>10</option>
                                                        <option value="15">15</option>
                                                    </select></div>
                                                <button class="btn btn-secondary mx-3" id="random">隨機產生</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="form-label">種類</label></th>
                                <td><select id="type">
                                        <option value="0" selected disabled></option>
                                        <option value="金額">金額</option>
                                        <option value="百分比">百分比</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <th><label for="form-label">折扣</label></th>
                                <td><input type="number" for="form-control" id="amount"></td>
                            </tr>
                            <tr>
                                <th><label for="form-label">優惠券數量</label></th>
                                <td><input type="number" for="form-control" id="num">
                            </tr>
                            </td>
                            <tr>
                                <th><label for="form-label">最低消費限制</label></th>
                                <td><input type="number" for="form-control" id="low_consumption"></td>
                            </tr>
                            <tr>
                                <th><label for="form-label">併用限制</label></th>
                                <td><input type="text" for="form-control" id="restriction"></td>
                            </tr>
                            <tr>
                                <th>開始時間</th>
                                <td><input for="form-control" id="start_date" type="date" value="<?= $start_date ?>">
                                    <input type="time" for="form-contorl" id="start_time" type="time">
                                </td>
                            </tr>
                            <tr>
                                <th>結束時間</th>
                                <td><input for="form-control" id="end_date" type="date">
                                    <input type="time" for="form-contorl" id="end_time" type="time">
                                </td>
                            </tr>
                        </table>
                        <div>
                            <a href="discounts.php" class="mx-3 btn btn-secondary">取消</a>
                            <button type="button" id="send" class="btn btn-outline-primary">新增優惠券</button>
                            <label for="" id="success"></label>
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
    <script>
        const main = document.querySelector("#main"),
            serial_number = document.querySelector("#serial_number"),
            type = document.querySelector("#type"),
            amount = document.querySelector("#amount"),
            num = document.querySelector("#num"),
            low_consumption = document.querySelector("#low_consumption"),
            restriction = document.querySelector("#restriction"),
            start_date = document.querySelector("#start_date"),
            start_time = document.querySelector("#start_time"),
            end_date = document.querySelector("#end_date"),
            end_time = document.querySelector("#end_time");
        const send = document.querySelector("#send");
        const random = document.querySelector("#random");
        const no = document.querySelector("#no"),
            number = document.querySelector("#number");
        const success = document.querySelector("#success");

        send.addEventListener("click", function() {
            mainVal = main.value;
            serial_numberVal = serial_number.value;
            typeVal = type.value;
            amountVal = amount.value;
            numVal = num.value;
            low_consumptionVal = low_consumption.value;
            restrictionVal = restriction.value;
            start_dateVal = start_date.value;
            start_timeVal = start_time.value;
            end_dateVal = end_date.value;
            end_timeVal = end_time.value;

            $.ajax({
                    method: "POST", //or GET
                    url: "doAdddiscount.php",
                    dataType: "json",
                    data: {
                        main: mainVal,
                        serial_number: serial_numberVal,
                        type: typeVal,
                        amount: amountVal,
                        num: numVal,
                        low_consumption: low_consumptionVal,
                        restriction: restrictionVal,
                        start_date: start_dateVal,
                        start_time: start_timeVal,
                        end_date: end_dateVal,
                        end_time: end_timeVal
                    } //如果需要
                })
                .done(function(response) {
                    if (response.status == 0) {
                        alert(response.message);
                        return;
                    }
                    if (response.status == 1) {
                        // alert(response.message);
                        alert("新增折扣" + mainVal + "成功!");
                        window.location.replace("discounts.php");
                    }


                }).fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
        })

        random.addEventListener("click", function() {
            let data = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
            let str = "";
            let l_number = number.value.length;
            let n = 0;
            if (l_number == 0)
                n = no.value;
            else {
                n = no.value - l_number;
                str += number.value;
            }

            // console.log(l_no);
            for (let i = 0; i < n; i++) {
                let r = parseInt(Math.random() * 31)
                str += data[r];
            }
            serial_number.value = str;
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>