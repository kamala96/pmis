<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Service Reports</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Service Reports</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
       <!--  <div class="row m-b-10">
                <div class="col-12">
                   <a href="<?php echo base_url() ?>Box_Application/Ems" class="btn btn-primary"><i class="fa fa-plus"></i> Ems Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>
                </div>    
        </div>  -->

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
                             <input type="text" name="startdatebtn" class="form-control mydatetimepickerFull Dayfirst " id="recipient-name1" required="required">
                          </div>
                          <div class="col-md-3 DayBtn2" style="display: none;">
                            <label>Select last Date</label>
                             <input type="text" name="startdatebtn" class="form-control mydatetimepickerFull Daysecond " id="recipient-name1" required="required">
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
                            <label>Select Service</label>
                           
                             <select class="form-control custom-select servicess" id="servicess" onChange="getype();">
                                 <option>--Select Service--</option>
                                 <option value="1">EMS POSTAGE</option>
                                 <option value="2">MAIL</option>
                                 <option value="3">COMMISSION</option>
                                 <option value="4">REAL ESTATE</option>
                                 <option value="5">PARKING</option>
                                 <option value="6">INTERNET</option>
                                  <option value="7">POST SHOPS</option>
                                 <option value="8">POST BUS</option>
                             </select>
                          </div>


                          <div class="col-md-3 EMS" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select EMSvalue"  name="EMSvalue" id="EMSvalue">
                                <option>--Select  Type--</option>
                                 <option value="DOCUMENT">DOCUMENT/PARCEL</option>
                                 <option value="GLOBAL"> EMS POSTA GLOBAL BILL</option>
                                  <option value="INTERNATIONAL">EMS INTERNATIONAL</option>
                                   <option value="LOAN">LOAN BOARD(HESLB)</option>
                                    <option value="PCUM">PCUM</option>
                                     <option value="EMSCARGO">EMS CARGO</option>
                             </select>
                          </div>

                            <div class="col-md-3 MAIL" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select MAILvalue" id="MAILvalue" name="MAILvalue">
                                <option>--Select  Type--</option>
                                 <option value="DOMESTICREGISTER">DOMESTIC REGISTER</option>
                                 <option value="INTERNATIONALREGISTER">INTERNATIONAL REGISTER</option>
                                 <option value="REGISTEREDBILL">REGISTERED BILL</option>
                                 <option value="STAMP">SALES OF STAMP</option>
                                 <option value="NECTA">NECTA</option>
                                 <option value="PRIVATE">PRIVATE BOX RENTAL FEES</option>
                                 <option value="AUTHORITY">AUTHORITY CARD FEES</option>
                                 <option value="LOCK">LOCK REPLACEMENT</option>
                                 <option value="POSTSCARGO">POSTS CARGO</option>
                                 <option value="PARCELDOMESTIC">PARCEL POST DOMESTIC</option>
                                  <option value="PARCELINTERNATIONAL">PARCEL POST INTERNATIONAL</option>
                                 <option value="PACKETSDOMESTIC">SMALL PACKETS DOMESTIC</option>
                                  <option value="PACKETSINTERNATIONAL">SMALL PACKETS INTERNATIONAL</option>
                                 <option value="PACKETSDELIVERY">SMALL PACKETS DELIVERY</option>
                             </select>
                          </div>
                            <div class="col-md-3 COMMISSION" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select COMMISSIONvalue" id="COMMISSIONvalue"  name="COMMISSIONvalue">
                                <option >--Select  Type--</option>
                                 <option value="WESTERN">WESTERN UNION</option>
                                 <option value="TPB">TPB AGENCY</option>
                                  <option value="CRDB">CRDB AGENCY</option>
                                 <option value="NTERSTATE">NTERSTATE MO REVENUE</option>
                                  <option value="MOBILE">MOBILE MONEY TRANSFER</option>
                                 
                             </select>
                          </div>
                            <div class="col-md-3 ESTATE" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select ESTATEvalue" id="ESTATEvalue" name="type">
                                <option>--Select  Type--</option>
                                 <option value="RESIDENTIAL">RESIDENTIAL</option>
                                 <option value="OFFICE">OFFICE</option>
                                  <option value="LAND">LAND</option>
                             </select>
                          </div>
                            <div class="col-md-3 PARKING" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select PARKINGvalue" id="PARKINGvalue"  name="type">
                                <option>--Select  Type--</option>
                                 <option value="PARKING">PARKING</option>
                             </select>
                          </div>
                            <div class="col-md-3 INTERNET" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select INTERNETvalue" id="INTERNETvalue"  name="type">
                                <option>--Select  Type--</option>
                                 <option value="INTERNET" >INTERNET INCOME</option>
                             </select>
                          </div>
                            <div class="col-md-3 SHOPS" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select SHOPSvalue" id="SHOPSvalue" name="type">
                                <option>--Select  Type--</option>
                                 <option value="SHOP">POST SHOP SALES</option>
                             </select>
                          </div>
                            <div class="col-md-3 BUS" id="update" style="display: none;">
                            <label>Select  Type</label>
                             <select class="form-control custom-select BUSvalue" id="BUSvalue" name="type">
                                <option>--Select  Type--</option>
                                 <option value="BUS">POST BUS REVENUE</option>
                             </select>
                          </div>

                          




                        <!--   <div class="col-md-3">
                            <label>Select EMS Payment Type</label>
                             <select class="form-control custom-select payment">
                                <option>--Select Payment Type--</option>
                                <option>Cash</option>
                                 <option>PostPaid</option>
                                 <option>PrePaid</option>
                             </select>
                          </div> -->
                          <div class="col-md-3">
                            <label>Select Graph Type</label>
                              <select class="custom-select form-control gtype" onChange ="getServiceype();">
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
        function getype() {
    var val = $('.servicess').val();

       if (val == '1') {
              $('.EMS').show();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').hide();

         }else if (val == '2') {
          $('.EMS').hide();
              $('.MAIL').show();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').hide();
            
        }else if (val == '3') {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').show();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').hide();
            
        }else if (val == '4') {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').show();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').hide();
            
        
        }else if (val == '5') {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').show();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').hide();
            
        }else if (val == '6') {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').show();
              $('.SHOPS').hide();
              $('.BUS').hide();
            
        }else if (val == '7') {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').show();
              $('.BUS').hide();
        }
        else
        {
          $('.EMS').hide();
              $('.MAIL').hide();
              $('.COMMISSION').hide();
              $('.ESTATE').hide();
              $('.PARKING').hide();
              $('.INTERNET').hide();
              $('.SHOPS').hide();
              $('.BUS').show();
           
        }


  
};
</script>


