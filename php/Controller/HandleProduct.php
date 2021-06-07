<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Admin/php/models/Merchandise.php");
  include($rootPath."/ShopPlus_Admin/php/ConnectDB.php");
  global $connect;
  $connect = connectDB();
  function getAllProductWithLimit($begin,$end){
    $products = array();
    $allProductQuery = "SELECT * FROM hanghoa LIMIT $begin,$end";
    $result = $GLOBALS["connect"]->query($allProductQuery);
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $merchandise = new Merchandise(
          $row["MSHH"],
          $row['TENHH'],$row["LOCATION"],
          $row["QUYCACH"],$row["GIA"],$row["SOLUONGHANG"],
          $row["MALOAIHANG"],$row["GHICHU"]
        );
        array_push($products,$merchandise->toArray());
      }
      return $products;
    }
  }
  function isExistProduct($id){
    $result = $GLOBALS["connect"]->query("SELECT MSHH FROM hanghoa WHERE MSHH = $id");
    if(($result->num_rows) > 0)
      return true;
    else 
      return false;
  }
  function getProductViaID($id){
    $result = $GLOBALS["connect"]->query(
                                    "SELECT MSHH,TENHH,
                                    LOCATION,QUYCACH,
                                    GIA,SOLUONGHANG,
                                    MALOAIHANG,GHICHU
                                     FROM hanghoa WHERE MSHH= $id");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Merchandise(
        $row["MSHH"],
        $row['TENHH'],$row["LOCATION"],
        $row["QUYCACH"],$row["GIA"],$row["SOLUONGHANG"],
        $row["MALOAIHANG"],$row["GHICHU"]
      );
    }  
    else 
      return null;
  }
function insertProduct($product){
  $prepare = $GLOBALS["connect"]->prepare("INSERT INTO hanghoa( TENHH, LOCATION, QUYCACH, GIA, SOLUONGHANG, MALOAIHANG, GHICHU) VALUES (?,?,?,?,?,?,?)");
  $name = $product->getName();
  $amount = $product->getAmount();
  $location = $product->getLocation();
  $unit = $product->getUnit();
  $price = $product->getPrice();
  $categoryID = $product->getCategoryId();
  $note = $product->getNote();
  $prepare->bind_param("sssiiis",$name,$location,$unit,$price,$amount,$categoryID,$note);
  if($prepare->execute()){
    $prepare->close();
    $GLOBALS["connect"]->close();
    return true;
  }
  else{
    $prepare->close();
    $GLOBALS["connect"]->close();
    return false;
  }
}
function updateProduct($product){
  $prepare = $GLOBALS["connect"]->prepare("
        UPDATE hanghoa 
        SET TENHH = ? , LOCATION = ?, QUYCACH = ?, GIA = ? ,SOLUONGHANG = ?, MALOAIHANG = ?, GHICHU = ?
        WHERE MSHH = ?
   ");
  $name = $product->getName();
  $amount = $product->getAmount();
  $location = $product->getLocation();
  $unit = $product->getUnit();
  $price = $product->getPrice();
  $categoryID = $product->getCategoryId();
  $note = $product->getNote();
  $id = $product->getId();
  $prepare->bind_param("sssiiisi",$name,$location,$unit,$price,$amount,$categoryID,$note,$id);
  if($prepare->execute()){
    $prepare->close();
    $GLOBALS["connect"]->close();
    return true;
  }
  else{
    $prepare->close();
    $GLOBALS["connect"]->close();
    return false;
  }
}
function updateProductWithoutLocation($product){
  $prepare = $GLOBALS["connect"]->prepare("
        UPDATE hanghoa 
        SET TENHH = ? ,QUYCACH = ?, GIA = ? ,SOLUONGHANG = ?, MALOAIHANG = ?, GHICHU = ?
        WHERE MSHH = ?
   ");
  $name = $product->getName();
  $amount = $product->getAmount();
  $unit = $product->getUnit();
  $price = $product->getPrice();
  $categoryID = $product->getCategoryId();
  $note = $product->getNote();
  $id = $product->getId();
  $prepare->bind_param("ssiiisi",$name,$unit,$price,$amount,$categoryID,$note,$id);
  if($prepare->execute()){
    $prepare->close();
    $GLOBALS["connect"]->close();
    return true;
  }
  else{
    $prepare->close();
    $GLOBALS["connect"]->close();
    return false;
  }
}
  function deleteProduct($productID){
    $result = $GLOBALS["connect"]->query("DELETE FROM hanghoa WHERE MSHH = $productID");
    return $result;
  }
  function getCategoryWithIdProduct($id)
  {
    $result = $GLOBALS["connect"]->query("
        SELECT TENLOAIHANG FROM loaihanghoa
        INNER JOIN hanghoa ON loaihanghoa.MALOAIHANG = hanghoa.MALOAIHANG
        WHERE MSHH = $id
    ");
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row["TENLOAIHANG"];
    }
    else
      return "Không có loại hàng";
  }

?>