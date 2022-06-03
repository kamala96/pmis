<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Necta Online Transactions  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Necta </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                  
                            <div class="card-body">


                            <?php 
                            if(!empty($this->session->flashdata('message'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('message'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>
                       
                            <form class="row" method="post" action="<?php echo site_url('Necta/necta_online_trans_results');?>">

                                    <input type="hidden" name="empid" class="form-control" value="<?php echo $this->session->userdata('getempid'); ?>">

                                    <div class="form-group col-md-2 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" placeholder="Enter Full name" >
                                    </div>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                         <input type="date" name="todate" class="form-control" placeholder="Enter No." >
                                    </div>

                                     <div class="form-group col-md-2 m-t-10">
                                    <select class="form-control"  name="status">
                                    <option value="Paid"> Paid </option>
                                    <option value="NotPaid"> NotPaid </option>
                                    </select>
                                    </div>

                                    <div class="form-group col-md-2 m-t-10">
                                         <input type="text" name="controlnumber" class="form-control" placeholder="Enter ControlNumber." >
                                    </div>
                                    
                                    <div class="form-group col-md-2 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
                            

 <?php if(isset($list)){ ?>



                        
                               
                                   <div class="table table-responsive">
                                   <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                  <th> Receiver Name  </th>
                                                 <th> Control Number  </th>
                                                <th> Barcode Number </th>
                                                <!-- <th> Weight </th> -->
                                                <th> Registered Date </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                                 <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php  
                                       $sn=1;
                                       foreach ($list as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo @$value->fullname; ?>  </td>
                                        <td>    <?php echo @$value->billid; ?>  </td>
                                         <td>  
                                          <?php 
                                          if(@$value->status=="Paid"){

                                          if(!empty(@$value->Barcode)){
                                          echo ucfirst(@$value->Barcode);   
                                        } else { ?>
                                        <button class="btn btn-info" data-toggle="modal" type="button" data-target="#add_barcode_modal<?php echo $value->serial; ?>"> Add Barcode </button>
                                         <?php }

                                         } else {
                                         echo "Pay to update";
                                         } 

                                         ?> 
                                          </td>
                                          <!-- <td>  <?php //echo @$value->weight; ?>     </td> -->
                                          <td>  <?php echo @$value->date_registered; ?>     </td>
                                           <td>  <?php  echo $value->branch;  ?>     </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            @$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 @$sumamount[] = @$finalamount;
                                        ?>   </td>
                                        <td>
                                         <button class="btn btn-danger btn-sm"> <?php echo @$value->status; ?></button>
                                        </td>
                                       </tr>
                                       <?php $sn++; ?>

                                      

                         <!-- Assign Task -->
                        <div class="modal fade" id="add_barcode_modal<?php echo $value->serial; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add Barcode Number  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                        <div class="modal-body"> 
            
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Necta/update_nectaonline_trans'); ?>">
                    
                    <input type="hidden" class="form-control"  name="serial" value="<?php echo $value->serial; ?>">

                    <div class="form-group row">
                    <div class="col-md-12">
                    <label> Barcode Number </label>
                    <input type="text" class="form-control"  name="barcode" required="">   
                    </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
                            
                     </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- Assign Task End -->

                                      <?php } ?> 

                                       <tr>
                                        <!-- <td></td> -->
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <?php if(!empty(@$sumprice)){ echo number_format(array_sum(@$sumprice),2); } ?> </td>
                                        <td> <?php if(!empty(@$sumvat)){ echo number_format(array_sum(@$sumvat),2);  } ?> </td>
                                        <td> <?php if(!empty(@$sumamount)){ echo number_format(array_sum(@$sumamount),2); } ?> </td>
                                        <td>    </td>
                                       </tr>   
                                        </tbody>
                                    </table>
                                    </div>
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
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>
    <?php $this->load->view('backend/footer'); ?>