<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Admin/php/models/Customer.php");
  include($rootPath."/ShopPlus_Admin/php/ConnectDB.php");
  global $connect;
  $connect = connectDB();
  function getAllCustomers(){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSKH,HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL FROM KHACHHANG");
    $customers = array();
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $customer = new Customer(
          $row["MSKH"],
          $row['HOTENKH'],$row["TENCONGTY"],
          $row["SODIENTHOAI"],$row["EMAIL"]
        );
        array_push($customers,$customer->toArray());
      }
      return $customers;
    }
    else
      return false;
  }
  function getCustomerViaEmail($email){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSKH,HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL FROM KHACHHANG WHERE EMAIL= '$email'");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Customer(
        $row["MSKH"],
        $row['HOTENKH'],$row["TENCONGTY"],
        $row["SODIENTHOAI"],$row["EMAIL"]
      );
    }
    else
      return false;
  }
  function getCustomerViaID($id){
    $result = $GLOBALS["connect"]->query(
      "SELECT MSKH,HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL FROM KHACHHANG WHERE MSKH = $id");
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      return new Customer(
        $row["MSKH"],
        $row['HOTENKH'],$row["TENCONGTY"],
        $row["SODIENTHOAI"],$row["EMAIL"]
      );
    }
    else
      return false;
  }
  function isExistCustomer($email){
    $result = $GLOBALS["connect"]->query(
      "SELECT * FROM KHACHHANG WHERE EMAIL = '$email'"
    );
    if($result->num_rows > 0){
      return true;
    }
    else
      return false;
  }
  function isExistEmailAnotherAccount($email,$id){
    $result = $GLOBALS["connect"]->query(
      "SELECT * FROM KHACHHANG WHERE EMAIL = '$email' and MSKH != $id"
    );
    if($result->num_rows == 0){
      return false;
    }
    else
      return true;
    }
  function insertCustomer($customer){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO KHACHHANG(HOTENKH,TENCONGTY,SODIENTHOAI,EMAIL)VALUES(?,?,?,?)");
    $name = $customer->getName();
    $companyName = $customer->getCompanyName();
    $phone = $customer->getPhone();
    $email = $customer->getEmail();
    $prepare->bind_param("ssss",$name,$companyName,$phone,$email);
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
  function updateCustomer($customer){
    $prepare = $GLOBALS["connect"]->prepare(
      "UPDATE KHACHHANG SET HOTENKH = ?,TENCONGTY = ?,SODIENTHOAI = ?,EMAIL = ? WHERE MSKH = ?"
    );
    $name = $customer->getName();
    $companyName = $customer->getCompanyName();
    $phone = $customer->getPhone();
    $email = $customer->getEmail();
    $id = $customer->getId();
    $prepare->bind_param("ssssi",$name,$companyName,$phone,$email,$id);
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
  function clearAddress($customerID){
    $prepare = $GLOBALS["connect"]->prepare("DELETE FROM DIACHIKH WHERE MSKH = ?");
    $prepare->bind_param("i",$customerID);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }

  }
  function deleteCustomer($customerID){
    $prepare = $GLOBALS["connect"]->prepare("DELETE FROM KHACHHANG WHERE MSKH = ?");
    $prepare->bind_param("i",$customerID);
    if(clearAddress($customerID)){
      if($prepare->execute()){
        return true;
      }
      else{
        return false;
      }
    }
    else
      return false;
  }
?>