 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('organization_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
		$this->load->model('Box_Application_model');
    }
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
			$this->load->view('login');
	}

    public function test_zone()
    {
        if ($this->session->userdata('user_login_access') != false) {
            
            $this->session->set_userdata('heading','Document / Parcel');

            $data['region'] = $this->employee_model->regselect();
            $data['total'] = $this->Box_Application_model->get_ems_sum();
            $data['ems_cat'] = $this->Box_Application_model->ems_cat();
            $data['region'] = $this->employee_model->regselect();
            $this->load->view('zone/document-test-form',$data);

        } else {
           redirect(base_url());
        }
        
    }

    public function getweightkg(){
        if ($this->session->userdata('user_login_access') != false) {
               $weight = $this->input->post('weight');
            
            //on 'nix start with cu.usbserial-
                //on windows starts with com : must be lower case in windows and end with a colon
                //$portName = 'COM11:';//'\\\\.\COM11'
                $portName = '\\\\.\COM11';
                $baudRate = 1200;
                $bits = 7;
                $spotBit = 1;
                $parity = 1;

                //flush
                //($string)
                if (!extension_loaded('dio')) {
                    $res['status'] = 'Failed';
                              $res['message'] ="PHP Direct IO error";
                              //response
                               print_r(json_encode($res));
                   // echo json_encode( "PHP Direct IO error");
                    
                }else{

                    try {
                    //the serial port resource
                    $bbSerialPort;

                //    ("Connecting to serial port: {$portName}");
                     $linx='';

                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        $bbSerialPort = dio_open($portName, O_RDWR);
                         $res['status'] = 'Failed';
                              $res['message'] ="window error ";
                              echo "window error ";
                              //response
                               print_r(json_encode($res));
                        //we're on windows configure com port from command line
                        exec("mode {$portName} baud={$baudRate} data={$bits} stop={$spotBit} parity={$parity} xon=on");
                    } else {
                        $bbSerialPort = dio_open($portName, O_RDWR | O_NOCTTY | O_NONBLOCK);
                        dio_fcntl($bbSerialPort, F_SETFL, O_SYNC);
                        $linx='Linux distribtn ';
                           $res['status'] = 'Failed';
                              $res['message'] ="linux error ";
                              echo "linux error ";
                              //response
                               print_r(json_encode($res));
                        //we're on 'nix configure com from php direct io function
                        dio_tcsetattr($bbSerialPort, array(
                            'baud' => $baudRate,
                            'bits' => $bits,
                            'stop' => $spotBit,
                            'parity' => 0

                        ));
                    }

                    if (!$bbSerialPort) {
                        $res['status'] = 'Failed';
                              $res['message'] ="Could not open Serial port {$portName} ";
                              //response
                               print_r(json_encode($res));

                        
                          //echo json_encode( "Could not open Serial port {$portName} ");
                       
                    }else{

                    $runForSeconds = new DateInterval("PT05S"); //5 seconds

                    $endTime = (new DateTime())->add($runForSeconds);

                  //("Waiting for {$runForSeconds->format('%S')} seconds to receive data on serial port");

                    $responseData = "";

                    while (new DateTime() < $endTime) {
                        $responseData .= dio_read($bbSerialPort, 256); //this is a blocking call
                         //($responseData);
                         // if($responseData.length > 4){
                         //     ('kidogo');

                         // }
                        if (strpos($responseData, 'KG') == false) {
                            //$output = preg_replace('/[^0-9]/', '', $responseData);
                            //echo ltrim($output, "0").' nyingine';
                            $m = explode(' ', $responseData);
                            $grams = @$m[5];
                            $kg = (double)$grams/100;
                              $res['status'] = 'success';
                              $res['message'] =$kg.'KG';
                              //response
                               print_r(json_encode($res));
                            //echo json_encode( $kg.'KG');
                            break;
                        }
                    }

                // ("Closing Port");

                    dio_close($bbSerialPort);
                }

                } catch (Exception $e) {
                    $res['status'] = 'Failed';
                 $res['message'] = $e->getMessage();
                  //response
                   print_r(json_encode($res));

                   
                     //echo json_encode($e->getMessage());
                    
                }

                }

               


        } else {
           redirect(base_url());
        }
        
    }


    public function DropcCountryList(){
    $reg_id = $this->input->post('region_id',TRUE);  
    $data['branches'] = $this->organization_model->selectbranch($reg_id);

       //$output = null;   
      foreach ($data['branches'] as $row)   
      {   
         $output .= "<option value='".$row->branch_name."'>".$row->branch_name."</option>";   
      }   
      echo $output;  
    }
    public function Region(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['region'] = $this->organization_model->regselect();
        $this->load->view('backend/region',$data); 
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Branches(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['branches'] = $this->organization_model->branchselect();
        $this->load->view('backend/branches',$data); 
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }

     public function BoxBranches(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['branches'] = $this->organization_model->boxbranchselect();
        $this->load->view('backend/boxbranches',$data); 
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }

    public function District(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['branches'] = $this->organization_model->districtselect();
        $this->load->view('backend/districts',$data); 
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Department(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['department'] = $this->organization_model->depselect();
        $this->load->view('backend/department',$data); 
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
	public function Supervisor_attendence(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['superAtt'] = $this->organization_model->supselect();
        $this->load->view('ems/supervisorAttendence',$data); 
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

   


    public function Save_region(){
    if($this->session->userdata('user_login_access') != False) { 
       $reg = $this->input->post('region_name');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       $this->form_validation->set_rules('region_name','region_name','trim|required|xss_clean');

       if ($this->form_validation->run() == FALSE) {
           echo validation_errors();
       }else{
        if($this->organization_model->Does_region_exists($reg)){
                $this->session->set_flashdata('formdata','Region is already Exist');
                echo "Region is already Exist";
            } else {
                $data = array();
                $data = array('region_name' => $reg);
                $success = $this->organization_model->Add_Region($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                   echo "Successfully Added";
            }
       
       }
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
     public function Save_branch(){
    if($this->session->userdata('user_login_access') != False) { 
       $reg = $this->input->post('region_id');
       $bra = $this->input->post('branch_name');
       $bclno = $this->input->post('bclno');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       $this->form_validation->set_rules('region_id','region_id','trim|required|xss_clean');
       $this->form_validation->set_rules('branch_name','branch_name','trim|required|xss_clean');

       if ($this->form_validation->run() == FALSE) {
           echo validation_errors();
       }else{
        $data = array();
        $data = array('region_id' => $reg,'branch_name' => $bra,'bcl'=>@$bclno);
        $success = $this->organization_model->Add_Branch($data);
        $this->session->set_flashdata('feedback','Successfully Added');
           echo "Successfully Added";
       }
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
     public function Save_boxbranch(){
    if($this->session->userdata('user_login_access') != False) { 
       $reg = $this->input->post('region_id');
       $bra = $this->input->post('branch_name');

        $data = array();
        $data = array('region_id' => $reg,'branch_name' => $bra);
        $success = $this->organization_model->Add_BoxBranch($data);
        $this->session->set_flashdata('feedback','Box Branch has been successfully saved');
        redirect($this->agent->referrer());
     
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Save_district(){
    if($this->session->userdata('user_login_access') != False) { 
       $reg = $this->input->post('region_id');
       $bra = $this->input->post('branch_name');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       $this->form_validation->set_rules('region_id','region_id','trim|required|xss_clean');
       $this->form_validation->set_rules('branch_name','branch_name','trim|required|xss_clean');

       if ($this->form_validation->run() == FALSE) {
           echo validation_errors();
       }else{
        $data = array();
        $data = array('region_id' => $reg,'district_name' => $bra);
        $success = $this->organization_model->Add_District($data);
        $this->session->set_flashdata('feedback','Successfully Added');
           echo "Successfully Added";
       }
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Save_dep(){
    if($this->session->userdata('user_login_access') != False) { 
       $dep = $this->input->post('department');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       $this->form_validation->set_rules('department','department','trim|required|xss_clean');

       if ($this->form_validation->run() == FALSE) {
           echo validation_errors();
       }else{
        $data = array();
        $data = array('dep_name' => $dep);
        $success = $this->organization_model->Add_Department($data);
        $this->session->set_flashdata('feedback','Successfully Added');
           echo "Successfully Added";
       }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Delete_region($region_id){
        if($this->session->userdata('user_login_access') != False) { 
          $this->organization_model->region_delete($region_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/region');
        echo $this->organization_model->region_delete($region_id);
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Delete_branch($branch_id){
        if($this->session->userdata('user_login_access') != False) { 
        $this->organization_model->branch_delete($branch_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/branches');
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }

    public function Delete_boxbranch($branch_id){
        if($this->session->userdata('user_login_access') != False) { 
        $this->db->query("DELETE FROM box_branch WHERE branch_id='$branch_id'");
        $this->session->set_flashdata('feedback','Box Branch has been successfully deleted');
        redirect($this->agent->referrer());
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Delete_district($district_id){
        if($this->session->userdata('user_login_access') != False) { 
        $this->organization_model->district_delete($district_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/District');
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Delete_dep($dep_id){
        if($this->session->userdata('user_login_access') != False) { 
        $this->organization_model->department_delete($dep_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/Department');
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function region_edit($region){
        if($this->session->userdata('user_login_access') != False) { 
        $data['region'] = $this->organization_model->regselect();
        $data['editregion']=$this->organization_model->region_edit($region);
        $this->load->view('backend/region', $data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function branch_edit($branchid){
        if($this->session->userdata('user_login_access') != False) {
 
       //$branchid = $this->input->post('id');

        $data['branches'] = $this->organization_model->branchselect();
        $data['editbranch']=$editbranch=$this->organization_model->branch_edit($branchid);
         $data['editregion']=$this->organization_model->regedit($editbranch->region_id);
        //echo $branchid;
        //echo $editbranch->branch_name;
        $this->load->view('backend/branches', $data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

     public function boxbranch_edit($branchid){
        if($this->session->userdata('user_login_access') != False) {
 
       //$branchid = $this->input->post('id');

        $data['branches'] = $this->organization_model->boxbranchselect();
        $data['editbranch']=$editbranch=$this->organization_model->boxbranch_edit($branchid);
        $data['editregion']=$this->organization_model->regedit($editbranch->region_id);
        //echo $branchid;
        //echo $editbranch->branch_name;
        $this->load->view('backend/boxbranches', $data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function district_edit($district){
        if($this->session->userdata('user_login_access') != False) { 
        $data['branches'] = $this->organization_model->districtselect();
        $data['editbranch']=$this->organization_model->district_edit($district);
        $this->load->view('backend/districts', $data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Dep_edit($dep){
        if($this->session->userdata('user_login_access') != False) { 
        $data['department'] = $this->organization_model->depselect();
        $data['editdepartment']=$this->organization_model->department_edit($dep);
        $this->load->view('backend/department', $data);
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Update_region(){
        if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->post('region_id');
        $region_name = $this->input->post('region_name');
        $data = array();
        $data = array('region_name'=>$region_name);
        $this->organization_model->Update_Region($id, $data);
        #$this->session->set_flashdata('feedback','Updated Successfully');
        echo "Successfully Added";
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Update_branch(){
        if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->post('branch_id');
        $region_id = $this->input->post('region_id');
        $branch = $this->input->post('branch_name');
        $bclno = $this->input->post('bclno');
        $data = array();
        $data = array('branch_name'=>$branch ,'region_id'=>$region_id,'bcl'=>@$bclno);
        $this->organization_model->Update_Branch($id, $data);
        #$this->session->set_flashdata('feedback','Updated Successfully');

        $data['branches'] = $this->organization_model->branchselect();
        $this->load->view('backend/branches', $data);
        echo "Successfully Added";
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
     public function Update_boxbranch(){
        if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->post('branch_id');
        $region_id = $this->input->post('region_id');
        $branch = $this->input->post('branch_name');
        //$bclno = $this->input->post('bclno');

        $data = array();
        $data = array('branch_name'=>$branch ,'region_id'=>$region_id);
        $this->organization_model->Update_BoxBranch($id, $data);
        #$this->session->set_flashdata('feedback','Updated Successfully');

        //$data['branches'] = $this->organization_model->boxbranchselect();
        //$this->load->view('backend/boxbranches', $data);

        $this->session->set_flashdata('feedback','Box Branch has been successfully updated');
        redirect($this->agent->referrer());
        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }
    public function Update_dep(){
        if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->post('id');
        $department = $this->input->post('department');
        $data =  array('dep_name' => $department );
        $this->organization_model->Update_Department($id, $data);
        #$this->session->set_flashdata('feedback','Updated Successfully');
        echo "Successfully Added";
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Designation(){
        if($this->session->userdata('user_login_access') != False) { 
        $data['designation'] = $this->organization_model->desselect();
        $this->load->view('backend/designation',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Save_des(){
        if($this->session->userdata('user_login_access') != False) { 
        $des = $this->input->post('designation');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('designation','designation','trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        }else{
            $data = array();
            $data = array('des_name' => $des);
            $success = $this->organization_model->Add_Designation($data);
            echo "Successfully Added";
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function des_delete($des_id){
        if($this->session->userdata('user_login_access') != False) {
        $this->organization_model->designation_delete($des_id);
        $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
        redirect('organization/Designation');
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Edit_des($des){
        if($this->session->userdata('user_login_access') != False) {
        $data['designation'] = $this->organization_model->desselect();
        $data['editdesignation']=$this->organization_model->designation_edit($des);
        $this->load->view('backend/designation', $data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Update_des(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $designation = $this->input->post('designation');
        $data =  array('des_name' => $designation );
        $this->organization_model->Update_Designation($id, $data);
        echo "Successfully Updated";
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }

    public function Services(){
        if($this->session->userdata('user_login_access') != False) {
         $id = base64_decode($this->input->get('I'));
         $data['service']=$this->organization_model->get_services();
         $data['serviceById']=$this->organization_model->get_services_byId($id);
         $this->load->view('backend/register_services',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

     public function add_counters(){
        if($this->session->userdata('user_login_access') != False) {
         $id = base64_decode($this->input->get('I'));
         $data['service']=$this->Box_Application_model->get_counter();
         $data['serviceById']=$this->Box_Application_model->get_counters_byId($id);
         $this->load->view('backend/register_counter',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function add_zone(){
        if($this->session->userdata('user_login_access') != False) {
         $zone_id = base64_decode($this->input->get('I'));
         $data['service']=$this->Box_Application_model->get_zone();
         $data['serviceById']=$this->Box_Application_model->get_zone_byId($zone_id);
         $this->load->view('backend/register_zone',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

     public function  Assign_zoneto_region()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $data['emid']= base64_decode($this->input->get('I'));
            //$id = base64_decode($this->input->get('I'));
            $data['service2'] = $this->Box_Application_model->get_zone(); 
           $data['region'] = $this->employee_model->regselect();
           $data['service'] = $this->Box_Application_model->check_zone_regionlist();
            //$data['service2'] = $this->employee_model->get_services_byEmId($id); 

             $this->load->view('backend/assign_region',$data);

        }else{
            redirect(base_url());
        }
    }

      public function  Delete_zoneto_region()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $zone_id = $this->input->post('zone_id');
            $reg_code = $this->input->post('reg_code');

            //check 
             $dlt= $this->Box_Application_model->delete_zone_region($zone_id);

            // echo json_encode($dlt);

                

           //  $data['service2'] = $this->Box_Application_model->get_zone(); 
           // $data['region'] = $this->employee_model->regselect();
           // $data['service'] = $this->Box_Application_model->check_zone_regionlist();

            echo "Successfully Deleted ";

            // $this->load->view('backend/assign_region',$data);

        }else{
            redirect(base_url());
        }
    }

    public function  Assign_region_Action()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            //$emid = $this->input->post('emid');
            $zone_id = $this->input->post('zone_id');
            $reg_code = $this->input->post('reg_code');

            //check 
              $checkzoneregion = $this->Box_Application_model->check_region_zone($zone_id);
              if(!empty($checkzoneregion->region_code)){
                 $id = $this->session->userdata('user_login_id');

                 $this->Box_Application_model->delete_zone_region($zone_id);

                 for ($i=0; $i <@sizeof($reg_code) ; $i++) { 

                    
                 
                      $zn = array();
                      $zn = array('zone_id'=>$zone_id,'region_code'=>$reg_code[$i],'assigned_by'=>$id,'assign_status'=>'Assign');
                      $this->Box_Application_model->save_zone_region($zn);

                 }

              }else{
                 $id = $this->session->userdata('user_login_id');

                 for ($i=0; $i <@sizeof($reg_code) ; $i++) { 
                    //check if it exist
                    $checkregion = $this->Box_Application_model->check_region($reg_code[$i]);
                    if($checkregion == false){
                         $zn = array();
                      $zn = array('zone_id'=>$zone_id,'region_code'=>$reg_code[$i],'assigned_by'=>$id,'assign_status'=>'Assign');
                      $this->Box_Application_model->save_zone_region($zn);

                    }
                 
                     

                 }

              }

            // $tz = 'Africa/Nairobi';
            // $tz_obj = new DateTimeZone($tz);
            // $today = new DateTime("now", $tz_obj);
            // $date = $today->format('Y-m-d');

           //  $checkCounter = $this->Box_Application_model->check_counter_service($emid);
           //  $lcId = @$checkCounter->c_id;
           // $csId = @$checkCounter->cs_id;

           // $sup = array();
           //        $sup = array('assign_status'=>'NotAssign');
           //        $this->employee_model->Update_Counters_Services1($sup,$lcId);

           //        $ssup = array();
           //        $ssup = array('c_status'=>'NotAssign');
           //        $this->employee_model->Update_Counters1($ssup,$lcId);

           //   $this->Box_Application_model->delete_servc_emp($emid);

                

                      // $csup = array();
                      // $csup = array('c_status'=>'Assign');
                      // $this->employee_model->Update_Counters($csup,$cId);

                      // $update = array();
                      // $update = array('assign_status'=>'Assign','date_assign'=>$date);
                      // $this->employee_model->Update_Jobassign($update,$emid);
                     
                      echo "Services Saved Successfully";

        }else{
            redirect(base_url());
        }
    }

    public function add_counters_action(){
        if($this->session->userdata('user_login_access') != False) {
         
            $cid = $this->input->post('cid');
            $cname = $this->input->post('cname');
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
                $o_region = $info->em_region;
                $o_branch = $info->em_branch;

            if (empty($cid)) {
                
                $data = array();
                $data = array('counter_name'=>$cname,'counter_region'=>$o_region,'counter_branch'=>$o_branch);
                $this->Box_Application_model->save_counter($data);

                echo "Counter Saved Successfully";

            } else {
               
               $data = array();
                $data = array('counter_name'=>$cname);
                $this->Box_Application_model->update_counter($data,$cid);

                echo "Counter Update Successfully";
            }
            
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }


      public function add_zone_action(){
        if($this->session->userdata('user_login_access') != False) {
         
            $zone_id = $this->input->post('zone_id');
            $zone_name = $this->input->post('zone_name');
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
                $o_region = $info->em_region;
                $o_branch = $info->em_branch;

            if (empty($zone_id)) {
                
                $data = array();
                $data = array('zone_name'=>$zone_name,'zone_region'=>$o_region,'zone_branch'=>$o_branch);
                $this->Box_Application_model->save_zone($data);

                echo "Zone Saved Successfully";

            } else {
               
               $data = array();
                $data = array('zone_name'=>$zone_name);
                $this->Box_Application_model->update_zone($data,$zone_id);

                echo "Zone Update Successfully";
            }
            
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function Contract(){
        if($this->session->userdata('user_login_access') != False) {

         $id = base64_decode($this->input->get('I'));
         $data['service']=$this->organization_model->get_contract();
         $data['serviceById']=$this->organization_model->get_contract_byIds($id);
         $this->load->view('legal/register_contract',$data);
         
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function Agreement(){
        if($this->session->userdata('user_login_access') != False) {

         $id = base64_decode($this->input->get('I'));
         $data['service']=$this->organization_model->get_contract();
         $data['agreement']=$this->organization_model->get_agreement();
         $data['serviceById']=$this->organization_model->get_agreement_byIds($id);
         $this->load->view('legal/agreement',$data);
         
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Register_Service_Action(){
        if($this->session->userdata('user_login_access') != False) {
            $service_name = $this->input->post('service_name');
            $service_code = $this->input->post('service_code');
            $service_desc = $this->input->post('service_desc');
            $service_id = $this->input->post('service_id');

            $usertype = $this->session->userdata('user_type');
            if ($usertype == "SUPERVISOR") {
               
               $get = $this->organization_model->get_supervisorType($usertype);

            if (!empty($service_id)) {
            $data = array();
            $data = array('serv_name'=>$service_name,'serv_code'=>$service_code,'description'=>$service_desc);
            $this->organization_model->update_services($data,$service_id);
             $this->organization_model->update_services2($data,$service_id);
            echo "Successfully Updated";
            }else{
            $data = array();
            $data = array('serv_name'=>$service_name,'serv_code'=>$service_code,'description'=>$service_desc,'em_sub_role'=>$get->em_sub_role,'em_section_role'=>$get->em_section_role);
            $this->organization_model->save_services($data);
			$this->Box_Application_model->save_services($data);
            echo 'Successfully Added';
            }

            } else {

            if (!empty($service_id)) {
            $data = array();
            $data = array('serv_name'=>$service_name,'serv_code'=>$service_code,'description'=>$service_desc);
            $this->organization_model->update_services($data,$service_id);
            $this->organization_model->update_services2($data,$service_id);
            echo "Successfully Updated";
            }else{
            $data = array();
            $data = array('serv_name'=>$service_name,'serv_code'=>$service_code,'description'=>$service_desc);
            $this->organization_model->save_services($data);
            $this->Box_Application_model->save_services($data);
            echo 'Successfully Added';
            }
          }
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Register_Contract_Action(){
        if($this->session->userdata('user_login_access') != False) {
            $service_name = $this->input->post('service_name');
            $service_id = $this->input->post('service_id');

            if (!empty($service_id)) {
            $data = array();
            $data = array('cont_name'=>$service_name);
            $this->organization_model->update_contract_type($data,$service_id);
            echo "Successfully Updated";
            }else{
            $data = array();
            $data = array('cont_name'=>$service_name);
            $this->organization_model->save_contract_type($data);
            echo 'Successfully Added';
            }
             
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Register_Agreement_Action(){
        if($this->session->userdata('user_login_access') != False) {
            $cont_type = $this->input->post('cont_type');
            $agreement_name = $this->input->post('agreement_name');
            $service_id = $this->input->post('service_id');

            if (!empty($service_id)) {
            $data = array();
            $data = array('agreement_name'=>$agreement_name,'contract_id'=>$cont_type);
            $this->organization_model->update_agreement_type($data,$service_id);
            echo "Successfully Updated";
            }else{
            $data = array();
            $data = array('agreement_name'=>$agreement_name,'contract_id'=>$cont_type);
            $this->organization_model->save_agreement_type($data);
            echo 'Successfully Added';
            }
             
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Token(){
        if($this->session->userdata('user_login_access') != False) {

            $this->load->view('backend/token_generate');

        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    
    public function Token_Generate(){
        if($this->session->userdata('user_login_access') != False) {

        $Id = $this->input->post('Id');

        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            //$emsno = 'ITM'.rand(10,100);
            $serial = '';
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 5; $j++) {
                    $serial .= $tokens[rand(0, 35)];
                }

                if ($i < 2) {
                    $serial .= '-';
                }
            }
            $custToken = $serial;
            $password  = sha1($custToken);
            $data = array();
            $data = array('cust_code'=>$custToken,'email'=>'customer@posta.co.tz','password'=>$password);
            $this->organization_model->save_customers($data);

            echo  $custToken;

        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function getAgreement(){

      $id = $this->input->post('ag_id',TRUE);  
      //run the query for the cities we specified earlier  
      echo $this->organization_model->GetAgreementById($id);
    }

    public function  shift_attendence()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $data['service2'] = $this->Box_Application_model->get_services_shift(); 

            $this->load->view('backend/shift_attendence',$data);

        }else{
            redirect(base_url());
        }
    }

    public function  zone_info()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $zone_name = $this->input->post('zone_name');
            $ems_type = $this->input->post('ems_type');
            $weight_step = $this->input->post('weight_step');
            $zone_tariff = $this->input->post('zone_tariff');
            $zone_vat = $this->input->post('zone_vat');
            $zone_price = $this->input->post('zone_price');
            $zoneId     = base64_decode($this->input->get('I'));
            $zone_id    = $this->input->post('zone_id');

            $data = array();
            $data = array('zone_name'=>$zone_name,'zone_vat'=>$zone_vat,'zone_price'=>$zone_price,'zone_tariff'=>$zone_tariff,'weight_step'=>$weight_step,'ems_type'=>$ems_type);
            if (!empty($zone_id)) {
                $this->organization_model->update_zone_info($data,$zone_id);
                $this->session->set_flashdata('success', 'Successfully Updated');
            } else {
                $this->organization_model->save_zone_info($data);
                $this->session->set_flashdata('success', 'Successfully Saved');
            }
            
            $data['zone'] = $this->organization_model->get_zone_info();
            $data['zoneEdit'] = $this->organization_model->get_zone_byZoneId($zoneId);
            $this->load->view('zone/zone_info',$data);

        }else{
            redirect(base_url());
        }
    }

    public function delete_zone(){

        if($this->session->userdata('user_login_access') != False) { 

        $zoneId =  base64_decode($this->input->get('I'));
        //delete mikoa yake kwanza
        $dlt= $this->Box_Application_model->delete_zone_region($zoneId);

        $this->organization_model->zone_delete($zoneId);

        $this->session->set_flashdata('success', 'Successfully Deleted');

        $data['zone'] = $this->organization_model->get_zone_info();

        $this->load->view('zone/zone_info',$data);


        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }


    public function  zone_country()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $zone_name = $this->input->post('zone_name');
            $country_name = strtoupper($this->input->post('country_name'));
            $countryId     = base64_decode($this->input->get('I'));
            $country_id    = $this->input->post('country_id');

            $data = array();
            $data = array('zone_name'=>$zone_name,'country_name'=>$country_name);
            if (!empty($country_id)) {
                $this->organization_model->update_country_zone($data,$country_id);
                $this->session->set_flashdata('success', 'Successfully Updated');
            } else {
                $this->organization_model->save_country_zone($data);
                $this->session->set_flashdata('success', 'Successfully Saved');
            }
            
            $data['country'] = $this->organization_model->get_country_zone();
            $data['countryEdit'] = $this->organization_model->get_zone_byZoneId($country_id);
            $this->load->view('zone/zone_country',$data);

        }else{
            redirect(base_url());
        }
    }

    public function  pcum_zone()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $district = $this->input->post('district');
            $zone_name = $this->input->post('zone_name');
            $city = $this->input->post('city');
            $weight = $this->input->post('weight');
            $tarrif = $this->input->post('tarrif');
            $vat = $this->input->post('vat');

            // $countryId     = base64_decode($this->input->get('I'));
            // $country_id    = $this->input->post('country_id');
            $zone = $this->organization_model->check_zone_name($zone_name,$district);

            if (!empty($zone)) {

               $last_id = $zone->zone_id;

            }else {

            $data = array();
            $data = array('district_id'=>$district,'zone_name'=>$zone_name);
            // if (!empty($country_id)) {
            //     $this->organization_model->update_country_zone($data,$country_id);
            //     $this->session->set_flashdata('success', 'Successfully Updated');
            // } else {
                    $db2 = $this->load->database('otherdb', TRUE);
                    $db2->insert('district_zone_tarrif',$data);
                    $last_id = $db2->insert_id();
            }
            
                    for ($i=0; $i <@sizeof(@$city) ; $i++)
                    {
                        
                        $data1 = array();
                        $data1 = array('district_id'=>$district,'zone_id'=>$last_id,'town_city'=>$city[$i],'tarrif'=>$tarrif,'vat'=>$vat,'weight'=>$weight);
                        $this->organization_model->save_pcum_zone($data1);
                    }
                    
                    $this->session->set_flashdata('success', 'Successfully Saved');
            // }
            
            // $data['country'] = $this->organization_model->get_country_zone();
            // $data['countryEdit'] = $this->organization_model->get_zone_byZoneId($country_id);
            $data['district'] = $this->dashboard_model->getdistrict();
            $this->load->view('zone/pcum-zone',$data);

        }else{
            redirect(base_url());
        }
    }
    
    public function delete_country(){

        if($this->session->userdata('user_login_access') != False) { 

        $countryId =  base64_decode($this->input->get('I'));

        $this->organization_model->country_delete($countryId);

        $this->session->set_flashdata('success', 'Successfully Deleted');

        $data['country'] = $this->organization_model->get_country_zone();

        $this->load->view('zone/zone_country',$data);


        }
    else{
        redirect(base_url() , 'refresh');
    }            
    }

    public function delete(){
        if($this->session->userdata('user_login_access') != False) { 

            $cid = $this->input->post('cid');
            $this->organization_model->delete_counter($cid);

            echo "Successfully Deleted";
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

    public function deletezoneemp(){
        if($this->session->userdata('user_login_access') != False) { 

            $zone_id = $this->input->post('zone_id');
            $this->Box_Application_model->delete_zone($zone_id);

            echo "Successfully Deleted";
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }


    public function add_subservices(){
        if($this->session->userdata('user_login_access') != False) { 

            $sid = base64_decode($this->input->get('I'));
            $sub_service = $this->input->post('sub_service');

            $save = array();
            $save = array('service_id' => $sid,'sub_service_name'=>$sub_service);
            $this->organization_model->save_sub_services($save);

            $data['sid'] = $sid;
            $data['service'] = $this->organization_model->get_sub_services_list();

            $this->load->view('backend/register_subservices',$data);
            
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
}