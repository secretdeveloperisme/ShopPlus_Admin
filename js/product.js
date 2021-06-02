$(()=>{
  //change label image file input file 
  let $imgFile = $("#imgFile")
  $imgFile.on("change", function (event) {
    let imgName = $(this).val().split("\\").pop()
    $(this).siblings(".custom-file-label").addClass("selected").html(imgName)
    readerImage(event)
  });
  //display image when input image file change
  let $displayImgFile = $("#displayImgFile")
  function readerImage(event){
    let input = event.target 
    let reader = new FileReader()
    reader.onload = ()=>{
      let dataURL = reader.result;
      $displayImgFile.attr("src",dataURL)
    }
    reader.readAsDataURL(input.files[0]);
  }
  //

  let $editModal = $("#editProductModal")
  let $categoryTable = $("#productTable")
  let $categoryBody = $categoryTable.find("tbody")
  //render category Table
  function renderProductTable(){
    $categoryBody.html("")
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php",
      type : "GET",
      data : {
        action : "getAllProducts"
      },
      async : false,
      dataType : "text",
      success : (response)=>{
        let products = JSON.parse(response)
        products.forEach((value,index)=>{
          let categoryName = ""
          $.ajax({
            url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
            type : "GET",
            data : {
              action : "getCategoryWithProduct",
              id : value.id
            },
            async : false,
            dataType : "text",
            success : (response)=>{
              categoryName = JSON.parse(response)
            }
          })
          let row =`
         <tr>
            <td scope="row"><input type="checkbox" class="custom-checkbox" productID="${value.id}"></td>
            <td>${value.id}</td>
            <td>${value.name}</td>
            <td><img src="${value.location}" alt="picture" class="img-thumbnail" style="width: 64px; height: 64px;" ></td>
            <td>${value.unit}</td>
            <td>${numberWithCommas(value.price)} đ</td>
            <td>${value.amount}</td>
            <td>${categoryName}</td>
            <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editProductModal">edit</button></td>
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
  renderProductTable()
  function renderCategory(){
    let $categoryAddProduct = $("#categoryAddProduct")
    let $categoryEditProduct = $("#categoryEditProduct")
    console.log($categoryAddProduct)
    $.ajax({
      url : "/ShopPlus_Admin/php/Controller/API/HandleCategoryAPI.php",
      type : "GET",
      data : {
        action : "getAllCategories"
      },
      dataType : "json",
      success : (response)=>{
        let categories = JSON.parse(response)
        console.log(categories)
        categories.forEach((value,index)=>{
          let option = `<option value="${value.id}">${value.name}</option>`
          $categoryAddProduct.html((i,current)=>{
            return current + option;
          })
          $categoryEditProduct.html((i,current)=>{
            return current + option;
          })

        })
      }
    })
  }
  renderCategory()
  let $btnAddProduct = $("#btnAddProduct")
  $btnAddProduct.on("click",(event)=>{
    let addForm = $("#formAdd")[0];
    let addFormData = new FormData(addForm);
    addFormData.append("action","addProduct")
    let xmlHTTP = new XMLHttpRequest();
    xmlHTTP.open("POST","/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php")
    xmlHTTP.onload = (e) =>{
      if(e.currentTarget.readyState === 4 && e.currentTarget.status === 200)
        if(e.currentTarget.responseText.trim() === "true"){
          toast({
            title : "Thành Công",
            message : "Thêm Sản Phẩm Thành Công",
            type : "success",
            duration : 5000
          })
        }
        else
          toast({
            title : "Thất Bại",
            message : "Thêm Sản Phẩm Thất Bại",
            type : "error",
            duration : 5000
          })
    }
    xmlHTTP.send(addFormData)
    // $.ajax({
    //   url : "/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php",
    //   type : "POST",
    //   data : {
    //     action : "insertCategory",
    //     categoryName :
    //   },
    //   success : (responses)=>{
    //     if(responses.trim() === "true"){
    //       toast({
    //         title : "Thành Công",
    //         message : "Thêm Thành Công",
    //         type : "success",
    //         duration : 4000
    //       })
    //       $inputDataCategory.val("");
    //       renderProductTable()
    //     }
    //     else
    //       toast({
    //         title : "Thất Bại",
    //         message : "Tên Hàng Hóa Không Được Để trống",
    //         type : "error",
    //         duration : 4000
    //       })
    //   }
    // })
  })
  //edit event
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
      url : "/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php",
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
          renderProductTable()
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
          url : "/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php",
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