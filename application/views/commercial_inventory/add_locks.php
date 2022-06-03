<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-shopping-bag" style="color:#1976d2"> </i> Private Box/Locks </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active"> Private Box/Locks </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
              <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Commercialuse/list_locks" class="text-white"><i class="" aria-hidden="true"></i> List Private Box/Locks </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Commercialuse/add_locks" class="text-white"><i class="" aria-hidden="true"></i> Add Private Box/Locks </a></button>
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Add Private Box/Locks  </h4>
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


<form  method="post" action="<?php echo site_url('Commercialuse/save_stock');?>">
<input type="hidden" class="form-control"  name="categoryid" value="3">

  <table class="table table-bordered">
    <thead>
       <tr>
           <th scope="col"> Issue Date </th>
           <th scope="col"> End Date  </th>
           <th scope="col">  Locks name </th>
           <th scope="col"> Quantity  </th>
           <th scope="col"> Price  </th>
           <th scope="col"><a class="addRow"><i class="fa fa-plus"></i></a></th>
         </tr>
       </thead>
       <tbody>
           <tr class="main_row">
             <td>  <input class="form-control" type="date" name="issuedate[]" required> </td>
             <td>  <input class="form-control" type="date" name="enddate[]" required> </td>
            <td><input type="text" name="product[]" class="form-control" required=""></td>
            <td><input type="number" name="quantity[]" class="form-control" required=""></td>
            <td><input type="number" name="pricepermint[]" class="form-control" required=""></td>
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
            '<td>  <input class="form-control" type="date" name="issuedate[]" required> </td>\n' +
             '<td>  <input class="form-control" type="date" name="enddate[]" required> </td>\n' +
            '<td><input type="text" name="product[]" class="form-control" required=""></td>\n' +
            '<td><input type="number" name="quantity[]" class="form-control" required=""></td>\n' +
            '<td><input type="number" name="pricepermint[]" class="form-control" required=""></td>\n' +
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
