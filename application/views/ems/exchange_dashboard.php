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
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> EMS OFFICE OF EXCHANGE DASHBOARD</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            EMS Exchange Office
                        </li>
                    </ol>
                </div>
            </div>
              

             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo base_url()?>Ems_Domestic/Incoming_Exchange?AskFor=EMS" class="text-muted m-b-0">Incoming To Exchange Office</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>Ems_Domestic/Sent_ToIps?AskFor=EMS" class="text-muted m-b-0">Sent To Ips Item</a>
                                 
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
