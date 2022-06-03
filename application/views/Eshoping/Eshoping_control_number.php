<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Eshoping  Control Number Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Eshoping  Control Number Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
               <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Eshoping/Eshoping_form" class="text-white"><i class="" aria-hidden="true"></i>Add Eshoping </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Eshoping/Eshoping_List" class="text-white"><i class="" aria-hidden="true"></i> Eshoping Transaction List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Eshoping Control Number Form
                        </h4>
                    </div>
                    <div class="card-body">
                           <h3><?php echo $result; ?></h3>
                        </div>
                    </div>

                </div>

            </div>
        </div>




<?php $this->load->view('backend/footer'); ?>
