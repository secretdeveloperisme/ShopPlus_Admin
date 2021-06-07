$(()=> {
  let $customerTable = $("#customerTable")
  let $customerBody = $customerTable.find("tbody")
  //render category Table
  function renderCustomerTable(){
    $customerBody.html("")
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleCustomerAPI.php",
      type : "GET",
      data : {
        action : "getAllCustomers"
      },
      async : false,
      dataType : "text",
      success : (response)=>{
        let customers = JSON.parse(response);
        customers.forEach((value,index)=>{
          let row =`
              <tr rowID="${value.id}">
                <td scope="row"><input type="checkbox" class="custom-checkbox" ></td>
                <td>${value.id}</td>
                <td>${value.name}</td>
                <td>${value.companyName}</td>
                <td>${value.phone}</td>
                <td>${value.email}</td>
              </tr>
          `
          $customerBody.html((index,current)=>{
            return current + row;
          })
        })
      }
    })
  }
  renderCustomerTable()
  //init delete event
  let $btnDeleteCustomer = $("#btnDeleteCustomer")
  $btnDeleteCustomer.click((event)=>{
    let $selectRow = $customerTable.find("[type=checkbox]");
    $selectRow.each((index,element)=>{
      if ($(element).prop("checked")){
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleCustomerAPI.php",
          type : "POST",
          data : {
            action : "deleteCustomer",
            customerID: $(element).parent().parent().attr("rowID")
          },
          dataType : "text",
          success : (response)=>{
            console.log(response)
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


