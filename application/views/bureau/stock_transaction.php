<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Stock Transactions </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
              <div class="col-12">


             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/stock" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>

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
                        <h4 class="m-b-0 text-white"> Stock Transactions List
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

                             <?php 
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

                      <form class="row" method="post" action="<?php echo site_url('Bureau/stock_transaction_results'); ?>">

                                    <div class="form-group col-md-4 m-t-10">
                                    <input class="form-control mydatetimepickerFull" type="text" name="fromdate" placeholder="From Date" required>
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                    <input class="form-control mydatetimepickerFull" type="text" name="todate" placeholder="To Date" required>
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                    </form>



                        <?php if(isset($list)){ ?>
                          <div class="table-responsive">
                                     <table class="table table-bordered table-striped International text-nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th> Currency </th>
                                            <th> Currency Code </th>
                                            <th> Amount (Qty) </th>
                                            <th> Buying Price </th>
                                            <th> Value </th>
                                            <th> Selling Price </th>
                                            <th> Amount Out (Qty) </th>
                                            <th> Available Amount (Qty) </th>
                                            <th> Status </th>
                                            <th> Created at </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->currency_desc; ?> </td>
                                            <td> <?php echo $data->currency_name; ?> </td>
                                            <td> <?php $amount = @$data->stock_amount; echo number_format(@$amount,2); ?> </td>
                                            <td> <?php echo number_format(@$data->buying_price,2); ?> </td>
                                            <td> <?php $total =@$data->stock_amount*@$data->buying_price;  echo number_format(@$total,2); ?> </td>
                                            <td> <?php echo number_format(@$data->selling_price,2); ?> </td>
                                            <td> <?php $outamount = @$data->stock_amount_out; echo number_format(@$outamount,2); ?> </td>
                                            <td> <?php $diffamount = @$amount-@$outamount; echo number_format(@$diffamount,2); ?></td>
                                            <td>
                                                   <?php 
                                                  if($data->stock_status=="COMPLETE"){ ?>
                                                  <button class="btn btn-success" disabled="disabled"> COMPLETE </button>
                                                  <?php } else { ?>
                                                  <button class="btn btn-danger" disabled="disabled"> <?php echo @$data->stock_status; ?> </button>
                                                  <?php } ?>
                                                   </td>
                                            <td> <?php echo $data->bureau_stock_created_at; ?> </td>
                                            <td>
                                            <?php
                                             if($data->stock_status=="INCOMPLETE"){ 
                                            $checkstrongroomIDExist = $this->BureauModel->checkstrongroomIDExist(@$data->bureau_strong_room_stock_id);
                                            if($checkstrongroomIDExist<=0){ ?>
                                            <a href="<?php echo base_url('Bureau/update__trans_stock');?>?I=<?php echo base64_encode($data->bureau_strong_room_stock_id); ?>" onclick='return del();' title="Delete" class="btn btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i> Cancel Stock </a>
                                            
                                            <?php } } ?>
                                            </td>
                                        </tr>
                                    <?php $sn++; ?>

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



<?php $this->load->view('backend/footer'); ?>

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
      function del()
      {
        if(confirm("Are you sure you want to Cancel this Stock?"))
        {
            return true;
        }
        
        else{
            return false;
        }
      }
</script>
