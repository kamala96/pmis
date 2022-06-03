<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
       <h3 class="text-themecolor"><i class="fa fa-send" style="color:#1976d2"></i> Send Stock Request </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Send Request </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
       <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaStamp/dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaStamp/stock_request" class="text-white"><i class="" aria-hidden="true"></i> My Requests </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>PostaStamp/send_stock_request" class="text-white"><i class="" aria-hidden="true"></i> Send Request </a></button>


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
                         

<form  method="post" action="<?php echo site_url('PostaStamp/save_stock_request');?>">


  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Item </th>
           <th scope="col"> Price </th>
           <th scope="col"> Quantity </th>
           <th scope="col"> Sub-Total</th>
           <th scope="col"> Action </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td><select name="product_id[]" class="form-control productname" required="">
                <option value=""> Choose </option>
              <?php foreach ($list as $value){ ?>
                   <option value="<?php echo $value->stock_productid; ?>"> <?php echo @$value->category_name.'-'.@$value->stock_product_name; ?></option>
              <?php } ?>
                     </select></td>
            <td><input type="number" name="price[]" class="form-control price" readonly></td>
            <td><input type="number" name="qty[]" class="form-control qty" required></td>
            <td><input type="text" name="amount[]" class="form-control amount" readonly></td>
           <td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>
         </tr>
       </tbody>

       <tfoot>
        <tr>
         <td></td>
         <td></td>
         <td><b>Total</b></td>
         <td><b class="total"></b></td>
         <td></td>
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
            url  : "<?php echo site_url('PostaStamp/get_stamp_information');?>",
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
                /*tr.find('.categoryid').val(data['category']);*/
                $('#forMessageTwo').hide();
                $('#notifyMessageTwo').html('');


                }else{

                    $('#nextstep3').hide();
                     $('#forMessage').hide();
                     $('#notifyMessage').html('');
                    $('#forMessageTwo').show();
                     tr.find('.price').val('');
                     /*tr.find('.categoryid').val('');*/
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
            /*var vat = amount*0/100;
            var ramount = amount - vat;*/
            tr.find('.amount').val(amount);
            /*tr.find('.vat').val(vat);*/
            /*tr.find('.ramount').val(ramount);*/
            total();
            /*totalvat();
            totalramount();*/
        });



        $('.addRow').on('click', function () {
            addRow();
        });
        function addRow() {
            var addRow = '<tr class="main_row">\n' +
                '         <td><select name="product_id[]" class="form-control productname " >\n' +
                '         <option value=""> Choose </option>\n' +
'                                        <?php foreach($list as $data){ ?>\n' +
'                                            <option value="<?php echo $data->stock_productid; ?>"><?php echo @$data->category_name.'-'.@$data->stock_product_name; ?></option>\n' +
'                                        <?php } ?>\n' +
                '               </select></td>\n' +
                                 '<td><input type="number" name="price[]" class="form-control price" readonly></td>\n' +
'                                <td><input type="number" name="qty[]" class="form-control qty" required></td>\n' +
'                                <td><input type="number" name="amount[]" class="form-control amount" readonly></td>\n' +
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

        /*function totalvat(){
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
        }*/
        

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
