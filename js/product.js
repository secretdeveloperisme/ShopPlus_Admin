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
})