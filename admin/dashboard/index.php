<?php
  session_start();
  include "../../php/Controller/HandleStaff.php";
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
</head>

<body>
  <div class="modal" id="addModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thêm Sản Phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="text" name="" id="" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success">Thêm</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Sửa Loại Hàng Hóa</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="text" name="" id="" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success">Sửa</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-2 bg-dark sidebar p-2">
        <div class="sidebar-sticky">
          <h1 class="text-center text-primary">ShopPlus</h1>
          <ul class="nav flex-column">
            <li class="nav-item btn-lg bg-primary"><a href="" class="d-block pl-2 text-white"><i class="fas fa-home"></i><span class="ml-2">Dashboard</span></a></li>
            <li class="nav-item btn-lg"><a href="../order" class="d-block pl-2 text-white"><i class="fas fa-file"></i><span class="ml-2">Orders</span></a></li>
            <li class="nav-item btn-lg"><a href="../product" class="d-block pl-2 text-white"><i class="fas fa-shopping-cart"></i><span class="ml-2">Products</span></a></li>
            <li class="nav-item btn-lg"><a href="../category" class="d-block pl-2 text-white"><i class="fas fa-list-ul"></i><span class="ml-2">Category</span></a></li>
            <li class="nav-item btn-lg"><a href="" class="d-block pl-2 text-white"><i class="fas fa-user"></i><span class="ml-2">Customers</span></a></li>
            <li class="nav-item btn-lg"><a href="" class="d-block pl-2 text-white"><i class="fas fa-user-tie"></i><span class="ml-2">Staffs</span></a></li>
          </ul>
        </div>
      </div>
      <div role="main" class="col-xl-10 sidebar-content container-fluid p-2">
      </div>
    </div>
  </div>
</body>

</html>