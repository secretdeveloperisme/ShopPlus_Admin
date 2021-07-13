<?php
  session_start();
  include_once "../../php/Controller/HandleStaff.php";
  $staff = getStaffViaID($_SESSION["id"]);
  $amountOfProduct = $amountOfCustomer = $amountOfNewOrder = 0;

  $result = $GLOBALS["connect"]->query("
        SELECT COUNT(*) as AMOUNT FROM hanghoa
  ");
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $amountOfProduct = $row["AMOUNT"];
  }
  $result = $GLOBALS["connect"]->query("
        SELECT COUNT(*) as AMOUNT FROM khachhang
  ");
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $amountOfCustomer = $row["AMOUNT"];
  }
  $result = $GLOBALS["connect"]->query("
        SELECT COUNT(*) as AMOUNT FROM dathang WHERE TRANGTHAI = 'pending'
  ");
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $amountOfNewOrder = $row["AMOUNT"];
  } 
  $topProducts = array();
  $allProductQuery = "SELECT hanghoa.TENHH AS `NAME`,sum(`chitietdathang`.`SOLUONG`) AS `AMOUNT` FROM `chitietdathang` JOIN hanghoa ON chitietdathang.MSHH = hanghoa.MSHH GROUP BY `chitietdathang`.`MSHH` ORDER BY sum(`chitietdathang`.`SOLUONG`) DESC LIMIT 0, 10 ";
  $result = $GLOBALS["connect"]->query($allProductQuery);
  if($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
      $merchandise = array(
        $row["NAME"],
        $row['AMOUNT']
      );
      array_push($topProducts,$merchandise);
    }
  }  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../assets/css/base.css">
  <title>DashBoard</title>
  <style>
    .bg-c-lite-green {
      background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
      background: linear-gradient(to right, #ee5a6f, #f29263)
    } 
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-2 bg-dark sidebar p-2">
        <div class="sidebar-sticky">
          <h1 class="text-center text-primary">ShopPlus</h1>
          <ul class="nav flex-column">
            <li class="nav-item btn-lg bg-primary"><div class="d-block pl-2 text-white"><i class="fas fa-home"></i><span class="ml-2">Dashboard</span></div></li>
            <li class="nav-item btn-lg"><a href="../order" class="d-block pl-2 text-white"><i class="fas fa-file"></i><span class="ml-2">Orders</span></a></li>
            <li class="nav-item btn-lg"><a href="../product" class="d-block pl-2 text-white"><i class="fas fa-shopping-cart"></i><span class="ml-2">Products</span></a></li>
            <li class="nav-item btn-lg"><a href="../category" class="d-block pl-2 text-white"><i class="fas fa-list-ul"></i><span class="ml-2">Category</span></a></li>
            <li class="nav-item btn-lg"><a href="../customer" class="d-block pl-2 text-white"><i class="fas fa-user"></i><span class="ml-2">Customers</span></a></li>
            <li class="nav-item btn-lg"><a href="../staff" class="d-block pl-2 text-white"><i class="fas fa-user-tie"></i><span class="ml-2">Staffs</span></a></li>
          </ul>
        </div>
      </div>
      <div role="main" class="col-xl-10 sidebar-content container-fluid p-1">
        <div class="profile row p-0 col-10 shadow-sm ml-2 mt-2" style="border-radius: 5px; overflow: hidden;">
          <div class="container-fluid d-flex flex-column align-items-center bg-c-lite-green col-5 p-5">
            <img src="../../assets/images/user.png"  alt="">
            <div><?php echo $staff->getName()?></div>
          </div>
          <div class="container-fluid col-7 pl-3 pr-3">
            <div class="font-weight-bolder">Information</div>
            <div class="border-primary" style="border:2px solid"></div>
            <div class="pt-2">
              <div class="font-italic text-primary" >
                Chức Vụ
              </div>
              <div class="ml-3 text-black-50" ><?php echo $staff->getPosition()?></div>
            </div>
            <div class="pt-2">
              <div class="font-italic text-primary" >
                Địa Chỉ: 
              </div>
              <div class="ml-3 text-black-50"><?php echo $staff->getAddress()?></div>
            </div>
            <div class="pt-2">
              <div class="font-italic text-primary" >
                Số Điên Thoại
              </div>
              <div class="ml-3 text-black-50"><?php echo $staff->getPhone()?></div>
            </div>
          </div>
        </div>
        <div class="row p-2 m-0">
          <div class="col-xl-3 text-white">
            <div class="position-relative container-fluid bg-info rounded-lg">
              <div>
              <h1><?php echo $amountOfNewOrder?></h1>
              <h2>new order</h2>
            </div>
            <div class="position-absolute" style="top: 32px; right: 10px;">
              <i class="fas fa-shopping-cart" style="font-size: 50px;"></i>
            </div>
            </div>
          </div>
          <div class="col-xl-3 text-white">
            <div class="position-relative container-fluid bg-success rounded-lg">
              <div>
              <h1><?php echo $amountOfProduct ?></h1>
              <h2>product</h2>
            </div>
            <div class="position-absolute" style="top: 32px; right: 10px;">
              <i class="fas fa-box" style="font-size: 50px;"></i>
            </div>
            </div>
          </div>
          <div class="col-xl-3 text-white">
            <div class="position-relative container-fluid bg-warning rounded-lg">
              <div>
              <h1><?php echo $amountOfCustomer ?></h1>
              <h2>customer</h2>
            </div>
            <div class="position-absolute" style="top: 32px; right: 10px;">
              <i class="fas fa-users" style="font-size: 50px;"></i>
            </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <h1 class="text-center font-weight-bolder text-primary">top 10 sản phẩm bán chạy</h1>
          <ul class="list-group">
            <?php
              foreach ($topProducts as $topProduct){
                $name = $topProduct[0];
                $amount = $topProduct[1];

                echo <<<ABC
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                  {$name}
                  <span class="badge badge-primary badge-pill">{$amount}</span>
                  </li>
                ABC;

              }
            ?>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>

</html>