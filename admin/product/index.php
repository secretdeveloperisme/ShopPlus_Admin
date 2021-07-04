<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../assets/css/base.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="../../js/base.js"></script>
  <script src="../../js/product.js"></script>
  <title>Product</title>
</head>
<body>
  <div id="toast"></div>
  <div class="modal fade" id="addProductModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thêm Sản Phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form class="row" id="formAdd">
            <div class="col-xl-7">
                <div class="form-group">
                  <label for="">Tên Hàng Hóa</label>
                  <input type="text" name="name" id="nameAddProduct" class="form-control">
                </div>
                <select id="unitAddProduct" name="unit" class="custom-select mb-3">
                  <option selected value="">Quy Cách</option>
                  <option value="Quyễn">Quyễn</option>
                  <option value="Cái">Cái</option>
                  <option value="Hộp">Hộp</option>
                </select>
                <div class="input-group form-group">
                  <input type="number" name="price" id="priceAddProduct" class="form-control" placeholder="Giá Sản Phẩm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">đ</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Số Lượng</label>
                  <input type="number" name="amount" id="amountAddProduct" class="form-control">
                </div>
            </div>
            <div class="col-xl-5 ">
              <div class="form-group">
                <label for="">Mô Tả</label>
                <textarea name="description" id="descriptionAddProduct" class="form-control" ></textarea>
              </div>
              <select name="categoryID" id="categoryAddProduct" class="custom-select mb-3">
                <option value="">Loại Hàng</option>
              </select>
              <div class="form-group">
                <div class="custom-file mb-3">
                  <input type="file" name="imageAddProduct" class="custom-file-input" accept="image/*" id="imgFile">
                  <label class="custom-file-label" for="imgFile">Chọn Hình ảnh</label>
                </div>
                <img class="border-danger img-thumbnail" id="displayImgFile" style="width: 128px; height: 128px; object-fit: contain;">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnAddProduct">Thêm</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editProductModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Sửa Sản Phẩm</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" id="editForm" class="modal-body">
          <div class="row">
            <div class="col-xl-7">
              <div class="form-group">
                <label for="">Tên Hàng Hóa</label>
                <input type="text" name="name" id="nameEditProduct" class="form-control">
              </div>
              <select id="unitEditProduct" name="unit" class="custom-select mb-3">
                <option selected value="">Quy Cách</option>
                <option value="quyễn">Quyễn</option>
                <option value="cái">Cái</option>
                <option value="hộp">Hộp</option>
              </select>
              <div class="input-group form-group">
                <input type="number" name="price" id="priceEditProduct" class="form-control" placeholder="Giá Sản Phẩm">
                <div class="input-group-prepend">
                  <span class="input-group-text">đ</span>
                </div>
              </div>
              <div class="form-group">
                <label for="amountEditProduct">Số Lượng</label>
                <input type="number" name="amount" id="amountEditProduct" class="form-control">
              </div>
            </div>
            <div class="col-xl-5">
              <div class="form-group">
                <label for="">Mô Tả</label>
                <textarea name="description" id="descriptionEditProduct" class="form-control"></textarea>
              </div>
              <select name="categoryID" id="categoryEditProduct" class="custom-select mb-3">
                <option value="">Loại Hàng</option>
              </select>
              <div class="form-group">
                <div class="custom-file mb-3">
                  <input type="file" class="custom-file-input" name="imgEditProduct" accept="image/*" id="imgFileEditProduct">
                  <label class="custom-file-label" for="imgFileEditProduct">Chọn Hình ảnh</label>
                </div>
                <img class="border-danger img-thumbnail" id="displayEditImgFile" style="width: 128px; height: 128px; object-fit: contain;">
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" id="btnCommitEdit" class="btn btn-success">Sửa</button>
          <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
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
            <li class="nav-item btn-lg bg-primary"><div" class="d-block pl-2 text-white"><i class="fas fa-shopping-cart"></i><span class="ml-2">Products</span></a></li>
            <li class="nav-item btn-lg"><a href="../category" class="d-block pl-2 text-white"><i class="fas fa-list-ul"></i><span class="ml-2">Category</span></a></li>
            <li class="nav-item btn-lg"><a href="../customer" class="d-block pl-2 text-white"><i class="fas fa-user"></i><span class="ml-2">Customers</span></a></li>
            <li class="nav-item btn-lg"><a href="../staff" class="d-block pl-2 text-white"><i class="fas fa-user-tie"></i><span class="ml-2">Staffs</span></a></li>
          </ul>
        </div>
      </div>
      <div role="main" class="col-xl-10 sidebar-content container-fluid p-2">
        <div class="header d-flex justify-content-between">
          <h1>Product</h1>
          <div class="btn-group">
            <button type="button" id="btnAddCategory" data-toggle="modal" data-target="#addProductModal" class="btn bg-primary text-white"><i class="fas fa-plus"></i> ADD</button>
            <button id="btnDeleteProduct" class="btn bg-danger text-white"><i class="fas fa-minus"></i> DELETE</button>
          </div>
        </div>
        <table class="table table-striped table-hover mt-2 " id="productTable">
          <thead class="bg-primary text-light">
            <tr>
              <th scope="col">Check</th>
              <th scope="col">Mã</th>
              <th scope="col">Tên Hàng Hóa</th>
              <th scope="col">Hình Ảnh</th>
              <th scope="col">Quy Cách</th>
              <th scope="col">Giá</th>
              <th scope="col">Số Lượng</th>
              <th scope="col">Loại Hàng</th>  
              <th scope="col">Edit</th> 
            </tr>
          </thead>
            <tbody>
            </tbody>

        </table>
      </div>
    </div>
  </div>
</body>
</html>