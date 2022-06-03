    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> MObjectives </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Objectives</li>
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
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  Objectives Lists<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                            <div class="row">
                    <div class="col-md-12">
                    <table class="table table-bordered" id="dynamic_field" style="height: 250px;"> 
                        <tr style="text-transform: uppercase;">
                            <th>S/No</th>
                            <th>Objective</th>
                            <th>Marks</th>
                            <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_emid') == "Kas1574" ){ ?>
                            <td>Actions</td>
                        <?php } ?>
                        </tr>
                        <?php $i =0; foreach ($kpilist as $value) {?>
                            
                        <tr>  
                        <td style=""><?php $i++; echo  $i;?></td>
                        <td style="">
                            <a href="Target_goals?objectiId=<?php echo base64_encode($value->objective_id) ?>"><?php echo  $value->objective_name .'   ';?></a>&nbsp; <a href="<?php echo base_url()?>kpi/add_my_goals?kpi_id=<?php echo base64_encode($value->objective_id)?>" style="color: red;" class="btn btn-info btn-sm">Add Target|Goals</a>
                        </td>
                        <td><?php echo $value->marks; ?> </td>

                        <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_emid') == "Kas1574" ){ ?>

                        <td>

                            <input type="hidden" name="objId" value="<?php echo $value->objective_id ?>"><button class="btn btn-danger btn-sm" name="delete" value="delete">Delete</button>  <a href="<?php echo base_url()?>kpi/edit_kpi?kpid=<?php echo base64_encode($value->objective_id) ?>" class="btn btn-warning btn-sm" name="edit" value="edit">Edit</a></td>
                        <?php } ?>
                        </tr> 
                        <?php } ?>
                        <tr>
                            <td></td>
                             <td style="text-align: right;"><b>Total Marks::</b></td>
                              <td><b><?php echo $sum->total; ?></b></td>
                               <td></td>
                        </tr>
                        </table> 

                               
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