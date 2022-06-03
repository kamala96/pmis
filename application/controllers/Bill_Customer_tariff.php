 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_Customer_tariff extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('employee_model');
        $this->load->model('Bill_Customer_model');
        $this->load->model('unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Sms_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
    }


public function dashboard()
{
if ($this->session->userdata('user_login_access') != false)
{
$this->load->view('billing_customer/customer-dashboard');
}
else{
redirect(base_url());
}
}

public function tbs_tanzania(){
if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$data['ems_cat'] = $this->Box_Application_model->ems_cat();
$data['I'] = base64_decode($this->input->get('I'));
$this->load->view('billing_customer/tbs_ems_application_form_send',$data);
}
else{
redirect(base_url());
}
}

public function the_embassy_of_italy(){
if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$data['ems_cat'] = $this->Box_Application_model->ems_cat();
$data['I'] = base64_decode($this->input->get('I'));
$this->load->view('billing_customer/italy_embassy_application_form_send',$data);
}
else{
redirect(base_url());
}
}

public function taes(){
if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$data['ems_cat'] = $this->Box_Application_model->ems_cat();
$data['I'] = base64_decode($this->input->get('I'));
$this->load->view('billing_customer/taes_ems_application_form_send',$data);
}
else{
redirect(base_url());
}
}


public function Ems_price_vat()
{
if ($this->session->userdata('user_login_access') != false)
{
$branch = $this->input->post('branch');
$weight = $this->input->post('weight');

if($weight > 10){

    $weight10    = 10;

    $getPrice    = $this->Box_Application_model->special_ems_cus_price($weight10,$branch);

    $vat10       = $getPrice->vat;
    $price10     = $getPrice->tariff_price;
    $totalprice10 = $vat10 + $price10;

    $diff   =  $weight - $weight10;

    if ($diff <= 0.5) {


        $totalPrice = $totalprice10 + 3540;
        

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
        <tr><th colspan='2' style=''>Charges</th></tr>
        <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
        <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
        </table>
            
            ";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

              
                    $totalPrice = $totalprice10 + ($whole*1000/500)*3540;
                

            } else {

                if ($decimal <= 0.5) {

                   
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3540 + 3540;
                    

                } else {

                   
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3540 + 3540+3540;
                    
                }

            }
            $dvat = $totalPrice * 0.18;
            $dprice = $totalPrice - ($totalPrice * 0.18);

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th colspan='2' style=''>Charges</th></tr>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
            </table><br />
            
            ";
            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$dvat' class='price1'>
            // <input type='text' name ='price2' value='$dprice' class='price1'>
    }


}else{


$price = $this->Box_Application_model->special_ems_cus_price($weight,$branch);


if (empty($price)) {

    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2'>Charges</th></tr>
    <tr><td><b>Price:</b></td><td>0</td></tr>
    <tr><td><b>Vat:</b></td><td>0</td></tr>
    <tr><td><b>Total Price:</b></td><td>0</td></tr>
    </table><br />";

}else{

    $vat = $price->vat;
    $emsprice = $price->tariff_price;
    $totalPrice = $vat + $emsprice;
     
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
    <tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />
        
            ";

}
}

}else{
redirect(base_url());
}
}


public function Ems_price_vat_other()
{
if ($this->session->userdata('user_login_access') != false)
{
$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');

if($weight > 10){

    $weight10    = 10;


    $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

    $vat10       = $getPrice->vat;
    $price10     = $getPrice->tariff_price;
    $totalprice10 = $vat10 + $price10;

    $diff   =  $weight - $weight10;

    if ($diff <= 0.5) {

        if ($emsCat == 1) {
            $totalPrice = $totalprice10 + 2300;
        } else {
            $totalPrice = $totalprice10 + 3500;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
        <tr><th colspan='2' style=''>Charges</th></tr>
        <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
        <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
        </table>
            
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$dvat' class='price1'>
            // <input type='text' name ='price2' value='$dprice' class='price1'>

    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($emsCat == 1) {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
                } else {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
                }

            } else {

                if ($decimal <= 0.5) {

                    if ($emsCat == 1) {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
                    } else {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
                    }

                } else {

                    if ($emsCat == 1) {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
                    } else {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);


            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th colspan='2' style=''>Charges</th></tr>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
            </table><br />
            
            ";
            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$dvat' class='price1'>
            // <input type='text' name ='price2' value='$dprice' class='price1'>
    }


}else{


$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);


if (empty($price)) {

    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2'>Charges</th></tr>
    <tr><td><b>Price:</b></td><td>0</td></tr>
    <tr><td><b>Vat:</b></td><td>0</td></tr>
    <tr><td><b>Total Price:</b></td><td>0</td></tr>
    </table><br />";

}else{

    $vat = $price->vat;
    $emsprice = $price->tariff_price;
    $totalPrice = $vat + $emsprice;
     
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
    <tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />
        
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$vat' class='price1'>
            // <input type='text' name ='price2' value='$emsprice' class='price1'>

}
}

}else{
redirect(base_url());
}
}


public function embassy_italy_Ems_price(){
if ($this->session->userdata('user_login_access') != false){
$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');
$boxtype = $this->input->post('boxtype');

if($boxtype=="Document" && $emsCat==1){

    ////////Within Dar es salaam
    $totalPrice = 80000;
    $emsprice = (100*$totalPrice)/118; 
    $vat = $totalPrice - $emsprice;

    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".number_format($emsprice)."</td></tr>
    <tr><td><b>Vat:</b></td><td>".number_format($vat)."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />";



} elseif ($boxtype=="Document" && $emsCat==2) {

    $totalPrice = 60000;
    $emsprice = (100*$totalPrice)/118; 
    $vat = $totalPrice - $emsprice;

    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".number_format($emsprice)."</td></tr>
    <tr><td><b>Vat:</b></td><td>".number_format($vat)."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />";
  
} else {

if($weight > 10){

    $weight10    = 10;


    $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

    $vat10       = $getPrice->vat;
    $price10     = $getPrice->tariff_price;
    $totalprice10 = $vat10 + $price10;

    $diff   =  $weight - $weight10;

    if ($diff <= 0.5) {

        if ($emsCat == 1) {
            $totalPrice = $totalprice10 + 2300;
        } else {
            $totalPrice = $totalprice10 + 3500;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
        <tr><th colspan='2' style=''>Charges</th></tr>
        <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
        <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
        </table>
            
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$dvat' class='price1'>
            // <input type='text' name ='price2' value='$dprice' class='price1'>

    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($emsCat == 1) {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
                } else {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
                }

            } else {

                if ($decimal <= 0.5) {

                    if ($emsCat == 1) {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
                    } else {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
                    }

                } else {

                    if ($emsCat == 1) {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
                    } else {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);


            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th colspan='2' style=''>Charges</th></tr>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
            </table><br />
            
            ";
            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$dvat' class='price1'>
            // <input type='text' name ='price2' value='$dprice' class='price1'>
    }


}else{


$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);


if (empty($price)) {

    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2'>Charges</th></tr>
    <tr><td><b>Price:</b></td><td>0</td></tr>
    <tr><td><b>Vat:</b></td><td>0</td></tr>
    <tr><td><b>Total Price:</b></td><td>0</td></tr>
    </table><br />";

}else{

    $vat = $price->vat;
    $emsprice = $price->tariff_price;
    $totalPrice = $vat + $emsprice;
     
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
    <tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />
        
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$vat' class='price1'>
            // <input type='text' name ='price2' value='$emsprice' class='price1'>

}

}

/////////////Above Parcel
}

} else {
redirect(base_url());
}

}





}