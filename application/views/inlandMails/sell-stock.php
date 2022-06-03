<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Sell Iterm Form</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Sell Iterm Form</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <?php $degvalue = $this->employee_model->getdesignation(); ?>
        <?php $depvalue = $this->employee_model->getdepartment(); ?>
        <?php $usertype = $this->employee_model->getusertype(); ?>
         <?php $auth =  $this->session->userdata('sub_user_type'); ?>
        <?php $regvalue1 = $this->employee_model->branchselect(); ?>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-info"><i class=""></i><a href="<?php echo base_url()?>inventory/dashboard" class="text-white"><i class="" aria-hidden="true"></i> <<< Back To Dashboard </a></button>
                
                </div>
            </div>
            <form method="POST" action="<?php echo base_url()?>inventory/sell_iterm"> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  Sell Iterm Form<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                            <div class="row">
                    <h3 style="color: red;">Are you Sure you want to sell this iterm</h3>
                    <table class="table" id="dynamic_field"> 
                    
                        <tr>  
                        <td>
                            <label> [ Customer Full Name ]</label>
                            <input type="text" name="fullname" class="form-control" value="">
                           
                        </td>
                        <td>
                            <label>[ Customer Phone Number ]</label>
                            <input type="text" name="phone" class="form-control" value="">

                        </td>
                    <input type="hidden" name="id"  class="form-control" value="<?php echo $id;?>">     </tr> 
                          <tr>
                            <td>
                            <label>[ Email ]</label>
                            <input type="text" name="email" class="form-control" value="">
                        </td> 
                        <td>
                            <label>[ Quantity ]</label>
                            <input type="text" name="quantity" class="form-control" value="">
                        </td> 
                          </tr>
                        </table> 
                               
                                
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info" type="submit">Sell Iterm >>></button>
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
           $('#dynamic_field').append('<tr id="row'+i+'"><td>'+'<select class="form-control custom-select st'+ i +'" name="stock_type[]" onChange="getStamp('+i+');" required="required" id="">'+'<option value="">-- Select Stock--</option>'+
                <?php foreach ($categorystock as $value) {?>
                 '<option  value="<?php echo $value->Stock_Category_Id; ?>"><?php echo $value->CategoryName;?></option>'+<?php  } ?>
      '</select>'+'</td><td>'+'<select class="form-control custom-select stocks'+i+'" name="stock_name[]" required="required">'+'<option value="">-- Select Stock--</option>'+
                
      '</select>'+'</td><td><input type="text" name="quantity[]" class="form-control" required="required"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">Remove</button></td></tr>');  
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
            var stid = $('.stid').val();
             $.ajax({

            url: "<?php echo base_url();?>inventory/getStockName",
                method:"POST",
          data:{stid:stid},//'region_id='+ val,
          success: function(data){
           $(".stockname").html(data);

        }
        });
    };
    </script>
    <script type="text/javascript">
        function getStamp(i) {
            var i = i;
    var stid = $('.st'+ i ).val();
             $.ajax({

            url: "<?php echo base_url();?>inventory/getStockName",
                method:"POST",
          data:{stid:stid},//'region_id='+ val,
          success: function(data){
           $(".stocks"+i).html(data);

        }
        });
        };
</script>

<!-- <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});
</script> -->
<?php $this->load->view('backend/footer'); ?>

    </p>