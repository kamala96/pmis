<?php
	include '../template/header.php';
?>
<style type="text/css">
  .editable-select{
        width: 90%;
  }
  .jumbotron{
    padding: 2rem 2rem;
  }
</style>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="attach-property.php">Attach a property</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
      </ol>
      
      <div class="row">       
        <div class="col-lg-6">
         <form action="../cli/functions.php" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="action" value="attachproperty" >
          <button class="btn btn-primary" type="submit" style="margin-bottom: 1em;">Add Property</button>          
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
              <input class="editable-select" list="client" name="client_id" placeholder="Select Client here" onchange="getInfo(this)" />
                  <datalist id="client">
                    <?php
                        $sql = "SELECT id,firstname,middlename,lastname FROM client WHERE deleted = 0 AND status = 0";
                         $result = mysqli_query($mysqli,$sql);
                          if (mysqli_num_rows($result) > 0) {                             
                             while($row = mysqli_fetch_assoc($result)) {
                              $name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'];
                              $id  = $row['id'];
                              echo '<option value="'.$name.'">';
                             }
                          }
                      ?>           
                  </datalist>   
                  <!--
              <label class="radio-inline attach-property-label">Select Client: </label> 

              <select class="custom-select radio-inline" name="client_id" style="display: inline;">
                  <?php
                    $sql = "SELECT id,firstname,middlename,lastname FROM client WHERE deleted = 0 AND status = 0";
                     $result = mysqli_query($mysqli,$sql);
                      if (mysqli_num_rows($result) > 0) { 
                         while($row = mysqli_fetch_assoc($result)) {
                          $name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'];
                          $id  = $row['id'];
                          echo '<option value="'.$id.'">'.$name.'</option>';
                         }
                      }
                  ?>                    
              </select>
              -->
            </div>
              <div class="form-group">
                <label >Relation to the property: </label><br>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="radioRelationProperty" value="0" checked> Owner
                </label>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="radioRelationProperty" value="1"> Board Member
                </label>
                 <label class="form-control" style="border: none;">
                  <input type="radio" name="radioRelationProperty" value="2"> Developer
                </label>

              </div>
              <div class="form-group">   
                <label>Date Management to Commence:</label>
                <input class="form-control" data-date-format="yyyy-mm-dd" id="datepicker" name="dateManagement">
              </div> 
              <div class="form-group">   
                <label>Property Name:</label>
                <input class="form-control" type="text" name="property_name" required="">
              </div> 
              <!--upload property image -->
                <div class="input-group addborder" style="margin-bottom: 1em;">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse… <input type="file" id="imgInp" name="image">
                            </span>
                        </span>
                        <input type="text" class="form-control" readonly>
                    </div>
                <!--upload property image -->
              <!-- if subdevided lot-->
               <i class="text-muted small">Fill up if subdevided lot</i>
              <div class="form-group jumbotron" style="text-align: center;">

                <label>Block: 
                  <input type="text" name="propBlock" class="form-control" placeholder="value numeric">
                </label>
                <label>Lot: 
                  <input type="text" name="propLot" class="form-control" placeholder="value numeric">
                </label>
              </div>

              <div class="form-group">   
                <label>Address:[Purok,Street,Brgy,]</label>
                <input class="form-control" type="text" name="address" required="">
              </div> 
              <div class="form-group">   
                <label>City</label>
                <input class="form-control" type="text" name="city" required="">
              </div> 
              <div class="form-group">   
                <label>Postal Code:</label>
                <input class="form-control" type="text" name="postal_code" required="">
              </div> 
              <div class="form-group">   
                <label>Property Size:</label><br>
                <input id="propertySize" class="form-control radio-inline" type="Number" name="property_size" style="width: 40%;display: inline;" placeholder="0">
                 <select id="sizeUnit" class="custom-select radio-inline" name="size_unit" style="width: 58%;display: inline;">
                 <option value="0">Square meter</option>    
                 <option value="1">Hectare</option>    
              </select>
              </div> 
              <div class="form-group">
                <label >Subject to: </label><br>
                <label class="form-control" style="border: none;">
                  <input id="forSale" type="radio" name="subject_to" value="0" checked> For Sale
                </label>
              

              </div>
              <div class="borderme">
                <div class="form-group" id="sale">  
                 <label>Price per Sq.m. </label>
                  <input id="pricePerSqm" class="form-control radio-inline" type="Number" name="price_per_sqm" style="display: inline;width:30%;" placeholder=" 0.00" onkeyup="javascript:calculateBoughtPrice()" >                               
                  <label>Bought Price </label>
                  <input id="inputPriceBought" class="form-control radio-inline" type="text" name="price_bought" style="display: inline;width:30%;" placeholder=" 0.00" readonly=""><br>
                  <label class="radio-inline" style="margin-top: 1em;">Terms of payment </label>
                  <select onchange="calculate(this.value);" class="custom-select radio-inline" name="payment_mode" style="display: inline;width:50%;">
                    <option value="0">One time payment</option>           
                    <option value="1">1 year</option>           
                    <option value="2">2 years</option>           
                    <option value="3">3 years</option>           
                    <option value="4">4 years</option>           
                    <option value="5">5 years</option>           
                    <option value="6">6 years</option>           
                    <option value="7">7 years</option>           
                    <option value="8">8 years</option>           
                    <option value="9">9 years</option>           
                    <option value="10">10 years</option>           
                  </select>
                </div> 
                <div class="form-group" id="rent">                                 
                  <label>Monthly Payment </label>
                  <input id="input_monthly_payment" class="form-control radio-inline" type="text" name="monthly_payment" style="display: inline;width:30%;" placeholder=" 0.00">
                </div>
                 <div class="form-group" id="rent">                                 
                  <label>Retail Price </label>
                  <input class="form-control radio-inline" type="text" name="price" style="display: inline;width:30%;" placeholder=" 0.00" required="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6" style="margin-top: 3.2em;">
          <div class="card mb-3">
            <div class="card-header">
             Additional information
            </div>
            <div class="card-body">
            <input type="hidden" name="condition" value="0">
            <!-- remove via update 10-05-2018
               <div class="form-group">
                <label >Property Condition: </label><br>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="condition" value="0" checked> Good
                </label>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="condition"  value="1"> Bad
                </label>                

              </div>
            -->
              <div class="form-group">
                <label >Property Type: </label><br>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="property_type" value="0" checked> Vacant Land
                </label>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="property_type"  value="1"> Residential Property
                </label>
                 <label class="form-control" style="border: none;">
                  <input type="radio" name="property_type"  value="2"> Commercial Property
                </label>

              </div>
                <input type="hidden" name="caretaker" value="0">
              <!-- remove via update 10-05-2018
              <div class="form-group">
                <label>Is there an onsite caretaker or any direct employee?: </label><br>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="caretaker" value="0" checked> Yes
                </label>
                <label class="form-control" style="border: none;">
                  <input type="radio" name="caretaker"  value="1"> No
                </label>                 
              </div>
              -->
            
               <div class="form-group">
                <label>Additional information/comments: </label><br>
                <textarea class="form-control" name="additional_info" rows="10"></textarea>
              </div>
          </form>
