 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpi extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('kpi_model');
    }
    
	public function kpi_form()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
            $data['design'] = $this->employee_model->getdesignation();
            $this->load->view('kpi/kpi-objective',$data);
            
	}else{
        redirect(base_ur());
    }
    }

    public function add_kpi()
    {
        if ($this->session->userdata('user_login_access') !=false){

           $Objective = $this->input->post('Objective'); 
           $Goal = $this->input->post('Goal'); 
           $KPI = $this->input->post('KPI'); 
           $Weight = $this->input->post('Weight'); 
           $Division = $this->input->post('Division');
           $delete = $this->input->post('delete');
           $objId = $this->input->post('objId');
           $marks = $this->input->post('marks');
           $design = $this->input->post('design');

           if (!empty($delete)) {
              $this->kpi_model->delete_objective($objId);
              echo "Successfull Deleted";
           } else {
          
            $data = array();
            $data = array('objective_name'=>$Objective,
                'marks'=>$marks);

            $db = $this->load->database('default', TRUE);
            $db->insert('kpiobjective',$data);
            $last_id = $db->insert_id();
            // $this->kpi_model->add_kpi_values($data);

           for ($i=0; $i <@sizeof($design) ; $i++) { 
                
                $data1 = array();
                $data1 = array(
                'objective_id'=>$last_id,
                'designation'=>$design[$i]
                );

                $this->kpi_model->add_kpi_who_to_see($data1);
        } 

        $data['message'] = "Saved Successfull";
        $this->load->view('kpi/kpi-objective',$data);
     }
            
    }else{
        redirect(base_ur());
    }
    }

    public function my_kpi()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['kpilist'] = $this->kpi_model->get_all_kpi();
            $data['sum'] = $this->kpi_model->get_all_kpi_sum();
            $data['designation'] = $this->kpi_model->get_desnation();
            $this->load->view('kpi/my-kpi',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function staff_to_see()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['objective']  = base64_decode($this->input->get('objective_id'));
            $data['designation'] = $this->kpi_model->get_desnation();
            $design = $this->input->post('design');
            $last_id = $this->input->post('objectiveid');
            if (!empty($design)) {
              for ($i=0; $i <@sizeof($design) ; $i++) { 
                
                $data1 = array();
                $data1 = array(
                'objective_id'=>$last_id,
                'designation'=>$design[$i]
                );

                $this->kpi_model->add_kpi_who_to_see($data1);
              }

              echo "Successfull Saved";
            }else{
              $this->load->view('kpi/staff-to-see',$data);
            }

    }else{
        redirect(base_ur());
    }
    }

    public function kpi_report()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['kpilist'] = $this->kpi_model->get_all_kpi();
            $data['sum'] = $this->kpi_model->get_all_kpi_sum();
            $this->load->view('kpi/kpi-report',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function general_kpi_report()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
            
            $design = $this->input->post('em_id');

            $data['employee'] = $this->kpi_model->get_employee();
            $data['kpilist']  = $this->kpi_model->general_kpi_report1($design);
            $data['design']   = $design;
            $this->load->view('kpi/general-kpi-report',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function Dowloan_KPI_Report()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
            
            $design = base64_decode($this->input->get('des_name'));

            $data['kpilist']  = $this->kpi_model->general_kpi_report1($design);

            $this->load->library('Pdf');
            $html= $this->load->view('kpi/pdf-kpi-report',$data,TRUE);
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','landscape');
            $this->dompdf->render();
            $this->dompdf->stream($design, array("Attachment"=>0));
            
    }else{
        redirect(base_ur());
    }
    }

    public function Target_goals()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $kpid = base64_decode($this->input->get('objectiId'));
            $data['kpilist'] = $this->kpi_model->get_goals($kpid);

            $this->load->view('kpi/my-kpi-target',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function my_kpi1()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['kpilist'] = $this->kpi_model->get_all_kpi1();
            $data['sum'] = $this->kpi_model->get_all_kpi_sum1();
            $this->load->view('kpi/my-kpi1',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function add_my_goals()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['kpi_id'] = base64_decode($this->input->get('kpi_id'));

            $this->load->view('kpi/kpi-goals',$data);
            
    }else{
        redirect(base_ur());
    }
    }
    public function edit_goals()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $Goals['goals_id'] = $id = base64_decode($this->input->get('goals_id'));
            $Goals['goals_values'] = $this->kpi_model->get_kpi_goals($id);

            $goalsid = $this->input->post('goals_id');
            $target = $this->input->post('target');

            $delete = $this->input->post('delete');

            $data = array();
            $data = array('target_name'=>$target);

            if ($delete == "delete") {
              $this->kpi_model->delete_kpi_target($goalsid);
              echo "Successfull Deleted";
            } else {
             if(!empty($goalsid)){
              $this->kpi_model->update_goals($goalsid,$data);
              echo "Successfull Updated";
            }
            $this->load->view('kpi/edit-goals',$Goals);
            }
            
    }else{
        redirect(base_ur());
    }
    }

    public function kpi_goal()
    {
        if ($this->session->userdata('user_login_access') !=false){

           //$Objective = $this->input->post('Objective'); 
           $Goal = $this->input->post('Goals'); 
           $objid = $this->input->post('kpiid'); 
           


           for ($i=0; $i <@sizeof($Goal) ; $i++) { 
                
                $data = array();
                $data = array(
                'objective_id'=>$objid,
                'target_name'=>$Goal[$i],
            );

                $this->kpi_model->add_kpi_goal($data);
        } 

        echo "Successfull Added";
            
    }else{
        redirect(base_ur());
    }
    }

    public function add_kpi_goals()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){

            $data['kpi_id'] = base64_decode($this->input->get('kpi_id'));

            $this->load->view('kpi/kpi-goals_form',$data);
            
    }else{
        redirect(base_ur());
    }
    }

    public function kpi_goal_value()
    {
        if ($this->session->userdata('user_login_access') !=false){

           //$Objective = $this->input->post('Objective'); 
           $Goal = $this->input->post('kpi'); 
           $objid = $this->input->post('kpiid'); 
           $marks = $this->input->post('marks'); 
           $id = $this->session->userdata('user_login_id');
           $data['designation'] = $this->kpi_model->get_desnation();

           $info = $this->employee_model->GetBasic($id);
           $user_type = $info->em_role;
           $design = $info->des_name;
           foreach ($data['designation'] as $value) {
            if ($design == $value->designation) {
                $design1 = $design;
           } else {
                
                $design1 = $info->em_id;
           }
           }

           for ($i=0; $i <@sizeof($Goal) ; $i++) { 
                
                $data = array();
                $data = array(
                'goals_id'=>$objid,
                'kpi_values'=>$Goal[$i],
                'user_type'=>$user_type,
                'designation'=>$design1,
                'marks'=>$marks[$i]
            );


            $this->kpi_model->add_kpi_goal_values($data);
        } 

        echo "Successfull Saved";

    }else{
        redirect(base_ur());
    }
    }

    public function edit_kpi()
    {
        if ($this->session->userdata('user_login_access') !=false){

           $kpid = base64_decode($this->input->get('kpid'));
           $data['design'] = $this->employee_model->getdesignation();
           $data['objective'] = $this->kpi_model->get_objective_by_id($kpid);
           $this->load->view('kpi/edit-kpi',$data);
    }else{
        redirect(base_ur());
    }
    }

    public function update_kpi()
    {
        if ($this->session->userdata('user_login_access') !=false){

           $marks  = $this->input->post('marks');
           $design = $this->input->post('design');
           $objid = $this->input->post('objId');
           $objname = $this->input->post('Objective');


          $data = array();
          $data = array('objective_name'=>$objname,'marks'=>$marks);

          for ($i=0; $i <@sizeof($design) ; $i++) { 
                
                $data1 = array();
                $data1 = array(
                'objective_id'=>$objid,
                'designation'=>$design[$i]
                );

                $this->kpi_model->add_kpi_who_to_see($data1);
              }

          $this->kpi_model->update_objective($data,$objid);

           echo "Successfull Updated";

    }else{
        redirect(base_ur());
    }
    }

    public function Get_Goals(){

      if ($this->input->post('objid') != '') {
          
          $objid = $this->input->post('objid');
          //$get = $this->kpi_model->GetGoalsById2($objid);
          echo $this->kpi_model->GetGoalsById($objid);
      }

    }

    public function Get_Marks(){

      if ($this->input->post('objid') != '') {
          
          $objid = $this->input->post('objid');

          $get = $this->kpi_model->GetMarksById($objid);

          echo $get->marks;
      }

    }

    public function Get_Goals2(){

      if ($this->input->post('objid') != '') {
          
          $objid = $this->input->post('objid');
          $get = $this->kpi_model->GetGoalsById2($objid);
          if (empty($get)) {
            echo "No";
          } else {

            $i = 1;

            //echo"<ol>";
            echo "<table width='100%'>";
            foreach ($get as  $value) {
              echo "<tr>";
              echo "<td>".$value->kpi_values."</td><td>".$value->marks."</td>";
              echo "<td></td>";
              echo "</tr>";
            }
            echo"</table>";
           //echo"</ol>";
          }
           
      }

    }

}