<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Bill Summary Sheet (TTCL FORMAT)  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            Summary Sheet
                        </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">


                <div class="row">
                    <div class="col-12">



                            <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Bill Summary Sheet (TTCL FORMAT)<span class="pull-right " ></span></h4>
                            </div>

                           <div class="card-body">


                           
                         <?php if(!empty($emslist)){ ?>

                            <div class="table-responsive">
                            <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                            <th style="text-align: center;" colspan="6">
    <!-- <img src="assets/images/tcp.png" width="130" height="80"> -->
      <img src="<?php echo base_url();?>assets/images/tcp.png" height="100px" width="200px"/><br>
      <b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b> <br>
      <b style="font-size: 20px;">BILL SUMMARY SHEET (TTCL FORMAT)</b> <br>
       <hr>
     <b style="font-size: 18px;"> <?php echo @$custinfo->customer_name; ?> | <?php echo @$custinfo->customer_address . ',' .@$custinfo->customer_region; ?> </b> <br>
    </th>
                            </tr>
                            <tr>
                            <th> S/N </th>
                             <th> Date </th>
                            <th>  No.  </th>
                             <th> Postage  </th>
                             <th> Vat </th>
                             <th> Total </th>
                            </tr>
                            </thead>
                            <tbody>
                           
                            <?php
                            $sn = 1;
                            foreach($emslist as $data)
                            {
                            $date = $data->date;
                            $acc_no = $this->session->userdata('account');
                            $value = $this->E_reports_Model->get_transaction_summary_ttcl($acc_no,$date);
                            ?>
                            
                            <tr>
                            <td>  <?php echo $sn; ?>  </td>
                            <td>  <?php echo date("d.m.Y", strtotime($value->regdate));  ?>  </td>
                            <td>  <?php $nooftrans=  $value->count_trans; echo $nooftrans;  $sum_no[] = $nooftrans; ?> </td>
                            <td> 
                            <?php 
                            //@$emsprice=$value->trans_amount;  
                             @$emsprice = (100*$value->trans_amount)/118; echo number_format($emsprice,2); 
                            $sumprice[] = @$emsprice;
                            ?>
                          </td>
                            <td> 
                            <?php @$amount = $value->trans_amount; 
                            @$emsvat = @$amount - @$emsprice;
                            $sumvat[] = @$emsvat;
                            echo number_format(@$emsvat,2);
                            ?> 
                            </td>
                            <td> 
                            <?php 
                            @$finalamount = $value->trans_amount; echo number_format($finalamount,2);
                            @$sumamount[] = @$finalamount;
                            ?>
                            </td>
                            </tr>
                            <?php $sn++; 
                            } 
                           ?>


                           <tr>
                           <td></td>
                           <td></td>
                           <td> <strong> <?php echo number_format(array_sum($sum_no));?>  </strong> </td>
                           <td>  <strong> <?php echo number_format(array_sum($sumprice),2);?>  </strong> </td>
                           <td> <strong> <?php echo number_format(array_sum($sumvat),2);?>  </strong> </td>
                           <td> <strong> 
                           <?php 
                           if(!empty(@$finalamount)){
                           echo number_format(array_sum(@$sumamount),2); 
                           }
                           ?> <strong></td>
                            </tr>

                            </tbody>
                            </table>
                            </div>

                         <?php } ?>
                         <!-- END OF EMS RESULTS -->


                        

                        </div>
                    </div>
                   </div>
               </div>









                        



            </div>


<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[-1, 10, 25, 50,100 ], ["All", 10, 25, 50,100]],
    dom: 'lBfrtip',
    buttons: [
    'excel'
    ]
} );
} );
</script>


<?php $this->load->view('backend/footer'); ?>


