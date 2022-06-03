<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
       <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i> Bureau De Change | Selling </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Bureau De Change  </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo site_url('Bureau/selling');?>" class="text-white"><i class="" aria-hidden="true"></i> Selling  </a></button>
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bureau/selling_transaction" class="text-white"><i class="" aria-hidden="true"></i> Selling Transaction </a></button>

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Services/Bureau" class="text-white"><i class="" aria-hidden="true"></i>  Bureau De Change Menu  </a></button>
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
                         

<form  method="post" action="<?php echo site_url('Bureau/save_sell_transaction');?>">

                             <div class="form-group row">

                                <div class="col-md-3">
                                <label> Customer Name </label>
                                <input type="text" name="name" class="form-control" required>
                                </div> 

                                <div class="col-md-3">
                                <label> Phone number </label>
                                <input type="text" name="phone" class="form-control" required>
                                </div> 

                                <div class="col-md-3">
                                <label> Identity Type </label>
                                <select name="id" class="form-control idtype" id="idtype" required>
                                <option value=""> Choose </option>
                                <?php foreach ($listidentity as $data) { ?>
                                <option value="<?php echo $data->identity_id; ?>"> <?php echo $data->identity_desc; ?> </option>
                                <?php } ?>
                                </select>
                                </div> 

                                <div class="col-md-3 iddesc" style="display: none;" id="iddesc">
                                <label> Identity Description </label>
                                <input type="text" name="iddesc" class="form-control">
                                </div>

                                <div class="col-md-3 idno" style="display: none;" id="idno">
                                <label> Identity No. </label>
                                <input type="text" name="idno" class="form-control">
                                </div> 

                                <div class="col-md-3">
                                <label> Purpose </label>
                                <select name="purpose" class="form-control purpose" id="purpose" required>
                                <option value=""> Choose </option>
                                <?php foreach ($listpurpose as $data) { ?>
                                <option value="<?php echo $data->purpose_id; ?>"> <?php echo $data->purpose_desc; ?> </option>
                                <?php } ?>
                                </select>
                                </div> 

                                <div class="col-md-3 purposedesc" style="display: none;" id="purposedesc">
                                <label> Purpose Description </label>
                                <input type="text" name="purposedesc" class="form-control">
                                </div>

                                <div class="col-md-3">
                                <label> Country </label>
                                <select name="country" class="form-control" required>
                                <option value=""> Choose </option>
                                <?php foreach ($listcountry as $data) { ?>
                                <option value="<?php echo $data->countryname; ?>"> <?php echo $data->countryname; ?> </option>
                                <?php } ?>
                                </select>
                                </div> 

                                </div>

  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Currency </th>
           <th scope="col"> Balance </th>
           <th scope="col"> Rate </th>
           <th scope="col"> Exchange Amount </th>
           <th scope="col"> Total</th>
           <th scope="col"> Vat (0%)</th>
           <th scope="col"> Amount </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td><select name="product_id[]" class="form-control productname" required="">
                <option value=""> Choose </option>
              <?php foreach ($listcurrency as $value){ ?>
                   <option value="<?php echo $value->currency_id; ?>"> <?php echo $value->currency_desc; ?></option>
              <?php } ?>
                     </select></td>
            <td><input type="number" name="balance[]" class="form-control balance" required="" readonly></td>
            <td><input type="number" name="qty[]" class="form-control qty" required="" readonly></td>
            <td><input type="number" name="price[]" class="form-control price" required=""></td>
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
         <td></td>
         <td><b>Total</b></td>
         <td><b class="total"></b></td>
         <td></td>
        </tr>
        <tr>
         <td></td>
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
    $('#idtype').on('change', function() {

         if($('#idtype').val() == 5){
            $('#iddesc').show();
            $('#idno').hide();
            $('#error1').html('');
            }

         if($('#idtype').val() == ""){
            $('#iddesc').hide();
            $('#idno').hide();
            $('#error1').html('');
          }  

        if($('#idtype').val() == 1 || $('#idtype').val() == 2 || $('#idtype').val() == 3 || $('#idtype').val() == 4 || $('#idtype').val() == 6){
            $('#iddesc').hide();
            $('#idno').show();
            $('#error1').html('');
        } 



     });
</script>

<script type="text/javascript">
    $('#purpose').on('change', function() {

         if($('#purpose').val() == 7){
            $('#purposedesc').show();
            $('#error1').html('');
            } else {
            $('#purposedesc').hide();
            $('#error1').html('');
            }
     });
</script>


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
            url  : "<?php echo site_url('Bureau/get_counter_selling_product_information');?>",
            data:'id='+id,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){

                    /*$('#nextstep3').hide();
                    $('#forMessageTwo').hide();
                    $('#notifyMessageTwo').html(''); qtybalance
                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);*/

                tr.find('.balance').val(data['balance']);
                tr.find('.qty').val(data['qty']);
                tr.find('.price').attr('max',data['balance']);
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
'                                        <?php foreach($listcurrency as $data){ ?>\n' +
'                                            <option value="<?php echo $data->currency_id; ?>"><?php echo $data->currency_desc; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +
                                '<td><input type="number" name="balance[]" class="form-control balance" required="" readonly></td>\n' +
'                                <td><input type="number" name="qty[]" class="form-control qty" readonly></td>\n' +
'                                <td><input type="number" name="price[]" class="form-control price" required></td>\n' +
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


<?php $this->load->view('backend/footer'); ?>
