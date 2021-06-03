$(()=>{
  //change label image file input file 
  let $imgFile = $("#imgFile")
  let $imgFileEditProduct = $("#imgFileEditProduct")
  $imgFile.on("change", function (event) {
    let imgName = $(this).val().split("\\").pop()
    $(this).siblings(".custom-file-label").addClass("selected").html(imgName)
    readerImage(event,$displayImgFile)
  });
  $imgFileEditProduct.on("change", function (event) {
    let imgName = $(this).val().split("\\").pop()
    $(this).siblings(".custom-file-label").addClass("selected").html(imgName)
    readerImage(event,$displayEditFile)
  });
  //display image when input image file change
  let $displayImgFile = $("#displayImgFile")
  let $displayEditFile = $("#displayEditImgFile")
  function readerImage(event,$displayImage){
    let input = event.target 
    let reader = new FileReader()
    reader.onload = ()=>{
      let dataURL = reader.result;
      $displayImage.attr("src",dataURL)
    }
    reader.readAsDataURL(input.files[0]);
  }
  //

  let $editModal = $("#editProductModal")
  let $productTable = $("#productTable")
  let $categoryBody = $productTable.find("tbody")
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
         <tr rowID="${value.id}">
            <td scope="row"><input type="checkbox" class="custom-checkbox" productID="${value.id}"></td>
            <td role="id">${value.id}</td>
            <td role="name">${value.name}</td>
            <td role="location"><img src="${value.location}" alt="picture" class="img-thumbnail" style="width: 64px; height: 64px;" ></td>
            <td role="unit">${value.unit}</td>
            <td role="price" price="${value.price}">${numberWithCommas(value.price)} đ</td>
            <td role="amount">${value.amount}</td>
            <td role="categoryID" categoryID="${value.categoryId}">${categoryName}</td>
            <td role="btnEdit"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editProductModal">edit</button></td>
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
          renderProductTable()
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
  })
  //edit event
  function initEditEvent(){
    let $btnEditProducts = $categoryBody.find("[role='btnEdit']").find("button")
    $btnEditProducts.each((index,element)=>{
      let $tdBtnEdit = $(element).parent();
      let id = $tdBtnEdit.parent().attr("rowID");
      let name = $tdBtnEdit.siblings("[role=name]").text()
      let location = $tdBtnEdit.siblings("[role=location]").children().attr("src")
      let price = $tdBtnEdit.siblings("[role=price]").attr("price")
      let amount = $tdBtnEdit.siblings("[role=amount]").text()
      let categoryID = $tdBtnEdit.siblings("[role=categoryID]").attr("categoryID")
      let unit = $tdBtnEdit.siblings("[role=unit]").text().trim()
      $(element).on("click",(event)=>{
        $editModal.prop("productID",id);
        $("#nameEditProduct").val(name)
        $("#priceEditProduct").val(price)
        $displayEditFile.attr("src",location)
        $("#amountEditProduct").val(amount)
        setSelectedValue($("#categoryEditProduct")[0],categoryID)
      })
    })
  }
  //init edit button commit
  let $btnCommitEdit = $("#btnCommitEdit");
  $btnCommitEdit.click((event)=>{
    // if($inputEditDataCategory.val() === "")
    // {
    //   toast({
    //     title : "Thất Bại",
    //     message : "Không Được Để trống",
    //     type : "error",
    //     duration : 5000
    //   })
    //   return false
    // }
    let addForm = $("#editForm")[0];
    let addFormData = new FormData(addForm);
    addFormData.append("action","updateProduct")
    addFormData.append("id",$editModal.prop("productID"))
    let xmlHTTP = new XMLHttpRequest();
    xmlHTTP.open("POST","/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php")
    xmlHTTP.onload = (e) =>{
      if(e.currentTarget.readyState === 4 && e.currentTarget.status === 200){
        console.log(e.currentTarget.responseText)
        if(e.currentTarget.responseText.trim() === "true"){
          toast({
            title : "Thành Công",
            message : "Sửa Sản Phẩm Thành Công",
            type : "success",
            duration : 5000
          })
          renderProductTable()
        }
        else
          toast({
            title : "Thất Bại",
            message : "Sửa Sản Phẩm Thất Bại",
            type : "error",
            duration : 5000
          })
      }
    }
    xmlHTTP.send(addFormData)
  })
  //init delete event
  let $btnDeleteProduct = $("#btnDeleteProduct")
  $btnDeleteProduct.click((event)=>{
    let $selectRow = $productTable.find("[type=checkbox]");
    $selectRow.each((index,element)=>{
      if ($(element).prop("checked")){
        console.log($(element).parent().parent().attr("rowid"))
        $.ajax({
          url : "/ShopPlus_Admin/php/Controller/API/HandleProductAPI.php",
          type : "POST",
          data : {
            action : "deleteProduct",
            productID: $(element).parent().parent().attr("rowid")
          },
          dataType : "text",
          success : (response)=>{
            console.log(response)
            if(response.trim() === "true"){
              toast({
                title : "Thành Công",
                message : "Xóa sản Phẩm có id : "+ $(element).parent().parent().attr("rowid") + " thành công" ,
                type : "success",
                duration : 5000
              })
              $(element).parent().parent().remove()
            }
            else
              toast({
                title : "Thất Bại",
                message : "Xóa sản Phẩm có id : "+ $(element).parent().parent().attr("rowid") + " thất bại",
                type : "error",
                duration : 5000
              })
          }
        })
      }
    })
  })

})