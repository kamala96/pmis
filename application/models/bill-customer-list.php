<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Bill Customer List</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Bill Customer List</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Bill_Customer_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?>  Customer List </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Bill_Transactions_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                </div>
            </div>
            <form method="POST" action="service_to_other"> 
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i> Bill Customer List<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                             
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                          <table id="table_id" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/No</th>
                                <th>Customer Name</th>
                                <th>Customer Address</th>
                                <th>Mobile Phone</th>                                
                                <th>Amount(Tsh.)</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($bill as  $value) {?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $value->cust_name;?></td>
                                <td><?php echo $value->cust_address;?></td>
                                <td><?php echo $value->cust_mobile;?></td>
                                <td><?php echo number_format($value->price,2);?></td>
                                <td style="text-align: right;">
                                <?php if( $this->session->userdata('user_type') == "EMPLOYEE"|| $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT"){ ?>
                                    <a href="<?php echo base_url()?>Ems_Domestic/Bill_Customer_Transaction?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Services</a>
                                    |
                                <a href="<?php echo base_url()?>Ems_Domestic/Pcum_Bill_Transactions_List?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Transactions List</a>

                                <?php }else{ ?>
                                  
                                <a href="<?php echo base_url()?>Ems_Domestic/Bill_Customer_Transaction?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Services</a>
                                |
                                <a href="<?php echo base_url()?>Ems_Domestic/Pcum_Bill_Transactions_List?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Transactions List</a>
                                <a href="<?php echo base_url()?>Box_Application/get_bill_ems_list?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Bill Payment Trend</a>
                                |
                                <a href="<?php echo base_url()?>Box_Application/Credit_Customer?I=<?php echo base64_encode($value->pcum_id) ?>" class="btn btn-info">Edit</a>
                                <?php }?> 
                                  
                                </td>
                                
                                <td style="text-align:right;">
                                
                                  
                            </td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                            </div>
                        </div>
                        </div>

                     </div>
                </div>
            </div> 
            
        </form>
         </div>
                          
    </div>
<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        ordering:false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    });
</script>

<?php $this->load->view('backend/footer'); ?>
