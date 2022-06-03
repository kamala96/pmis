<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
$domain = ".posta.co.tz";
$emid = $this->session->userdata('user_login_id');
setcookie("emid", $emid, 0, '/', $domain);
               // setcookie('emid',$emid,time() + (86400 * 30),$domain);
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
                    <?php 
                         $id = $this->session->userdata('user_login_id');
                         $basicinfo = $this->employee_model->GetBasic($id); 
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                            <?php echo $this->session->userdata('heading')?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            <?php echo $this->session->userdata('heading')?>
                      </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>Ems_Domestic/document_parcel" class="text-muted m-b-0">Document/Parcel</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>Loan_Board/Loan_info" class="text-muted m-b-0">Loan Board(HESLB)</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url()?>Necta/necta_info" class="text-muted m-b-0">Necta</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                   <!--  <div class="col-lg-3 col-md-6" >
                        <div class="card">
                            <a href="Ems_Domestic/Pucm">
                            <div class="card-body">
                                <div class="d-flex flex-row" >
                                    <div class="round align-self-center round-info" style=""><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url()?>Ems_Domestic/Pcum" class="text-muted m-b-0">Pcum</a>
                                        </div>
                                </div>
                            </div>
                             </a>
                        </div>
                    </div>
                   -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url();?>Ems_Cargo/ems_cargo_form" class="text-muted m-b-0">Ems Cargo</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if($this->session->userdata('user_type') == "ADMIN" ){ ?>
                     <div class="col-lg-3 col-md-6" >
                        <div class="card">
                            <a href="Ems_Domestic/Pucm">
                            <div class="card-body">
                                <div class="d-flex flex-row" >
                                    <div class="round align-self-center round-info" style=""><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url()?>Ems_Domestic/Emszero" class="text-muted m-b-0">Ems Zero</a>
                                        </div>
                                </div>
                            </div>
                             </a>
                        </div>
                    </div>

                      <?php }?>

                       <div class="col-lg-3 col-md-6" >
                        <div class="card">
                            <a href="Ems_Domestic/Pucm">
                            <div class="card-body">
                                <div class="d-flex flex-row" >
                                    <div class="round align-self-center round-info" style=""><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo base_url()?>Ems_Domestic/Emszero" class="text-muted m-b-0">Ems Parcel Charge</a>
                                        </div>
                                </div>
                            </div>
                             </a>
                        </div>
                    </div>

                          <div class="col-lg-3 col-md-6" >
                        <div class="card">
                            <a href="#">
                            <div class="card-body">
                                <div class="d-flex flex-row" >
                                    <div class="round align-self-center round-info" style=""><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        </h3>
                                    <a href="<?php echo site_url('Ems_Domestic/mct_cash_dashboard'); ?>" class="text-muted m-b-0"> MCT Dashboard </a>
                                        </div>
                                </div>
                            </div>
                             </a>
                        </div>
                    </div>

                     <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url('Mail_box/callnote');?>" class="text-muted m-b-0"> Call Note </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo base_url()?>Mail_box/bulk_callnote" class="text-muted m-b-0"> Bulk Call Note </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                      <!--  <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>Ems_Domestic/employee_report" class="text-muted m-b-0">Report</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>
                  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <div class="card-header">
                            <h4 class=""> Graph Report </h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                <select class="form-control custom-select catType" style="border: 0px;">
                                        <option value="">--Select Category--</option>
                                        <option value="Parcel">Parcel</option>
                                        <option value="Document">Document</option>
                                        <option value="LOAN BOARD">Loan Board(HESLB)</option>
                                        <option value="NECTA">Necta</option>
                                        <option value="PCUM">Pcum</option>Loan Board(HESLB)
                                        <option value="EMS-CARGO">Ems Cargo</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control custom-select reportType" style="border: 0px;" onchange="ReportType();">
                                        <option value="">--Select Report Type--</option>
                                        <option>Dairly</option>
                                        <option>Weekly</option>
                                        <option>Monthly</option>
                                        <option>Quartery</option>
                                        <option>Mid Report</option>
                                        <option>Annual</option>
                                    </select>
                                </div>
                                <div class="col-md-3 dairly input-group" style="display: none; ">
                                    <input type="text" name="date1" class="form-control mydatetimepickerFull dairly1" style="border: 0px;" placeholder="Select Date">
                                </div>
                                <div class="col-md-3 weekly input-group" style="display: none; ">
                                    <input type="text" name="date1" class="form-control mydatetimepickerFull date1" style="border: 0px;" placeholder="Select First Date">
                                    TO
                                    <input type="text" name="date2" class="form-control mydatetimepickerFull date2" style="border: 0px;" placeholder="Select Second Date">
                                </div>
                                <div class="col-md-3 month input-group" style="display: none; ">
                                    <input type="text" name="mon" class="form-control mydatetimepicker mon" style="border: 0px;" placeholder="Select Month">
                                </div>
                            <div class="col-md-3 quartery input-group" style="display: none; ">
                                    <input type="text" name="mon1" class="form-control mydatetimepicker month1" style="border: 0px;" placeholder="Select First Month">
                                    TO
                                    <input type="text" name="mon2" class="form-control mydatetimepicker month2" style="border: 0px;" placeholder="Select Second Month">
                                </div>
                                <div class="col-md-3 annual input-group" style="display: none; ">
                                    <select id="years" class="form-control custom-select year" style="border: 0px;">
                                        <option>--Select Year--</option>
                                    </select>
                                </div>
                               <div class="col-md-3">
                                  <select class="custom-select form-control gtype" onChange ="getEMSType();" style="border: 0px;">
                                      <option>--Select Graph Type--</option>
                                      <option value="line">Line Chart</option>
                                      <option value="column3d">Bar Chart</option>
                                      <option value="pie3d">Pie Chart</option>
                                  </select>
                              </div>
                            </div>
                              <hr/>
                            <br>
                             <div class="row">
                        <div class="col-md-12">
                          <div class="example" data-text="" style="height: 450px;">
                         <div class="cell">
                              <h5></h5>
                              <div class="panel">
                                    <div class="content" id="chart-container">
                                       
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

         var catType = $('.catType').val();
         var gtype   = $('.gtype').val();
         var date1   = $('.date1').val();
         var date2   = $('.date2').val();
         var month   = $('.mon').val();
         var month1  = $('.month1').val();
         var month2  = $('.month2').val();
         var year    = $('.year').val();
         var reportType    = $('.reportType').val();
         var dairly    = $('.dairly1').val();
         
         //alert(catType);
         $.ajax({
                         type: "POST",
                         url: "<?php echo base_url();?>Ems_Domestic/Generate_Report",
                         data:{'catType':catType,'gtype':gtype,'year':year,'date1':date1,'month':month,'month1':month1,'month2':month2,'date2':date2,'reportType':reportType,'dairly':dairly},
                         dataType: "JSON",
                         success: function(response) {
                                //alert(response);
                               // $('#response').html(response)
                                const dataSource = {
                                  chart: {
                                    caption: "Region With Most Item",
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
                                    width: "90%",
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
    function ReportType(){

        var reportType = $('.reportType').val();
        if( reportType == "Dairly"){
            $('.dairly').show();
            $('.weekly').hide();
            $('.month').hide();
            $('.quartery').hide();
            $('.annual').hide();
        }
        if( reportType == "Weekly"){
            $('.weekly').show();
            $('.month').hide();
            $('.quartery').hide();
            $('.annual').hide();
            $('.dairly').hide();
        }if( reportType == "Monthly"){
            $('.weekly').hide();
            $('.quartery').hide();
            $('.month').show();
            $('.annual').hide();
            $('.dairly').hide();
        }if( reportType == "Quartery"){
            $('.weekly').hide();
            $('.month').hide();
            $('.quartery').show();
            $('.annual').hide();
            $('.dairly').hide();
        }if( reportType == "Mid Report"){
            $('.weekly').hide();
            $('.month').hide();
            $('.quartery').show();
            $('.annual').hide();
            $('.dairly').hide();
        }if( reportType == "Annual"){
            $('.weekly').hide();
            $('.month').hide();
            $('.quartery').hide();
            $('.dairly').hide();
            $('.annual').show();
        }
        
    };
</script>            
<script type="text/javascript">
            $(document).ready(function() {
                $(".parceldetails").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute
                    var iid = $(this).attr('data-id');
                    $('#leaveapply').trigger("reset");
                    $('#appmodel').modal('show');
                    $.ajax({
                        url: '<?php echo base_url()?>Parcel/parcelAppbyid?id=' + iid,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function(response) {
                        // console.log(response);
                        // Populate the form fields with the data returned from server
                        
                        $('#leaveapply').find('[name="sender_name"]').val(response.parcelvalue.sender_name).end();
                       
                    });
                });
            });
        </script>

<script>
  $(".to-do").on("click", function(){
      //console.log($(this).attr('data-value'));
      $.ajax({
          url: "Update_Todo",
          type:"POST",
          data:
          {
          'toid': $(this).attr('data-id'),         
          'tovalue': $(this).attr('data-value'),
          },
          success: function(response) {
              location.reload();
          },
          error: function(response) {
            console.error();
          }
      });
  });			
</script>      


<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(6),:eq(7)").each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#example4').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
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
