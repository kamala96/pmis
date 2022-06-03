<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
       <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i> Posta Shop</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Posta Shop </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo site_url('PostaShop/saleproducts');?>" class="text-white"><i class="" aria-hidden="true"></i> Sale Products  </a></button>
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo site_url('PostaShop/selling_transaction'); ?>" class="text-white"><i class="" aria-hidden="true"></i> Sales Transaction </a></button> 

                     <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaShop/postashop_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>


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

          <div class='alert alert-success alert-dismissible fade show' role='alert' style="display:none;" id="forMessageTwo">
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
                         

<form  method="post" action="<?php echo site_url('PostaShop/save_selling');?>">

                             <div class="form-group row">

                                <div class="col-md-3">
                                <label> Customer Name/Company </label>
                                <input type="text" name="name" class="form-control" required>
                                </div> 

                                <div class="col-md-3">
                                <label> Phone number </label>
                                <input type="text" name="phone" class="form-control" required>
                                </div> 

                                <div class="col-md-3">
                                <label> TIN Number </label>
                                <input type="text" name="tin" class="form-control">
                                </div>

                                <div class="col-md-3">
                                <label> VRN Number </label>
                                <input type="text" name="vrn" class="form-control">
                                </div> 

                                <div class="col-md-3">
                                <label> Address </label>
                                <input type="text" name="address" class="form-control" required>
                                </div>  


                                </div>

  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Product </th>
           <th scope="col"> Price </th>
           <th scope="col"> Qty Available </th>
           <th scope="col"> Quantity </th>
           <th scope="col"> Total</th>
           <th scope="col"> Vat (0%)</th>
           <th scope="col"> Amount </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td><select name="product_id[]" class="form-control custom-select js-example-basic-multiple productname" required="">
                <option value=""> Choose </option>
              <?php foreach ($list as $value){ ?>
                   <option value="<?php echo $value->productid; ?>"> <?php echo $value->product_name; ?></option>
              <?php } ?>
                     </select></td>
            <td><input type="number" name="price[]" class="form-control price" readonly></td>
            <td><input type="number" name="qtybalance[]" class="form-control qtybalance" readonly></td>
            <td><input type="number" name="qty[]" class="form-control qty" required></td>
            <td><input type="text" name="amount[]" class="form-control amount" readonly></td>
            <td><input type="text" name="vat[]" class="form-control vat" readonly></td>
            <td> <input type="text" name="ramount[]" class="form-control ramount" readonly> </td>
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
        <tr>
         <td></td>
         <td></td>
         <td></td>
         <td><b> Vat(0%)</b></td>
         <td><b class="totalvat"></b></td>
         <td></td>
        </tr>
        <tr>
         <td></td>
         <td></td>
         <td></td>
         <td><b> Amount </b></td>
         <td><b class="totalramount"></b></td>
         <td></td>
        </tr>
       </tfoot>

    </table>
    <div >
       <button class="btn btn-primary" type="submit">Submit</button>
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
            url  : "<?php echo site_url('PostaShop/get_counter_Product_information');?>",
            data:'id='+id,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){

                    /*$('#nextstep3').hide();
                    $('#forMessageTwo').hide();
                    $('#notifyMessageTwo').html(''); qtybalance
                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);*/

                tr.find('.price').val(data['price']);
                tr.find('.qtybalance').val(data['qty']);
                tr.find('.qty').attr('max',data['qty']);
                $('#forMessageTwo').hide();
                $('#notifyMessageTwo').html('');


                }else{

                    $('#nextstep3').hide();
                     $('#forMessage').hide();
                     $('#notifyMessage').html('');
                    $('#forMessageTwo').show();
                     tr.find('.price').val('');
                     tr.find('.qtybalance').val('');
                    $('#notifyMessageTwo').html(data['message']);
                }
                
            }
        });


        
        });

        $('tbody').delegate('.qty,.price', 'keyup', function () {
            var tr = $(this).parent().parent();
            var qty = tr.find('.qty').val();
            var price = tr.find('.price').val();
            var amount = qty * price;
            var vat = amount*0/100;
            var ramount = amount - vat;
            tr.find('.amount').val(amount);
            tr.find('.vat').val(vat);
            tr.find('.ramount').val(ramount);
            total();
            totalvat();
            totalramount();
        });



        $('.addRow').on('click', function () {
            addRow();
        });
        function addRow() {
            var addRow = '<tr class="main_row">\n' +
                '         <td><select name="product_id[]" class="form-control productname " >\n' +
                '         <option value=""> Choose </option>\n' +
'                                        <?php foreach($list as $data){ ?>\n' +
'                                            <option value="<?php echo $data->productid; ?>"><?php echo $data->product_name; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +
                                 '<td><input type="number" name="price[]" class="form-control price" readonly></td>\n' +
                                 '<td><input type="number" name="qtybalance[]" class="form-control qtybalance" readonly></td>\n'+
'                                <td><input type="number" name="qty[]" class="form-control qty" required></td>\n' +
'                                <td><input type="number" name="amount[]" class="form-control amount" readonly></td>\n' +
'                                <td><input type="text" name="vat[]" class="form-control vat" readonly ></td>\n' +
'                                <td><input type="text" name="ramount[]" class="form-control ramount" readonly ></td>\n' +
'                                <td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>\n' +
'                             </tr>';
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
            $('.amount').each(function (i,e) {
                var amount =$(this).val()-0;
                total += amount;
            })
            $('.total').html(total);


        }

        function totalvat(){
            var totalvat = 0;
            $('.vat').each(function (i,e) {
                var vat =$(this).val()-0;
                totalvat += vat;
            })
            $('.totalvat').html(totalvat);
        }

        function totalramount(){
            var totalramount = 0;
            $('.ramount').each(function (i,e) {
                var ramount =$(this).val()-0;
                totalramount += ramount;
            })
            $('.totalramount').html(totalramount);
        }
        

    function deleteRow(obj){
           var l =$('tbody tr').length;
            if(l==1){
            alert('you cant delete last one')
            }else{
            $(obj).closest('.main_row').remove();
            total();
            totalvat();
            totalramount();
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
