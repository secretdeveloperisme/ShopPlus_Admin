<?php
  session_start();
  if(isset($_POST["userName"])){
    include "php/Controller/HandleStaff.php";
    $valid = isExistStaff($_POST["userName"]);
    if($valid == true){
        $_SESSION["id"] = $_POST["userName"];
        header("Location: admin/dashboard/index.html");
    }
  }
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/base.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="js/base.js"></script>
  <title>Đăng Nhập</title>
</head>
<body class="h-100">
  <div id="toast"></div>
  <div class="login container-fluid d-flex flex-column h-100">
    <h1 class="text-primary text-center display-1 font-weight-bolder">Shop Plus Admin</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="login-form was-validated ml-auto mr-auto w-25 d-flex flex-column align-items-center">
      <h1>Đăng Nhập</h1>
      <div class="form-group mb-3 d-flex flex-column w-100">
        <label for="userName" class="">Mã số Nhân Viên</label>
        <input type="text" name="userName" id="userName" class="form-control" required> 
        <div class="valid-feedback">Valid.</div>
        <div class="invalid-feedback">Please fill out this field.</div>
      </div>
      <div class="form-group mb-3 d-flex w-500 flex-column w-100">
        <label for="password">Mật Khẩu</label>
        <input type="text" name="password" id="password" class="form-control" disabled> 
      </div>
      <button class="btn btn-primary w-50 ">Đăng Nhập</button>
    </form>
  </div>
  <script>
    <?php
       if(isset($_POST["userName"]))
         if($valid == false){
           echo <<<SCRIPT
             toast({
             title : "Thất Bại",
             message : "Bạn Đã Sai Username Hoặc Password",
             type : "error",
             duration : 4000
           })
           SCRIPT;
      }
    ?>
  </script>
</body>
</html>