<!--upload image -->
              <div class="form-group">   
                <label>Attachment [e.g. Legal documents]</label>
                <div class="file_upload">
                  <form action="../snippet/upload-attachment.php" class="dropzone">
                    <div class="dz-message needsclick">
                      <strong>Drop files here or click to upload.</strong><br />
                      <span class="note needsclick">(Select or upload multiple attachment)</span>
                    </div>
                  </form>
                </div>
              </div> 
             
            </div>
          </div>
        </div>
      </div><!--row -->
      
      </div>
      
    </div>
</div>
 <!--  session error /no -->
<input type="hidden" value="<?php echo $_SESSION['ERR']; ?>" id="transactResult">


<?php
	include '../template/footer.php';
?>
<script type="text/javascript">

  function calculate(val){
   var total = parseInt(document.getElementById("inputPriceBought").value);
   var terms = 12 * (parseInt(val));
   var result = total / terms ;
    
   $('#input_monthly_payment').val(result);
}

 transactionValidate();
  function transactionValidate(){
     var error = $('#transactResult').val();
     if(error != ""){
         if(error == "success"){
          processingSuccess();
         }else{
          processingError();
         }
     }      
  }


  $(function() {
    $(".sidebar .nav-item").removeClass("active");
    $(".menu-attach-property").addClass("active");

});

 function calculateBoughtPrice(){
    
    var size        = Number($('#propertySize').val());
    var unit        = Number($('#sizeUnit').val());
    var pricePerSqm = Number($('#pricePerSqm').val());
    var result = 0;
   
    if(unit == 1){
      size *= 1000;
    }

    result = size * pricePerSqm;
    $("#inputPriceBought").val(result);

}
   

</script>