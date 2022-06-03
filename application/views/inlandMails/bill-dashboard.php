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
                           Bill Dashboard</h3>
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
            <div class="container-fluid" style="font-size: 28">
                 <br>
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                      <form id="register" action="<?php echo base_url()?>Bill_Customer/bill_customer_list?AskFor=MAILS"  method="POST">
                                      <!-- <input type="text" hidden="hidden" name="status" value="Back" class="" > -->
                                       <input type="text" hidden="hidden" name="billtype" value="Register" class="" >
                                     
                                        <a href="javascript:{}" onclick="document.getElementById('register').submit(); return false;" class="text-muted m-b-0">Register Bill</a>
                                      </form>
                                     
                                         <!-- <a href="<?php echo base_url()?>Bill_Customer/bill_customer_list?AskFor=MAILS" class="text-muted m-b-0">Registered Bill</a> -->
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                         <form id="parcel" action="<?php echo base_url()?>Bill_Customer/bill_customer_list?AskFor=MAILS"  method="POST">
                                      <!-- <input type="text" hidden="hidden" name="status" value="Back" class="" > -->
                                       <input type="text" hidden="hidden" name="billtype" value="Parcel" class="" >
                                     
                                        <a href="javascript:{}" onclick="document.getElementById('parcel').submit(); return false;" class="text-muted m-b-0">Parcel Bill</a>
                                      </form>

                                           <!-- <a href="<?php echo base_url()?>Bill_Customer/bill_customer_list?AskFor=MAILS" class="text-muted m-b-0">Parcel Bill</a> -->

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                       <form id="postamlangoni" action="<?php echo base_url()?>Posta_Mlangoni/bill_customer_list?AskFor=Posta Mlangoni"  method="POST">
                                      <!-- <input type="text" hidden="hidden" name="status" value="Back" class="" > -->
                                       <input type="text" hidden="hidden" name="billtype" value="Posta Mlangoni" class="">
                                        <a href="javascript:{}" onclick="document.getElementById('postamlangoni').submit(); return false;" class="text-muted m-b-0"> Posta Mlangoni Bill </a>
                                      </form>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column -->
                    <!-- Column -->
                   
                   
                   <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
        <form id="Register" action="<?php echo base_url()?>Register_International/bill_customer_list?AskFor=Register International"  method="POST">
        <input type="text" hidden="hidden" name="billtype" value="Register" class="" >                   
    <a href="javascript:{}" onclick="document.getElementById('Register').submit(); return false;" class="text-muted m-b-0"> Register Internationl </a>
        </form>

                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                 
                
                    
                   
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
