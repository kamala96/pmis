<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<?php
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
                            Inland Mails Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                      </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>unregistered/unregistered_form" class="text-muted m-b-0">Registered Domestic</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 <!--    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>Bill_Customer/bill_customer_list?AskFor=MAILS" class="text-muted m-b-0">Registered Bill</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

                                        <a href="<?php echo base_url()?>unregistered/registered_international_form" class="text-muted m-b-0">Deliver Registered FPL,RDP </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

                                        <a href="<?php echo base_url()?>unregistered/international_bulk_registered_form" class="text-muted m-b-0">International Registered</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            
                            <div class="card-body">
                            <div class="row">
                                
                            </div>
                            </div>
                            </div>
                            </div>
            </div> 
             </div>
            </div> 
            
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
