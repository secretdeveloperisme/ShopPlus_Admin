<?php
  header('Content-Type: application/json');
  if(isset($_GET["action"])&&!empty($_GET["action"])){
    include("../../Controller/HandleProduct.php");
    if($_GET["action"] == "getAllProducts"){
      echo json_encode(getAllProductWithLimit(1,100));
    }
    if($_GET["action"] == "getProductViaId" && isset($_GET["id"])&& !empty($_GET["id"])){
      echo json_encode(getProductViaID($_GET["id"])->toArray());
    }
  }
  if(isset($_POST["action"])&&!empty($_POST["action"])){
    include("../../Controller/HandleProduct.php");
    if($_POST["action"] == "addProduct"){
      if(isset($_POST["name"])&&!empty($_POST["name"])){
        if(isset($_POST["amount"])&&!empty($_POST["amount"])){
          if(isset($_POST["unit"])&&!empty($_POST["unit"])){
            if(isset($_POST["price"])&&!empty($_POST["price"])){
              if(isset($_POST["categoryID"])&&!empty($_POST["categoryID"])){
                $targetDir = "/ShopPlus_Customer/assets/images/products/";
                $targetFile  = $targetDir.basename($_FILES["imageAddProduct"]["name"]);
                $statusUpload = 1;
                if (file_exists($targetFile)) {
                  $statusUpload = 0;
                }
                if($statusUpload == 1)
                  if(move_uploaded_file($_FILES["imageAddProduct"]["tmp_name"],$_SERVER['DOCUMENT_ROOT'].$targetFile)){
                    echo json_encode(insertProduct(new Merchandise(0,$_POST["name"],$targetFile,$_POST["unit"],$_POST["price"],$_POST["amount"],$_POST["categoryID"],"")));
                  }
              }
            }
          }
        }
      }
    }
  }

?>