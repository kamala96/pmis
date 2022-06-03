<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Opening Balance Summary </h3>
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
                        <h4 class="m-b-0 text-white"> Strong Room  | Opening Balance Summary
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        
                      </div>

                    


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
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; $avtotal = 0; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->currency_desc; ?> </td>
                                            <td> <?php echo $data->currency_name; ?> </td>
                                            <td> <?php $amount = @$data->stock_amount; echo number_format(@$amount,2); ?> </td>
                                            <td> <?php echo number_format(@$data->buying_price,2); ?> </td>
                                            <td> <?php $total =@$data->stock_amount*@$data->buying_price;  echo number_format(@$total,2); ?> </td>
                                            <td> <?php echo number_format(@$data->selling_price,2); ?> </td>
                                            <td> <?php $outamount = @$data->stock_amount_out; echo number_format(@$outamount,2); ?> </td>
                                            <td> <?php $diffamount = @$amount-@$outamount; $avtotal+=$diffamount; echo number_format(@$diffamount,2); ?></td>
                                        </tr>
                                    <?php $sn++; ?>

                                     <?php } ?>
                   
                                    </tbody>

                                    <tr>
                                    <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> 
                                    <td><?php echo number_format(@$avtotal,2);?></td>
                                    </tr>
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