<script type="text/javascript">
function getServiceype() {

   var val = $('.servicess').val();

         if (val == '1') {
             
          var type = $('.EMSvalue').val();

         }else if (val == '2') {
          var type = $('.MAILvalue').val();
            
        }else if (val == '3') {
          var type = $('.COMMISSIONvalue').val();

            
        }else if (val == '4') {
         
             var type = $('.ESTATEvalue').val();
        
        }else if (val == '5') {
          
        var type = $('.PARKINGvalue').val();
            
        }else if (val == '6') {
         
          var type = $('.INTERNETvalue').val();
            
        }else if (val == '7') {
            var type = $('.SHOPSvalue').val();
        
        }
        else
        {
          var type = $('.BUSvalue').val();
           
        }

              var season = $('.reprt').val();
        if (season == 'Day') {
            var datetime = $('.Days1').val();
         }else if (season == 'DayBtn') {
            var Dayfirst = $('.Dayfirst').val();
            var Daysecond = $('.Daysecond').val();
        }else if (season == 'Year') {
            var datetime = $('.year1').val();
        }else if (season == 'MonthBtn') {
            var first = $('.First').val();
            var second = $('.Second').val();
        } else{
            var datetime = $('.mydatetimepicker').val();
        }



        
         var payment = $('.Second').val();
          var gtype = $('.gtype').val();

         
                        $.ajax({
                         type: "POST",
                         url: "<?php echo base_url();?>Reports/Get_Service_Reports",
                         data:{date_time:datetime,type:type,sreport:season,first:first,second:second,payment:payment,Dayfirst:Dayfirst,Daysecond:Daysecond},
                         dataType: "JSON",
                         success: function(response) {
                                //alert(response);
                                $('#response').html(response)
                                const dataSource = {
                                  chart: {
                                    caption: "Region With Most Item",
                                     // caption: "Region With Most Item"+ ' ' + type+'  ,'+payment,
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
         $('.DayBtn1').hide();
        $('.DayBtn2').hide();
         $('.Year').hide();
    }else if (val == 'DayBtn') {
        $('.Day').hide();
        $('.Month').hide();
        $('.Month1').hide();
        $('.Month2').hide();

        $('.DayBtn1').show();
        $('.DayBtn2').show();
         $('.Year').hide();
    
    }else if (val == 'Month') {
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
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
    </script>

<?php $this->load->view('backend/footer'); ?>

