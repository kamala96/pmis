    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> My Kpi </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">My Kpi</li>
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
            <form method="POST" action="<?php echo base_url()?>kpi/add_kpi"> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  My Kpi<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                            <div class="row">
                    
                    <table class="table" id="dynamic_field" style="height: 250px;"> 
                        
                        <?php foreach ($kpilist as $value) {?>
                            
                        <tr>  
                        <td style="width: 400px;">
                            <textarea name="Objective" class="form-control stid"  required="required" rows="10"><?php echo  $value->objective; ?></textarea>
                        </td>
                        <td style="width: 400px;">
                            <textarea name="Goal" class="form-control stid"  required="required"  rows="10"><?php echo  $value->goal; ?></textarea>
                            
                        </td>
                        <td style="width: 400px;">
                             <textarea name="KPI" class="form-control stid"  required="required"  rows="10"><?php echo  $value->kpi; ?></textarea>
                            </td> 
                            <td>
                            <input type="text" name="Weight" class="form-control" required="required" style="width: 75px;" value="<?php echo  $value->weight; ?>"></td>
                            <td style="width: 300px;">
                            <select class="custom-select form-control" name="Division">
                                <option>--Select Division--</option>
                                <?php if($this->session->userdata('user_type') == "PMG"){ ?>
                                    <option>CIPA</option>
                                    <option>H/S&I</option>
                                    <option>H/IA&I</option>
                                    <option>PMU</option>
                                    <option>H/UPU-RTC</option>
                                    <option>CS</option>
                                    <option>GMCRM</option>
                                    <option>GMBOP</option>
                                    <option>OMS-PMG</option>
                                <?php }elseif($this->session->userdata('user_type') == "CRM"){?>
                                    <option>M/HR</option>
                                    <option>M/CF&A</option>
                                    <option>M/CP</option>
                                    <option>H/REM</option>
                                    <option>OMS-GM/CRM</option>
                                    
                                <?php }elseif($this->session->userdata('user_type') == "BOP"){?>
                                    <option>M/MKT</option>
                                    <option>M/EB</option>
                                    <option>M/CIS</option>
                                    <option>M/FAS</option>
                                    <option>M/EMS</option>
                                    <option>M/MLB</option>
                                    <option>AM/PSI</option>
                                    <option>AM/SB</option>
                                    <option>OMS-PMG</option>
                                <?php }elseif($this->session->userdata('user_type') == "RM"){?>

                                <?php }?>
                                
                            </select>
                        </td>
                        </tr> 
                        <?php } ?>
                        </table> 
                               
                                
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info" type="submit">Send Request >>></button>
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
           $('#dynamic_field').append('<tr id="row'+i+'"><td>'+' <textarea name="Objective[]" class="form-control stid"  required="required" rows="10"></textarea>'+'</td><td>'+'<textarea name="Goal[]" class="form-control stid"  required="required"  rows="10"></textarea>'+'</td><td>'+'<textarea name="KPI[]" class="form-control stid"  required="required"  rows="10"></textarea>'+'<td><input type="text" name="Weight[]" class="form-control" required="required"></td><td style="width: 75px;">'+'<select class="form-control custom-select" name="Division[]" required="required" id="">'+'<option value="">-- Select Division--</option>'+
               
                 '<option>PMG</option><option>GMCRM</option><option>GMBOP</option>'+'</select>'+'</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">Remove</button></td></tr>');  
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

<script type="text/javascript">
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
                $(".message").fadeIn('fast').delay(6000).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},6000);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});
</script>
<?php $this->load->view('backend/footer'); ?>

    </p>