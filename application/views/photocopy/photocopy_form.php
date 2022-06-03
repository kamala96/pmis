<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> photocopy  Application Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">photocopy  Application Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>photocopy/photocopy_form" class="text-white"><i class="" aria-hidden="true"></i>Add photocopy </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>photocopy/photocopy_List" class="text-white"><i class="" aria-hidden="true"></i> photocopy Transaction List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> photocopy Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                           <form method="POST" action="<?php echo base_url()?>photocopy/Save_photocopy">
                               <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                   <!--  <h3> photocopy Form</h3> -->
                                </div>

                                  <div class="col-md-3">
                                <label>Item :</label>
                            <input type="text" name="photocopyDetails" class="form-control" id="photocopyDetails" >
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
                            <input type="Number" name="Amount" class="form-control catweight" id="Amount" onkeyup="getPriceFrom()">
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
