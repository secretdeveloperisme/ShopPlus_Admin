<?php
    session_start();
    if(!isset($_SESSION["id"])){
        header("Location: /ShopPlus_Admin");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../assets/css/base.css">
  <link rel="stylesheet" href="../../assets/css/base.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../../js/base.js"></script>
  <script src="../../js/category.js"></script>
  <title>DashBoard</title>
</head>
<body>
  <div id="toast"></div>
  <div class="modal" id="addModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thêm Sản Phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="text" name="" id="inputDataCategory" class="form-control" placeholder="Nhập Tên Loại Hàng">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnAddCategory">Thêm</button>
          <button type="button" class="btn btn-danger"  data-dismiss="modal">Close</button>
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
          <input type="text" name="" id="inputEditDataCategory" class="form-control" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnCommitEdit">Sửa</button>
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
            <li class="nav-item btn-lg"><a href="../dashboard" class="d-block pl-2 text-white"><i class="fas fa-home"></i><span class="ml-2">Dashboard</span></a></li>
            <li class="nav-item btn-lg"><a href="../order" class="d-block pl-2 text-white"><i class="fas fa-file"></i><span class="ml-2">Orders</span></a></li>
            <li class="nav-item btn-lg"><a href="../product" class="d-block pl-2 text-white"><i class="fas fa-shopping-cart"></i><span class="ml-2">Products</span></a></li>
            <li class="nav-item btn-lg bg-primary"><div class="d-block pl-2 text-white"><i class="fas fa-list-ul"></i><span class="ml-2">Category</span></div></li>
            <li class="nav-item btn-lg"><a href="../customer" class="d-block pl-2 text-white"><i class="fas fa-user"></i><span class="ml-2">Customers</span></a></li>
            <li class="nav-item btn-lg"><a href="../staff" class="d-block pl-2 text-white"><i class="fas fa-user-tie"></i><span class="ml-2">Staffs</span></a></li>
          </ul>
        </div>
      </div>
      <div role="main" class="col-xl-10 sidebar-content container-fluid p-2">
        <div class="header d-flex justify-content-between">
          <h1>Category</h1>
          <div class="btn-group">
            <button type="button" id="btnAddCategory" data-toggle="modal" data-target="#addModal" class="btn bg-primary text-white"><i class="fas fa-plus"></i> ADD</button>
            <button class="btn bg-danger text-white" id="btnDeleteCategory"s><i class="fas fa-minus"></i> DELETE</button>
          </div>
        </div>
        <table class="table table-striped table-hover" id="categoryTable">
          <thead class="bg-primary text-white">
            <tr>
              <th scope="col">Check</th>
              <th scope="col">Mã Loại Hàng</th>
              <th scope="col">Tên Loại Hàng</th>
              <th scope="col">Edit</th>
            </tr>
          </thead>
            <tbody>
              <tr>
                <td scope="row"><input type="checkbox" class="custom-checkbox"></td>
                <th>1</th>
                <td>máy tính</td>
                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal">edit</button></td>
              </tr>
            </tbody
        </table>
      </div>
    </div>
  </div>
</body>
</html>