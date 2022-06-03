<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
       <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i> Payment Voucher </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">  </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/payment_voucher/" class="text-white"><i class="" aria-hidden="true"></i> Payment Voucher Transactions List </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/StrongRoom/" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>


                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">


        <div class='alert alert-danger alert-dismissible fade show' role='alert' style="display:none;" id="forMessage">
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
          <strong id="notifyMessage"></strong>
          </div>

          <div class='alert alert-danger alert-dismissible fade show' role='alert' style="display:none;" id="forMessageTwo">
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
          <strong id="notifyMessageTwo"></strong>
          </div>


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
                         

<form  method="post" action="<?php echo site_url('Bureau/save_accounts_information');?>">

<input type="hidden" name="status" value="payment_voucher">

  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Paying To [Dr] </th>
           <th scope="col"> Paying From [Cr] </th>
           <th scope="col"> Currency </th>
           <th scope="col"> Balance  </th>
           <th scope="col"> Amount  </th>
           <th scope="col"> Description  </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td>
              <select name="payingto[]" class="form-control custom-select payingto" required="">
                <option value=""> Choose </option>
              <?php foreach ($debitlist as $value){ ?>
                   <option value="<?php echo $value->account_name; ?>"> <?php echo $value->account_name; ?></option>
              <?php } ?>
            </select>
             </td>
            <td> 
            <select name="payingfrom[]" class="form-control custom-select payingfrom" required="">
                <option value=""> Choose </option>
              <?php foreach ($creditlist as $value){ ?>
                   <option value="<?php echo $value->account_name; ?>"> <?php echo $value->account_name; ?></option>
              <?php } ?>
            </select>
            </td>
            <td> 
            <select name="product_id[]" class="form-control custom-select productname" required="">
                <option value=""> Choose </option>
              <?php foreach ($listcurrency as $value){ ?>
                   <option value="<?php echo $value->currencyid; ?>"> <?php echo $value->currency_desc; ?> </option>
              <?php } ?>
            </select>
            </td>
            <td><input type="number" name="qtybalance[]" class="form-control qtybalance" readonly></td>
            <td><input type="number" name="qty[]" class="form-control qty" required></td>
            <td><textarea name="desc[]" class="form-control desc" cols="4" required></textarea></td>
           <td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>
         </tr>
       </tbody>

       <tfoot>
        <tr>
         <td></td>
         <td></td>
         <td></td>
         <td><b>Total</b></td>
         <td><b class="total"></b></td>
         <td></td>
        </tr>
       </tfoot>

    </table>
    <div >
       <button class="btn btn-primary" type="submit"> Submit </button>
    </div>
</form>




                            </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


<script type="text/javascript">
    $(document).ready(function(){
        $('tbody').delegate('.productname', 'change', function () {
            var  tr = $(this).parent().parent();
            tr.find('.qty').focus();
        })

        $('tbody').delegate('.productname', 'change', function () {
            var tr =$(this).parent().parent();
            var id = tr.find('.productname').val();
            var dataId = {'id':id};
            
            $.ajax({
            type : "post",
            url  : "<?php echo site_url('Bureau/get_strong_room_balance_information');?>",
            data:'id='+id,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){

                    /*$('#nextstep3').hide();
                    $('#forMessageTwo').hide();
                    $('#notifyMessageTwo').html(''); qtybalance
                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);*/

                //tr.find('.price').val(data['price']);
                tr.find('.qtybalance').val(data['price']);
                tr.find('.qty').attr('max',data['price']);
                $('#forMessageTwo').hide();
                $('#notifyMessageTwo').html('');


                }else{

                    $('#nextstep3').hide();
                     $('#forMessage').hide();
                     $('#notifyMessage').html('');
                    $('#forMessageTwo').show();
                     tr.find('.qty').val('');
                     tr.find('.qtybalance').val('');
                    $('#notifyMessageTwo').html(data['message']);
                }
                
            }
        });


        
        });

        $('tbody').delegate('.qty', 'keyup', function () {
            var tr = $(this).parent().parent();
            var qty = tr.find('.qty').val();
            //var price = tr.find('.price').val();
            var amount = qty;
           // var vat = amount*0/100;
            //var ramount = amount - vat;
            tr.find('.qty').val(amount);
            //tr.find('.vat').val(vat);
            //tr.find('.ramount').val(ramount);
            total();
        });



        $('.addRow').on('click', function () {
            addRow();
        });
        function addRow() {
            var addRow = '<tr class="main_row">\n' +
                '         <td> <select name="payingto[]" class="form-control custom-select payingto" required="">\n' +
                '         <option value=""> Choose </option>\n' +
'                                        <?php foreach($debitlist as $data){ ?>\n' +
'                                            <option value="<?php echo $data->account_name; ?>"><?php echo $data->account_name; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +

                                '         <td><select name="payingfrom[]" class="form-control custom-select payingfrom" required="">\n' +
                '         <option value=""> Choose </option>\n' +
'                                        <?php foreach($creditlist as $data){ ?>\n' +
'                                            <option value="<?php echo $data->account_name; ?>"><?php echo $data->account_name; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +

                                '         <td><select name="product_id[]" class="form-control custom-select productname" required="">\n' +
                '         <option value=""> Choose </option>\n' +
'                                        <?php foreach($listcurrency as $data){ ?>\n' +
'                                            <option value="<?php echo $data->currencyid; ?>"><?php echo $data->currency_desc; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +
                            '<td><input type="number" name="qtybalance[]" class="form-control qtybalance" readonly></td>\n'+
                            '<td><input type="number" name="qty[]" class="form-control qty" required></td>\n'+
                            '<td><textarea name="desc[]" class="form-control desc" cols="4" required></textarea></td>\n'+
                            '<td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>\n' +
                            '</tr>';
            $('tbody').append(addRow);
        };

        /*$('.remove').on('click', function () {
            var l =$('tbody tr').length;
            if(l==1){
                alert('you cant delete last one')
            }else{
                $(this).parent().parent().remove();
            }
        });*/



    });

       function total(){
            var total = 0;
            $('.qty').each(function (i,e) {
                var amount =$(this).val()-0;
                total += amount;
            })
            $('.total').html(total);
        }



        

    function deleteRow(obj){
           var l =$('tbody tr').length;
            if(l==1){
            alert('you cant delete last one')
            }else{
            $(obj).closest('.main_row').remove();
            total();
           }
        }
</script>


<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example2-basic-multiple').select2();
});
</script>



<?php $this->load->view('backend/footer'); ?>
