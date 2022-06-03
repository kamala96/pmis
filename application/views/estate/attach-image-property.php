<?php
	include '../template/header.php';
  define("UPLOAD_DIR_PROPIMAGE", "../../property-gallery/"); 
?>
<link rel="stylesheet" type="text/css" href="../css/jquery-editable-select.min.css">
  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Add image to property</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
      </ol>
      
      <div class="row">       
        <div class="col-lg-6">    
          <div class="card mb-3">
            <div class="card-header">
             Property Information
            </div>
            <div class="card-body">
              <!-- 
              <div class="form-group">
                <button class="radio-inline btn btn-primary">Select Client</button>
                <input class="radio-inline form-control" style="display:inline;width: 80%;" type="text" name="clientName" placeholder="Select Client" disabled>
              </div>
              -->
            <div class="form-group inline-layout">   
             <span class="btn btn-primary" onclick="propertyOnchange()"> Select </span>             
              <select id="propertySelect"  class="custom-select radio-inline" name="property" style="display: inline;width: 80%;" placeholder="Select Property here...">
             
                  <?php
                    $sql = "SELECT 
                            id,
                            property_name,
                            address, city 
                            FROM property
                            WHERE deleted = 0";

                     $result = mysqli_query($mysqli,$sql);
                      if (mysqli_num_rows($result) > 0) {

                         while($row = mysqli_fetch_assoc($result)) {

                          $name = $row['property_name'] .' - '.$row['address'].', '.$row['city'];
                          $id  = $row['id'];
                          echo '<option value="'.$id.'">'.$name.'</option>'; 
                        }
                    ?>               
              </select> 
            </div>  
            <!--upload image multiple -->
            <div class="form-group"  id="uploadPropertyGallery" >    
                <label>Attachment [e.g. Legal documents]</label> 

                <div class="file_upload">
                  <form action="../snippet/upload-property-gallery.php" class="dropzone" enctype="multipart/form-data">
                   <input type="hidden" name="property_id" id="setPropertyId">
                    <div class="dz-message needsclick">
                      <strong>Drop files here or click to upload.</strong><br />
                      <span class="note needsclick">(Select or upload multiple attachment)</span>
                    </div>
                  </form>
                  <?php  
                      } 
                  ?>     
                </div>
                <button class="btn btn-success" style="margin-top: 1em;" onclick="pagerefresh()">UPLOAD IMAGES</button>
              </div> 
            <!--upload image multiple -->

            </div>
          </div>
        </div>
        <div class="col-lg-6" >
          <div class="card mb-3">
            <div class="card-header">
             Property Image 
            </div>
            <div class="card-body">
               <div id="propertyGallery">
                 
               </div>      
            </div>
          </div>
        </div>
      </div><!--row -->
      
      </div>
      
    </div>
</div> 

<?php
	include '../template/footer.php';
?>
<script type="text/javascript">
  $('#uploadPropertyGallery').css("display","none");
  function propertyOnchange(e){
    
    var val = $('#propertySelect').val();
    var pid = $(".es-list li:contains('"+ val +"')").val();

    $('#setPropertyId').val(pid);
    $('#uploadPropertyGallery').css("display","block");

     if(val != ""){            
       if(pid != 0 || pid != null || pid != ""){
          $.get("../snippet/website-attach-image-property-dynamic.php?id="+pid, function (data) {
      
            $("#propertyGallery").html(data);
          });   
          //alert(pid);
        }
     }   
    
    e.stopPropagation();
  }

  function pagerefresh(){
   location.reload();
  }

   $(function() {
    $(".sidebar .nav-item").removeClass("active");
    $(".menu-website-details").addClass("active");
});

</script>