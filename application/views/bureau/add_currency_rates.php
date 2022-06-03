<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
       <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i> Add Currency Rate </h3>
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
                    

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/currency_rates" class="text-white"><i class="" aria-hidden="true"></i> Currency Rates List  </a></button>


             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/StrongRoom/" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">


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
                         

<form  method="post" action="<?php echo site_url('Bureau/save_currency_rate');?>">


  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Currency </th>
           <th scope="col"> Buying Rate </th>
           <th scope="col"> Min Buying </th>
           <th scope="col"> Max Buying </th>
           <th scope="col"> Selling Rate </th>
           <th scope="col"> Min Selling </th>
           <th scope="col"> Max Selling </th>
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
            <td><input type="number" name="buyingrate[]" class="form-control" required></td>
            <td><input type="number" name="minbuying[]" class="form-control" required></td>
            <td><input type="number" name="maxbuying[]" class="form-control" required></td>
            <td><input type="number" name="sellingrate[]" class="form-control" required></td>
            <td><input type="number" name="minselling[]" class="form-control" required></td>
            <td><input type="number" name="maxselling[]" class="form-control" required></td>
           <td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>
         </tr>
       </tbody>

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
                             '<td><input type="number" name="buyingrate[]" class="form-control" required></td>\n' +
                             '<td><input type="number" name="minbuying[]" class="form-control" required></td>\n' +
                             '<td><input type="number" name="maxbuying[]" class="form-control" required></td>\n' +
                             '<td><input type="number" name="sellingrate[]" class="form-control" required></td>\n' +
                             '<td><input type="number" name="minselling[]" class="form-control" required></td>\n' +
                             '<td><input type="number" name="maxselling[]" class="form-control" required></td>\n' +
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
