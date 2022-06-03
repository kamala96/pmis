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
 <?php $id = $this->session->userdata('user_login_id'); $basicinfo = $this->employee_model->GetBasic($id);?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                        <div class="row">
                    <div class="col-md-12">
                    <table class="table table-bordered" id="dynamic_field" style="height: 250px;"> 
                        <thead>
                        <tr style="text-transform: uppercase;">
                           <th>S/No</th>
                            <th width="95%">Objective</th>
                            <th style="text-align: right;">Marks</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($kpilist as $value) {?>
                                <tr>
                                    <td><?php echo $i;$i++; ?></td>
                                 <td>
                                   <a href="<?php echo base_url()?>Kpi/Target_goals?objectiId=<?php echo base64_encode($value->objective_id) ?>" style="text-decoration: none;text-decoration-color: none;"><?php echo $value->objective_name; ?></a> &nbsp;&nbsp;&nbsp;
                                        <?php foreach ($designation as $value1) {?>
                                            <?php if( $basicinfo->des_name == $value1->designation ){?>
                                                 <a href="staff_to_see?objective_id=<?php echo base64_encode($value->objective_id) ?>" class="btn btn-info">Add Staff To See This Objective</a>
                                            <?php } ?>
                                       <?php } ?>
                                       
                                 </td>
                                 <td style="text-align: center;">
                                    <?php echo $value->marks; ?>
                                 </td>
                                 </tr>
                            <?php } ?>
                            <tr>
                             
                              <td></td>
                              <td style="text-align: right;"><b>Total Marks::</b></td>
                               <td style="text-align: center;"><b><?php echo $sum->total; ?></b></td>
                        </tr>
                        </tbody>
                        <tr>  
                        </tr> 
                        </table> 
                               
                                </div>
                            </div>
                           <!--  <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info" type="submit" >Save KPI >>></button>
                            </div>
                        </div> -->
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
    function getGoals() {
    var obj = $('.obj').val();

     $.ajax({
     url: "<?php echo base_url();?>Kpi/Get_Goals",
     method:"POST",
     data:{objid:obj},
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>
<script type="text/javascript">
    function getMarks() {
    var obj = $('.obj').val();

     $.ajax({
     url: "<?php echo base_url();?>Kpi/Get_Marks",
     method:"POST",
     data:{objid:obj},
     success: function(data){

         $(".marks").html(data);
         $('.results').hide();
         $('.thresults').hide();
         $('.marks').show();
         $('.thmarks').show();
     }
 });
};
</script>
<script type="text/javascript">
    function getGoals2() {
    var obj = $('.obj').val();

     $.ajax({
     url: "<?php echo base_url();?>Kpi/Get_Goals2",
     method:"POST",
     data:{objid:obj},
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>
<script type="text/javascript">
    function Redirect() {
    var obj = $('#branchdropo').val();
    
    $.ajax({
     url: "<?php echo base_url();?>Kpi/Get_Goals2",
     method:"POST",
     data:{objid:obj},
     success: function(data){
        var m = $.trim(data);
         if(m === "No"){
             var obj = $('#branchdropo').val();
             window.location= "add_kpi_goals?kpi_id="+obj;
        }else{
            
            $('.results').html(data);
            $('.results').show();
             $('.thresults').show();
            $('.marks').hide();
            $('.thmarks').hide();

        }

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