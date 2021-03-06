<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Admin/php/models/Staff.php");
  include($rootPath."/ShopPlus_Admin/php/ConnectDB.php");
  global $connect;
  $connect = connectDB();
  function isValidLogin($id,$password){
    $prepare = $GLOBALS["connect"]->prepare("SELECT is_valid_login(?,?) AS VALID");
    $prepare->bind_param("is",$id,$password);
    $prepare->execute();
    $result = $prepare->get_result();
    $row = $result->fetch_assoc();
    $valid = $row["VALID"];
    if($valid == 1)
      return true;
    else
    return false;
}
  function getStaffViaID($id){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSNV,HOTENNV,MATKHAU,CHUCVU,DIACHI,SODIENTHOAI FROM nhanvien WHERE MSNV = $id");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Staff(
        $row["MSNV"],
        $row['HOTENNV'],$row["MATKHAU"],$row["CHUCVU"],
        $row["DIACHI"],$row["SODIENTHOAI"]
      );
    }
    else
      return false;
  }
  function getAllStaffs(){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSNV,HOTENNV,MATKHAU,CHUCVU,DIACHI,SODIENTHOAI FROM nhanvien");
    $staffs = array();
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $staff = new Staff(
          $row["MSNV"],
          $row['HOTENNV'],$row["MATKHAU"],$row["CHUCVU"],
          $row["DIACHI"],$row["SODIENTHOAI"]
        );
        array_push($staffs,$staff->toArray());
      }
      return $staffs;
    }
    else
      return false;
  }
  function isExistStaff($id){
    $prepare = $GLOBALS["connect"]->prepare("SELECT STAFF_LOGIN(?) AS VALID");
    $prepare->bind_param("i",$id);
    $prepare->execute();
    $result = $prepare->get_result();
    $row = $result->fetch_assoc();
    $valid = $row["VALID"];
    if($valid == 1)
      return true;
    else
      return false;
  }
  function insertStaff($staff){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO nhanvien(HOTENNV,MATKHAU,CHUCVU,DIACHI,SODIENTHOAI)VALUES(?,?,?,?,?)");
    $name = $staff->getName();
    $password = $staff->getPassword();
    $position = $staff->getPosition();
    $address = $staff->getAddress();
    $phone = $staff->getPhone();
    $prepare->bind_param("sssss",$name,$password,$position,$address,$phone);
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
function updateStaff($staff){
  $prepare = $GLOBALS["connect"]->prepare(
    "UPDATE nhanvien SET HOTENNV = ?,MATKHAU = ?,CHUCVU = ?,DIACHI = ?,SODIENTHOAI = ? WHERE MSNV = ?"
  );
  $name = $staff->getName();
  $password = $staff->getPassword();
  $position = $staff->getPosition();
  $address = $staff->getAddress();
  $phone = $staff->getPhone();
  $id = $staff->getId();
  $prepare->bind_param("sssssi",$name,$password,$position,$address,$phone,$id);
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
  function deleteStaff($orderStaff){
    $prepare = $GLOBALS["connect"]->prepare("DELETE FROM nhanvien WHERE MSNV = ?");
    $prepare->bind_param("i",$orderStaff);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }
  }
?>