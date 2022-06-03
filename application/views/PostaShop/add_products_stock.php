<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-shopping-bag" style="color:#1976d2"> </i> Posta Shop </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active"> Posta Shop </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaShop/postashop_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>PostaShop/productstock" class="text-white"><i class="" aria-hidden="true"></i> Products (Stocks) </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>PostaShop/list_productstock" class="text-white"><i class="" aria-hidden="true"></i> List Stock </a></button>
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Add Products (Stock)  </h4>
                </div>

                <div class="card-body">

                            <?php 
                            if(!empty($this->session->flashdata('message'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('message'); ?>
                                      <?php
                            echo "</div>";
                           }
                           ?>


<form  method="post" action="<?php echo site_url('PostaShop/save_stock');?>">

  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Category </th>
           <th scope="col"> Product Name </th>
           <th scope="col"> Quantity</th>
           <th scope="col"> Purchase price </th>
           <th scope="col"> Sales price </th>
           <th scope="col"> Sub-Total </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td>
             <select name="categoryid[]" class="form-control" required="">
                <option value=""> Choose </option>
              <?php foreach ($categories as $value){ ?>
                   <option value="<?php echo $value->category_id; ?>"> <?php echo $value->category_name; ?></option>
              <?php } ?>
            </select>
            </td>
             <td><input type="text" name="product[]" class="form-control product" required></td>
            <td><input type="number" name="qty[]" class="form-control qty" min="1" required></td>
            <td><input type="number" name="purchaseprice[]" class="form-control purchaseprice" required></td>
            <td><input type="number" name="price[]" class="form-control price" required></td>
            <td><input type="text" name="amount[]" class="form-control amount" readonly></td>
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
        });

        $('tbody').delegate('.qty,.price', 'keyup', function () {
            var tr = $(this).parent().parent();
            var qty = tr.find('.qty').val();
            var price = tr.find('.price').val();
            var amount = qty * price;
            tr.find('.amount').val(amount);
            total();
        });



        $('.addRow').on('click', function () {
            addRow();
        });
        function addRow() {
            var addRow = '<tr class="main_row">\n' +
                         '<td><select name="categoryid[]" class="form-control" required>\n' +
                         '<option value=""> Choose </option>\n' +
                                         '<?php foreach($categories as $data){ ?>\n' +
                                           '<option value="<?php echo $data->category_id; ?>"><?php echo $data->category_name; ?></option>\n' +
                                       '<?php } ?>\n' +
                              '</select></td>\n' +
                              '<td><input type="text" name="product[]" class="form-control product" required></td>\n' +
                               '<td><input type="number" name="qty[]" class="form-control qty" min="1" required></td>\n' +
                               '<td><input type="number" name="purchaseprice[]" class="form-control purchaseprice" required></td>\n' +
                              '<td><input type="number" name="price[]" class="form-control price" required></td>\n' +       
                                '<td><input type="text" name="amount[]" class="form-control amount" readonly></td>\n' +
                                '<td><a class="btn btn-danger remove" onclick="deleteRow(this)"> <i class="fa fa-remove"></i></a></td>\n' +
                               '</tr>';
            $('tbody').append(addRow);
        };



    });

       function total(){
            var total = 0;
            $('.amount').each(function (i,e) {
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
