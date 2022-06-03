<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> FPL,RDP Delivery Transactions List </h3>
        </div>
        <div class="col-md-7 align-self-center">
            
        </div>
    </div>
    <div class="container-fluid">
      <div class="row m-b-10">
                <div class="col-12">
                  <?php if($this->session->userdata('user_type') =='ACCOUNTANT' 
                  || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/registered_international_List" class="text-white"><i class="" aria-hidden="true"></i>  FPL,RDP Delivery Transactions List</a></button>

<?php }else{?>
   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/registered_international_form" class="text-white"><i class="" aria-hidden="true"></i> Add FPL,RDP </a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/registered_international_List" class="text-white"><i class="" aria-hidden="true"></i>  FPL,RDP Delivery Transactions List</a></button>
                   <?php }?>
                   
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
                        <h4 class="m-b-0 text-white"> FPL,RDP Delivery Transactions List
                        </h4>
                    </div>
                    <div class="card-body">

                      <div class="col-md-12">
                        <form action="search_registered_international_List" method="POST">
                        <div class="input-group">
                          <input type="date" name="fromdate" class="form-control" placeholder="From Date">
                          <input type="date" name="todate" class="form-control" placeholder="To Date">
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div>
                     

                       <?php if(isset($list)){?>
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 <th>Operator</th>
                                 <th>Customer Mobile</th>
                                   <th> Item</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>

                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php foreach ($list as $value) { ?>
                                       <tr>
                                           <td><?php echo $value->Operator; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php echo $value->paidamount; ?></td>
                                          
                                           
                                           <td>
                                            <?php 

                                                
                                                $serial = $value->serial;
                                                $amount = $value->paidamount;
                                                //$this->Box_Application_model->getUpdatePaymentInternational($serial,$amount);
                                                
                                                echo $value->billid;
                                           ?> 
                                           </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                           <td><?php echo $value->paymentdate; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button>
                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td>
                                          
                                           
                                       </tr>
                                   <?php } ?>
                                   
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
$(document).ready(function() {
    $("#checkAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll").prop("checked", true);
            }
        }
        else {
            $("#checkAll").prop("checked", false);
        }
    });
});
</script>

<?php $this->load->view('backend/footer'); ?>
