    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> General Kpi Report </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"> General Kpi Report</li>
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
            <form method="POST" action="<?php echo base_url()?>kpi/general_kpi_report"> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> General Kpi Report<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                        <div class="row">
                    <div class="col-md-12">
                    
                    <table width="100%">
                        <tr>
                        <td width="80%">
                            <select class="js-example-basic-multiple form-control" name="em_id">
                                <option>--Selec Employee--</option>
                                <?php foreach ($employee as $value) {?>
                                   <option value="
                                   <?php echo $value->des_name;?>"><?php echo strtoupper( $value->first_name.'  '.$value->middle_name.'  '.$value->last_name) ?>
                                       
                                   </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td style="">
                            <button class="btn btn-info" type="submit">Show Kpi Report</button>
                        </td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-bordered" id="dynamic_field" style="height: 250px;"> 
                        <thead>
                        <tr style="text-transform: uppercase;">
                           <th>S/No</th>
                            <th width="">Objective</th>
                            <th>Goals | Targets</th>
                            <th>Kpi</th>
                            <th style="text-align: right;">Marks</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $d=1; foreach ($kpilist as $value) {?>
                                <tr>
                                    <td><?php echo $d;$d++; ?></td>
                                 <td>
                                  <?php echo $value->objective_name; ?>
                                 </td>
                                 <td>
                                     <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>
                                        <?php $i=1; foreach ($goals as $report) { ?>
                                        <?php echo $i;$i++; echo '.              '; echo $report->target_name. '   '.'<br>'; ?>
                                     <?php } ?>
                                     <?php }?>
                                 </td>
                                 <td>
                                     <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php $i=1; foreach ($goals as $report) { ?>
                                        <?php echo $i;$i++; echo '.              '; echo $report->target_name. '   '.'<br>';

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            $s=1;
                                            foreach ($kpi as $key) {
                                                ?>
                                             &nbsp;&nbsp;&nbsp;&nbsp; <?php  echo '              '. $s;$s++; echo '.              '; echo $key->kpi_values; ?>  &nbsp;&nbsp;&nbsp;            <b>Marks(<?php echo $key->marks ?>)</b><br>
                                          <?php  }
                                            
                                         ?>
                                     <?php } ?>
                                     <?php }?>
                                 </td>
                                 <td style="text-align: center;">
                                    <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php $sum1=0;  $i=1; foreach ($goals as $report) { ?>
                                        <?php

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            foreach ($kpi as $key) {
                                                ?>
                                                <?php  $sum1+=$key->marks ?>
                                          <?php  }
                                            
                                         ?>
                                     <?php } echo $sum1; ?>
                                     <?php }?>
                                 </td>
                                 </tr>
                            <?php } ?>
                            <tr>
                             <td></td>
                             <td></td>
                              <td></td>
                              <td style="text-align: right;"><b>Total Marks::</b></td>
                               <td style="text-align: center;"><b><?php $sum1=0; foreach ($kpilist as $value) {?>
                                   <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php   $i=1; foreach ($goals as $report) { ?>
                                        <?php

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            foreach ($kpi as $key) {
                                                ?>
                                                <?php  $sum1+=$key->marks ?>
                                          <?php  }
                                            
                                         ?>
                                     <?php }  ?>
                                     <?php }?>
                                   <?php } echo $sum1;?>
                               </b></td>
                        </tr>
                        </tbody>
                        <tr>  
                        </tr> 
                        </table> 
                               
                                </div>
                            </div>
                          <div class="row">
                            <div class="col-md-12" style="text-align: right;">
                                <?php if(!empty($kpilist)){ ?>
                                     <a href="Dowloan_KPI_Report?des_name=<?php echo base64_encode(trim($design)) ;?>" class="btn btn-info">Download KPI Report >>></a>
                                <?php }?>
                               
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
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<?php $this->load->view('backend/footer'); ?>

    </p>