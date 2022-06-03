<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
$todaydate = date("Y-m-d");
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-8 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> 

                Incident Management  <b style="color:red;"> (Dashboard shows incidents of <?php echo date("F j, Y",strtotime($todaydate)); ?>) </b>


            </h3>
                </div>
                <div class="col-md-4 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            Dashboard
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
                                     Find Incidents
                                     </h3>
                                          <a href="<?php echo site_url('Exedence/list_issues');?>" class="text-muted m-b-0">View Incidents </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php if($this->session->userdata('sub_user_type')=="TECHNICAL" || $this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="SUPER ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="PMG" || $this->session->userdata('user_type')=="CRM"){ ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                         Master Cancelation
                                        </h3>
                                        <a href="<?php echo site_url('MasterCancelation/dashboard');?>" class="text-muted m-b-0"> View </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
<?php } ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        <?php echo number_format(@$countpending); ?>
                                        </h3>
                                         <a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&status=Pending');?>" class="text-muted m-b-0">Pending Incidents</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                         <?php echo number_format(@$countreceived); ?>
                                        </h3>
                                         <a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&status=Received');?>" class="text-muted m-b-0">Received Incidents</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                          <?php echo number_format(@$countsolved); ?>
                                        </h3>
                                        <a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&status=Solved');?>" class="text-muted m-b-0">Solved Incidents</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                          <?php echo number_format(@$countclosed); ?>
                                        </h3>
                                        <a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&status=Closed');?>" class="text-muted m-b-0">Closed Incidents</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->


                    <?php if($this->session->userdata('sub_user_type')!="TECHNICAL"){ ?>

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-calendar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                          <?php echo number_format(@$countcancelation); ?>
                                        </h3>

<?php if($this->session->userdata('user_type')=="RM"){ ?>
<a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&request=Cancelation+Incident&status=PendingRequest');?>" class="text-muted m-b-0">Cancelation  Incidents </a>
<?php } elseif($this->session->userdata('user_type')=="BOP") { ?>
<a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&request=Cancelation+Incident&status=ApprovedByRM');?>" class="text-muted m-b-0">Cancelation  Incidents </a>
<?php } else { ?>
<a href="<?php echo site_url('Exedence/search_issues?fromdate='.$todaydate.'&todate='.$todaydate.'&region=&request=Cancelation+Incident&status=');?>" class="text-muted m-b-0">Cancelation  Incidents </a>
<?php } ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                  <?php } ?>



                </div>

             


                    <div class="row">
                    <div class="col-12">


                         <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>
                          
                          <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                          <?php } ?>


                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Request your Incident <span class="pull-right " ></span></h4>
                            </div>

                            
                          

                            <div class="card-body">


                            <div class="row">

                            <div class="col-lg-6 col-md-6">



                               <form method="post" action="<?php echo site_url('Exedence/save_issue'); ?>" enctype="multipart/form-data">

                               <div class="form-group row"> 

                                <div class="col-lg-12 col-md-12">
                                <label> Choose Service </label>
                                <select class="form-control" style="width: 100%; height:36px;" name="service" required>
                                <option value=""> Choose </option>
                                <?php foreach ($service as $data) { ?>
                                <option value="<?php echo $data->service_id; ?>"><?php echo $data->service_name; ?> </option>
                                <?php }?>
                                </select>
                                </div>

                               </div>

                               <div class="form-group row"> 

                                <div class="col-lg-12 col-md-12">
                                <label> Choose Incident </label>
                                <select class="form-control" style="width: 100%; height:36px;" name="request" required>
                                <option value=""> Choose </option>
                                <?php foreach ($request as $data) { ?>
                                <option value="<?php echo $data->request_name; ?>"><?php echo $data->request_name; ?> </option>
                                <?php }?>
                                </select>
                                </div>

                               </div>


                               <div class="form-group row"> 

                                <div class="col-lg-12 col-md-12">
                                <label> Descriptions (500=>Maximum Characters) </label>
                                <textarea name="desc" class="form-control" maxlength=500 rows="5" required></textarea>
                                </div>

                               </div>

                               <div class="form-group row"> 

                                <div class="col-lg-6 col-md-6">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Submit </button>
                                </div>

                               </div>
                            
                                    
                                  
                                </form>

                            </div>

                            <div class="col-lg-6 col-md-6">

                            <h3> Instructions</h3>

                            <p>1. Cancelation Incident: This type of Incident must approved by Regional Manager (RM) and Finally Approved by BOP before received with Technical Team (Check progress of your request on the Cancelation Incidents Dashboard)</p>

                            <p>2. Support Incident: Received with Technical Team after request submitted </p>

                            <h3> Conversation </h3>

                             <p> Chart with Technical Officer after your incident request go to Solved incidents Dashboard. </p>

                            </div>



                                

                            </div>



                            </div>
                        </div>


<?php if($this->session->userdata('sub_user_type')=="TECHNICAL" || $this->session->userdata('user_type')=="RM" || $this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN"){ 

if(!empty($getincidents)){ ?>



<div class="card card-outline-info">
<div class="card-header">
<h4 class="m-b-0 text-white"><i class="fa fa-area-chart" aria-hidden="true"></i>  Incident Performance <span class="pull-right " ></span></h4>
</div>

<div class="card-body">

<div class="content" id="chart-container"> </div>

</div>
</div>


<?php } } ?>

                  



                    </div>
                </div>
  



            </div>



<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>


<script type="text/javascript">

FusionCharts.ready(function () {
            // chart instance
            var chart = new FusionCharts({
                type: "column2d",
                renderAt: "chart-container", // container where chart will render
                width: "1480",
                height: "450",
                dataFormat: "json",
                dataSource: {
                    // chart configuration
                    chart: {
                                     caption: "Incidents Performance in Graphical Presentation",
                                     xaxisname: "Incident Status",
                                     yaxisname: "Incidents (Total)",
                                     numbersuffix: "",
                                     theme: "fusion"
                    },
                    // chart data
                    data: [
                        <?php foreach($getincidents as $value){?>
                       { label: "<?php echo $value->status; ?>", 
                         value: "<?php echo $value->value; ?>" 
                       },       
                        <?php } ?>
                          ]
                }
            }).render();
        });
</script>

<?php $this->load->view('backend/footer'); ?>
