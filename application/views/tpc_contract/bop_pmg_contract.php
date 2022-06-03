    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
/* Box styles */
.myBox {
border: none;
padding: 5px;
font: 18px/36px sans-serif;
width: 80%px;
color:#000;
height: 580px;
overflow: scroll;
}

/* Scrollbar styles */
::-webkit-scrollbar {
width: 12px;
height: 12px;
}

::-webkit-scrollbar-track {
border: 1px solid #d22c19;
border-radius: 8px;
}

::-webkit-scrollbar-thumb {
background: #d22c19;  
border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
background: #000;  
}
</style>
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i>  Performance Contract between </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"> Performance Contract </li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                  
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  The Postmaster General Vs General Manager Business Operations <span class="pull-right " ></span></h4>
                        </div>
						
                        
                        <div class="card-body">
						<!-- Contents -->
						
                            <!-- Cover -->
							<div class="row" id="cover">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/cover'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page1"> Next page > </button>
                            </div> 
                            </div>
							<!-- End Cover -->
							
							<!-- Page 1 -->
							<div class="row" id="p1" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page1'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page2"> Next page >   </button>
								 <button class="btn btn-info" type="submit" id="back1">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 1 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 1 -->
							
							<!-- Page 2 -->
							<div class="row" id="p2" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page2'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page3"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back2">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 2 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 2 -->
							
							<!-- Page 3 -->
							<div class="row" id="p3" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page3'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page4"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back3">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 3 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 3 -->
							
							<!-- Page 4 -->
							<div class="row" id="p4" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page4'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page5"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back4">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 4 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 4 -->
							
							<!-- Page 5 -->
							<div class="row" id="p5" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page5'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page6"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back5">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 5 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 5 -->
							
							<!-- Page 6 -->
							<div class="row" id="p6" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page6'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page7"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back6">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 6 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 6 -->
							
							<!-- Page 7 -->
							<div class="row" id="p7" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page7'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page8"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back7">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 7 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 7 -->
							
							<!-- Page 8 -->
							<div class="row" id="p8" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page8'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page9"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back8">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 8 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 8 -->
							
							<!-- Page 9 -->
							<div class="row" id="p9" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page9'); ?>
							</div>	
                                <button class="btn btn-info" type="submit" id="page10"> Next page > </button>
								 <button class="btn btn-info" type="submit" id="back9">  < Back   </button>
								<strong style="color:#000;font-weight:bold;"> Page 9 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 9 -->
							
							<!-- Page 10 -->
							<div class="row" id="p10" style="display:none;">
							<div class="col-md-12">
							<div class="myBox">
							    <?php $this->load->view('contract/bop_pmg/page10'); ?>
							</div>
							
								 <button class="btn btn-info" type="submit" id="back10">  < Back   </button>
								   <button class="btn btn-info" type="submit" id="start">   Start  </button>
								<strong style="color:#000;font-weight:bold;"> Page 10 out of 10 </strong>
                            </div> 
                            </div>
							<!-- Page 10 -->
							
							
							
							
						<!-- End Contents -->	
                     </div>
                </div>
            </div> 
            
        
         </div>
                          
    </div>

<script type="text/javascript">
$('#page1').click(function() {
  $('#cover').hide();
  $('#p1').show();
});
$('#page2').click(function() {
  $('#p1').hide();
  $('#p2').show();
});
$('#page3').click(function() {
  $('#p2').hide();
  $('#p3').show();
});
$('#page4').click(function() {
  $('#p3').hide();
  $('#p4').show();
});
$('#page5').click(function() {
  $('#p4').hide();
  $('#p5').show();
});
$('#page6').click(function() {
  $('#p5').hide();
  $('#p6').show();
});
$('#page7').click(function() {
  $('#p6').hide();
  $('#p7').show();
});
$('#page8').click(function() {
  $('#p7').hide();
  $('#p8').show();
});
$('#page9').click(function() {
  $('#p8').hide();
  $('#p9').show();
});
$('#page10').click(function() {
  $('#p9').hide();
  $('#p10').show();
});
$('#page11').click(function() {
  $('#p10').hide();
  $('#p11').show();
});
$('#page12').click(function() {
  $('#p11').hide();
  $('#p12').show();
});
$('#page13').click(function() {
  $('#p12').hide();
  $('#p13').show();
});
$('#page14').click(function() {
  $('#p13').hide();
  $('#p14').show();
});
$('#page15').click(function() {
  $('#p14').hide();
  $('#p15').show();
});
$('#page16').click(function() {
  $('#p15').hide();
  $('#p16').show();
});
$('#page17').click(function() {
  $('#p16').hide();
  $('#p17').show();
});
$('#page18').click(function() {
  $('#p17').hide();
  $('#p18').show();
});

$('#back1').click(function() {
  $('#cover').show();
  $('#p1').hide();
});
$('#back2').click(function() {
  $('#p1').show();
  $('#p2').hide();
});
$('#back3').click(function() {
  $('#p2').show();
  $('#p3').hide();
});
$('#back4').click(function() {
  $('#p3').show();
  $('#p4').hide();
});
$('#back5').click(function() {
  $('#p4').show();
  $('#p5').hide();
});
$('#back6').click(function() {
  $('#p5').show();
  $('#p6').hide();
});
$('#back7').click(function() {
  $('#p6').show();
  $('#p7').hide();
});
$('#back8').click(function() {
  $('#p7').show();
  $('#p8').hide();
});
$('#back9').click(function() {
  $('#p8').show();
  $('#p9').hide();
});
$('#back10').click(function() {
  $('#p9').show();
  $('#p10').hide();
});
$('#back11').click(function() {
  $('#p10').show();
  $('#p11').hide();
});
$('#back12').click(function() {
  $('#p11').show();
  $('#p12').hide();
});
$('#back13').click(function() {
  $('#p12').show();
  $('#p13').hide();
});
$('#back14').click(function() {
  $('#p13').show();
  $('#p14').hide();
});
$('#back15').click(function() {
  $('#p14').show();
  $('#p15').hide();
});
$('#back16').click(function() {
  $('#p15').show();
  $('#p16').hide();
});
$('#back17').click(function() {
  $('#p16').show();
  $('#p17').hide();
});
$('#back18').click(function() {
  $('#p17').show();
  $('#p18').hide();
});
$('#start').click(function() {
  $('#cover').show();
  $('#p10').hide();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<?php $this->load->view('backend/footer'); ?>

    </p>