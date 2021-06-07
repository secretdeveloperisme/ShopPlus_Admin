<?php
if(isset($_POST["action"]) && !empty($_POST["action"])){
  include("../../Controller/HandleStaff.php");
  if ($_POST["action"] == "deleteStaff"){
    if(isset($_POST["staffID"])&&!empty($_POST["staffID"])){
      echo json_encode(deleteStaff($_POST["staffID"]));
    }
  }
}
if(isset($_GET["action"]) && !empty($_GET["action"])){
  include("../../Controller/HandleStaff.php");
  if ($_GET["action"] == "getAllStaffs"){
    echo json_encode(getAllStaffs());
  }
}