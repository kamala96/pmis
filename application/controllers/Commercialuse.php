 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commercialuse extends CI_Controller {
	
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
        $this->load->model('CommercialuseModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
    }

    public function main_dashboard(){
    $this->load->view('commercial_inventory/main_dashboard');
    }

    public function stock_dashboard(){
    $this->load->view('commercial_inventory/stock_dashboard');
    }

    public function stampbureau_dashboard(){
    $this->load->view('commercial_inventory/stampbureau_dashboard');
    }

    public function list_philatelic_stamp(){
    $data['list'] = $this->CommercialuseModel->list_philatelic_stamp();
    $this->load->view('commercial_inventory/list_philatelic_stamp',$data);
    }

    public function add_philatelic_stamp(){
    $this->load->view('commercial_inventory/add_philatelic_stamp');
    }

    public function list_stamp(){
    $data['list'] = $this->CommercialuseModel->list_stamp();
    $this->load->view('commercial_inventory/list_stamp',$data);
    }

    public function add_stamp(){
    $this->load->view('commercial_inventory/add_stamp');
    }

    public function list_locks(){
    $data['list'] = $this->CommercialuseModel->list_locks();
    $this->load->view('commercial_inventory/list_locks',$data);
    }

    public function add_locks(){
    $this->load->view('commercial_inventory/add_locks');
    }

    public function delete_stock(){
    $stockid = base64_decode($this->input->get('I'));
    $this->CommercialuseModel->delete_stock($stockid);
    $this->session->set_flashdata('message','Item has been successfully deleted');
    redirect($this->agent->referrer());
    }

    public function update_stock(){
    $stockid = $this->input->post('stockid');
    $issuedate = $this->input->post('issuedate');
    $enddate = $this->input->post('enddate');
    $product = $this->input->post('product');
    $denomination = $this->input->post('denomination');
    $quantity = $this->input->post('quantity');
    $pricepermint = $this->input->post('pricepermint');
    $pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
    $priceperfdcover = $this->input->post('priceperfdcover');

             $data = array();
             $data = array(
             'issuedate'=>$issuedate,
             'enddate'=>$enddate,
             'product'=>$product,
             'denomination'=>@$denomination,
             'quantity'=>$quantity,
             'pricepermint'=>$pricepermint,
             'pricepersouverantsheet'=>@$pricepersouverantsheet,
             'priceperfdcover'=>@$priceperfdcover
         );
    $this->CommercialuseModel->update_stock($data,$stockid);

    $this->session->set_flashdata('message','Item has been successfully updated');
    redirect($this->agent->referrer());
    }

    public function save_stock(){
    $empid = $this->session->userdata('user_emid');
    $product = $this->input->post('product');
    $categoryid = $this->input->post('categoryid');
    $issuedate = $this->input->post('issuedate');
    $enddate = $this->input->post('enddate');
    $denomination = $this->input->post('denomination');
    $quantity = $this->input->post('quantity');
    $pricepermint = $this->input->post('pricepermint');
    $pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
    $priceperfdcover = $this->input->post('priceperfdcover');

    foreach($product as $key=>$value){
             $data = array();
             $data = array(
             'issuedate'=>$issuedate[$key],
             'enddate'=>$enddate[$key],
             'product'=>$value,
             'denomination'=>@$denomination[$key],
             'quantity'=>$quantity[$key],
             'pricepermint'=>$pricepermint[$key],
             'pricepersouverantsheet'=>@$pricepersouverantsheet[$key],
             'priceperfdcover'=>@$priceperfdcover[$key],
             'categoryid'=>$categoryid,
             'createdby'=>$empid
         );
    $this->CommercialuseModel->save_stock($data);
    //print_r($data);
 }

    $this->session->set_flashdata('message','Item has been successfully added');
    redirect($this->agent->referrer());
    }
    

}