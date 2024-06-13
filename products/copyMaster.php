<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- 使用 Bootstrap 5.1.3、jQuery 3.6.0、Popper 2.11.6 版本 -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
   <title>Bootstrap Nested Dropdown Example</title>

</head>

<body>
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
               <li><a class="dropdown-item" href="#" data-filter="<?= $brand ?>" name="<?= $brand ?>"><?= $brand ?></a></li>
            <?php endforeach; ?>
         </ul>
      </li>
      <li class="dropdown dropend">
         <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Category</a>
         <ul class="dropdown-menu">
            <?php foreach ($cateRows as $cate) : ?>
               <li><a class="dropdown-item" href="#" data-filter="<?= $cate["type"] ?>" name="<?= $cate["type"] ?>"><?= $cate["type"] ?></a></li>
            <?php endforeach; ?>
         </ul>
      </li>
      <li class="dropdown dropend">
         <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Status</a>
         <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-filter="ON shelf" neme="ON shelf">ON shelf</a></li>
            <li><a class="dropdown-item" href="#" data-filter="Off shelf" name="Off shelf">OFF shelf</a></li>
         </ul>
      </li>
   </ul>
</body>

</html>