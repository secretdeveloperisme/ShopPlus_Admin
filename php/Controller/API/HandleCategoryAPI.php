<?php
  if(isset($_GET["action"]) && !empty($_GET["action"])){
    include("../../Controller/HandleCategory.php");
    if ($_GET["action"] == "getAllCategories"){
      echo json_encode(getAllCategories());
    }
    if ($_GET["action"] == "getNumberOfCategory"){
      echo json_encode(getNumberOfCategory());
    }
  }
  if(isset($_POST["action"]) && !empty($_POST["action"])){
    include("../../Controller/HandleCategory.php");
    if ($_POST["action"] == "insertCategory" && isset($_POST["categoryID"]) && !empty($_POST["categoryID"])){
      if((isset($_POST["categoryName"])&&!empty($_POST["categoryName"]))){
        echo json_encode(insertCategory(new Category(0,$_POST["categoryName"],$_POST["categoryID"])));
      }
    }
    if ($_POST["action"] == "deleteCategory" && isset($_POST["categoryID"]) && !empty($_POST["categoryID"])){
      echo json_encode(deleteCategory(new Category($_POST["categoryID"],"")));
    }
    if ($_POST["action"] == "updateCategory" && isset($_POST["categoryID"]) && !empty($_POST["categoryID"])){
      if((isset($_POST["categoryName"])&&!empty($_POST["categoryName"]))){
        echo json_encode(updateCustomerAddress(new Category($_POST["categoryName"],$_POST["categoryName"])));
      }
    }
  }
?>