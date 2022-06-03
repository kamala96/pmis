<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Ems Report</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Ems Report</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                   <a href="<?php echo base_url() ?>Box_Application/Ems" class="btn btn-primary"><i class="fa fa-plus"></i> Ems Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Report                      
                        </h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-3">
                            <label>Select Report Season</label>
                             <select class="form-control custom-select reprt" onChange ="getDate();">
                                 <option>--Select Option--</option>
                                 <option value="Day">Dairly Report</option>
                                 <option value="DayBtn">Dairly  In Between Report</option>
                                 <option value="Month">Monthly Report</option>
                                 <option value="MonthBtn">Monthly In Between Report</option>
                                 <option value="Year">Yearly Report</option>
                             </select>
                          </div>

                           <div class="col-md-3 DayBtn1" style="display: none;">
                            <label>Select First Date</label>
                             <input type="text" name="startdatebtn" class="form-control mydatetimepickerFull DayBtn12 " id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3 DayBtn2" style="display: none;">
                            <label>Select last Date</label>
                             <input type="text" name="startdatebtn" class="form-control mydatetimepickerFull DayBtn22 " id="recipient-name1" required="required">
                          </div>

                          <div class="col-md-3 Day">
                            <label>Select Date</label>
                             <input type="text" name="startdate" class="form-control mydatetimepickerFull Days1" id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3 Month" style="display: none;">
                            <label>Select Month</label>
                             <input type="text" name="startdate" class="form-control mydatetimepicker" id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3 Year" style="display: none;">
                            <label>Select Year</label>
                             <select id="years" class="form-control custom-select year1" name="year">
                                        <option>--Select Year--</option>
                                    </select>
                          </div>
                         
                            <div class="col-md-3 Month1" style="display: none;">
                            <label>Select First Month</label>
                             <input type="text" name="startdate" class="form-control mydatetimepicker First" id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3 Month2" style="display: none;">
                            <label>Select Second Month</label>
                             <input type="text" name="startdate" class="form-control mydatetimepicker Second" id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3">
                            <label>Select Option</label>
                             <select class="form-control custom-select Saida">
                                 <option>--Select Option--</option>
                                 <option>Sent</option>
                                 <option>Received</option>
                             </select>
                          </div>
                          <div class="col-md-3">
                            <label>Select EMS Type</label>
                             <select class="form-control custom-select Hamrish">
                                <option>--Select EMS Type--</option>
                                 <option>Document</option>
                                 <option>Parcel</option>
                             </select>
                          </div>
                          <div class="col-md-3">
                            <label>Select EMS Payment Type</label>
                             <select class="form-control custom-select payment">
                                <option>--Select Payment Type--</option>
                                <option>Cash</option>
                                 <option>PostPaid</option>
                                 <option>PrePaid</option>
                             </select>
                          </div>
                          <div class="col-md-3">
                            <label>Select Graph Type</label>
                              <select class="custom-select form-control gtype" onChange ="getEMSType();">
                                  <option>--Select Graph Type--</option>
                                  <option value="line">Line Chart</option>
                                  <option value="column2d">Bar Chart</option>
                                  <option value="pie3d">Pie Chart</option>
                              </select>
                          </div>
                          
                      </div>
                      <br>
                      <div class="row">
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                    <div class="example" data-text="" style="height: 300px;padding-right: 20px;">
                       
                         <div class="cell">
                              <h5></h5>
                              <div class="panel">
                                    
                                    <div class="content" id="chart-container">
                                        FusionCharts XT will load here!
                                    </div>
                            </div>
                         </div>
                        
                        </div> 
                        </div>
                  </div>
                    </div>
                        
                    </div>

                </div>
           
            </div>
        </div>

<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>

<script type="text/javascript">
function getEMSType() {

         var season = $('.reprt').val();
        if (season == 'Day') {
            var datetime = $('.Days1').val();
         }else if (season == 'DayBtn') {
            var Dayfirst = $('.DayBtn12').val();
            var Daysecond = $('.DayBtn22').val();
        }else if (season == 'Year') {
            var datetime = $('.year1').val();
        }else if (season == 'MonthBtn') {
            var first = $('.First').val();
            var second = $('.Second').val();
        } else{
            var datetime = $('.mydatetimepicker').val();
        }
         var type = $('.Saida').val();
         var gtype = $('.gtype').val();
         var cat = $('.Hamrish').val();
         var payment = $('.payment').val();

         
                        $.ajax({
                         type: "POST",
                         url: "<?php echo base_url();?>Box_Application/Get_EMSReport",
                         data:{date_time:datetime,type:type,cat:cat,sreport:season,first:first,second:second,payment:payment,Dayfirst:Dayfirst,Daysecond:Daysecond},
                         dataType: "JSON",
                         success: function(response) {
                                //alert(response);
                                $('#response').html(response)
                                const dataSource = {
                                  chart: {
                                    caption: "Region With Most Item"+ ' ' + type+'  ,'+payment,
                                    //subcaption: "In MMbbl = One Million barrels",
                                    xaxisname: "Region",
                                    yaxisname: "Item (Total)",
                                    numbersuffix: "",
                                    theme: "fusion"
                                  },
                                  data:response
                                };

                                FusionCharts.ready(function() {
                                  var myChart = new FusionCharts({
                                    type: gtype,
                                    renderAt: "chart-container",
                                    width: "98%",
                                    height: "100%",
                                    dataFormat: "json",
                                    dataSource
                                  }).render();
                                });
                            }
                        });
};
</script>


<script type="text/javascript">
        function getDate() {

    var val = $('.reprt').val();
    if (val == 'Day') {
        $('.Day').show();
        $('.Month1').hide();
        $('.Month2').hide();
        $('.Month').hide();
    }else if (val == 'DayBtn') {
        $('.Day').hide();
        $('.Month').hide();
        $('.Month1').hide();
        $('.Month2').hide();

        $('.DayBtn1').show();
        $('.DayBtn2').show();
    
    }else if (val == 'Month') {
        $('.Day').hide();
        $('.Month').show();
        $('.Month1').hide();
        $('.Month2').hide();
    }else if (val == 'Year') {
        $('.Day').hide();
        $('.Month').hide();
        $('.Year').show();
        $('.Month1').hide();
        $('.Month2').hide();
    }else{
        $('.Day').hide();
        $('.Month').hide();
        $('.Year').hide();
        $('.Month1').show();
        $('.Month2').show();
    }
     
};
</script>
<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
    </script>

<?php $this->load->view('backend/footer'); ?>

