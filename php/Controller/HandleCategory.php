<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Admin/php/models/Category.php");
  include($rootPath."/ShopPlus_Admin/php/ConnectDB.php");
  global $connect ;
  $connect = connectDB();
  function insertCategory($category){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO LOAIHANGHOA(TENLOAIHANG) VALUES(?)");
    $name = $category->getName();
    $prepare->bind_param("s",$name);
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
  function updateCategory($category){
    $id = $category->getId();
    $name = $category->getName();
    $result = $GLOBALS["connect"]->query("UPDATE LOAIHANGHOA SET TENLOAIHANG = '$name' WHERE MALOAIHANG = $id");
    return $result;
  }
  function deleteCategory($category){
    $id = $category->getId();
    $result = $GLOBALS["connect"]->query("DELETE FROM LOAIHANGHOA WHERE MALOAIHANG = $id");
    return $result;
  }
  function getAllCategories(){
    $categories = array();
    $result = $GLOBALS["connect"]->query("SELECT MALOAIHANG,TENLOAIHANG FROM LOAIHANGHOA");
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $address = new Category($row["MALOAIHANG"],$row["TENLOAIHANG"]);
        array_push($categories ,$address->toArray());
      }
    }
    return json_encode($categories);
  }
  function getNumberOfCategory(){
    $numberOfCategory = 0;
    $result = $GLOBALS["connect"]->query("SELECT MALOAIHANG FROM LOAIHANGHOA ");
    if($result->num_rows > 0){
      $numberOfCategory = $result->num_rows;
    }
    return $numberOfCategory;
  }
  function getCategoryWithIdProduct($id)
  {
    $result = $GLOBALS["connect"]->query("
          SELECT TENLOAIHANG FROM LOAIHANGHOA
          INNER JOIN HANGHOA ON LOAIHANGHOA.MALOAIHANG = HANGHOA.MALOAIHANG
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