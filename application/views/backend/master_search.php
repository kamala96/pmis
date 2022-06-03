<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
 <div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Transaction search</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Transaction</li>
            </ol>
        </div>
    </div>
            
<div class="container-fluid">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Master search                  
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%">
                    
                    <tr>
                        <td>
                            <input type="text" class="form-control form-control-line" placeholder="Barcode number" name="barcode" id="barcode">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-line" placeholder="Controll number" name="cnumber" id="cnumber">
                        </td>
                            
                        <td>
                            <input type="text" class="form-control form-control-line" placeholder="Mobile number" name="mobile" id="mobile">
                        </td>
                        <td>
                            <button onclick="searchTransaction('#barcode','#cnumber','#mobile')" type="submit" class="btn btn-info col-md-12" id="BtnSubmit">Search transaction</button>
                        </td>
                    </tr>
                    
                </table>
            </div>

            <div class="card-body">
                <div style="display: none;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                </div>
                <div >
                    <textarea id="reasonBox" style="display:none;" class="form-control" cols="20" rows="" placeholder="Please write the reasons"></textarea>
                </div>
                <div class="table-responsive">
                    <table id="example4" class="display nowrap table table-bordered fromServer2 receiveTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Barcode</th>
                                <th>Customer mobile</th>
                                <th>Payment for</th>
                                <th>Bag status</th>
                                <th>Bill Id</th>
                                <th>District</th>
                                <th>IsbagNo</th>
                                <th>Paid amount</th>
                                <th>Pay channel</th>
                                <th>paymentdate</th>
                                <th>receipt</th>
                                <th>region</th>
                                <th>serial</th>
                                <th>transaction date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="" id='emsListData'>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function searchTransaction(barcode,cnumber,mobile){
        var barcode = $(barcode).val();
        var cnumber = $(cnumber).val();
        var mobile = $(mobile).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Services/search_transaction",
            data:{barcode:barcode,cnumber:cnumber,mobile:mobile},
            dataType:'json',
            success:function(response){
                
                if (response['status'] == 'Success') {
                    $('#emsListData').html(response['msg'])
                }else{
                    $('#emsListData').html(response['msg'])
                }
                //console.log(response)

            },error:function(){

            }
        })
       
    }

    function allowEdit(){
        // var transId = transId;
        // var editbarcode  = 
        $('.editbarcode').removeAttr('disabled').removeAttr('readonly');
        $('#reasonBox').show();
        // console.log(transId);
        // console.log(editbarcode);
    }

    function editingProcess(obj){
        var barcode = $(obj).val();
        var transId = $(obj).attr('data-transId');
        var reasonText = $('#reasonBox').val();

        //console.log(transId)

        if (barcode.length != 13) {
            $('#optionBox').hide();
            $('#forMessage').show();
            $('#notifyMessage').html('Tafadhali barcode haijakamilika = 13');
        }else{
            if (reasonText == '') {
                $('#optionBox').hide();
                $('#forMessage').show();
                $('#notifyMessage').html('Tafadhali andika sababu');
            }else{
                $.ajax({
                    type : "POST",
                    url  : "<?php echo base_url();?>Box_Application/editBarcodeprocess",
                    data:{barcode:barcode,transid:transId,reasonMessage:reasonText},
                    dataType:'json',
                    success: function(data){
                         
                        if(data['status'] == 'error'){
                            
                            $('#forMessage').show();
                            $('#notifyMessage').html(data['message']);
                        }else{
                            
                            $('#forMessage').show();
                            //$('#notifyMessage').html('');
                            $('#notifyMessage').html(data['message']);
                        }
                    }
                });
            }
            
        }
    }


</script>
<?php $this->load->view('backend/footer'); ?>