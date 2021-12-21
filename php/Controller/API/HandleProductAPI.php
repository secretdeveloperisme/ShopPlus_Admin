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
                $isExistFile = 0;
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$targetFile)) {
                  $isExistFile = 1;
                }
                if($isExistFile == 0){
                  if(move_uploaded_file($_FILES["imageAddProduct"]["tmp_name"],$_SERVER['DOCUMENT_ROOT'].$targetFile)){
                    $isExistFile = 1; 
                  }
                }
                if($isExistFile == 1)
                  echo json_encode(insertProduct(new Merchandise(0,$_POST["name"],$targetFile,$_POST["unit"],$_POST["price"],$_POST["amount"],$_POST["categoryID"],$_POST["description"])));
                else
                  echo false;

                }
              }
            }
          }
        }
    }
    if ($_POST["action"] == "deleteProduct" && isset($_POST["productID"]) && !empty($_POST["productID"])){
      echo json_encode(deleteProduct($_POST["productID"]));
    }
    if($_POST["action"] == "updateProduct"){
      if(isset($_POST["id"])&&!empty($_POST["id"])){
        if(isset($_POST["name"])&&!empty($_POST["name"])){
          if(isset($_POST["amount"])&&!empty($_POST["amount"])){
            if(isset($_POST["unit"])&&!empty($_POST["unit"])){
              if(isset($_POST["price"])&&!empty($_POST["price"])){
                if(isset($_POST["categoryID"])&&!empty($_POST["categoryID"])){
                  if(!empty($_FILES["imgEditProduct"]["name"]))
                  {
                    $targetDir ="/ShopPlus_Customer/assets/images/products/";
                    $targetFile  = $targetDir.basename($_FILES["imgEditProduct"]["name"]);
                    $isExistFile = 0;
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$targetFile)) {
                      $isExistFile = 1;
                    }
                    if($isExistFile == 0){
                      if(move_uploaded_file($_FILES["imgEditProduct"]["tmp_name"],$_SERVER['DOCUMENT_ROOT'].$targetFile)){
                        $isExistFile = 1; 
                      }
                    }
                    if($isExistFile == 1)
                      echo json_encode(updateProduct(new Merchandise($_POST["id"],$_POST["name"],$targetFile,$_POST["unit"],$_POST["price"],$_POST["amount"],$_POST["categoryID"],$_POST["description"])));
                    else
                      echo false;
                  }
                }
              }
            }
          }
        }
      }
    }
  }

?>