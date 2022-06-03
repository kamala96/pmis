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
                            Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                          
                        Dashboard 
                        <?php
// if(!isset($_COOKIE['emid'])) {
//     echo "Cookie named is not set!";
// } else {
//     echo "Cookie is set!<br>";
//     echo "Value is: " . $_COOKIE['emid'];
// }
?></li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                
                <?php if ($this->session->userdata('user_type') == 'AGENT') {?>
                   
                <?php } else { ?>
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                                    if($this->session->userdata('user_type')=='RM' ){
                                        $this->db->where('status','ACTIVE');
                                        $this->db->from("employee");
                                        $this->db->where('em_region',$basicinfo->em_region);
                                        echo $this->db->count_all_results();
                                    }
                                    elseif($this->session->userdata('user_type')=='HOD'){
										$this->db->where('status','ACTIVE');
										$this->db->from("employee");
										$this->db->where('em_region',$basicinfo->em_region);
										$this->db->where('dep_id',$basicinfo->dep_id);
										echo $this->db->count_all_results();
                                    }
                                    elseif($this->session->userdata('user_type')=='SUPERVISOR' ){
                                        $this->db->where('status','ACTIVE');
                                        $this->db->from("employee");
                                        $this->db->where('em_region',$basicinfo->em_region);
                                        $this->db->where('em_branch',$basicinfo->em_branch);
                                        $this->db->where('dep_id',$basicinfo->dep_id);
                                        echo $this->db->count_all_results();
                                    }
									elseif($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='ACCOUNTANT' || $this->session->userdata('user_type')=='ACCOUNTANT-HQ'){

									}
                                    else
                                    {
                                       $this->db->where('status','ACTIVE');
                                        $this->db->from("employee");
                                        echo $this->db->count_all_results();
                                    }
                                    
                                    ?> 
                                    <?php 
                                    if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='ACCOUNTANT' || $this->session->userdata('user_type')=='ACCOUNTANT-HQ'){
                                       echo "My Profile";
                                    }
                                    else
                                    {
                                        echo "Employees";
                                    }
                                    ?>
                                     </h3>
                                     <?php 
                                     if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='ACCOUNTANT' || $this->session->userdata('user_type')=='ACCOUNTANT-HQ'){ 
                                        ?>
                                        <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id)?>" class="text-muted m-b-0">View My Profile</a>
                                   <?php }else{?>
                                        <!-- <a href="<?php echo base_url(); ?>employee/Employees" class="text-muted m-b-0">View Employees</a> -->
                                          <a href="#" class="text-muted m-b-0">View Employees</a>
                                  <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                             <?php 
                                             echo $leaveno."   "."Leaves";
                                             ?>
                                        </h3>

                                       <!--  <a href="<?php echo base_url(); ?>leave/Application" class="text-muted m-b-0">View Leaves Application</a> -->
                                         <a href="#" class="text-muted m-b-0">View Leaves Application</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                         <?php
                                               echo $imprestno; 
                                         ?>&nbsp; Imprest
                                        </h3>
                                        <!-- <a href="<?php echo base_url(); ?>imprest/imprest_subsistence_list" class="text-muted m-b-0">View Imprest List</a> -->
                                        <a href="#" class="text-muted m-b-0">View Imprest List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div> 
           
            <div class="container-fluid">

                <?php $notice = $this->notice_model->GetNoticelimit(); 
                $running = $this->dashboard_model->GetRunningProject(); 
                $userid = $this->session->userdata('user_login_id');
                $todolist = $this->dashboard_model->GettodoInfo($userid);                 
                $holiday = $this->dashboard_model->GetHolidayInfo();                 
                ?>
    <?php if( $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR"){ ?>

    <?php }else{ ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Active Staff Summary</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered all table-striped">
                                    <thead>
                                        <th>S/no</th>
                                        <th>Region</th>
                                        <th>Number</th>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($activeemp as $value) { ?>
                                           <tr>
                                               <td><?php echo $i;$i++; ?></td>
                                               <td><?php echo $value->em_region; ?></td>
                                                <td><?php echo $value->value; ?></td>
                                           </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            </div>
                <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Staff Expected To Retire Summary</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered all table-striped">
                                    <thead>
                                        <th>S/no</th>
                                        <th>Region</th>
                                        <th><?php echo date('Y');?></th>
                                        <th><?php echo date('Y') + 1;?></th>
                                        <th><?php echo date('Y') + 2;?></th>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($region as $value) { ?>
                                           <tr>
                                               <td><?php echo $i;$i++; ?></td>
                                               <td><?php echo $value->region_name; ?></td>
                                                <td><?php $rname = $value->region_name;
                                                $leave =  $this->dashboard_model->expetedtoretire($rname); echo $leave->year;?></td>
                                                <td><?php $rname = $value->region_name;
                                                $leave =  $this->dashboard_model->expetedtoretire1($rname); echo $leave->year1;?></td>
                                                <td><?php $rname = $value->region_name;
                                                $leave =  $this->dashboard_model->expetedtoretire2($rname); echo $leave->year2;?></td>
                                           </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            </div>
                <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Leave Summary</h4>
                            </div>
                            <div class="card-body">
                              <table class="table table-bordered all table-striped">
                                    <thead>
                                        <th>S/no</th>
                                        <th>Region</th>
                                        <th>Leave On</th>
                                        <th>Leave Off</th>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($region as $value) { ?>
                                           <tr>
                                               <td><?php echo $i;$i++; ?></td>
                                               <td><?php echo $value->region_name; ?></td>
                                               <td><?php $rname = $value->region_name;
                                                $leave =  $this->dashboard_model->countleaveon($rname); echo $leave->leaveon;?></td>
                                               <td><?php  $rname = $value->region_name;
                                                $leave =  $this->dashboard_model->countleaveoff($rname); echo $leave->leaveoff;?></td>
                                           </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            </div>
                            </div>

                        <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Employee Graph Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="example" data-text="" style="height: 500px;">
                       
                            <div class="cell">
                              <h5></h5>
                              <div class="panel">
                                    <div class="content" id="chart-container1">
                                        
                                    </div>
                            </div>
                          </div>
                        
                        </div>
                            </div>
                            </div>
                            </div>
                            </div>
                    <?php }?>
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Notice Board</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive slimScrollDiv" style="">
                                    <table class="table table-hover earning-box nowrap">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                <?php foreach($notice AS $value): ?>
                <tr class="scrollbar" style="vertical-align:top">
                <td><?php echo $value->title ?></td>
                <td><mark><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url ?>" target="_blank"><?php echo $value->file_url ?></a></mark>
                </td>
                <td style="width:100px"><?php echo $value->date; 
                    $id = $value->id;
                    if (date('Y-m-d h:i') > $value->date) {
                       
                    } else {
                        
                    }
                    
                ?></td>
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
                <?php }?>

                
     


<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
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

    var table = $('.all').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        ordering:false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [
                    [5, 10, 25, 50, -1],
                    ['5 rows', '10 rows', '25 rows', '50 rows', 'Show all']
                ],
    } );
} );
</script> 

<script type="text/javascript">

FusionCharts.ready(function () {
            // chart instance
            var chart = new FusionCharts({
                type: "column3d",
                renderAt: "chart-container1", // container where chart will render
                width: "1650",
                height: "450",
                dataFormat: "json",
                dataSource: {
                    // chart configuration
                    chart: {
                        caption: "",
                                     yaxisname: "Employee (Number)",
                                     numbersuffix: "",
                                     theme: "fusion"
                    },
                    // chart data
                data: [
                
                <?php foreach($graph as $value){?>
                { label: "<?php echo $value->year; ?>", value: "<?php  echo $value->value;?>" },
               <?php } ?>

                ]
              }
            }).render();
        });
</script>                   
<?php $this->load->view('backend/footer'); ?>
