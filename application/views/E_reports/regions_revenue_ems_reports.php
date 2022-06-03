<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
<style type="text/css">  
table {
    border:solid #000 !important;
    border-width:1px 0 0 1px !important;
}
th, td {
    border:solid #000 !important;
    border-width:0 1px 1px 0 !important;
    padding: 3px !important;
    color: #000 !important;
}

</style>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Download EMS Revenue Collection Report  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Reports </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   <div class="card-header">

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports" class="text-white"><i class="" aria-hidden="true"></i>  Download Reports </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>E_reports/list_revenue_reports" class="text-white"><i class="" aria-hidden="true"></i>  Download History </a></button>

                    </div>
                            
                            <div class="card-body">

                         
                           <h4 class="statusText"></h4>
                            <form class="row">

                            <div class="col-md-3">
                             <select class="form-control custom-select report" name="report" id="report" onChange ="getDate();">
                                 <option value="Daily">Daily Report</option>
                                 <option value="Weekly">Weekly  Report</option>
                                 <option value="Monthly">Monthly Report</option>
                             </select>
                             </div>

                          <div class="col-md-3 DayBtn2" style="display: none;">
                             <input type="date" name="fromdate" class="form-control fromdate" id="fromdate">
                          </div>

                           <div class="col-md-3 DayBtn2" style="display: none;">
                             <input type="date" name="todate" class="form-control todate" id="todate">
                          </div>

                          <div class="col-md-3 Day">
                             <input type="date" name="date" class="form-control date" id="date">
                          </div>

                          <div class="col-md-3 Month" style="display: none;">
                             <input type="month" name="month" class="form-control month" id="month">
                          </div>


                                    <div class="col-md-3">
                                    <select class="form-control region" name="region" id="region">
                                        <option value="all"> --  Select All Regions-- </option>
                                        <?php foreach($listbranch as $data){ ?>
                                        <option value="<?php echo $data->region_id; ?>"> <?php echo $data->region_name; ?> </option>
                                    <?php } ?>
                                    </select>
                                    </div>
                                    
                                    

                                    <div class="col-md-12">
                                        <br>
                                         <button type="submit" id="BtnSubmit" class="btn btn-info BtnSubmit"> <i class="fa fa-download"></i> Download </button>
                                    </div>
                            </form>


                             <div id="div6" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="list" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                            </div>
                                                     
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>
<script type="text/javascript">
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>

<script type="text/javascript">
        function getDate() {

    var val = $('.report').val();
    if (val == 'Daily') {
        $('.Day').show();
        $('.Month1').hide();
        $('.Month2').hide();
        $('.Month').hide();
         $('.DayBtn1').hide();
        $('.DayBtn2').hide();
         $('.Year').hide();
    }else if (val == 'Weekly') {
        $('.Day').hide();
        $('.Month').hide();
        $('.Month1').hide();
        $('.Month2').hide();

        $('.DayBtn1').show();
        $('.DayBtn2').show();
         $('.Year').hide();
    
    }else if (val == 'Monthly') {
        $('.Day').hide();
        $('.Month').show();
        $('.Month1').hide();
        $('.Month2').hide();
        $('.DayBtn1').hide();
        $('.DayBtn2').hide();
         $('.Year').hide();
    }else if (val == 'Year') {
        $('.Day').hide();
        $('.Month').hide();
        $('.Year').show();
        $('.Month1').hide();
        $('.Month2').hide();
         $('.DayBtn1').hide();
        $('.DayBtn2').hide();
    }else{
        $('.Day').hide();
        $('.Month').hide();
        $('.Year').hide();
        $('.Month1').show();
        $('.Month2').show();
         $('.DayBtn1').hide();
        $('.DayBtn2').hide();
    }
     
};
</script>


<script>
   $(document).ready(function() {
   
       $(".BtnSubmit").on("click", function(event) {
            event.preventDefault();
           var date = $('#date').val();
           var fromdate = $('#fromdate').val();
           var todate = $('#todate').val();
           var month = $('#month').val();
           var report = $('#report').val();
           var region = $('#region').val();
       $('.statusText').html('<h3><strong>Please wait......</strong></h3>');
        $('#div6').hide();

             $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>E_reports/cron_ems_report",
              data:{date:date,fromdate:fromdate,todate:todate,region:region,month:month,report:report},
              //dataType:'json',
              success: function(data) {
                $('.statusText').html('<h3><strong> Download Revenue Collection report </strong></h3>');
                  $('#div6').show();
                 $('.list').html(data);
                 }
             });
       });

   });

</script>

<?php $this->load->view('backend/footer'); ?>