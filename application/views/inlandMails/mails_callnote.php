    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
/* Box styles */
.myBox {
border: 3px solid #ccc;
padding: 5px;
font: 18px/36px sans-serif;
width: 80%px;
color:#000;
height: 580px;
overflow: scroll;
}

/* Scrollbar styles */
::-webkit-scrollbar {
width: 12px;
height: 12px;
}

::-webkit-scrollbar-track {
border: 1px solid yellowgreen;
border-radius: 10px;
}

::-webkit-scrollbar-thumb {
background: #d22c19;  
border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
background: #000;  
}
</style>
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa fa-envelope-open-o" aria-hidden="true"></i>  Call Note </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"> Mails </li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                  
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                             <a href="<?php echo site_url('Mail_box/single_callnote');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Duplicate Call Note </button> </a>

                           <!--  <h4 class="m-b-0 text-white"><i class="fa fa fa-address-card-o" aria-hidden="true"></i>  Call Note Form <span class="pull-right " ></span></h4> -->
                        </div>
						
                        
                        <div class="card-body">
						<!-- Contents -->
								   
           <form name="add_name" id="add_name" method="post" action="<?php echo site_url('Mail_box/print_callnote');?>">
            <table class="table table-bordered table-hover" id="dynamic_field">
              <tr>
                <td><input type="text" name="name[]" placeholder="Enter Name" class="form-control name_list" required></td>
                <!-- <td><input type="text" name="fplno[]" placeholder="Enter FPL No. / FGN No." class="form-control name_fplno" required></td> -->
				 <td> <input type="number" name="address[]" class="form-control name_address" placeholder="Enter Box Number" required> </td>
				  <td><input type="text" name="identifier[]" class="form-control name_identifier" placeholder="Enter Identifier Number" required> </td>
                <td><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
              </tr>
            </table>
            <input type="submit" class="btn btn-info" name="submit" id="submit" value="Submit">
			<a href="<?php echo base_url('Services/Inland_Mail'); ?>" <button type="button" class="btn btn-info">Cancel</button> </a>
            </form>
							
							
						<!-- End Contents -->	
                     </div>
                </div>
            </div> 
            
        
         </div>
                          
    </div>

<script type="text/javascript">
  $(document).ready(function(){

    var i = 1;

    $("#add").click(function(){
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter Name" class="form-control name_list" required></td>  <td> <input type="text" name="address[]" class="form-control name_address" placeholder="Enter Address" required> </td> <td><input type="text" name="identifier[]" class="form-control name_identifier" placeholder="Enter Identifier Number" required> </td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    });

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    });
  });
</script>

<?php $this->load->view('backend/footer'); ?>