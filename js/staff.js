$(()=> {
  let $staffTable = $("#staffTable")
  let $staffBody = $staffTable.find("tbody")
  //render category Table
  function renderStaffTable(){
    $staffBody.html("")
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleStaffAPI.php",
      type : "GET",
      data : {
        action : "getAllStaffs"
      },
      async : false,
      dataType : "text",
      success : (response)=>{
        let orders = JSON.parse(response)
        orders.forEach((value,index)=>{
          let row =`
              <tr rowID="${value.id}">
                <td scope="row"><input type="checkbox" class="custom-checkbox" ></td>
                <td>${value.id}</td>
                <td>${value.name}</td>
                <td>${value.position}</td>
                <td>${value.address}</td>
                <td>${value.phone}</td>
              </tr>
          `
          $staffBody.html((index,current)=>{
            return current + row;
          })

        })
      }
    })
  }
  renderStaffTable()
  //init delete event
  let $btnDeleteStaff = $("#btnDeleteStaff")
  $btnDeleteStaff.click((event)=>{
    let $selectRow = $staffTable.find("[type=checkbox]");
    $selectRow.each((index,element)=>{
      if ($(element).prop("checked")){
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleStaffAPI.php",
          type : "POST",
          data : {
            action : "deleteStaff",
            staffID: $(element).parent().parent().attr("rowID")
          },
          dataType : "text",
          success : (response)=>{
            if(JSON.parse(response)){
              toast({
                title : "Thành Công",
                message : "Xóa Nhân Viên có id : "+ $(element).parent().parent().attr("rowID") + " thành công" ,
                type : "success",
                duration : 5000
              })
              $(element).parent().parent().remove()
            }
            else
              toast({
                title : "Thất Bại",
                message : "Xóa Nhân Viên có id : "+ $(element).parent().parent().attr("rowID") + " thất bại",
                type : "error",
                duration : 5000
              })
          }
        })
      }
    })
  })
})


