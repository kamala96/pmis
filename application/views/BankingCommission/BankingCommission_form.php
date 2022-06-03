<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> BankingCommission  Application Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Banking Commission  Application Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>BankingCommission/BankingCommission_form" class="text-white"><i class="" aria-hidden="true"></i>Add Banking Agency Commission </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>BankingCommission/BankingCommission_List" class="text-white"><i class="" aria-hidden="true"></i> Banking Agency Commission Transaction List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Banking Commission Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                           <form method="POST" action="<?php echo base_url()?>BankingCommission/Save_BankingCommission">
                               <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                   <!--  <h3> BankingCommission Form</h3> -->
                                </div>

                                  <div class="col-md-3">
                                <label>Item :</label>
                            <input type="text" name="BankingCommissionDetails" class="form-control" id="BankingCommissionDetails" >
                                <span id="" style="color: red;"></span>
                                </div> 

                                <div class="form-group col-md-3">
                                    <label>Currency:</label>
                                    <select name="Currency" value="" class="form-control custom-select boxtype" required id="Currency">
                                            <option value="TZS">TZS</option>
                                            <option value="USD">USD</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                               
                                 <div class="col-md-3">
                                <label>Amount:</label>
                            <input type="Number" name="Amount" step=".01" class="form-control catweight" id="Amount" onkeyup="getPriceFrom()">
                            <!-- <div><label>Amount $
                                <input type="number" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
                            this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'
                            "></label></div> -->
                                     <span id="weight_error" style="color: red;"></span>
                                </div>

                                 <div class="col-md-3">
                                    <label>Operator Mobile</label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="errmobile" style="color: red;"></span>
                                </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                              
                                
                                </div>


                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
                                    </div>
                                </div>
                                </div>
                           </form>
                            </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>






<?php $this->load->view('backend/footer'); ?>
