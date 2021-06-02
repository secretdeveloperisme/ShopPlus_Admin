$(()=> {
  let $editModal = $("#editModal")
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
            <th role="id">${value.id}</th>
            <td role="name">${value.name}</td>
            <td><button type="button" class="btn btn-info " role="btnEdit" data-toggle="modal" data-target="#editModal">edit</button></td>
          </tr>
          `
          $categoryBody.html((index,current)=>{
            return current + row;
          })

        })


      }
    })
    initEditEvent()
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
  let $inputEditDataCategory = $("#inputEditDataCategory")
  function initEditEvent(){
    let $btnCategoryEdits = $categoryBody.find("[role='btnEdit']")
    $btnCategoryEdits.each((index,element)=>{
      let id = $(element).parent().siblings().filter("[role=id]").text()
      $(element).on("click",(event)=>{
        $editModal.prop("categoryID",id);
        $inputEditDataCategory.val($(element).parent().siblings("[role=name]").text())
      })
    })
  }
  //init edit button commit
  let $btnCommitEdit = $("#btnCommitEdit");
  $btnCommitEdit.click((event)=>{
    if($inputEditDataCategory.val() === "")
    {
      toast({
        title : "Thất Bại",
        message : "Không Được Để trống",
        type : "error",
        duration : 5000
      })
      return false
    }
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
      type : "POST",
      data : {
        action : "updateCategory",
        categoryName: $inputEditDataCategory.val(),
        categoryID : $editModal.prop("categoryID")
      },
      dataType : "text",
      success : (response)=>{
        if(response.trim() === "true"){
          toast({
            title : "Thành Công",
            message : `Bạn đã Cập Nhật Thành Công`,
            type : "success",
            duration : 5000
          })
          $editModal.modal("hide")
          renderCategoryTable()
        }
        else
          toast({
            title : "Thất bại",
            message : "Cập Nhật Thất Bại",
            type : "error",
            duration : 5000
          })
      }
    })
  })
  //init delete event
  let $btnDeleteCategory = $("#btnDeleteCategory")
  $btnDeleteCategory.click((event)=>{
    let $selectRow = $categoryTable.find("[type=checkbox]");
    $selectRow.each((index,element)=>{
      if ($(element).prop("checked")){
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
          type : "POST",
          data : {
            action : "deleteCategory",
            categoryID: $(element).parent().siblings("[role=id]").text()
          },
          dataType : "text",
          success : (response)=>{
            if(response.trim() === "true"){
              toast({
                title : "Thành Công",
                message : "Xóa sản Phẩm có id : "+ $(element).parent().siblings("[role=id]").text() + " thành công" ,
                type : "success",
                duration : 5000
              })
              $(element).parent().parent().remove()
            }
            else
              toast({
                title : "Thất Bại",
                message : "Xóa sản Phẩm có id : "+ $(element).parent().siblings("[role=id]").text() + " thất bại",
                type : "error",
                duration : 5000
              })
          }
        })
      }
    })
  })
})


