$(()=> {
  let $categoryTable = $("#categoryTable")
  let $categoryBody = $categoryTable.find("tbody")
  //render category Table
  function renderCategoryTable(){
    $categoryBody.html("")
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
      type : "GET",
      data : {
        action : "getAllCategories"
      },
      async : false,
      dataType : "json",
      success : (response)=>{
        let categories = JSON.parse(response)
        categories.forEach((value,index)=>{
          let row =`
          <tr>
            <td scope="row"><input type="checkbox" class="custom-checkbox" ></td>
            <th role="id" >${value.id}</th>
            <td>${value.name}</td>
            <td><button type="button" class="btn btn-info " role="btnEdit" data-toggle="modal" data-target="#editModal">edit</button></td>
          </tr>
          `
          $categoryBody.html((index,current)=>{
            return current + row;
          })

        })


      }
    })
  }
  renderCategoryTable()
  let $btnAddCategory = $("#btnAddCategory")
  let $inputDataCategory = $("#inputDataCategory")
  $btnAddCategory.on("click",(event)=>{
    if($inputDataCategory.val() === ""){
      toast({
        title : "Thất Bại",
        message : "Tên Hàng Hóa Không Được Để trống",
        type : "error",
        duration : 4000
      })
      return false;
    }
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
      type : "POST",
      data : {
        action : "insertCategory",
        categoryName : $inputDataCategory.val()
      },
      success : (responses)=>{
        if(responses.trim() === "true"){
          toast({
            title : "Thành Công",
            message : "Thêm Thành Công",
            type : "success",
            duration : 4000
          })
          $inputDataCategory.val("");
          renderCategoryTable()
        }
        else
          toast({
            title : "Thất Bại",
            message : "Tên Hàng Hóa Không Được Để trống",
            type : "error",
            duration : 4000
          })
      }
    })
  })
  //edit event
  let $btnCategoryEdits = $categoryBody.find("[role='btnEdit']")
  $btnCategoryEdits.each((index,element)=>{
    console.log($(element).parent().siblings().filter("[role=id]"))
  })
})


