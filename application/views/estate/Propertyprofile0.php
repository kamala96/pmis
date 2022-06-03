<?php //$this->load->view('backend/header'); ?>
<?php //$this->load->view('backend/sidebar'); ?>

<style>

	.active_tab1
	{
		background-color:#fff;
		color:#333;
		font-weight: 600;
	}
	.inactive_tab1
	{
		background-color: #f5f5f5;
		color: #333;
		cursor: not-allowed;
	}
	.has-error
	{
		border-color:#cc0000;
		background-color:#ffff99;
	}
</style>

<div class="">
	<!--<div class="message"></div>
	 <div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>Property Profile </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active">Details 
                list </li>
			</ol>
		</div>
	</div> -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); ?>
	<div class="container-fluid">
		<!-- <div class="row m-b-10">
			<div class="col-12">
			 <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php //echo base_url(); ?>Realestate/Propertylist" class="text-white"><i class="" aria-hidden="true"></i>  Back Property List</a></button>
			
			</div>
		</div> -->

        <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
               
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="kiwi" class="table table-bordered table-property" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th >PHOTO</th>
                                <th>BUILDING/PLOT DETAILS</th>
                                <th>OTHER DETAILS</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                        
                        </tfoot>
                        <tbody>
                        <?php
                            foreach ($property as $value) {
                            

                            $id = $value->id;
                            $address = $value->address;
                            $PropertyUsage = $value->PropertyUsage;
                            $property_size =  $value->property_size;
                            $RegistrationNo =$value->RegistrationNo; 
                            $DateofReg = $value->DateofReg;
                           
                            $Status = $value->Status;
                            $image_path = $value->image_path;
                           
                            $Region = $value->Region;
                            $block =$value->block;
                            $lot = $value->lot;
                            $price_per_sqm = $value->price_per_sqm;

                          

                                
                                    echo '<tr style="width: 100%;">';
                                
                                echo ' <td style="width: 10%;">';
                                if($image_path != "no-image-land.png"){
                                    echo '<img src="'.base_url().'images/'.$image_path.'" style="width: 150px; height: 140px;">';
                                }else{
                                    echo '<img src="'.base_url().'images/no-image-land.png" style="width: 150px; height: 140px;">';
                                }
                                echo '</td> ';
                                echo '<td style="width: 40%;">';
                                echo ' <span>Property Type: </span> <span>'. $value->property_type.'</span><br>';
                                echo ' <span>Property Name: </span> <span>'. $value->property_name.'</span><br>';
                                echo ' <span>Registration Number: </span> <span>'.$value->RegistrationNo.'</span><br>';
                                echo ' <span>Registration Date: </span> <span class="box-owner">'.$value->DateofReg.'</span><br>';
                                echo ' <span>Property Usage: </span> <span>'.$value->PropertyUsage.'</span><br>';
                                //echo ' <span>Property Type: </span> <span>'.$value->property_type.'</span><br>';
                                echo ' <span>Status: </span> <span>'.$value->Status.' </span> <br>';
                                
                                if($block == "" && $lot != ""){
                                    echo ' <span>Address: </span> <span> '.' lot '.$lot.' ,'.$address.' </span><br>';
                                }else if($lot == "" && $block != ""){
                                    echo ' <span>Address: </span> <span> block '.$block.' ,'.$address.' </span><br>';  
                                }else if($block == "" && $lot == ""){
                                    echo ' <span>Address: </span> <span> '.$address.' </span><br>';  
                                }
                                else{
                                    echo ' <span>Address: </span> <span> block '.$block.' lot '.$lot.' ,'.$address.' </span><br>';  
                                }
                                echo ' <span>Region: </span> <span>'.$value->Region.'  </span> <br>';
                                echo "</td>";

                                echo '<td style="width: 40%;">';
                                echo ' <span>Property Size: </span> <span>'.$value->property_size.'</span><span> '.sizeUnit($value->size_unit).'</span><br>';
                                echo ' <span>Property Value: </span> <span>TSHS '.number_format($value->PropertyValue).'</span><br>';
                                echo ' <span>Land Value: </span> <span>TSHS '.number_format($value->LandValue).'</span><br>';
                                
                                echo ' <span>Total price: </span> <span style="color:#1410e0;" class="price price2">TSHS '.number_format($value->Totalprice).'</span><br>';
                                echo ' <span>monthly Rent Vat Exclusive: </span> <span class="price ">TSHS '.number_format($value->monthly_paymentRent).'</span><br>';
                                echo "</td>";

                                
                                echo "</tr>";
                            } 
                            
                        ?>                                                                                        
                        </tbody>
                        </table>
              

                     </div>
                 </div>





						
	    	</div>
		</div>
	</div>
    <?php 
function sizeUnit($var){
    $var = $var;
 
     switch ($var) {
 
       case 0:
         $var = "Square meter";
         break;
 
       case 1:
         $var = "Hectare";
         break;
 
       default:
         $var = "Something went wrong";
         break;
     }
 
     return $var;
 } 

?>
 

	</div>
</div>

<script type="text/javascript">
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

      $(document).ready(function() {
      
         $('#datetimepicker').datetimepicker({
            format: 'yyyy-MM-dd',
            language: 'en'
        });
</script>







	<?php $this->load->view('backend/footer'); ?>

	
	