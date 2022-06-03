<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
$domain = ".posta.co.tz";
$emid = $this->session->userdata('user_login_id');
setcookie("emid", $emid, 0, '/', $domain);
               // setcookie('emid',$emid,time() + (86400 * 30),$domain);
 ?>
<?php $auth =  $this->session->userdata('sub_user_type');
        $auths = $this->session->userdata('user_type') ; ?>
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
                            Stamp Bureau Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Stamp Bureau Dashboard
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
                                        <?php
                                            echo $stampno;
                                        ?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url()?>inventory/Stamps_List" class="text-muted m-b-0">View Stamps</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php
                                            echo $locksno;
                                        ?>
                                        </h3>

                                        <a href="#" class="text-muted m-b-0">View Private Box | Locks</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        <?php
                                            echo $stockno;
                                        ?>
                                        </h3>
                                        <a href="<?php echo base_url(); ?>inventory/dashboard" class="text-muted m-b-0">View Stocks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-settings"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php
                                            echo $cashno;
                                        ?>
                                        </h3>
                                        <a href="<?php echo base_url()?>inventory/Cash_list" class="text-muted m-b-0">View Cash On Hand</a>
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
                                <span><h4 class="card-title">Stock List

                                      <?php if($auth == "PMU"){?>
                                        <text style="float: right;">
                                            <a href="<?php echo base_url()?>inventory/add_stock"  class="btn btn-info"><i class="fa fa-plus"></i> Add Stock</a> <a href="<?php echo base_url()?>inventory/request_incomming"  class="btn btn-info"><i class="fa fa-list"></i> Incomming Request</a>
                                        </text>
                                       
                                    <?php }elseif ($auth== "STRONGROOM") {?>

                                        <text style="float: right;">
                                            <a href="<?php echo base_url()?>inventory/strong_room_request"  class="btn btn-info"><i class="fa fa-plus"></i> Send Request >>></a> <a href="<?php echo base_url()?>inventory/request_to"  class="btn btn-info"><i class="fa fa-list"></i> Request List To Store(PMU)</a>  <a href="<?php echo base_url()?>inventory/request_incomming"  class="btn btn-info"><i class="fa fa-list"></i> Incomming Request</a>

                                            <a href="<?php echo base_url()?>inventory/returned_stock"  class="btn btn-info"><i class="fa fa-list"></i>  Returned Stock</a>
                                        </text>
                                        <!-- <a href="<?php echo base_url()?>inventory/strong_room_request" style="float: right;" class="btn btn-info "><i class=""></i> Send Request >>></a> --> 
                                    <?php }elseif ($auth== "BRANCH") {?>

                                        <text style="float: right;">
                                            <a href="<?php echo base_url()?>inventory/strong_room_request"  class="btn btn-info"><i class="fa fa-plus"></i> Send Request >>></a> <a href="<?php echo base_url()?>inventory/request_to"  class="btn btn-info"><i class="fa fa-list"></i> Request List To STRONG ROOM</a>  <a href="<?php echo base_url()?>inventory/request_incomming"  class="btn btn-info"><i class="fa fa-list"></i> Incomming Request</a>
                                        </text>
                                <?php }elseif ($auth== "COUNTER") {?>

                                    <?php $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") { ?>
                        <text style="float: right;">
                                            <a href="<?php echo base_url()?>inventory/strong_room_request"  class="btn btn-info"><i class="fa fa-plus"></i> Send Request >>></a> <a href="<?php echo base_url()?>inventory/request_to"  class="btn btn-info"><i class="fa fa-list"></i> Request List To STRONG ROOM</a>     <a href="<?php echo base_url()?>inventory/returned_stock"  class="btn btn-info"><i class="fa fa-list"></i>  Returned Stock</a>  <a href="<?php echo base_url()?>inventory/sold_stock"  class="btn btn-info"><i class="fa fa-list"></i>  Sold Stock</a>
                                        </text>
                    <?php }else{ ?>
                        <text style="float: right;">
                                            <a href="<?php echo base_url()?>inventory/strong_room_request"  class="btn btn-info"><i class="fa fa-plus"></i> Send Request >>></a> <a href="<?php echo base_url()?>inventory/request_to"  class="btn btn-info"><i class="fa fa-list"></i> Request List To Branch</a>     <a href="<?php echo base_url()?>inventory/returned_stock"  class="btn btn-info"><i class="fa fa-list"></i>  Returned Stock</a> <a href="<?php echo base_url()?>inventory/sold_stock"  class="btn btn-info"><i class="fa fa-list"></i>  Sold Stock</a>
                                        </text>
                    <?php }?>

                                        
                                    <?php } ?>
                                    </h4>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive slimScrollDiv" style="">
                                    <table class="table table-hover earning-box nowrap table-bordered" id="example4">
                                        <thead>
                                            <tr>
                                            <!-- <th>Issue Date</th>
                                            <th class="Hidden">Release Date</th> -->
                                            <th>Stock Type</th>
                                            <th>Stock Name</th>
                                            <th>Quantity </th>
                                            <th>Price Per Mint</th>
                                            <th>Price Per Souverant Sheet</th>
                                            <th>Price Per F D Cover</th>
                                            <th style="text-align: right;">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($stocklist as $value): ?>
                                        <tr>
                                            <!-- <td>
                                            <?php echo  date('Y', strtotime($value->issuedate)) .' - '.date('Y', strtotime($value->enddate)); ?>
                                                
                                            </td>
                                           
                                           <td class="Hidden"><?php echo $value->releasedate; ?></td> -->
                                           <?php if(($auth == "PMU") || ($auths == "ADMIN")){?>
                                            <td><?php echo $value->CategoryName; ?></td>
                                           <?php }else{ ?>
                                            <td><?php echo $value->stock_type; ?></td>
                                           <?php } ?>
                                            <td><?php echo $value->stampname; ?></td>
                                            <td><?php echo $value->quantity; ?></td>

                                            <td><?php echo $value->pricepermint; ?></td>
                                            <td><?php echo $value->pricepersouverantsheet; ?></td>
                                            <td><?php echo $value->priceperfdcover; ?></td>
                                          
                                           <td class="jsgrid-align-center " style="text-align: right;">

                                            <?php if($auth == "PMU"){?>

                                            <a href="<?php echo base_url(); ?>inventory/add_stock?stid=<?php echo base64_encode($value->id) ?>" title="Edit Stock" class="btn btn-sm btn-info waves-effect waves-light">Edit Stock</a> | <a href="#" title="Stock Details" class="btn btn-sm btn-info waves-effect waves-light">Stock Details</a>
                                        <?php }elseif ($auth== "COUNTER") {?>

                                           
                                                <a href="return_stock?id=<?php echo base64_encode($value->id); ?>" class="btn btn-danger">Return Stock</a>   <a href="sell_iterm?id=<?php echo base64_encode($value->id); ?>" class="btn btn-info">Sell Iterm</a>
                                            
                                           <?php }elseif ($auth== "STRONGROOM" || $auth== "BRANCH") {?>
                                            <?php if($value->quantity <= 10){ ?>

                                                <a href="#" style="float: right;" class="btn btn-danger "><i class=""></i> Weak Stock</a>

                                            <?php }else{?>
                                                <a href="#" style="float: right;" class="btn btn-success "><i class=""></i> Strong Stock</a>
                                            <?php }?>
                                            
                                           <?php } ?>
                                             
                                           </td>
                            
                                        </tr>
                                       <?php endforeach; ?>
                                        </tbody>
                                        </table>
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
    
    var table = $('#example4').DataTable( {
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
<?php $this->load->view('backend/footer'); ?>
