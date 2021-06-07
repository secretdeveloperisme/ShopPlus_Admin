<?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include($rootPath."/ShopPlus_Admin/php/models/Order.php");
  include($rootPath."/ShopPlus_Admin/php/models/OrderDetail.php");
  include($rootPath."/ShopPlus_Admin/php/Controller/HandleProduct.php");
  global $connect;
  $connect = connectDB();
  function getAllOrderWithLimit($begin,$end){
    $orders = array();
    $allOrderQuery = "SELECT * FROM dathang LIMIT $begin,$end";
    $result = $GLOBALS["connect"]->query($allOrderQuery);
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()){
        $order = new Order(
          $row["SODONDH"],
          $row['MSKH'],$row["MSNV"],
          $row["NGAYDH"],$row["NGAYGH"],$row["TRANGTHAI"]
        );
        array_push($orders,$order->toArray());
      }
      return $orders;
    }
  }
  function insertOrder($order){
    $insertId = 0;
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO dathang(MSKH,NGAYDH,TRANGTHAI) VALUES (?,?,?)");
    $idCustomer = $order->getIdCustomer();
    $orderDate = $order->getOrderDate();
    $status = $order->getStatus();
    $prepare->bind_param("sss",$idCustomer,$orderDate,$status);
    if($prepare->execute()){
      $insertId = $GLOBALS["connect"]->insert_id;
      return $insertId;
    }
    else{
      return $insertId;
    }
  }
  function insertOrderDetail($orderDetail){
    $prepare = $GLOBALS["connect"]->prepare("INSERT INTO chitietdathang(SODONDH,MSHH,SOLUONG,GIADATHANG,GIAMGIA) VALUES (?,?,?,?,?)");
    $orderId = $orderDetail->getOrderId();
    $orderMerchandiseId = $orderDetail->getIdMerchandise();
    $product = getProductViaID($orderMerchandiseId);
    $amount = $orderDetail->getAmount();
    $discount = $orderDetail->getDiscount();
    $orderPrice = ($product->getPrice()* $orderDetail->getAmount() - $product->getPrice() * $discount);
    $prepare->bind_param("iiiid",$orderId,$orderMerchandiseId,$amount,$orderPrice,$discount);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }
  }
  function purchaseProducts($customer,$orderDetails){
    $order = new Order(0,$customer->getId(),0,date("Y-m-d"),"","processing");
    $isSuccess = true;
    if($orderID = insertOrder($order)){
      if($orderID != 0){
        foreach($orderDetails as $orderDetail){
          $orderDetail = new OrderDetail($orderID,$orderDetail->getIdMerchandise(),$orderDetail->getAmount(),0,0);
          if(!insertOrderDetail($orderDetail)){
            $isSuccess = false;
          }
        }
      }
    }
    else
      $isSuccess = false;
    return $isSuccess;
  }
  function getOrderViaCustomer($id){
    $orders = array();
    $prepare  = $GLOBALS["connect"]->prepare("CALL getOrderViaCustomer(?)");
    $id_customer = $id;
    $prepare->bind_param("i",$id_customer);
    if($prepare->execute()){
     $result = $prepare->get_result();
     if($result->num_rows > 0){
       while ($row = $result->fetch_assoc()){
         $order = new Order($row["SODONDH"],$row["MSKH"],$row["MSNV"],$row["NGAYDH"],$row["NGAYGH"],$row["TRANGTHAI"]);
         array_push($orders,$order->toArray());
       }
      }
    }
    return $orders;
  }
  function getDetailOrdersViaOrderID($id){
    $orderDetails = array();
    $prepare  = $GLOBALS["connect"]->prepare("CALL getAllOrderDetail(?)");
    $orderID = $id;
    $prepare->bind_param("i",$orderID);
    if($prepare->execute()){
      $result = $prepare->get_result();
      if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
          $orderDetail = new OrderDetail($row["SODONDH"],$row["MSHH"],$row["SOLUONG"],$row["GIADATHANG"],$row["GIAMGIA"]);
          array_push($orderDetails,$orderDetail->toArray());
        }
      }
    }
    return $orderDetails;
  }
  function calculateMoney($id){
    $result = $GLOBALS["connect"]->query("SELECT calculateMoneyOrder($id) as total");
    return $result->fetch_assoc()["total"];
  }
  function updateOrderViaStaff($order){
    $prepare = $GLOBALS["connect"]->prepare("UPDATE dathang SET MSNV = ?,NGAYGH =?,TRANGTHAI = ? WHERE SODONDH = ?");
    $orderID = $order->getId();
    $staffID = $order->getIdStaff();
    $deliverDate = $order->getDeliverDate();
    $status = $order->getStatus();
    $prepare->bind_param("issi",$staffID,$deliverDate,$status,$orderID);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }


  }
  function deleteOrderDetail($orderID){
    $prepare = $GLOBALS["connect"]->prepare("DELETE FROM chitietdathang WHERE SODONDH = ?");
    $prepare->bind_param("i",$orderID);
    if($prepare->execute()){
      return true;
    }
    else{
      return false;
    }
  }
  function deleteOrder($orderID){
    $prepare = $GLOBALS["connect"]->prepare("DELETE FROM dathang WHERE SODONDH = ?");
    $prepare->bind_param("i",$orderID);
    if(deleteOrderDetail($orderID)){
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