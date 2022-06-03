<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Posta Cash | Agent Deposit Transactions </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posta Cash</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">


<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/registered_agent_wallet_transactions" class="text-white"><i class="" aria-hidden="true"></i> Agent Deposit Transactions </a></button>

<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_agents_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

                </div>
        </div>

            <div class="row">
              <div class="col-md-12">

              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Transactions List
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        
                      </div>

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
                            ?>

                      <form class="row" method="post" action="<?php echo site_url('Posta_Cash/find_agent_wallat_transactions'); ?>">
                                
                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="fromdate" class="form-control mydatetimepickerFull"  placeholder="From Date">
                                </div>
                                    
                                <div class="form-group col-md-3 m-t-10">
                                <input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date">
                                </div>

                                <div class="form-group col-md-3 m-t-10">
                                <select name="region" class="form-control region" id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="form-group col-md-3 m-t-10">
                                <select name="branch" class="form-control branch" id="branchdropo">  
                                 <option value=""> Branch </option>
                                </select>
                                </div>
                                    
                                <div class="form-group col-md-4 m-t-10">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                </div>
                    </form>



                        <?php if(isset($list)){ ?>
                        <hr>
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%">
                               <thead>
                                    <th>S/N </th>
                                   <th> Agent Name </th>
                                   <th> Agent No. </th>
                                   <th> Region </th>
                                   <th> Branch </th>
                                   <th> Paid Amount </th>
                                   <th> Control Number </th>
                                   <th> Created at </th>
                                   <th> Status </th>
                               </thead>
                               <tbody>
                                   <?php $sn=1; $sumamount=0; foreach ($list as $value) { ?>
                                       <tr>
                                           <td> <?php echo $sn; ?> </td>
                                           <td>
                                            <?php echo @$value->agent_fname.' '.@$value->agent_mname.' '.@$value->agent_lname; ?> 
                                            </td>
                                           <td> <?php echo @$value->agent_no; ?> </td>
                                           <td> <?php echo @$value->agent_region; ?> </td>
                                           <td> <?php echo @$value->agent_branch; ?> </td>
                                           <td> <?php echo number_format(@$value->paidamount,2); $sumamount+=@$value->paidamount; ?> </td>
                                           <td> <?php echo @$value->billid; ?> </td>
                                           <td> <?php echo @$value->transactiondate; ?> </td>
                                           <td>
                                            <?php if($value->status=="Paid"){ ?>
                                            <button class="btn btn-success" disabled="disabled"> Paid </button>
                                            <?php } else { ?>
                                            <button class="btn btn-danger" disabled="disabled"> <?php echo @$value->status; ?> </button>
                                            <?php } ?>
                                           </td>
                                           
                                       </tr>
                                   <?php $sn++;  ?>

                                   <?php } ?>
                                   
                               </tbody>
                               <tr>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td></td>
                               <td> Total: </td>
                               <td> <?php echo number_format(@$sumamount,2); ?> </td>
                               <td></td>
                               <td></td>
                               <td></td>
                               </tr>


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
