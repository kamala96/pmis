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
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>photocopy/photocopy_form" class="text-muted m-b-0">photocopy Form</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                   
                    
                </div>
                <!--   <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                            <h4 class=""> International Graph Report </h4>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                    <div class="example" data-text="" style="height: 500px;padding-right: 20px;">
                       
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
            </div>  -->
            <script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<script type="text/javascript">

FusionCharts.ready(function () {
            // chart instance
            var chart = new FusionCharts({
                type: "column3d",
                renderAt: "chart-container", // container where chart will render
                width: "1400",
                height: "450",
                dataFormat: "json",
                dataSource: {
                    // chart configuration
                    chart: {
                        caption: "<?php if($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR" ){
                                        echo "Branch";
                                     }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){
                                        echo "Month";
                                     }else{
                                        echo "Region";
                                     } ?> With Most International Item",
                                    //subcaption: "In MMbbl = One Million barrels",
                                     xaxisname: "<?php if($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR" ){
                                        echo "Branch";
                                     }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){
                                        echo "Month";
                                     }else{
                                        echo "Region";
                                     } ?>",
                                     yaxisname: "Item (Total)",
                                     numbersuffix: "",
                                     theme: "fusion"
                    },
                    // chart data
                    // chart data
                    
                    data: [
                        <?php foreach($cash as $value){?>
                { label: "<?php echo $value->year; ?>", 
                value: "<?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){
                 echo $value->value;
                }else{
                    echo $value->value;
                }  ?>" },
                                
                <?php } ?>
                    
                    ]
                }
            }).render();
        });
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
<?php $this->load->view('backend/footer'); ?>
