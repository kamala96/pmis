<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-truck" style="color:#1976d2"> </i>  List Vehicles </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Fleet Profile </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">

                   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>services/Fleet" class="text-white"><i class="" aria-hidden="true"></i> Add Vehilce  </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Fleet/list_vehicle" class="text-white"><i class="" aria-hidden="true"></i> List Vehicles </a></button>

                </div>
        </div>

            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                </div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> List Vehicles
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        
                      </div>

                      <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                          <?php } ?>

                           <form method="POST" action="<?php echo base_url('Fleet/search_vehicle');?>">

                                <div class="row">

                                <div class="col-md-6">
                                <label> Region: </label>
                                <select name="region" value="" class="form-control" required id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="col-md-6">
                                <label> Branch: </label>
                                <select name="branch" value="" class="form-control"  id="branchdropo">  
                                 <option> Branch </option>
                                </select>
                                </div>

                                </div>
                                <br>
                               

                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Search</button>
                                    </div>
                                </div>
                                </div>
                           </form>

                      <?php if(isset($list)) {?>

                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 <th>S/N </th>
                                 <th> Vehicle Registration # </th>
                                   <th> Vehicle Make </th>
                                   <th> Vehicle Model </th>
                                   <th> Chasis Number </th>
                                   <th> Engine Number </th>
                                   <th> Engine Capacity (CC) </th>
                                   <th> Vehicle Type </th>
                                   <th> Insurance Status </th>
                                   <th> Year of Manufacture </th>
                                   <th> Vehicle Status </th>
                                   <th> Region </th>
                                   <th> Branch </th>
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php $sn=1; foreach ($list as $value) {  ?>
                                       <tr>
                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->regno; ?></td>
                                           <td><?php echo $value->make; ?></td>
                                           <td><?php echo $value->model; ?></td>
                                           <td><?php echo $value->chasis; ?></td>
                                           <td><?php echo $value->engine; ?></td>
                                           <td><?php echo $value->capacity; ?></td>
                                           <td><?php echo $value->type; ?></td>
                                           <td><?php echo $value->insurance; ?></td>
                                           <td><?php echo $value->manufacture; ?></td>
                                           <td><?php echo $value->status; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                       </tr>
                                   <?php $sn++; } ?>
                                   
                               </tbody>
                           </table>
                           </div>
                        <?php } ?>
                        
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
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
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>


<?php $this->load->view('backend/footer'); ?>
