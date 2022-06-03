<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('leave_model');
		$this->load->model('settings_model');
		$this->load->model('project_model');
	}

	public function index()
	{
		#Redirect to Admin dashboard after authentication
		if ($this->session->userdata('user_login_access') == 1)
			redirect('dashboard/Dashboard');
		$data = array();
		#$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('login');
	}

	public function Verify_Leave()
	{
		$emid = base64_decode($this->input->get('I'));
		$id = base64_decode($this->input->get('E'));
		$data['employee'] = $this->leave_model->GetLeaveApplyById($id);
		$data['family'] = $this->leave_model->GetFamilys($emid);
		$data['application'] = $this->leave_model->AllLeaveAPPlication();
		$data['regionlist'] = $this->employee_model->regselect();
		$this->load->view('backend/verify_leave', $data);
	}
	public function Edit_Leave()
    {
		$emid = base64_decode($this->input->get('I'));
		$id = base64_decode($this->input->get('E'));

		$data['employee']  = $this->leave_model->GetLeaveApplyById($id);
		$data['family']    = $this->leave_model->GetFamilys($emid);
		$data['application'] = $this->leave_model->AllLeaveAPPlication();
		$data['regionlist']  = $this->employee_model->regselect();
		$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();

        $this->load->view('backend/edit_leave', $data);
    }
	public function Holidays()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['holidays'] = $this->leave_model->GetAllHoliInfo();
			$this->load->view('backend/holiday', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Holidays_for_calendar()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$result = $this->leave_model->GetAllHoliInfoForCalendar();
			print_r($result);
			die();
			echo jason_encode($result);

		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Add_Holidays()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->post('id');
			$name = $this->input->post('holiname');
			$sdate = $this->input->post('startdate');
			$edate = $this->input->post('enddate');
			if (empty($edate)) {
				$nofdate = '1';
				//die($nofdate);
			} else {
				$date1 = new DateTime($sdate);
				$date2 = new DateTime($edate);
				$diff = date_diff($date1, $date2);
				$nofdate = $diff->format("%a");
				//die($nofdate);
			}
			$year = date('m-Y', strtotime($sdate));
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('holiname', 'Holidays name', 'trim|required|min_length[5]|max_length[120]|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("leave/Holidays");
			} else {
				$data = array();
				$data = array(
					'holiday_name' => $name,
					'from_date' => $sdate,
					'to_date' => $edate,
					'number_of_days' => $nofdate,
					'year' => $year
				);
				if (empty($id)) {
					$success = $this->leave_model->Add_HolidayInfo($data);
					$this->session->set_flashdata('feedback', 'Successfully Added');
					#redirect("leave/Holidays");
					echo "Successfully Added";
				} else {
					$success = $this->leave_model->Update_HolidayInfo($id, $data);
					$this->session->set_flashdata('feedback', 'Successfully Updated');
					#redirect("leave/Holidays");
					echo "Successfully Updated";
				}

			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Add_leaves_Type()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->post('id');
			$name = $this->input->post('leavename');
			$nodays = $this->input->post('leaveday');
			$status = $this->input->post('status');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('leavename', 'leave name', 'trim|required|min_length[1]|max_length[220]|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("leave/Holidays");
			} else {
				$data = array();
				$data = array(
					'name' => $name,
					'leave_day' => $nodays,
					'status' => $status
				);
				if (empty($id)) {
					$success = $this->leave_model->Add_leave_Info($data);
					echo "Successfully Added";
				} else {
					$success = $this->leave_model->Update_leave_Info($id, $data);
					echo "Successfully Updated";
				}

			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Application()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$emid = $this->input->get('em_id');

			$data['employee'] = $this->employee_model->emselect();
			$data['employee1'] = $this->employee_model->emselectleave(); // gets active employee details
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['application'] = $this->leave_model->AllLeaveAPPlication();

			$this->load->view('backend/leave_approve', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function My_leave()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$emid = $this->input->get('em_id');

			$data['employee'] = $this->employee_model->emselect();
			$data['employee1'] = $this->employee_model->emselectleave(); // gets active employee details
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['application'] = $this->leave_model->MyLeaveAPPlication();

			$this->load->view('backend/leave_approve', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function Batch()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$emid = $this->input->get('em_id');

			$data['employee'] = $this->employee_model->emselect();
			$data['employee1'] = $this->employee_model->emselectleave(); // gets active employee details
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['application'] = $this->leave_model->AllLeaveAPPlication();

			$this->load->view('backend/leave_batch', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function ApprovedLeave()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect(); // gets active employee details
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['application'] = $this->leave_model->AllLeaveApproved();
			$this->load->view('backend/approved_leave', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function EmApplication()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$emid = $this->session->userdata('user_login_id');
			$data['employee'] = $this->employee_model->emselectByID($emid);
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['application'] = $this->leave_model->GetallApplication($emid);
			$this->load->view('backend/leave_apply', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Update_Applications()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$ids = $this->input->post('id');
			$emid = $this->input->post('emid');
			$typeid = $this->input->post('typeid');
			$appstartdate = $this->input->post('startdate');
			$appenddate = $this->input->post('enddate');
			$reason = $this->input->post('reason');
			/*      $type = $this->input->post('type');*/
			$duration = $this->input->post('duration');
			$hour = $this->input->post('hour');
			$datetime = $this->input->post('datetime');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('reason', 'reason', 'trim|required|min_length[5]|max_length[512]|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("employee/view?I=" .base64_encode($eid));
			} else {
				$data = array();
				$data = array(
					'em_id' => $emid,
					'typeid' => $typeid,
					'start_date' => $appstartdate,
					'end_date' => $appenddate,
					'reason' => $reason,
					/*'leave_type'=>$type,*/
					'leave_duration' => $duration,
					'leave_status' => 'Approve'
				);
				$success = $this->leave_model->Application_Apply_Update($ids, $data);
				#$this->session->set_flashdata('feedback','Successfully Updated');
				#redirect("leave/Application");

				if ($this->db->affected_rows()) {
					$data = array();
					$data = array(
						'emp_id' => $emid,
						'app_id' => $id,
						'type_id' => $typeid,
						'day' => $duration,
						'hour' => $hour,
						'dateyear' => $datetime
					);
					$success = $this->leave_model->Application_Apply_Approve($data);
					echo "Successfully Approved";
				}
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Add_Applications()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->session->userdata('user_login_id');
			$basicinfo = $this->employee_model->GetBasic($id);
			$region_from = $basicinfo->em_region;
			$district_to = $this->input->post('district_to');
			$region_to = $this->input->post('region_to');
			$village_to = $this->input->post('village_to');
			$ids = $this->input->post('id');
			$emid = $this->input->post('emid');
			$typeid = $this->input->post('typeid');
			$applydate = date('Y-m-d');
			$appstartdate = $this->input->post('startdate');
			$appenddate = $this->input->post('enddate');
			$hourAmount = $this->input->post('hourAmount');
			$reason = $this->input->post('reason');
			$data['leavetypevalue'] = $this->leave_model->GetLeaveType($typeid);
			$type1 = $data['leavetypevalue']->name;
			$type = $type1;
			// $duration     = $this->input->post('duration');

			if ($type == 'Half Day') {
				$duration = $hourAmount;
			} else if ($type == 'Full Day') {
				$duration = 8;
			} else {
				$formattedStart = new DateTime($appstartdate);
				$formattedEnd = new DateTime($appenddate);

				$duration = $formattedStart->diff($formattedEnd)->format("%R%a");
				$duration = $duration * 8;
			}

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('startdate', 'Start Date', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
				#redirect("employee/view?I=" .base64_encode($eid));
			} else {
				$data = array();
				$data = array(
					'em_id' => $emid,
					'typeid' => $typeid,
					'apply_date' => $applydate,
					'start_date' => $appstartdate,
					'end_date' => $appenddate,
					'reason' => $reason,
					'leave_type' => $type,
					'leave_duration' => $duration,
					'leave_status' => 'Not Approve',
					'region_from' => $region_from,
					'region_to' => $region_to,
					'district_to' => $district_to,
					'village_to' => $village_to
				);
				if (empty($ids)) {
					if ($basicinfo->em_gender == 'Male' and $type1 == 'Maternity Leave') {
						$this->session->set_flashdata('formdata', 'Please Maternity Leave is for Female');
						echo "Please Maternity Leave is for Female Employee";
					} elseif ($basicinfo->em_gender == 'Female' and $type1 == 'Paternity Leave') {
						$this->session->set_flashdata('formdata', 'Please Paternity Leave is for Male');
						echo "Please Paternity Leave is for Male Employee";
					} else {
						if ($this->leave_model->Does_leaveApprove_exists($emid)) {
							$this->session->set_flashdata('formdata', 'Please wait you have aleave already');
							echo "Please wait you have aleave already";
						} elseif ($this->leave_model->Does_leaveNotApprove_exists($emid)) {
							$this->session->set_flashdata('formdata', 'Please wait your leave is in process');
							echo "Please wait your leave is in process";
						} else {
							$success = $this->leave_model->Application_Apply($data);
							#$this->session->set_flashdata('feedback','Successfully Updated');
							#redirect("leave/Application");
							echo "Successfully Added";
						}
					}

				} else {
					$success = $this->leave_model->Application_Apply_Update($ids, $data);
					#$this->session->set_flashdata('feedback','Successfully Updated');
					#redirect("leave/Application");
					echo "Successfully Updated";
				}
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Add_L_Status()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$ids = $this->input->post('lid');
			$value = $this->input->post('lvalue');
			$duration = $this->input->post('duration');
			$type = $this->input->post('type');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$data = array();
			$data = array(
				'leave_status' => $value
			);
			$success = $this->leave_model->Application_Apply_Update($ids, $data);
			if ($value == 'Approve') {
				$totalday = $this->leave_model->GetTotalDay($type);
				$total = $totalday->total_day + $duration;
				$data = array();
				$data = array(
					'total_day' => $total
				);
				$success = $this->leave_model->Assign_Duration_Update($type, $data);
				echo "Successfully Updated";
			} else {
				echo "Successfully Updated";
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}


	public function Holidaybyib()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$data['holidayvalue'] = $this->leave_model->GetLeaveValue($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function LeaveAppbyid()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$emid = $this->input->get('em_id');
			$data['leaveapplyvalue'] = $this->leave_model->GetLeaveApply($id);

			echo json_encode($data);


		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function LeaveTypebYID()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$typeid = $this->input->get('id');
			$data['leavetypevalue'] = $this->leave_model->GetLeaveType($typeid);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function GetEarneBalanceByEmCode()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$data['earnval'] = $this->leave_model->GetEarneBalanceByEmCode($id);
			echo json_encode($data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function HOLIvalueDelet()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$success = $this->leave_model->DeletHoliday($id);
			echo "Successfully Deletd";
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function APPvalueDelet()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$success = $this->leave_model->DeletApply($id);
			redirect('leave/Application');
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function LeavetypeDelet()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('D');
			$success = $this->leave_model->DeletType($id);
			redirect('leave/leavetypes');
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function leavetypes()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$this->load->view('backend/leavetypes', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function LeaveType()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->input->get('id');
			$year = date('Y');
			$leavetype = $this->leave_model->GetemLeaveType($id, $year);
			$assignleave = $this->leave_model->GetemassignLeaveType($id, $year);
			foreach ($leavetype as $value) {
				echo "<option value='$value->type_id'>$value->name</option>";
			}
			$totalday = $assignleave->total_day . '/' . $assignleave->day;
			echo $totalday;
		} else {
			redirect(base_url(), 'refresh');
		}
	}


	public function EmLeavesheet()
	{
		$emid = $this->session->userdata('user_login_id');
		$data = array();
		$data['embalance'] = $this->leave_model->EmLeavesheet($emid);
		$this->load->view('backend/leavebalance', $data);
	}

	public function GetemployeeGmLeave()
	{
		$year = $this->input->get('year');
		$id = $this->input->get('typeid');
		$emid = $this->input->get('emid');
		$assignleave = $this->leave_model->GetemassignLeaveType($emid, $id, $year);
		$totaldays = 0;
		foreach ($assignleave as $value) {
			$totaldays = $totaldays + $value->day;
		}
		$day = $totaldays;
		$leavetypes = $this->leave_model->GetleavetypeInfoid($id);
		$totalday = $day . '/' . $leavetypes->leave_day;
		echo $totalday;
	}

	public function Leave_report()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect();
			$this->load->view('backend/leave_report', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	// Get leave details hourly
	public function Get_LeaveDetails()
	{
		$emid = $this->input->get('emp_id');
		$date = $this->input->get('date_time');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters();
		$this->form_validation->set_rules('date_time', 'Date Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_id', 'Employee', 'trim|required|xss_clean');
		$date = explode('-', $date);

		$day = @$date[0];
		$year = @$date[1];

		$report = $this->leave_model->GetEmLEaveReport($emid, $day, $year);

		if (is_array($report) || is_object($report)) {
			foreach ($report as $value) {
				$des_id = $value->des_id;
				$desvalue = $this->employee_model->getdesignation1($des_id);

				$dep_id = $value->dep_id;
				$dep_value = $this->employee_model->getdepartment1($dep_id);

				echo "<tr>
                        <td>$value->em_code</td>
                        <td>$value->first_name $value->middle_name $value->last_name </td>
                        <td>$dep_value->dep_name</td>
                        <td>$desvalue->des_name</td>
                        <td>$value->name</td>
                        <td>$value->leave_duration Days</td>
                        <td>$value->start_date</td>
                        <td>$value->end_date</td>
                    </tr>";
			}
		} else {
			echo "<p>No Data Found</p>";
		}
	}

	public function Get_LeaveDetailsBatch()
	{
		$emid = $this->input->get('leaveType');
		$date = $this->input->get('date_time');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters();
		$this->form_validation->set_rules('date_time', 'Date Time', 'trim|required|xss_clean');
		$this->form_validation->set_rules('emp_id', 'Employee', 'trim|required|xss_clean');
		$date = explode('-', $date);

		$day = @$date[0];
		$year = @$date[1];

		$report = $this->leave_model->GetEmLEaveBatch($emid, $day, $year);

		if (is_array($report) || is_object($report)) {
			foreach ($report as $value) {
				$des_id = $value->des_id;
				$desvalue = $this->employee_model->getdesignation1($des_id);

				$dep_id = $value->dep_id;
				$dep_value = $this->employee_model->getdepartment1($dep_id);

				echo "<tr>
                        <td>$value->em_code</td>
                        <td>$value->first_name $value->middle_name $value->last_name </td>
                         <td>$value->name</td>
                        <td>$value->apply_date</td>
                        <td>$value->start_date</td>
                        <td>$value->end_date</td>
                        <td>$value->leave_duration Days</td>
                        <td>$value->fare_amount</td>
                        <td>$value->leave_status</td>
                        <td><div class='form-check'>
                     <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                     <label class='form-check-label' for='remember-me'></label>
                 </div> </td>
                    </tr>";
			}
		} else {
			echo "<p>No Data Found</p>";
		}
	}
	/*Approve and update leave status*/
	public function approveLeaveStatus()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$employeeId = $this->input->post('employeeId');
			$id = $this->input->post('lid');
			$value = $this->input->post('lvalue');
			$duration = $this->input->post('duration');
			$type = $this->input->post('type');
			$fare_amount = $this->input->post('fare_amount');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();

			$data = array();
			$data = array(
				'leave_status' => $value,
				'fare_amount' => $fare_amount
			);
			$success = $this->leave_model->updateAplicationAsResolved($id, $data);
			if ($value == 'Approve' or $value == 'Complete') {
				$determineIfNew = $this->leave_model->determineIfNewLeaveAssign($employeeId, $type);
				//How much taken
				$totalHour = $this->leave_model->getLeaveTypeTotal($employeeId, $type);
				//If already taken some
				if ($determineIfNew > 0) {
					$total = $totalHour[0]->totalTaken + $duration;
					$data = array();
					$data = array(
						'hour' => $total
					);
					$success = $this->leave_model->updateLeaveAssignedInfo($employeeId, $type, $data);
					$earnval = $this->leave_model->emEarnselectByLeave($employeeId);
					if ($earnval > 0) {
						$data = array();
						$data = array(
							'present_date' => $earnval->present_date - ($duration / 8),
							'hour' => $earnval->hour - $duration
						);
						$success = $this->leave_model->UpdteEarnValue($employeeId, $data);
						echo "Updated successfully";
					} else {
						echo "No Earnedleave";
					}

				} else {
					//If not taken yet
					$data = array();
					$data = array(
						'emp_id' => $employeeId,
						'type_id' => $type,
						'hour' => $duration,
						'dateyear' => date('Y')
					);
					$success = $this->leave_model->insertLeaveAssignedInfo($data);
					echo "Updated successfully";
				}
			} else {
				echo "Updated successfully";
			}
		}
	}

	public function LeaveAssign()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$employeeID = $this->input->get('employeeID');
			$leaveID = $this->input->get('leaveID');
			if (!empty($leaveID)) {
				$year = date('Y');
				$daysTaken = $this->leave_model->GetemassignLeaveType($employeeID, $leaveID, $year);
				//die($daysTaken->hour);
				$leavetypes = $this->leave_model->GetleavetypeInfoid($leaveID);
				if (empty($daysTaken->hour)) {
					$daysTakenval = '0';
				} else {
					$daysTakenval = $daysTaken->hour / 8;
				}
				if ($leaveID == '5') {
					$earnTaken = $this->leave_model->emEarnselectByLeave($employeeID);
					if ($earnTaken > 0) {
						$totalday = 'Earned Balance: ' . ($earnTaken->hour / 8) . ' Days';
						echo $totalday;
					} else {
						$totalday = 'Earned Balance: 0 Days';
						echo $totalday;
					}
				} else {
					//$totalday   = $leavetypes->leave_day . '/' . ($daysTaken/8);
					$totalday = 'Leave Balance: ' . ($leavetypes->leave_day - $daysTakenval) . ' Days Of ' . $leavetypes->leave_day;
					echo $totalday;
				}

				/* $daysTaken = $this->leave_model->GetemassignLeaveType('Sah1804', 2, 2018);
				 $leavetypes = $this->leave_model->GetleavetypeInfoid($leaveID);
				 // $totalday   = $leavetypes->leave_day . '/' . $daysTaken['0']->day;
				 echo $daysTaken['0']->day;
				 echo $leavetypes->leave_day;*/
			} else {
				echo "Something wrong.";
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Earnedleave()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['employee'] = $this->employee_model->emselect();
			$data['earnleave'] = $this->leave_model->GetEarnedleaveBalance();
			$this->load->view('backend/earnleave', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function Update_Earn_Leave()
	{
		$employee = $this->input->post('emid');
		$start = $this->input->post('startdate');
		$end = $this->input->post('enddate');
		if (empty($end)) {
			$days = '1';
			//die($nofdate);
		} else {
			$date1 = new DateTime($start);
			$date2 = new DateTime($end);
			$diff = date_diff($date1, $date2);
			$days = $diff->format("%a");
			//die($nofdate);
		}
		$hour = $days * 8;
		$emcode = $this->employee_model->emselectByCode($employee);
		$emid = $emcode->em_id;
		$earnval = $this->leave_model->emEarnselectByLeave($emid);
		if (!empty($earnval)) {
			$data = array();
			$data = array(
				'present_date' => $earnval->present_date + $days,
				'hour' => $earnval->hour + $hour,
				'status' => '1'
			);
			$success = $this->leave_model->UpdteEarnValue($emid, $data);
		} else {
			$data = array();
			$data = array(
				'em_id' => $emid,
				'present_date' => $days,
				'hour' => $hour,
				'status' => '1'
			);
			$success = $this->leave_model->Add_Earn_Leave($data);
		}

		if ($this->db->affected_rows()) {
			$startdate = strtotime($start);
			$enddate = strtotime($end);
			for ($i = $startdate; $i <= $enddate; $i = strtotime('+1 day', $i)) {
				$date = date('Y-m-d', $i);
				$data = array();
				$data = array(
					'emp_id' => $employee,
					'atten_date' => $date,
					'working_hour' => '480',
					'signin_time' => '09:00:00',
					'signout_time' => '17:00:00',
					'status' => 'E'
				);
				$this->project_model->insertAttendanceByFieldVisitReturn($data);

			}
			echo "Successfully Added";
		}
	}

	public function Update_Earn_Leave_Only()
	{
		$emid = $this->input->post('employee');
		$days = $this->input->post('day');
		$hour = $this->input->post('hour');
		$data = array();
		$data = array(
			'present_date' => $days,
			'hour' => $hour
		);
		$success = $this->leave_model->UpdteEarnValue($emid, $data);
		echo "Successfully Updated.";
	}

	public function Application_Form()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->session->userdata('user_login_id');
			$emid = $id;
			$data['employee'] = $this->employee_model->emselectByID1($emid);
			$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();
			$data['regionlist'] = $this->employee_model->regselect();
			$this->load->view('backend/leave_application_form', $data);
		}
	}

	public function Leave_Application()
	{
		
			$em_gender = $this->input->post('em_gender');
			$typeid = $this->input->post('leave_type');
			$emid = $this->input->post('em_id');
			$em_code = $this->input->post('em_code');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('days');
			$region_to = $this->input->post('region_to');
			$district_to = $this->input->post('district_to');
			$village_to = $this->input->post('village_to');
			$reason = $this->input->post('reason');
			$region_from = $this->input->post('region_from');
			$leaveID = $this->input->post('leave_id');
			$status = $this->input->post('status');
			$amount1 = $this->input->post('amount');
			$amount2 = $this->input->post('amount2');
			//$amount = ($amount1 + $amount2);
			$rejected_reason = $this->input->post('rejected_reason');

			$startdate1 = new DateTime($startdate);
			//$enddate1 = new DateTime($enddate);
			$leave_duration = $enddate;//$enddate1->diff($startdate1)->format('%a');

			$this->form_validation->set_rules('leave_type', 'Select Leave Type', 'required');
			$this->form_validation->set_rules('region_to', 'Region To', 'required');

			$leaveById = $this->leave_model->GetLeaveType($typeid);
			$leavetype = $leaveById->name;
			$id = $leaveID;
			$lstatus = $this->leave_model->GetLeaveApplyByIDs($id);

			$date = $startdate;
			$days = $enddate;
    		$enddate1 =  date('Y-m-d', strtotime($date. ' +'.$days.' days'));
			$year = date('Y');

    		$get= $this->leave_model->getdesignation1($emid);
    		if (empty($get)) {
    			echo "Please Fill Your Designation";
    		} 
    		$des_id = $get->des_id;
    		$get1= $this->leave_model->getdesignation2($des_id);
    		
    		if (!empty($leaveID)) {

			if ($this->session->userdata('user_type') == 'HOD' || $this->session->userdata('user_type') == 'ADMIN' ) {
				if ($status == 'Rejected')
				{
					
					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}
					
					$data1 = array();
					$data1 = array('isHOD' => $status,'leave_status'=>$status,'rejected_reason'=>$rejected_reason);



				}else{
					$data1 = array();
					$data1 = array('isHOD' => $status);
				}

				$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
				echo "Successfully Approved";

			} elseif ($this->session->userdata('user_type') == 'RM') {
				if ($status == 'Rejected')
				{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						echo "string";
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}

					$data1 = array();
					$data1 = array('isRM' => $status,'leave_status'=>$status,'rejected_reason'=>$rejected_reason);
				}else{

					$data1 = array();
					$data1 = array('isRM' => $status);
				}

				$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
				echo "Successfully Approved";

			} elseif ($this->session->userdata('user_type') == 'HR') {

				
				if ($status == 'Rejected'){

					 	$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}

						$data1 = array();
						$data1 = array('isHR' => $status,'leave_status'=>$status,'rejected_reason'=>$rejected_reason,'fare_amount' => $amount1,'faredistrictvillage'=>$amount2);


					} else {

						$data1 = array();
						$data1 = array('isHR' => $status, 'leave_status' => $status,'fare_amount' => $amount1,'faredistrictvillage'=>$amount2);
					}
				
					$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
					echo "Successfully Approved";
				
			} elseif ($this->session->userdata('user_type') == 'PMG') {

					if ($status == 'Rejected'){
						
						$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}

						$data1 = array();
						$data1 = array('leave_status' => 'Rejected','isPMG' => $status,'rejected_reason'=>$rejected_reason);
					} else {

						$data1 = array();
						$data1 = array('isPMG' => $status, 'leave_status' => $status);
					}
			

					$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
					echo "Successfully Approved";
				
			}elseif ($this->session->userdata('user_type') == 'BOP') {

						if ($status == 'Rejected'){
						
						$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}

						$data1 = array();
						$data1 = array('leave_status' => 'Rejected','isGMBOP' => $status,'rejected_reason'=>$rejected_reason);
					} else {

						$data1 = array();
						$data1 = array('isGMBOP' => $status, 'leave_status' => $status);
					}
			
					
			$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
					echo "Successfully Approved";
				
			}elseif ($this->session->userdata('user_type') == 'CRM') {

			
					if ($status == 'Rejected'){
						
						$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					if (empty($checkDay)) {
						
					}else{

					$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $enddate;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

					}

						$data1 = array();
						$data1 = array('leave_status' => 'Rejected','isGMCRM' => $status,'rejected_reason'=>$rejected_reason);
					} else {

						$data1 = array();
						$data1 = array('isGMCRM' => $status, 'leave_status' => $status);
					}
			

			$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
					echo "Successfully Approved";
				
			} 
		} else {

			if ($em_gender == 'Male' && $leavetype == 'Maternity Leave') {
				echo 'Martenity Leave is for Female Employee';
			} elseif ($em_gender == 'Female' && $leavetype == 'Paternity Leave') {
				echo 'Paternity Leave is for Male Employee';
			}elseif ($this->leave_model->Does_leaveNotApprove_exists($emid)) {
				echo 'Please wait you have a leave in process';
			} elseif ($this->leave_model->Does_leaveApprove_exists($emid)) {
				echo 'Please wait until leave Complete';
			} elseif (empty($leaveID) && $this->leave_model->Does_leaveRejected_exists($emid)) {
				echo 'Please review your rejected leave for correction';
			}elseif ($leavetype == 'Annual Leave' || $leavetype == 'Compassionate Leave' || $leavetype == 'Sick Leave') {
				if (date('m') >= 07) {
					$year = date('Y')+1;
				} else {
					$year = date('Y');
				}
				
				$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
				if (empty($checkDay)) {

					$data1 = array();
					$data1 = array('emp_id'=>$emid,'day'=>28,'dateyear'=>$year);
					$this->leave_model->insert_assign_leave($data1);

					$checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay1->day - $enddate;

					$update = array();
				    $update = array('day'=>$diff);

				    $id =  $checkDay1->id;
				    $this->leave_model->updateDay($id,$update);

					if ($diff >= 0) {

					$data = array();
				    $data = array(
					'em_id' => $emid,
					'des_name'=>$get1->des_name,
					'start_date' => $startdate,
					'end_date' => $enddate1,
					'apply_date' => date('Y-m-d'),
					'reason' => $reason,
					'leave_status' => 'Not Approve',
					'region_from' => $region_from,
					'region_to' => $region_to,
					'district_to' => $district_to,
					'village_to' => $village_to,
					'typeid' => $typeid,
					'leave_duration' => $leave_duration,
					'fare_amount' => $amount1,
					'faredistrictvillage'=>$amount2
				);
				$success = $this->leave_model->Application_Apply($data);
				//$this->leave_model->sendsms($mobile,$sms);
				echo "Successfully Added";

					}
					
				}else{

					$checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay1->day - $enddate;
					   
					if ($diff >= 0) {
						
					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay1->id;
				    $this->leave_model->updateDay($id,$update);

				    $data = array();
				    $data = array(
					'em_id' => $emid,
					'des_name'=>$get1->des_name,
					'start_date' => $startdate,
					'end_date' => $enddate1,
					'apply_date' => date('Y-m-d'),
					'reason' => $reason,
					'leave_status' => 'Not Approve',
					'region_from' => $region_from,
					'region_to' => $region_to,
					'district_to' => $district_to,
					'village_to' => $village_to,
					'typeid' => $typeid,
					'leave_duration' => $leave_duration,
					'fare_amount' => $amount1,
					'faredistrictvillage'=>$amount2
				);
				$success = $this->leave_model->Application_Apply($data);
				//$this->leave_model->sendsms($mobile,$sms);
				echo "Successfully Added";
					}else{

						echo "You Live Balance is".' '.$checkDay1->day;
					}

				}
				
			}else {

				$data = array();
				$data = array(
					'em_id' => $emid,
					'des_name'=>$get1->des_name,
					'start_date' => $startdate,
					'end_date' => $enddate1,
					'apply_date' => date('Y-m-d'),
					'reason' => $reason,
					'leave_status' => 'Not Approve',
					'region_from' => $region_from,
					'region_to' => $region_to,
					'district_to' => $district_to,
					'village_to' => $village_to,
					'typeid' => $typeid,
					'leave_duration' => $leave_duration,
					'fare_amount' => $amount1,
					'faredistrictvillage'=>$amount2
				);
				$success = $this->leave_model->Application_Apply($data);
				//$this->leave_model->sendsms($mobile,$sms);
				echo "Successfully Added";
				
			}

		}

	}

    public function Rejected_Leave()
    {
		$emid = base64_decode($this->input->get('I'));
		$id = base64_decode($this->input->get('E'));

		$data['employee']  = $this->leave_model->GetLeaveApplyById($id);
		$data['family']    = $this->leave_model->GetFamilys($emid);
		$data['application'] = $this->leave_model->AllLeaveAPPlication();
		$data['regionlist']  = $this->employee_model->regselect();
		$data['leavetypes'] = $this->leave_model->GetleavetypeInfo();

        $this->load->view('backend/rejected_leave', $data);
    }
    public function Edit_Application()
	{
		if($this->session->userdata('user_login_access') != False) {

			$em_gender = $this->input->post('em_gender');
			$typeid = $this->input->post('leave_type');
			$emid = $this->input->post('em_id');
			$em_code = $this->input->post('em_code');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$day = $this->input->post('day');
			$region_to = $this->input->post('region_to');
			$district_to = $this->input->post('district_to');
			$village_to = $this->input->post('village_to');
			$reason = $this->input->post('reason');
			$region_from = $this->input->post('region_from');
			$leaveID = $this->input->post('leave_id');
			$status = $this->input->post('status');
			$amount1 = $this->input->post('amount');
			$amount2 = $this->input->post('amount2');
			$year = date('Y');
			$rejected_reason = $this->input->post('rejected_reason');

			$startdate1 = new DateTime($startdate);
			//$enddate1 = new DateTime($enddate);
			$leave_duration = $enddate;//$enddate1->diff($startdate1)->format('%a');

			$this->form_validation->set_rules('leave_type', 'Select Leave Type', 'required');
			$this->form_validation->set_rules('region_to', 'Region To', 'required');

			$leaveById = $this->leave_model->GetLeaveType($typeid);
			$leavetype = $leaveById->name;
			$id = $leaveID;
			$lstatus = $this->leave_model->GetLeaveApplyByIDs($id);

			$date = $startdate;
			$days = $enddate;
    		$enddate1 =  date('Y-m-d', strtotime($date. ' +'.$days.' days'));

    		$get= $this->leave_model->getdesignation1($emid);
    		$des_id = $get->des_id;

    		$get1= $this->leave_model->getdesignation2($des_id);

    		if ($leavetype == 'Annual Leave' || $leavetype == 'Compassionate Leave' || $leavetype == 'Sick Leave') {

    			$checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay->day + $day;

					$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay->id;
				    $this->leave_model->updateDay($id,$update);

				    $checkDay2 = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff1 = $checkDay2->day - $enddate;

					$update = array();
				    $update = array('day'=>$diff1);
				    $id =  $checkDay2->id;
				    $this->leave_model->updateDay($id,$update);
    		}

    		$data1 = array();
				$data1 = array(
					'em_id' => $emid,
					'des_name'=>$get1->des_name,
					'start_date' => $startdate,
					'end_date' => $enddate1,
					'apply_date' => date('Y-m-d'),
					'reason' => $reason,
					'region_from' => $region_from,
					'region_to' => $region_to,
					'district_to' => $district_to,
					'village_to' => $village_to,
					'typeid' => $typeid,
					'leave_duration' => $leave_duration,
					'fare_amount' => $amount1,
					'faredistrictvillage'=>$amount2
				);


				$success = $this->leave_model->Application_Apply_Update1($leaveID, $data1);
				echo "Successfully Updated";
		}else{

			redirect(base_url(),'refresh');
		}
	}
	public function Leave_Bank()
	{
		if($this->session->userdata('user_login_access') != False) {

			$isPMG = $this->input->get('isPMG');
			$isACC = $this->input->get('isACC');

			$data['imprestList'] = $this->leave_model->getLeaveToBank($isPMG,$isACC);


			$this->load->library('Pdf');
			$html= $this->load->view('backend/leave_bank_sheet',$data,TRUE);
			$this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			$this->dompdf->stream('example.pdf', array("Attachment"=>0));

			// foreach ($data['imprestList']->id_is as  $value) {

			// 	$id_receive = $data['imprestList']->id_is;
			// 	$data = array();
			// 	$data = array('date2' =>date('Y-m-d'),'status'=>'Yes');
			// 	$success = $this->employee_model->Update_Receivable($id_receive,$data);

			// }
			//$this->load->view('backend/leave_bank_sheet',$data);
		}
	}

	public function batch_to_bank()
	{
		if($this->session->userdata('user_login_access') != False) {
			$batchNo = $this->input->get('batchno');

			 $data['batch'] = $this->leave_model->getBatchToBank($batchNo);
			 $data['batchNo1'] = $batchNo;
			 $data['approver'] = $this->leave_model->getApprover($batchNo);
			 $data['sum'] = $this->leave_model->getSum($batchNo);
			 $data['sum2'] = $this->leave_model->getSum2($batchNo);

			 $this->load->library('Pdf');
			 $html= $this->load->view('backend/batch-to_bank_sheet',$data,TRUE);
			 $this->load->library('Pdf');
			 $this->dompdf->loadHtml($html);
			 $this->dompdf->setPaper('A4','potrait');
			 $this->dompdf->render();
			 $this->dompdf->stream( $batchNo, array("Attachment"=>0));

			
		}
	}
	public function update_status(){
		if($this->session->userdata('user_login_access') != False) {

			$id = $this->input->post('leaveId');

			$update = array();
			$update = array('leave_status'=>'Complete');
			$success = $this->leave_model->Update_Leave_Status($id,$update);
			
			echo 'Successfully Updated';
		}else{
			redirect(base_url(), 'refresh');
		}
	}
	public function Save_Batch(){
		if($this->session->userdata('user_login_access') != False) {

		$batchNo = "Batch".rand(1000,2000);
		$leaveid = $this->input->post('I');
		$emid = $this->session->userdata('user_login_id');
		$batch = array();
        $batch = array('batch_no'=>$batchNo,'batch_date'=>date('Y-m-d'),'em_id'=>$emid);
        $this->leave_model->SaveBatch($batch);

		for ($i=0; $i <@sizeof($leaveid) ; $i++) { 

		$id = $leaveid[$i];
		$getLeave = $this->leave_model->getLeaveDetails($id);

		$data = array();
		$data = array('HRtoCRM'=>'Yes','batchNumber'=>$batchNo);
		$this->leave_model->Update_Leave_StatusHRtoCRM($id,$data);

		$datas = array();
				$datas = array(
					'em_id' => $getLeave->em_id,
					'leave_id'=>$getLeave->id,
					'typeid'=>$getLeave->typeid,
					'des_name'=>$getLeave->des_name,
					'start_date' => $getLeave->start_date,
					'end_date' => $getLeave->end_date,
					'apply_date' =>$getLeave->apply_date,
					'leave_status' =>$getLeave->leave_status,
					'region_from' =>$getLeave->region_from,
					'region_to' => $getLeave->region_to,
					'district_to' => $getLeave->district_to,
					'village_to' => $getLeave->village_to,
					'leave_duration' => $getLeave->leave_duration,
					'fare_amount' => $getLeave->fare_amount,
					'faredistrictvillage'=>$getLeave->faredistrictvillage,
					'HRtoCRM'=>'Yes',
					'batchNo'=>$batchNo
				);
		$this->leave_model->SaveBatchHRtoCRM($datas);
		echo "Successfully Batch Transfer To GMCRM";
		}
		}else{
			redirect(base_url(), 'refresh');
		}
	}

	public function show_batch(){
		if($this->session->userdata('user_login_access') != False) {

		 $data['batch'] = $this->leave_model->getBatch();
		 $this->load->view('backend/show_batch', $data);
			
		}else{
			redirect(base_url(), 'refresh');
		}
	}
	public function show_leave_batch(){
		if($this->session->userdata('user_login_access') != False) {

		 $batchNo = $this->input->get('batch');
		 $data['no'] =  $this->input->get('batch');
		 $data['batchNo'] = $this->leave_model->getLeaveBatch($batchNo);
		 $this->load->view('backend/show_leave_batch', $data);
			
		}else{
			redirect(base_url(), 'refresh');
		}
	}
	public function batch_status(){
		if($this->session->userdata('user_login_access') != False) {
			
			$batchNo = $this->input->post('batchNo');
			$emid = $this->session->userdata('user_login_id');
			$bid  = $this->input->post('I');
			$remove = $this->input->post('remove');
			$check = $this->leave_model->get_batch_status($batchNo);

			if (!empty($remove)) {

				if (!empty($bid)) {

				for ($i=0; $i <@sizeof($bid) ; $i++) { 

				$id = $bid[$i];
			 	$data = array();
				$data = array('batchNo'=>'NoBatch');
				$this->leave_model->Update_Batch_Remove($id,$data);

			    }
			    echo "Successfully Removed";
				} else {
					echo "Select Atleast One Leave";
				}
				
			} else {

			if ($this->session->userdata('user_type') == 'CRM') {
				
				if ($check->batch_status == "isHR") {

					$batch = array();
			 	    $batch = array('batch_status'=>'isCRM','em_id'=>$emid,'batch_no'=>$batchNo);
			 	    $this->leave_model->SaveBatch($batch);
			 	    echo "Successfully Batch Transfer To PMG";

				} else {
					echo "Already Approved";
				}
			 	
				
			 }elseif ($this->session->userdata('user_type') == 'PMG') {

				if ($check->batch_status == "isCRM") {

					$batch = array();
			 	    $batch = array('batch_status'=>'isPMG','em_id'=>$emid,'batch_no'=>$batchNo);
			 	    $this->leave_model->SaveBatch($batch);

			 	    echo "Successfully Batch Transfer To ACCOUNTANT";

				} else {
					echo "Already Approved";
				}
			 	

			 }elseif ($this->session->userdata('user_type') == 'ACCOUNTANT') {
				
			 	if ($check->batch_status == "isPMG") {

					$batch = array();
			 	    $batch = array('batch_status'=>'isACC','em_id'=>$emid,'batch_no'=>$batchNo);
			 	    $this->leave_model->SaveBatch($batch);

			 	    echo "Successfully Batch Transfer To PDF";

				} else {
					echo "Already Approved";
				}

			 }else{
			 	echo 'Your Not authorized to Access this page';
			 }
			
			}
			
			
			
			 
		}else{
			redirect(base_url(), 'refresh');
		}
	}

	public function Cancel_Leave(){
		if($this->session->userdata('user_login_access') != False) {

			$leaveid = $this->input->post('leaveId');
			$emid = $this->input->post('em_id');
			$days= $this->input->post('days');
			$year = date('Y');

			$checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
					$diff = $checkDay1->day + $days;

			$update = array();
				    $update = array('day'=>$diff);
				    $id =  $checkDay1->id;
				    $this->leave_model->updateDay($id,$update);

			$update1 = array();
			$update1 = array('leave_status'=>'Canceled');
			$success = $this->leave_model->Update_Leave_Status($leaveid,$update1);
			
			echo "Successfully Canceled";
		}else{
			redirect(base_url(), 'refresh');
		}
	}

	public function Leave_days(){
		if($this->session->userdata('user_login_access') != False) {

			$this->load->view('backend/update_days');

		}else{
			redirect(base_url(), 'refresh');
		}
	}

	public function Leave_days_action(){
		if($this->session->userdata('user_login_access') != False) {

			$pfno = $this->input->post('pfno');
			$days = $this->input->post('days');
			//$year = date('Y');

			$getemid = $this->leave_model->Search_Emid($pfno);
			$id = $getemid->em_id;

			if (date('m') >= 07) {
					$year = date('Y')+1;
				} else {
					$year = date('Y');
				}

			$data = array();
			$data = array('day'=>$days);
			$this->leave_model->updateLeaveDay($id,$data,$year);

			echo "Successfully Updated";

		}else{
			redirect(base_url(), 'refresh');
		}
	}
}
