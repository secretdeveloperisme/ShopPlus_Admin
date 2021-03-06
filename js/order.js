$(()=> {
  let $orderTable = $("#orderTable")
  let $orderBody = $orderTable.find("tbody")
  //render category Table
  function renderOrderTable(){
    $orderBody.html("")
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleOrderAPI.php",
      type : "GET",
      data : {
        action : "getAllOrders"
      },
      async : false,
      dataType : "text",
      success : (response)=>{
        let orders = JSON.parse(response)
        orders.forEach((value,index)=>{
          let price = 0;
          let selectPending,selectApproved,selectProcessing,selectCompleted,selectCancelled =""
          switch (value.status) {
            case "pending" :
              selectPending = "selected"
              break
            case "approved" :
              selectApproved = "selected"
              break
            case "processing" :
              selectProcessing = "selected"
              break
            case "completed" :
              selectCompleted = "selected"
              break
            case "canceled" :
              selectCancelled = "selected"
              break

          }
            $.ajax({
              url : "/ShopPlus_Admin/php/Controller/API/HandleOrderAPI.php",
              type : "GET",
              data : {
                action : "getCalculateMoneyOrder",
                orderID : value.id
              },
              async : false,
              dataType : "text",
              success : (response)=>{
                price = JSON.parse(response);
              }
            })
          let row =`
              <tr rowID="${value.id}">
                <td scope="row"><input type="checkbox" class="custom-checkbox"></td>
                <td role="id">${value.id}</td>
                <td >${value.idCustomer}</td>
                <td>${value.idStaff}</td>
                <td><input type="date" name="" id="" class="form-control-sm text-info font-weight-bold" value="${value.orderDate}" disabled></td>
                <td role="deliverDate"><input type="date" name="" id="" class="form-control-sm" value="${value.deliverDate}"></td>
                <td><span>${numberWithCommas(price)}<span> ?? </td>
                <td role="status">
                  <select name="" id=""  class="custom-select">
                    <option ${selectPending} value="pending">??ang Ch???</option>
                    <option ${selectApproved} value="approved">???? Duy??t</option>
                    <option ${selectProcessing} value="processing">??ang X??? l??</option>
                    <option ${selectCompleted} value="completed">???? Giao</option>
                    <option ${selectCancelled} value="canceled">???? H??y</option>
                  </select>
                </td>
                <td role="save"><button type="button" class="btn btn-info">Save</button></td>
              </tr>
          `
          $orderBody.html((index,current)=>{
            return current + row;
          })

        })
      }
    })
    initSaveEvent()
  }
  renderOrderTable()
  function initSaveEvent(){
    let $btnSaveOrder = $orderBody.find("[role='save']").children();
    $btnSaveOrder.each((index,element)=>{
      $(element).on("click",(event)=>{
        let id = $(element).parent().parent().attr("rowID")
        let staffID = $(element).parent().parent().parent().attr("manageStaff")
        let status = $(element).parent().siblings("[role=status]").children().val()
        let deliverDate = $(element).parent().siblings("[role='deliverDate']").children().val()
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleOrderAPI.php",
          type : "POST",
          data : {
            action : "updateOrderViaStaff",
            orderID : id,
            "staffID" : staffID,
            "deliverDate" : deliverDate,
            "status" : status
          },
          dataType : "text",
          success : (response)=>{
            console.log(response)
            if(JSON.parse(response)){
              toast({
                title : "Th??nh C??ng",
                message : "C???p Nh???t ????n h??ng c?? id :" +id +" th??nh c??ng!",
                type : "success",
                duration : 5000
              })
              renderOrderTable()
            }
            else{
              toast({
                title : "Th???t B???i",
                message : "C???p Nh???t ????n h??ng c?? " +id +" th???t b???i!",
                type : "error",
                duration : 5000
              })
            }
          }
        })
      })
    })
  }
  //init delete event
  let $btnDeleteOrder = $("#btnDeleteOrder")
  $btnDeleteOrder.click((event)=>{
    let $selectRow = $orderTable.find("[type=checkbox]");
    $selectRow.each((index,element)=>{
      if ($(element).prop("checked")){
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleOrderAPI.php",
          type : "POST",
          data : {
            action : "deleteOrder",
            orderID: $(element).parent().parent().attr("rowID")
          },
          dataType : "text",
          success : (response)=>{
            if(JSON.parse(response)){
              toast({
                title : "Th??nh C??ng",
                message : "X??a ????n h??ng c?? id : "+ $(element).parent().parent().attr("rowID") + " th??nh c??ng" ,
                type : "success",
                duration : 5000
              })
              $(element).parent().parent().remove()
            }
            else
              toast({
                title : "Th???t B???i",
                message : "X??a ????n H??ng c?? id : "+ $(element).parent().parent().attr("rowID") + " th???t b???i",
                type : "error",
                duration : 5000
              })
          }
        })
      }
    })
  })
})


