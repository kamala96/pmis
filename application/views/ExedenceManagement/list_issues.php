<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> <i class="fa fa-braille" style="color:#1976d2"></i> Incident Management | Find Incidents   </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Dashboard </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">  


            <div class="row m-b-10">
            <div class="col-12">
            
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

            
            </div>
        </div>

                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   
                            
                            <div class="card-body">


                            <?php 

                            if(!empty($this->session->flashdata('feedback'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('feedback'); ?>
                                      <?php
                            echo "</div>";
                            
                            }

                            if(!empty($this->session->flashdata('success'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('success'); ?>
                                      <?php
                            echo "</div>";
                            
                            }

                            ?>
                       
                            <form class="row" method="get" action="<?php echo site_url('Exedence/search_issues');?>">

                                <div class="form-group col-md-2 m-t-10">
                                <input type="text" name="fromdate" class="form-control  mydatetimepickerFull" placeholder="From Date">
                                </div> 

                                <div class="form-group col-md-2 m-t-10">
                                <input type="text" name="todate" class="form-control  mydatetimepickerFull" placeholder="To Date">
                                </div>
                                
                                  
                                    <?php if($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="SUPER ADMIN"){?>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                    <select class="form-control region" name="region">
                                        <option value=""> --  Choose Region-- </option>
                                        <?php foreach($listregion as $data){ ?>
                                        <option value="<?php echo $data->region_name; ?>"> <?php echo $data->region_name; ?> </option>
                                    <?php } ?>
                                    </select>
                                    </div>

                                    <?php } ?>

                                    <div class="form-group col-md-2 m-t-10">
                                    <select class="form-control region" name="request">
                                        <option value=""> --  Choose Incident-- </option>
                                        <?php foreach($request as $data){ ?>
                                        <option value="<?php echo $data->request_name; ?>"> <?php echo $data->request_name; ?> </option>
                                    <?php } ?>
                                    </select>
                                    </div>

                                    <div class="form-group col-md-2 m-t-10">
                                    <select class="form-control" name="status">
                                        <option value=""> --  Choose Status-- </option>
                                         <option value="Pending"> Pending </option>
                                         <option value="Received"> Received </option>
                                         <option value="Solved"> Solved </option>
                                         <option value="Closed"> Closed </option>
                                    </select>
                                    </div>

                                    <div class="form-group col-md-2 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>


                        <?php if(isset($list)) { ?>

                            <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th>Service </th>
                                            <th>Description </th>
                                            <th>Region </th>
                                            <th>Branch </th>
                                            <th> Incident </th>
                                            <th>Requested By </th>
                                            <th>Requested Date </th>
                                            <th> Status </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ 
                                     $createdinfo  = $this->ExedenceModel->user_info(@$data->createdby);
                                     $sendname = @$createdinfo->first_name.' '.@$createdinfo->middle_name.' '.@$createdinfo->last_name.' - PFNo: '.@$createdinfo->em_code;
                                     $receivedinfo  = $this->ExedenceModel->user_info(@$data->receivedby);
                                     $receiver = @$receivedinfo->first_name.' '.@$receivedinfo->middle_name.' '.@$receivedinfo->last_name;
                                     ?>
                                            <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->service_name; ?> </td>
                                            <td> 
                                        <?php 
                                        $desc = $data->description;
                                        $desccount = strlen($desc);
                                        if($desccount>=40){
                                        echo substr($data->description, 0, 40).'.....';
                                        } else {
                                        echo $data->description;
                                        }
                                        ?> 
                                            <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#readmore_modal<?php echo $data->issue_id; ?>">   <i class="fa fa-eye"></i> Read more  </button>
                                            
                                            </td>
                                            <td> <?php echo $data->region; ?> </td>
                                            <td> <?php echo $data->branch; ?> </td>
                                            <td> <button type="button" class="btn btn-primary btn-xm"> <?php echo $data->request_type; ?> </button>  </td>
                                            <td> <?php echo $sendname; ?> </td>
                                            <td> <?php echo $data->issue_created_at; ?> </td>
                                            <td> 
                                            <?php if($data->issue_status=="Pending"){?>

                                            <?php if(!empty(@$data->bop_code)){ ?>
                                            <button type="button" class="btn btn-primary btn-xm"> ApprovedByBOP </button> 
                                            <?php } else { ?>
                                            <button type="button" class="btn btn-primary btn-xm"> <?php echo $data->issue_status; ?> </button> 
                                            <?php } ?>

                                            <?php } elseif ($data->issue_status=="Received") { ?>
                                            <button type="button" class="btn btn-success btn-xm"> <?php echo $data->issue_status; ?> </button> 
                                            <?php } else { ?>
                                            <button type="button" class="btn btn-success btn-xm"> <?php echo $data->issue_status; ?> </button> 
                                            <?php } ?>
                                            </td>
                                            <td>

                                             <!-- <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->issue_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                             -->


    <?php if($this->session->userdata('sub_user_type')=="TECHNICAL" || $this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="SUPER ADMIN"){ ?>

                                             <?php if($data->issue_status=="Pending"){ ?>
                                             <a class="btn btn-xm btn-info waves-effect waves-light" style="color:#fff" href="<?php echo site_url('Exedence/accept_request');?>?I=<?php echo base64_encode($data->issue_id); ?>">  Accept Request </a>
                                             <?php } ?>

                                              <?php if($data->issue_status=="Received"){ ?>
                                             <button title="Edit" class="btn btn-xm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#reply_modal<?php echo $data->issue_id; ?>">   Reply Request </button>
                                             <?php } ?>

                                              <?php if($data->issue_status=="Solved" && $data->chart_status=="open"){ ?>
                                             <a class="btn btn-xm btn-success waves-effect waves-light" onclick='return del();' style="color:#fff" href="<?php echo site_url('Exedence/close_support');?>?I=<?php echo base64_encode($data->issue_id); ?>">  Close Support </a>
                                             <?php } ?>

    <?php } ?>

    <?php if($data->issue_status=="Solved"){ ?>

   <button title="Edit" class="btn btn-xm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#solution_modal<?php echo $data->issue_id; ?>">   View Solution </button>

    <?php } ?>

    <?php if($data->issue_status=="Closed"){ ?>

   <button title="Edit" class="btn btn-xm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#solution_modal<?php echo $data->issue_id; ?>">   View Conversation </button>

    <?php } ?>


   <?php if($data->issue_status=="PendingRequest"){ ?>

   <?php if($this->session->userdata('user_type')=="RM"){ ?>

    <a class="btn btn-xm btn-info waves-effect waves-light" style="color:#fff" href="<?php echo site_url('Exedence/rm_confirm_request');?>?I=<?php echo base64_encode($data->issue_id); ?>&S=<?php echo base64_encode('ApprovedByRM'); ?>"> Accept </a>

   <a class="btn btn-xm btn-success waves-effect waves-light" onclick='return canceled();' style="color:#fff" href="<?php echo site_url('Exedence/rm_confirm_request');?>?I=<?php echo base64_encode($data->issue_id); ?>&S=<?php echo base64_encode('CanceledByRM'); ?>">  Cancel </a>

   <?php } } ?>


    <?php if($data->issue_status=="ApprovedByRM"){ ?>

   <?php if($this->session->userdata('user_type')=="BOP"){ ?>

    <a class="btn btn-xm btn-info waves-effect waves-light" style="color:#fff" href="<?php echo site_url('Exedence/bop_confirm_request');?>?I=<?php echo base64_encode($data->issue_id); ?>&S=<?php echo base64_encode('Pending'); ?>"> Accept </a>

   <a class="btn btn-xm btn-success waves-effect waves-light" onclick='return canceled();' style="color:#fff" href="<?php echo site_url('Exedence/bop_confirm_request');?>?I=<?php echo base64_encode($data->issue_id); ?>&S=<?php echo base64_encode('CanceledByBOP'); ?>">  Cancel </a>

   <?php } } ?>

                                              
                                                 

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>


                    <!-- Read Incident -->

                    <div class="modal fade" id="readmore_modal<?php echo $data->issue_id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                                               
                    <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">  Incident Details  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>             
                    <div class="modal-body"> 

                    <strong>Service:</strong> <?php echo $data->service_name; ?> <hr>

                    <strong> Incident Description: </strong> <br> <hr>

                    <?php echo $data->description; ?>

                        </div>
                       </div>
                       </div>
                    </div>

                 <!--  End of Read Incident -->
                                      
                 
                    <div class="modal fade" id="reply_modal<?php echo $data->issue_id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                                               
                    <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel"> Solve/Reply Incident  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>             
                    <div class="modal-body"> 

                    <strong>Service:</strong> <?php echo $data->service_name; ?> | <strong>Requested By:</strong> <?php echo @$sendname; ?><hr>

                    <strong> Incident Description: </strong> <br> <hr>

                    <?php echo $data->description; ?>

                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Exedence/solve_request');?>">

                    <input type="hidden" class="form-control"  name="issueid" value="<?php echo $data->issue_id; ?>">


                    <div class="form-group row">
                    <div class="col-12">
                    <label> Reply Incident / Solution </label>
                    <textarea name="desc" class="form-control" maxlength=500 rows="5" required></textarea>
                    </div>
                    </div>


                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>   
                     </form>

                        </div>
                       </div>
                       </div>
                    </div>


                    <div class="modal fade" id="solution_modal<?php echo $data->issue_id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                                               
                    <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel"> Incident Solution / Feedback </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>             
                    <div class="modal-body"> 

                    <strong>Service: </strong> <?php echo $data->service_name; ?> | <strong>Requested By: </strong> <?php echo @$sendname; ?><hr>

                    <strong> Incident Description: </strong> <br> <hr>

                    <?php echo $data->description; ?> <hr>

                    <strong>Technical: </strong> <?php echo @$receiver; ?><hr>
                    
                    <strong> Coversation: </strong> <br> <hr>

                    <?php  
                    @$chartlist = $this->ExedenceModel->lists_charts($data->issue_id);
                    foreach($chartlist as $value) { 
                    $replyinfo  = $this->ExedenceModel->user_info(@$value->solvedby);
                    $chatname = @$replyinfo->first_name.' '.@$replyinfo->middle_name.' '.@$replyinfo->last_name;
                    ?>

                    (<?php echo $value->solution_created_at; ?>) <i> <strong> <?php echo @$chatname; ?> : </strong></i>

                    <?php echo @$value->solution_description; ?> 

                    <hr>
                      
                    <?php } ?>

                    <?php if($data->chart_status=="open"){ ?>
                    
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Exedence/reply_solution');?>">

                    <input type="hidden" class="form-control"  name="issueid" value="<?php echo $data->issue_id; ?>">


                    <div class="form-group row">
                    <div class="col-12">
                    <label> Reply  </label>
                    <textarea name="desc" class="form-control" maxlength=500 rows="5" required></textarea>
                    </div>
                    </div>


                    <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>   
                     </form>

                     <?php } ?>
                    

                        </div>
                       </div>
                       </div>
                    </div>
              

                                     <?php } ?>
                   
                                    </tbody>
                                </table>
                                </div>
                            <?php } ?>
                            
                               
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
      function del()
      {
        if(confirm("Are you sure you want to close support?"))
        {
            return true;
        }
        
        else{
            return false;
        }
      }

    function canceled()
      {
        if(confirm("Are you sure you want to cancel this request?"))
        {
            return true;
        }
        
        else{
            return false;
        }
      }
</script>

    <?php $this->load->view('backend/footer'); ?>

