<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style type="text/css">
  .editable-select{
        width: 90%;
  }
  .jumbotron{
    padding: 2rem 2rem;
  }
</style>


      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Add Property</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Realestate/Propertylist">Property List</a></li>
                        <li class="breadcrumb-item active">Add Property</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <?php $usertype = $this->employee_model->getusertype(); ?>
    <?php  ?>
    <?php $regvalue1 = $this->employee_model->branchselect(); ?>
            <div class="container-fluid">

                <div class="row m-b-10"> 
                    <!-- <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Realestate/Propertylist" class="text-white"><i class="" aria-hidden="true"></i>  Back Property List</a></button>
                        
                    </div> -->


                </div>
              
    
  <div id="content-wrapper">

<div class="container-fluid">



                             <?php 
                            if(!empty($this->session->flashdata('feedback'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('feedback'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>

                            <?php 
                            if(!empty($this->session->flashdata('success'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('success'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>

 
  <div class="row">       
    <div class="col-lg-6">


                           



     <form action="Saveproperty" method="POST" enctype="multipart/form-data">
   
     <button class="btn btn-primary" type="submit" style="margin-bottom: 1em;">Save Property</button>      
     <!-- <button class="btn btn-primary" type="submit" style="margin-bottom: 1em;">Save Property</button>           -->
      <div class="card mb-3">
        <div class="card-header">
         Property Information
        </div>
        <div class="card-body">
        


          <div class="form-group">
            <label >Property Type: </label><br>

<input type="radio" id="Residential" name="propertytype" value="Residential">
<label for="Residential">Residential</label>
<input type="radio" id="Land" name="propertytype" value="Land">
<label for="Land">Land</label>
<input type="radio" id="Offices" name="propertytype" value="Offices">
<label for="Offices">Offices</label>
<input type="radio" id="Conference" name="propertytype" value="Conference">
<label for="Conference">Conference</label>

          </div>


          <div class="form-group ">
            <!-- <label>Issue Date </label><br> -->
               <input type="text" name="property_name" placeholder="Property name" class="form-control " style="width: 80%;display: inline;"   required="required"> 
                                  
                                    
          </div>
          <div class="form-group ">
            <!-- <label>Issue Date </label><br> -->
              <input type="text" name="RegistrationNo" placeholder="Registration number"class="form-control " style="width: 40%;display: inline;"  required ="required">  

                <input type="text" name="Plot" placeholder="Plot number"class="form-control " style="width: 40%;display: inline;"  required ="required">                    
                                    
          </div>
          
          <div class="form-group ">
            <!-- <label>Issue Date </label><br> -->
               <input type="Number" name="property_size" placeholder="Property size" class="form-control" style="width: 40%;display: inline;"   required="required"> 
               <select id="sizeUnit" class="form-control" name="size_unit" style="width: 40%;display: inline;">
                <option value=""> Unit size </option>
                  <option value="Square Meter">Square Meter</option>    
                  <option value="Hectare">Hectare</option>    
               </select>                   
          </div>

          <div class="form-group ">
            <!-- <label>Issue Date </label><br> -->
            <select name="Region" value="" class="form-control custom-select" style="width: 40%;display: inline;" required id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                
                                <select name="district" class="form-control branch" id="branchdropo" style="width: 40%;display: inline;">  
                                 <option value=""> District </option>
                                </select>
                           
                              
          </div>
          <div class="form-group ">
            <!-- <label>Issue Date </label><br> -->
               <input type="text" name="address" placeholder="address" class="form-control " style="width: 40%;display: inline;"   required="required"> 
                <input type="text" name="postal_code" placeholder="Postal Code"class="form-control " style="width: 40%;display: inline;"  required ="required">                    
                                    
          </div>


         
                     
          <!--upload property image -->
            <div class="input-group addborder" style="margin-bottom: 1em;">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            Browse… picture <input type="file" id="imgInp" name="cover">
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
            <!--upload property image -->
          <!-- if subdevided lot-->
           <i class="text-muted small">Fill up if subdevided </i>
          <div class="form-group jumbotron" style="text-align: center;">

            <label>Block: 
              <input type="text" name="block" class="form-control" placeholder="value numeric">
            </label>
            <!-- <label>Lot: 
              <input type="text" name="lot" class="form-control" placeholder="value numeric">
            </label> -->
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
        <input type="hidden" name="property_condition" value="0">
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
            <label >Property Status: </label><br>
<input type="radio" id="Developed" name="Status" value="Developed">
<label for="Developed">Developed</label>
<input type="radio" id="Developed(tpc/ttcl)" name="Status" value="Developed(tpc/ttcl)">
<label for="Developed(tpc/ttcl)">Developed(tpc/ttcl)</label>
<input type="radio" id="Undeveloped" name="Status" value="Undeveloped">
<label for="Undeveloped">Undeveloped</label>


          </div>
          <div class="form-group" id="sale">  
             <!-- <label>Price per Sq.m. </label> -->
              <input id="pricePerSqm" class="form-control radio-inline" type="Number" name="price_per_sqm" style="display: inline;width:40%;" placeholder=" Price per Sq.m." onkeyup="javascript:calculateBoughtPrice()" >                               
              <!-- <label>Bought Price </label> -->
              <input id="inputPriceBought" class="form-control radio-inline" type="Number" name="PropertyValue" style="display: inline;width:40%;" placeholder="Property Value"  required="required"><br>
             
            </div> 
            <div class="form-group" id="sale">  
             <!-- <label>Price per Sq.m. </label> -->
              <input id="landvalue" class="form-control radio-inline" type="Number" name="LandValue" style="display: inline;width:40%;" placeholder=" Land Value" onkeyup="javascript:calculateBoughtPrice()" >                               
              <!-- <label>Bought Price </label> -->
              <input id="totalprice" class="form-control radio-inline" type="Number" name="Totalprice" style="display: inline;width:40%;" placeholder=" Total price" ><br>
             
            </div> 
            <div class="form-group" id="rent">                                 
              <label>Monthly Payment </label>
              <input id="input_monthly_payment" class="form-control radio-inline" type="Number" name="monthly_paymentRent" style="display: inline;width:50%;" placeholder=" 0.00" required="required">
            </div>

          <!-- <div class="form-group">
            <label >Property Condition: </label><br>
            <label class="form-control" style="border: none;">
              <input type="checkbox" name="property_condition" value="0" id="1" checked> Vacant Land
            </label>
            <label class="form-control" style="border: none;">
              <input type="checkbox" name="property_condition" id="2"  value="1"> Residential Property
            </label>
             <label class="form-control" style="border: none;">
              <input type="checkbox" name="property_condition" id="3" value="2"> Commercial Property
            </label>

          </div> -->

            <!-- <input type="hidden" name="caretaker" value="0"> -->
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
          
         
        </div>
      </div>
    </div>
  </div><!--row -->
  
  </div>
  
</div>
</div>
    
<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Realestate/RealEsategetDistrict",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>
    
    
    
    


<script>
$( "#target" ).keyup(function() {
  //alert( "Handler for .keyup() called." );
});
</script>
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
   
 //upload image js
 $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
          
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });   
      });
</script>
<?php $this->load->view('backend/footer'); ?>

