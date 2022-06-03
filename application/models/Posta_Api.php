 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 require(APPPATH.'/libraries/REST_Controller.php');
class Posta_Api extends REST_Controller {


    function __construct() {
        parent::__construct();
        //$this->load->database();
        //$this->load->model('login_model');
       // $this->load->model('dashboard_model');
        //$this->load->model('employee_model');
        //$this->load->model('notice_model');
        //$this->load->model('settings_model');
        $this->load->model('billing_model');
    }
    
	public function posta_get()
	{
		echo 'Mussa Johanes';
	}
	public function post_posta_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$update1 = json_decode( file_get_contents( 'php://input' ), true );

		if ($update1['amount'] > 0 && $update1['controlno'] != ''){

			$controlno = $update1['controlno'];
			$receiptno = $update1['receiptno'];
			$date      = date("Y-m-d h:i:sa");
			$check = $this->billing_model->checkValue($controlno,$receiptno);
			if ($check->receipt == $receiptno){

				$data = array('status'=>'107','description'=>"Duplicate",'controlno'=>$update1['controlno'],'receipt'=>$update1['receiptno']);
				header('Content-Type: application/json');
				echo json_encode($data);

			}else{
				$data = array('status'=>'100','description'=>"Successfully",'controlno'=>$update1['controlno']);
				header('Content-Type: application/json');
				echo json_encode($data);

				$update = array('paymentdate'=>$date,'receipt'=>$update1['receiptno'],'paidamount'=>$update1['amount']);
				$serial = $update1['controlno'];
				$this->billing_model->update_transactions2($update,$serial);
			}

		}else{

			$data = array('status'=>'105','description'=>"UnSuccessfully",'controlno'=>$update1['controlno']);
			header('Content-Type: application/json');
			echo json_encode($data);
		}


	}
    
}
