<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Bill Customer To Other</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Bill Customer To Other</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_form" class="text-white"><i class="" aria-hidden="true"></i> Add Cash Register Customer</a></button>
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE"){ ?>
                         <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/Bill_Customer_list" class="text-white"><i class="" aria-hidden="true"></i> Bill Register Customer List</a></button>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/Bill_Customer_form" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Register Customer</a></button>
                   <?php } ?>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/register_application_list" class="text-white"><i class="" aria-hidden="true"></i> Register Cash Transactions List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button>
                </div>
            </div>
            <form method="POST" action="service_to_other"> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Region And Branch For Service<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                         
                    <table class="table" id="dynamic_field"> 
                        <tr><td colspan="3">
                            <?php if(!empty($message)){ ?>
                            <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $message;?>
                          </div>
                          <?php }elseif(!empty($errormessage)){?>
                            <div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Warning!</strong> <?php echo $errormessage; ?>
                          </div>
                          <?php }else{?>
                          <?php } ?>
                        </td></tr>
                    <input type="hidden" name="cust_name" value="<?php  if(!empty($cust)){
                        echo $cust;
                            }else{
                                echo $cust1;
                            }   ?>">
                        <tr>  
                        <td>
                            <label> [ Region ]</label>
                            <select name="reg[]" class="custom-select form-control stid" onchange="getStampname();" required="required">
                                        <option value="">--Select Region --</option>
                                        <?php foreach ($region as $value) {?>
                                            <option value="<?php echo $value->region_id; ?>"><?php echo $value->region_name; ?></option>
                                        <?php } ?>
                                    </select>
                        </td>
                        <td>
                            <label>[ Branch ]</label>
                        <select name="branch[]" class="custom-select form-control stockname">
                            <option value="">--Select Branch--</option>
                            </select>
                        </td>
                        
                        <td style="padding-top: 45px;">
                            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </td>  
                        </tr> 
                        </table> 
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info" type="submit">Save Information >>></button>
                            </div>
                        </div>
                        </div>

                     </div>
                </div>
            </div> 
            
        </form>
         </div>
                          
    </div>
<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td>'+'<select class="form-control custom-select st'+ i +'" name="reg[]" onChange="getStamp('+i+');" required="required" id="">'+'<option value="">-- Select Region--</option>'+
                <?php foreach ($region as $value) {?>
                 '<option  value="<?php echo $value->region_id; ?>"><?php echo $value->region_name;?></option>'+<?php  } ?>
      '</select>'+'</td><td>'+'<select class="form-control custom-select stocks'+i+'" name="branch[]">'+'<option value="">-- Select Branch--</option>'+
                
      '</select>'+'</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">Remove</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
   

    <script type="text/javascript">
        function getStampname() {
            var region_id = $('.stid').val();
             $.ajax({

            url: "<?php echo base_url();?>Bill_Customer/GetBranch",
                method:"POST",
          data:{region_id:region_id},//'region_id='+ val,
          success: function(data){
           $(".stockname").html(data);

        }
        });
    };
    </script>
    <script type="text/javascript">
        function getStamp(i) {
            var i = i;
    var region_id = $('.st'+ i ).val();
             $.ajax({

            url: "<?php echo base_url();?>Bill_Customer/GetBranch",
                method:"POST",
          data:{region_id:region_id},//'region_id='+ val,
          success: function(data){
           $(".stocks"+i).html(data);

        }
        });
        };
</script>

<?php $this->load->view('backend/footer'); ?>
