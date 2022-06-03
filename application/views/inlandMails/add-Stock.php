<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> <?php if(!empty($stocklist)){ ?>
                                    Edit Stock<span class="pull-right " ></span>
                                <?php }else{ ?>
                                 Add Stock
                             <?php } ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inventory</a></li>
                        <li class="breadcrumb-item active"><?php if(!empty($stocklist)){ ?>
                                    Edit Stock<span class="pull-right " ></span>
                                <?php }else{ ?>
                                 Add Stock
                             <?php } ?></li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <?php $usertype = $this->employee_model->getusertype(); ?>
    <?php  ?>
    <?php $regvalue1 = $this->employee_model->branchselect(); ?>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>inventory/dashboard" class="text-white"><i class="" aria-hidden="true"></i>  Back stock List</a></button>
                        
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i> <?php if(!empty($stocklist)){ ?>
                                    Edit Stock Form<span class="pull-right " ></span>
                                <?php }else{ ?>
                                 Add New Stock Form<span class="pull-right " ></span>
                             <?php } ?>
                             </h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

            <form class="row" method="post" action="Save_Stock" enctype="multipart/form-data">

                                    <?php if(!empty($stocklist)){ ?>
                                        <div class="form-group col-md-3">
                                        <label>[ Issue Date ] </label>
                                        <input type="date" name="issuedate" class="form-control form-control-line" value="<?php echo $stocklist->issuedate; ?>" placeholder="" required="required"> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ End Date ]</label>
                                        <input type="date" name="enddate" class="form-control form-control-line" value="<?php echo $stocklist->enddate; ?>" placeholder=""  required ="required"> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Stock Type ] </label>
                                        <select class="form-control custom-select" name="stock_type" required="required">
                                        <option value="<?php echo $stocklist->Stock_Category_Id; ?>><?php echo $stocklist->CategoryName; ?></option>
                                            <?php foreach ($categorystock as $value) {?>
                                                <option value="<?php echo $value->Stock_Category_Id; ?>"><?php echo $value->CategoryName; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Stock Name ] </label>
                                        <input type="text"  name="stock_name" class="form-control form-control-line" value="<?php echo $stocklist->stampname; ?>" placeholder="" > 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Quantity ] </label>
                                       <input type="text"  name="quantity" class="form-control form-control-line" value="<?php echo $stocklist->quantity; ?>" placeholder=""  required> 
                                    </div>
                                     <div class="form-group col-md-3">
                                        <label>[ Price Per Mint ] </label>
                                         <input type="text" id="" name="price_mint" class="form-control form-control-line" value="<?php echo $stocklist->pricepermint; ?>" placeholder=""  required> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Price Per Souverant Sheet ] </label>
                                        <input type="text" name="price_sheet"  class="form-control" placeholder="" value="<?php echo $stocklist->pricepersouverantsheet; ?>" required> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Price Per F D Cover ] </label>
                                        <input type="text"  name="price_cover" class="form-control form-control-line" value="<?php echo $stocklist->priceperfdcover; ?>" placeholder=""  required> 
                                    </div>
                                    <input type="hidden" name="stid" value="<?php echo $stocklist->id; ?>">
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-info">Cancel</button>
                                    </div>
                                    <?php }else{ ?>
                                     <div class="form-group col-md-3">
                                        <label>[ Issue Date ] </label>
                                        <input type="date" name="issuedate" class="form-control form-control-line" placeholder="" required="required"> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ End Date ]</label>
                                        <input type="date" name="enddate" class="form-control form-control-line" placeholder=""  required ="required"> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Stock Type ] </label>
                                        <select class="form-control custom-select" name="stock_type" required="required">
                                            <option value="">--Select Stock Category--</option>
                                            <?php foreach ($categorystock as $value) {?>
                                                <option value="<?php echo $value->Stock_Category_Id; ?>"><?php echo $value->CategoryName; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Stock Name ] </label>
                                        <input type="text"  name="stock_name" class="form-control form-control-line" value="" placeholder="" > 
                                    </div>
                                    <!-- <div class="form-group col-md-3">
                                        <label>[ Denomination ] </label>
                                        <input type="text" name="denomination" class="form-control form-control-line" value="" placeholder="" required> 
                                    </div> -->
                                   <div class="form-group col-md-3">
                                        <label>[ Quantity ] </label>
                                       <input type="text"  name="quantity" class="form-control form-control-line" value="" placeholder=""  required> 
                                    </div>
                                     <div class="form-group col-md-3">
                                        <label>[ Price Per Mint ] </label>
                                         <input type="text" id="" name="price_mint" class="form-control form-control-line" value="" placeholder=""  required> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Price Per Souverant Sheet ] </label>
                                        <input type="text" name="price_sheet"  class="form-control" placeholder="" required> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>[ Price Per F D Cover ] </label>
                                        <input type="text"  name="price_cover" class="form-control form-control-line" value="" placeholder=""  required> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-info">Cancel</button>
                                    </div>
                                <?php }?>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    

<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>

<?php $this->load->view('backend/footer'); ?>

