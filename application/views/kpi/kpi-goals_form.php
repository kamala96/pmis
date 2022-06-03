    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Kpi Form</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Kpi Form</li>
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
            <form method="POST" action="<?php echo base_url()?>kpi/kpi_goal_value"> 
                <div class="row">
                    
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Kpi Goals Form<span class="pull-right " ></span></h4>
                        </div>
                        <?php if(empty($this->session->userdata('message'))){ ?>
                    <?php }else{ ?>
                        <?php echo $this->session->userdata('message'); ?>
                    <?php }?>
                        <div class="card-body">
                            <div class="row">
                    <div class="col-md-12">
                    <input type="hidden" name="kpiid" value="<?php echo $kpi_id; ?>">
                    <table class="table" id="dynamic_field" style="height: 250px;width: 1000px;"> 
                    
                        <tr>  
                        <td style="">
                            <label> [ KPI Vlues]</label>
                            <textarea name="kpi[]" class="form-control stid"  required="required" rows="10"></textarea>
                        </td>
                        <td style="">
                            <label> [ Marks]</label>
                            <input type="text" name="marks[]" class="form-control stid"  required="required" rows="10">
                        </td>
                        <td style="padding-top: 43px;">
                            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </td>  
                        </tr> 
                        </table> 
                    </div>
                    </div>
                            <div class="row">
                            <div class="col-md-12" style="padding-left: 25px;">
                                <button class="btn btn-info" type="submit">Save KPI >>></button>
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
           $('#dynamic_field').append('<tr id="row'+i+'"><td>'+' <textarea name="kpi[]" class="form-control stid"  required="required" rows="10"></textarea>'+'</td><td>'+' <input type="text" name="marks[]" class="form-control"  required="required" rows="10">'+'</td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">Remove</button></td></tr>');  
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
            timeout: 6000,
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