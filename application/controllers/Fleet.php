 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends CI_Controller {
	
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
        $this->load->model('FleetModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
    }

    public function list_vehicle(){
    $data['region'] = $this->FleetModel->get_regions();
    $this->load->view('fleet/list_vehicles',$data); 
    }

    public function search_vehicle(){
    $data['region'] = $this->FleetModel->get_regions();
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    $results = $this->FleetModel->search_vehicle($region,$branch);
    if($results){
    $data['list'] = $this->FleetModel->search_vehicle($region,$branch);
    $this->load->view('fleet/list_vehicles',$data); 
    } else {
    $this->session->set_flashdata('feedback',"Results not found, Please try again!");
    redirect("Fleet/list_vehicle");
    }

    }

    public function save_vehicle(){

            $regno = $this->input->post('regno');
            $make = $this->input->post('make');
            $model = $this->input->post('model');
            $chasis = $this->input->post('chasis');
            $engine = $this->input->post('engine');
            $capacity = $this->input->post('capacity');
            $type = $this->input->post('type');
            $insurance = $this->input->post('insurance');
            $status = $this->input->post('status');
            $region = $this->input->post('region');
            $branch = $this->input->post('branch');
            $manufacture = date("Y-m-d",strtotime($this->input->post('manufacture')));

            
            if($_FILES['image_url']['name']){
            $empid = $this->session->userdata('user_emid');
            $emrand1 = substr($empid,0,3).rand(1000,2000); 
            $emrand = str_replace("'", '', $emrand1);

            $file_name = $_FILES['image_url']['name'];
            $fileSize = $_FILES["image_url"]["size"]/1024;
            $fileType = $_FILES["image_url"]["type"];
            $new_file_name='';
            $new_file_name .= $emrand;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/vehicle",
                'allowed_types' => "jpg|png|gif|JPG|jpeg",
                'overwrite' => False,
                'max_size' => "0"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('image_url')) {
                  //echo $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to upload vehicle image, Please try again!");
                   redirect("services/Fleet");
            }
            else 
            {
                $path = $this->upload->data();
                $img_url = $path['file_name'];

                $results = $this->FleetModel->save_vehicle($img_url,$regno,$make,$model,$chasis,$engine,$capacity,$type,$insurance,$status,$region,$branch,$manufacture);
                if($results){
                $this->session->set_flashdata('success','Vehicle infomation has been successfully added');
                }
                else{
                $this->session->set_flashdata('feedback',"Failed to add vehicle information, Please try again!");
                }
                redirect("services/Fleet");

            }
         }
         else
         {
         //No image found
                $results = $this->FleetModel->s_vehicle($regno,$make,$model,$chasis,$engine,$capacity,$type,$insurance,$status,$region,$branch,$manufacture);
                if($results){
                $this->session->set_flashdata('success','Vehicle infomation has been successfully added');
                }
                else{
                $this->session->set_flashdata('feedback',"Failed to add vehicle information, Please try again!");
                }
                redirect("services/Fleet");
         
         }

    }





  
    

}