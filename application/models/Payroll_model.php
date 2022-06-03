<?php

	class Payroll_model extends CI_Model{


	function __consturct(){
	parent::__construct();

	}
   

   public function GetsalaryValue($em_id){

        $sql = "SELECT * FROM `emp_salary`
        WHERE `emp_id`='$em_id' ORDER BY id DESC LIMIT 1";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;

      }

        public function get_kkportal_loan_process($fromdate,$todate,$status){
        $sql = "SELECT * from loan_process INNER JOIN employee ON employee.em_code=loan_process.pfno WHERE 
        loan_process.request_status='$status' AND DATE(loan_process.request_created_at) BETWEEN '$fromdate' AND '$todate'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        }

        public function get_single_loan_process_info($processid){
        $sql = "SELECT * from loan_process INNER JOIN employee ON employee.em_code=loan_process.pfno WHERE 
        loan_process.loan_process_id='$processid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
        }

        public function update_kkportal_loan_process($data,$processid){
        $this->db->where('loan_process_id',$processid);
        $this->db->update('loan_process',$data);
        }

        

      public function getAllSalaryPayedData_Slips00($month,$year){

      // $month = date('m');
      //       $dateObj   = DateTime::createFromFormat('!m', $month);
      //       $monthName = $dateObj->format('F');
      $sql = "SELECT `pay_salary`.`year`,`month`,`paid_date`,`net_payment`,`basic_payment`,`salary_scale`,
              `employee`.`first_name`,`last_name`,`em_code`,`des_id`,`dep_id`,`middle_name`,
              `emp_salary`.`id`,`emp_id`
              FROM `pay_salary`
              INNER JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              INNER JOIN `emp_salary` ON `emp_salary`.`emp_id`=`employee`.`em_id`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year` = '$year' AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`) ORDER BY `employee`.`em_code` ASC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }


      public function getPayedSalary0($em_code,$month,$year){
      $sql = "SELECT `pay_salary`.`year`,`month`,`paid_date`,`net_payment`,`basic_payment`,`salary_scale`,
             
              `emp_salary`.`id`,`emp_id`
              FROM `pay_salary`
              INNER JOIN `emp_salary` ON `emp_salary`.`emp_id`=`pay_salary`.`em_id`
      WHERE `pay_salary`.`em_id`='$em_code' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year` = '$year'
      AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`)
       LIMIT 1";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }

      public function getPayedSalary($em_code,$month,$year){
      $sql = "SELECT * FROM `pay_salary`
      WHERE `em_id`='$em_code' AND `month` = '$month' AND `year`='$year'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
   public function getTaxReliefs($salary_id,$id)
    {
      $sql = "SELECT * FROM `taxt_relief` WHERE `salaryId` = '$salary_id'AND `em_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getTaxRelief($salary_id)
    {
      $sql = "SELECT * FROM `taxt_relief` WHERE `salaryId` = '$salary_id'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
  public function Add_Salary($data){
      $this->db->insert('emp_salary',$data);
      }
      public function save_emplogs($data){
    $this->db->insert('emp_logs',$data);
  }

  public function Get_NontaxAddition($id){
      $sql = "SELECT *  FROM `non_tax_addition`
      WHERE `add_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }

    public function Get_taxAddition($id){
      $sql = "SELECT *  FROM `emp_addition`
      WHERE `add_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }



  public function save_paye_value($save){
        $this->db->insert('paye_per_region',$save);
    }
     public function update_pension_fund_contribution($PensionFs,$fund_id){
        $this->db->where('fund_id', $fund_id);
        $this->db->update('pension_fund_contribution',$PensionFs);
      }
      public function delete_pension_fund_contribution($fund_id){
        $this->db->delete('pension_fund_contribution',array('fund_id' => $fund_id ));
      }
    
  public function InsertPensionPermonth($PensionF){
        $result = $this->db->insert('pension_fund_contribution',$PensionF);
        return $result;
    }
    public function Get_Scale_Salary($scale_name){
          $sql    = "SELECT * FROM `em_salary_scale` WHERE `scale_name`='$scale_name'";
          $query  = $this->db->query($sql);

          foreach ($query->result() as $row) {
            $output .='<option value="'.$row->amount.'">'.$row->amount.'</option>';
          }
          return $output;
  }
   
    public function GetsalaryType(){
        $sql = "SELECT * FROM `salary_type` ORDER BY `salary_type` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function GetSalaryScalebyid($scaleId){
          $sql    = "SELECT * FROM `em_salary_scale`  WHERE `scaleId`='$scaleId'  ORDER BY `scaleId` DESC";
          $query  = $this->db->query($sql);
          $result = $query->row();
           return $result;
       }


     public function GetSalaryScale(){
          $sql    = "SELECT * FROM `em_salary_scale` ORDER BY `scaleId` DESC";
          $query  = $this->db->query($sql);
          $result = $query->result();
           return $result;
       }


  public function Insert_Salary_Scale($data){
      $this->db->insert('em_salary_scale',$data);
      }

       public function Add_Emp_Non_Percent($data){
      $this->db->insert('emp_non_percent_deduction',$data);
      }
  public function addTaxAdditionPErMonth($dataTaxA){
        $this->db->insert('emp_addition_permonth',$dataTaxA);
    }
  public function addNonTaxAdditionPErMonth($dataNonTaxA){
        $this->db->insert('emp_addition_permonth',$dataNonTaxA);
    }
  public function save_tax_relief($data){
        $result = $this->db->insert('taxt_relief',$data);
        return $result;
    }
  public function insertOthersDeductionData($dedu){
        $result = $this->db->insert('others_deduction',$dedu);
        return $result;
    }

    public function insertloans_deductionData($dedu){
      $result = $this->db->insert('loans_deduction',$dedu);
      return $result;
  }

  public function Add_Non_Tax_Addition($data){
      $this->db->insert('non_tax_addition',$data);
      }
  public function insertPensionFundContributionPermonth($pension){
        $this->db->insert('pension_funds',$pension);
    }
    public function insertPensionFundContributionPermonthContrubution($pension){
        $this->db->insert(' pension_fund_contribution',$pension);
    }
  public function Add_Emp_Fund($data){
      $this->db->insert('pension_funds',$data);
      }
  public function Add_Emp_Fund1($data){
      //$this->db->insert('pension_fund_contribution',$data);
      //$this->db->insert('emp_percent_deduction',$data);
      //$this->db->insert('pension_fund_contribution',$data);
      $this->db->insert('emp_addition',$data);
      }
   public function Add_Emp_Assuarance($data){
      $this->db->insert('assuarance_infor',$data);
      }
  public function InsertLoansDeduction($data){
        $this->db->insert('loans_deduction',$data);
    }
  public function insertPaidSalaryData($data){
        $result = $this->db->insert('pay_salary',$data);
        return $result;
    }
  public function insertNonPDeductioCommulative($dataNonP){
        $result = $this->db->insert('emp_non_percent_deduction_permonth',$dataNonP);
        return $result;
    }

     public function insertAssurance($Ass){
        $result = $this->db->insert('assurance_info_months',$Ass);
        return $result;
    }



          public function deleteloans($monthName){
              $this->db->delete('loans_deduction',array('month'=> $monthName));
          }
            public function deleteNonPercent($monthName){
              $this->db->delete('emp_non_percent_deduction_permonth',array('month'=> $monthName));
          }
            public function deletePercent($monthName){
              $this->db->delete('emp_percent_deduction_permonth',array('month'=> $monthName));
          }
            public function deletepension_fund_contribution($monthName){
              $this->db->delete('pension_fund_contribution',array('month'=> $monthName));
          }
            public function deleteemp_addition($monthName){
              $this->db->delete('emp_addition_permonth',array('month'=> $monthName));
          }
            public function deleteassurance($monthName){
              $this->db->delete('assurance_info_months',array('month'=> $monthName));
          }
            public function deletepaysalary($monthName){
              $this->db->delete('pay_salary',array('month'=> $monthName));
          }

           public function Delete_Salary_Scale($scaleId){
              $this->db->delete('em_salary_scale',array('scaleId'=> $scaleId));
          }

          



  public function Add_Others_Deduction($data){
      $this->db->insert('others_deduction',$data);
      }
      

      public function Salary_Scale_Update($scaleId,$data){
        $this->db->where('scaleId', $scaleId);
        $this->db->update('em_salary_scale',$data);
      }

        public function update_Others_Deductions($data,$others_id){
        $this->db->where('others_id', $others_id);
        $this->db->update('others_deduction',$data);
      }

  public function insertPDeductioCommulative($dataP){
        $result = $this->db->insert('emp_percent_deduction_permonth',$dataP);
        return $result;
    }
  public function Add_Emp_Percent($data){
      $this->db->insert('emp_percent_deduction',$data);
      }
    public function getTotalPDeductionAmount($id,$salary_id)
    {
      $sql = "SELECT SUM(ded_amount) as ded_amount FROM `emp_percent_deduction` WHERE `salary_id` = '$salary_id'AND `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function Get_OthersDeduction($id){
      $sql = "SELECT *  FROM `others_deduction`
      WHERE `others_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }

     public function Get_loans_deduction($salary_id,$em_id){
      $sql = "SELECT *  FROM `loans_deduction`
      WHERE `salary_id`='$salary_id' AND `em_id`='$em_id' ORDER BY `others_id` DESC";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }

    public function getOthersDeduction($salary_id){
    $sql = "SELECT * FROM `others_deduction` WHERE `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
    public function getTotalDeductionAmount($id,$salary_id)
    {
      $month  = date('M');
      $year  = date('Y');
      $sql = "SELECT SUM(installment_amount) as others_amount FROM `loans_deduction` 
      WHERE `salary_id` = '$salary_id'  
      AND `month` LIKE '%$month%' AND `year` = '$year'
      AND `em_id` = '$id' ORDER BY `others_id` DESC";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getTotalDeductionAmount2($id,$salary_id)
    {
      $month  = date('M');
      $year  = date('Y');
      $sql = "SELECT SUM(installment_amount) as others_amount FROM `others_deduction` 
      WHERE `salary_id` = '$salary_id' AND `status` = 'ACTIVE' 
      AND `month` LIKE '%$month%' AND `year` = '$year'
      AND `em_id` = '$id' ORDER BY `others_id` DESC";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function Get_BankInfo($id){
      $sql = "SELECT *  FROM `bank_info`
      WHERE `em_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }

     public function swiftcode($name){
      $sql = "SELECT *  FROM `bank_name`
      WHERE `bank_nanme`='$name'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
    public function getPercentDeduction($salary_id,$id)
    {
      $sql = "SELECT * FROM `emp_percent_deduction` WHERE `salary_id` = '$salary_id' AND `em_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getPensionDeduction($salary_id,$id)
    {
      $sql = "SELECT * FROM `pension_funds` WHERE `em_id` = '$id' AND `salary_id`= '$salary_id' LIMIT 1";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getPensionDeductionlist()
    {
      $sql = "SELECT * FROM `pension_funds` ";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getTotalNonPDeductionAmount($id,$salary_id)
    {
      $sql = "SELECT SUM(ded_amount) as ded_amount FROM `emp_non_percent_deduction` WHERE `salary_id` = '$salary_id' AND `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getTotalAdditionAmount($id,$salary_id)
    {

  
      $currentDateTime = date('Y-m-d H:i:s');
      $month  = date('m');
      $year  = date('Y');
//       $sql = "SELECT SUM(add_amount) as add_amount FROM `emp_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR  (`end_month` LIKE '0000-00-00 00:00:00' ))
//  OR (MONTH(`end_month`) >= '2' 
// AND YEAR(`end_month`) = '2021')  OR (YEAR(`end_month`) > '2021'))";

       $sql ="SELECT SUM(add_amount) as add_amount FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
         AND (
        (`end_month` >= '$currentDateTime')
         OR (`end_month` ='')
          OR  (`end_month` LIKE '0000-00-00 00:00:00' )
          OR (`end_month` IS NULL) 
        )";

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getTotalAdditionAmounts($monthName,$salary_id)
    {

      $month  = date('m');
      $year  = date('Y');
      $sql = "SELECT SUM(add_amount) as add_amount FROM `emp_addition_permonth` WHERE `salary_id` = '$salary_id' AND `month` = '$monthName'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
  public function getTotalNonTaxAdditionAmount($id,$salary_id)
    {
      $month  = date('m');
      $year  = date('Y');
      $sql = "SELECT SUM(add_amount) as add_amount FROM `non_tax_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id')AND (((`end_month` IS NULL) OR  (`end_month` LIKE '0000-00-00 00:00:00' ))
 OR (MONTH(`end_month`) >= '2' 
AND YEAR(`end_month`) = '2021')  OR (YEAR(`end_month`) > '2021'))
";

 //      $sql = "SELECT SUM(add_amount) as add_amount FROM `non_tax_addition` WHERE `salary_id` = '$salary_id'AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
 // OR (`end_month` =''))";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getTotalNonTaxAdditionAmounts($monthName,$salary_id)
    {

      $month  = date('m');
      $year  = date('Y');
      $sql = "SELECT SUM(add_amount) as add_amount FROM `emp_addition_permonth` WHERE `salary_id` = '$salary_id' AND `month` = '$monthName'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
public function getFundAmount($id)
    {
      $sql = "SELECT * FROM `pension_funds` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
public function getAssuarance($salary_id)
    {
      $sql = "SELECT * FROM `assuarance_infor` WHERE `salary_id` = '$salary_id' ORDER BY  `salary_id` DESC  LIMIT 1";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAssuarances($salary_id,$id)
    {
      $sql = "SELECT * FROM `assuarance_infor` WHERE `salary_id` = '$salary_id'  AND `em_id` = '$id' ORDER BY  `salary_id` DESC ";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAssuarance2($id)
    {
      $sql = "SELECT * FROM `assuarance_infor` WHERE `em_id` = '$id' ORDER BY  `em_id` DESC  ";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
public function getSalaryRecord($id,$year,$monthName){
      $sql = "SELECT * FROM `pay_salary`
              WHERE `em_id`='$id' AND `month`='$monthName' AND `year`='$year'";
      $query=$this->db->query($sql);
      $result = $query->row();
      return $result;
    }
   public function getIncrementByScale($salary_scale){
      $sql = "SELECT *  FROM `em_salary_scale`
      WHERE `scale_name`='$salary_scale'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function Get_SalaryID1($id){
      $sql = "SELECT * FROM `emp_salary`
      WHERE `emp_id`='$id'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function getAllSalaryPayedData(){

      $month = date('m');
            $dateObj   = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
      $sql = "SELECT `pay_salary`.*,
              `employee`.`first_name`,`last_name`,`em_code`,`des_id`,`dep_id`,`middle_name`,
              `emp_salary`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `emp_salary` ON `emp_salary`.`emp_id`=`employee`.`em_id`
              WHERE `pay_salary`.`month` = '$monthName' AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`) ORDER BY `employee`.`em_code` ASC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }
    public function get_pay_list_data($month,$year,$region){

    if ($region == "Zanzibar") {

      $sql = "SELECT `pay_salary`.*,`employee`.*,`emp_salary`.* FROM `pay_salary`  
              INNER JOIN `employee` ON `employee`.`em_id` = `pay_salary`.`em_id`
              INNER JOIN `emp_salary` ON `emp_salary`.`emp_id` = `pay_salary`.`em_id` 
              WHERE `employee`.`em_region` = '$region' AND `pay_salary`.`month` = '$month' 
              AND `pay_salary`.`year` = '$year' ORDER BY `employee`.`em_code` ASC";

    } else {

      $sql = "SELECT `pay_salary`.*,`employee`.*,`emp_salary`.* FROM `pay_salary`  
              INNER JOIN `employee` ON `employee`.`em_id` = `pay_salary`.`em_id`
              INNER JOIN `emp_salary` ON `emp_salary`.`emp_id` = `pay_salary`.`em_id` 
              WHERE `employee`.`em_region` != 'Zanzibar' AND `pay_salary`.`month` = '$month' 
              AND `pay_salary`.`year` = '$year' ORDER BY `employee`.`em_code` ASC";
    }
    
    
    $query  = $this->db->query($sql);
    $result = $query->result();
    return $result;
    }

     public function get_pay_data($month,$year,$region){

    if ($region == "Zanzibar") {

      $sql = "SELECT * FROM `paye_per_region` WHERE `region` = '$region' AND `month` = '$month' 
              AND `year` = '$year' ORDER BY `PFno` ASC";

    } else {

      $sql = "SELECT * FROM `paye_per_region` WHERE `region` != 'Zanzibar' AND `month` = '$month' 
              AND `year` = '$year' ORDER BY `PFno` ASC";
    }
    $query  = $this->db->query($sql);
    $result = $query->result();
    return $result;

    }
  public function Get_SalaryIDById($id){
      $sql = "SELECT *  FROM `emp_salary`
      WHERE `emp_id`='$id' ORDER BY id DESC LIMIT 1";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function getLastContribution($id)
    {
      $sql = "SELECT SUM(`fund_amount`) AS `amount` FROM `pension_fund_contribution` WHERE `em_id` = '$id'";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }
     public function getLastContributionAmountWithoutApril($fund_id,$id, $aprilid)
    {
      $sql = "SELECT SUM(`fund_amount`) AS `amount` FROM `pension_fund_contribution` WHERE `em_id` = '$id'
      AND `fund_id` <= '$fund_id'  AND `fund_id` != '$aprilid'";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }
    public function getLastContributionAmount($fund_id,$id, $aprilid)
    {
      $sql = "SELECT SUM(`fund_amount`) AS `amount` FROM `pension_fund_contribution` WHERE `em_id` = '$id'
      AND `fund_id` <= '$fund_id'  ";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }

    public function getAprilContributionAmount($id)
    {
      $sql = "SELECT SUM(`fund_amount`) AS `amount`,`fund_id` FROM `pension_fund_contribution` WHERE `em_id` = '$id' 
              AND `month` = 'April' AND `year` = '2020' ORDER BY `fund_id` DESC LIMIT 1";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }

    public function getSumpensionFundtotalpreviousyear($month,$year,$id)
    {
      $sql = "SELECT SUM(`fund_amount`) AS `amount`,`fund_id` FROM `pension_fund_contribution` WHERE `em_id` = '$id' 
      AND (`year` < '$year' ) ORDER BY `fund_id` DESC LIMIT 1";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }


    public function getSumpensionFundtotalcurrentyear($month,$year,$id)
    {
      $nmonths = date('m',strtotime($month));
      $sql = "SELECT SUM(`fund_amount`) AS `amount`,`fund_id` FROM `pension_fund_contribution` WHERE `em_id` = '$id' 
              AND  (month(str_to_date(`month`,'%M')) <= '$nmonths') AND `year` = '$year' ORDER BY `fund_id` DESC LIMIT 1";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }




 public function getAprilContributionAmountlist($id)
    {
      $sql = "SELECT `fund_id` FROM `pension_fund_contribution` WHERE `em_id` = '$id' 
              AND `month` = 'April' AND `year` = '2020' ORDER BY `fund_id` DESC ";

        $query=$this->db->query($sql);
       $result = $query->result();
      return $result;
    }

    public function getLastContributionid($month,$year,$id)
    {
      $sql = "SELECT `fund_id` FROM `pension_fund_contribution` WHERE `em_id` = '$id' 
              AND `month` = '$month' AND `year` = '$year' ORDER BY `fund_id` DESC LIMIT 1";

        $query=$this->db->query($sql);
       $result = $query->row();
      return $result;
    }

  public function Get_SalaryID($id){
      $sql = "SELECT `emp_salary`.*
      FROM `emp_salary`
      WHERE `emp_salary`.`emp_id`='$id' ORDER BY `emp_salary`.`id` DESC LIMIT 1";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function Others_Employee_Deductions($salary_id,$id){
    $currentMonth = date('F');
    $month=Date('M', strtotime($currentMonth . " last month"));
    $year=date("Y");
    $sql = "SELECT * FROM `others_deduction` WHERE `salary_id` = '$salary_id' 
     AND `em_id` = '$id' AND `status` != 'COMPLETE'
    AND `other_names` != 'CEASE EMERGENCY LOAN' 
    AND `other_names` != 'CEASE KK LOAN'
     ORDER BY `others_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function Others_Employee_Deduction($salary_id,$id){
    $currentMonth = date('F');
    $month=Date('M', strtotime($currentMonth . " last month"));
    $year=date("Y");
    $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salary_id' 
     AND `em_id` = '$id' AND `status` != 'COMPLETE' 
     AND `month` LIKE '%$month%' AND `year` = '$year'
     ORDER BY `others_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function Others_Employee_Deduction_Permonth($installmentName,$salary_id){
    $currentMonth = date('F');
    $month=Date('M', strtotime($currentMonth . " last month"));
    $year=date("Y");
    // if($month == 'Dec'){
    //   $year=$year - 1;
    // }

    $sql = "SELECT * FROM `loans_deduction` WHERE `other_names` LIKE '%$installmentName%' 
     AND `salary_id` = '$salary_id'  
     AND `month` LIKE '%$month%' AND `year` = '$year'
     AND `status` != 'COMPLETE'
     ORDER BY `others_id` DESC  LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
  }
  public function getSumNonTaxDeduction($ded_name,$month,$year,$salary_id)
    {
      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `year` = '$year' AND `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getSumTaxDeductionS($ded_name,$month,$year,$salary_id)
    {
      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `year` = '$year' AND `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

      public function getSumTaxDeduction($ded_name,$month,$year,$salary_id)
    {
      //$month = date('m');
      $yearnow  = date('Y');
      // $nmonth = date('m',strtotime($month));
      // $dateofs=$year.'-'.$nmonth.'-29';

      // $dateof=$year.'-'.$month.'-29';
      // $dateoftim= date('Y-m-d', strtotime($dateof));
      // $currentDateTime = date('Y-m-d H:i:s');

      // $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `year` = '$year' AND `salary_id` = '$salary_id' AND (`year` <= '$year' AND  ((month(str_to_date(`month`,'%M')) <= $month)OR (month(str_to_date(`month`,'%b')) <= $+
      //   month))) ";
      //date_format(str_to_date(concat(2012, 'FEB'), '%Y%b'), '%m')
     //$monthNumeric=date_format(str_to_date(concat($year, $month), '%Y%M'),'%m');
     $monthNumeric = date("m", strtotime($month.'-'.$year));

       $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_percent_deduction_permonth` WHERE `ded_name` = '$ded_name'  AND `salary_id` = '$salary_id' AND (`year` <= '$year') ";
       if($yearnow == $year) $sql .= " AND date_format(str_to_date( `month`, '%M'),'%m') <= '$monthNumeric'";

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getSumNonTaxDeductiontotal($ded_name,$id,$months,$year)
    {
      //$month = month(str_to_date('$months','%b'));//%M ///
      //$month = STRING_TO_DATE('$months','%M');
      $nmonth = date('m',strtotime($months));

      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' AND (`year` <= '$year' AND  ((month(str_to_date(`month`,'%M')) <= $nmonth)
        OR (month(str_to_date(`month`,'%b')) <= $nmonth)))";

// $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' AND (`year` <= '$year' AND  ((month(str_to_date(`month`,'%M')) <= $nmonth)
// OR (month(str_to_date(`month`,'%b')) <= $nmonth)))";


       // $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' AND (`year` <= '$year' AND  (month(str_to_date(`month`,'%M')) <= $nmonth))";

       // $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' ";

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getSumNonTaxDeductiontotalcurrentyear($ded_name,$id,$months,$year)
    {
      $nmonths = date('m',strtotime($months));
      //,concat_ws('/', `year`, `month`) AS `datemont`

      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' 
      AND `em_id` = '$id'  AND  (month(str_to_date(`month`,'%M')) <= '$nmonths') AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getSumNonTaxDeductiontotalpreviousyear($ded_name,$id,$months,$year)
    {
      $nmonth = date('m',strtotime($months));

      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' AND (`year` < '$year' )";

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getSumNonTaxDeductiontotalS($ded_name,$id)
    {
      $sql = "SELECT SUM(`ded_amount`) AS `ded_amount` FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$ded_name' AND `em_id` = '$id' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
  public function getPDeduction($id){
    $sql = "SELECT * FROM `emp_percent_deduction` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getNonPDeduction($salary_id){
    $sql = "SELECT * FROM `emp_non_percent_deduction` WHERE `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

   public function getNonPDeductions($id,$salary_id){
    $sql = "SELECT * FROM `emp_non_percent_deduction` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' AND  `ded_name` !='AFRICAN LIFE ASSURANCE'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }



  public function getTaxAdditionss($id,$salary_id){

    $month = date('m');
    $year  = date('Y');
      $currentDateTime = date('Y-m-d H:i:s');
    $sql ="SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
    AND (   `end_month` >= '$currentDateTime' OR  (`end_month` LIKE '0000-00-00 00:00:00' ) OR `end_month` IS NULL  
        )
     ";//   OR  (`end_month` LIKE '0000-00-00 00:00:00' )  (`end_month` IS NULL) OR  OR `end_month` =''

    //$sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
 // $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getTaxAdditionssss($id,$salary_id,$month,$year){

    //$month = date('m');
    //$year  = date('Y');
    $nmonth = date('m',strtotime($month));
    $dateofs=$year.'-'.$nmonth.'-29';

    $dateof=$year.'-'.$month.'-29';
    $dateoftim= date('Y-m-d', strtotime($dateof));

      
      $currentDateTime = date('Y-m-d H:i:s');
    $sql ="SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
    AND (   `end_month` >= '$currentDateTime' OR  (`end_month` LIKE '0000-00-00 00:00:00' ) OR `end_month` IS NULL  
        OR (
          -- (MONTH(`end_month`) = $month && YEAR(`end_month`) = $year )
           DATE('$dateoftim') BETWEEN `start_month` AND `end_month`
          ))";
           //   OR  (`end_month` LIKE '0000-00-00 00:00:00' )  (`end_month` IS NULL) OR  OR `end_month` =''

    //$sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
 // $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getTaxAdditionsss($id,$salary_id,$month,$year){

    //$month = date('m');
    //$year  = date('Y');
    $nmonth = date('m',strtotime($month));
    $dateofs=$year.'-'.$nmonth.'-29';

    $dateof=$year.'-'.$month.'-29';
    $dateoftim= date('Y-m-d', strtotime($dateof));

      
      $currentDateTime = date('Y-m-d H:i:s');
    $sql ="SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
    AND (   `start_month` <= '$dateoftim' OR  (`end_month` LIKE '0000-00-00 00:00:00' ) OR `end_month` IS NULL  
        OR (
          -- (MONTH(`end_month`) = $month && YEAR(`end_month`) = $year )
           DATE('$dateoftim') BETWEEN `start_month` AND `end_month`
          ))";
           //   OR  (`end_month` LIKE '0000-00-00 00:00:00' )  (`end_month` IS NULL) OR  OR `end_month` =''

    //$sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
 // $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }




  public function getNonTaxAdditionssmonth($id,$salary_id,$month_number){
        $month = date('m');
        $year  = date('Y');
          $currentDateTime = date('Y-m-d H:i:s');
          $currentDateTime = date($year.'-'.$month_number.'-28');

        $sql ="SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
    AND (   `end_month` >= '$currentDateTime' OR  (`end_month` LIKE '0000-00-00 00:00:00' ) OR `end_month` IS NULL  
        )
     ";//   OR  (`end_month` LIKE '0000-00-00 00:00:00' )  (`end_month` IS NULL) OR  OR `end_month` =''

       // $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
  $this->db->query("SET sql_mode = '' ");
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

       public function getNonTaxAdditionss($id,$salary_id){
        $month = date('m');
        $year  = date('Y');
          $currentDateTime = date('Y-m-d H:i:s');

        $sql ="SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
    AND (   `end_month` >= '$currentDateTime' OR  (`end_month` LIKE '0000-00-00 00:00:00' ) OR `end_month` IS NULL  
        )
     ";//   OR  (`end_month` LIKE '0000-00-00 00:00:00' )  (`end_month` IS NULL) OR  OR `end_month` =''

       // $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
  $this->db->query("SET sql_mode = '' ");
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

 public function getTaxAddition($id,$salary_id){

    $month = date('m');
    $year  = date('Y');
 //    $sql ="SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
 // AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
 // OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year'))
 // OR (`end_month` ='')
 //  OR (`end_month` IS NULL) )";
    $sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
    $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getTaxAdditions($id,$salary_id){

    $month = date('m');
    $year  = date('Y');
 //    $sql ="SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
 // AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
 // OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year'))
 // OR (`end_month` ='')
 //  OR (`end_month` IS NULL) )";
    $sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
  $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getNonTaxAddition($id,$salary_id){
        $month = date('m');
        $year  = date('Y');
//        SELECT * FROM `non_tax_addition` WHERE `salary_id` = '1427' 
// AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
// OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year')))        `end_month` IS NULL  `end_month` =''

 //        $sql ="SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
 // AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
 // OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year'))
 // OR (`end_month` ='')
 //  OR (`end_month` IS NULL) )";

        $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
  $this->db->query("SET sql_mode = '' ");
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

       public function getNonTaxAdditions($id,$salary_id){
        $month = date('m');
        $year  = date('Y');
//        SELECT * FROM `non_tax_addition` WHERE `salary_id` = '1427' 
// AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
// OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year')))        `end_month` IS NULL  `end_month` =''

 //        $sql ="SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id` = '$salary_id' 
 // AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
 // OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year'))
 // OR (`end_month` ='')
 //  OR (`end_month` IS NULL) )";

        $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
  $this->db->query("SET sql_mode = '' ");
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }


   public function getTaxAddition000($id,$salary_id){
    $month = date('m');
    $year  = date('Y');

    $sql = "SELECT * FROM `emp_addition` WHERE (`em_id` LIKE '$id' AND  `salary_id` = '$salary_id')AND (((`end_month` IS NULL) OR  (`end_month` LIKE '0000-00-00 00:00:00' ))
 OR (MONTH(`end_month`) >= '2' 
AND YEAR(`end_month`) = '2021')  OR (YEAR(`end_month`) > '2021'))
";


    //$sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
       $this->db->query("SET sql_mode = '' ");
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

   public function getTaxAdditions000($id,$salary_id){
    $month = date('m');
    $year  = date('Y');

    $sql = "SELECT * FROM `emp_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR  (`end_month` LIKE '0000-00-00 00:00:00' ))
 OR (MONTH(`end_month`) >= '2' 
AND YEAR(`end_month`) = '2021')  OR (YEAR(`end_month`) > '2021'))
 ";

        $this->db->query("SET sql_mode = '' ");

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getNonTaxAddition000($id,$salary_id){
        $month = date('m');
        $year  = date('Y');
         $sql = "SELECT * FROM `non_tax_addition` WHERE  (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR  (`end_month` LIKE '0000-00-00 00:00:00' ))
 OR (MONTH(`end_month`) >= '2' 
AND YEAR(`end_month`) = '2021')  OR (YEAR(`end_month`) > '2021'))
";
      

        // $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id' AND `end_month` < date()";
         $this->db->query("SET sql_mode = '' ");
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function getPensionFund($id){
        $sql = "SELECT * FROM `pension_funds`
        WHERE  `em_id` = '$id'";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function Get_Paid_Salary($id,$month,$year){
      $sql = "SELECT `emp_salary`.*,
      `employee`.*,
      `pay_salary`.*
      FROM `emp_salary`
      -- LEFT JOIN `addition` ON `emp_salary`.`id`=`addition`.`salary_id`
      -- LEFT JOIN `deduction` ON `emp_salary`.`id`=`deduction`.`salary_id`
      INNER JOIN `employee` ON `emp_salary`.`emp_id`=`employee`.`em_id`
      INNER JOIN `pay_salary` ON `pay_salary`.`em_id`=`emp_salary`.`emp_id`
      WHERE `pay_salary`.`em_id`='$id' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function getTaxAddition1($id,$month,$year){

    $month = date('m');
    $year  = date('Y');
    $sql = "SELECT * FROM `emp_addition_permonth` WHERE `em_id` = '$id' AND `month`='$month' AND `year`='$year'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getAdditional($id,$month,$year){
    $sql = "SELECT * FROM `emp_addition_permonth` WHERE `em_id` = '$id' AND `month` = '$month' AND `year` = '$year' GROUP BY `add_name`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getNonTaxDeduction1($salary_id,$month,$year,$id){
    $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salary_id' AND `em_id` = '$id' AND `month` = '$month' AND `year` = '$year' GROUP BY `ded_name`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getTaxDeduction1($salary_id,$id,$month,$year){
    $sql = "SELECT * FROM `emp_percent_deduction_permonth` WHERE `salary_id` = '$salary_id' AND `month` = '$month' AND `em_id` = '$id' AND `year` = '$year' GROUP BY `ded_name`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getLoanDeduction2($salary_id,$month,$year){
    $sql = "SELECT * FROM `loans_deduction` WHERE `others_id` IN( SELECT MAX(`others_id`) FROM `loans_deduction` WHERE `salary_id` = '$salary_id' AND `month`='$month' AND `year` = '$year' GROUP BY `other_names`)";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }

   public function getLoanDeduction21($salary_id,$month,$year,$id){  // 
    $sql = "SELECT * FROM `loans_deduction` WHERE `others_id` IN( SELECT MAX(`others_id`) FROM `loans_deduction` WHERE `salary_id` = '$salary_id' AND `em_id`='$id' AND `status`!='COMPLETE'   AND `month`='$month'  AND `year` = '$year' GROUP BY `other_names`)";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }

   public function getLoanDeduction211($salary_id,$month,$year,$id){  // 

    $month=Date('M', strtotime($month));
    $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salary_id'
     AND `em_id`='$id' 
     AND `other_names` != 'CEASE KK LOAN'
     AND `other_names` != 'CEASE SAVINGS'
     AND `other_names` != 'CEASE EMERGENCY LOAN'
      AND `month` LIKE '%$month%'  AND `year` = '$year' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }


  public function getLoanDeduction($id){
    $sql = "SELECT * FROM `others_deduction` WHERE `em_id` = '$id'
    AND `status` LIKE '%ACTIVE%'
    AND `other_names` != 'KK EMERGENCY LOAN' AND `other_names` != 'CEASE EMERGENCY LOAN' 
    AND `other_names` != 'CEASE KK LOAN'";
       $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }

  
  public function getLoanDeduction2222($id){
    $sql = "SELECT * FROM `loans_deduction` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }
 

    public function GetCommulativePension($id){
        $sql = "SELECT SUM(`fund_amount`) AS fund_amount,`fund_name`,`fund_id`  FROM `pension_fund_contribution`   WHERE  `em_id` = '$id'
      GROUP BY  `fund_name`  ";// AND `fund_id` = ( SELECT MAX(`fund_id`) `fund_id` IN( SELECT MAX(`fund_id`)
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

      public function GetCommulativePensions($id){
        $sql = "SELECT SUM(`fund_amount`) AS fund_amount,`fund_name`,`fund_id`  FROM `pension_fund_contribution`   WHERE  `em_id` = '$id'
       AND `fund_name` = 'PSSSF' GROUP BY  `fund_name`  ";// AND `fund_id` = ( SELECT MAX(`fund_id`) `fund_id` IN( SELECT MAX(`fund_id`)
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }


       public function GetCommulativePensionPssf($id){
        $sql = "SELECT SUM(`fund_amount`) AS fund_amount,`fund_name`,`fund_id`  FROM `pension_fund_contribution`   WHERE  `em_id` = '$id'
        GROUP BY  `fund_name` LIMIT 1 ";// AND `fund_id` = ( SELECT MAX(`fund_id`) `fund_id` IN( SELECT MAX(`fund_id`)
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
      }

  public function GetCommulativePension0($id){
        $sql = "SELECT MAX(`fund_amount`) AS fund_amount,`fund_name`,`fund_id`  FROM `pension_fund_contribution`   WHERE  `em_id` = '$id'
      GROUP BY  `fund_name`  ";// AND `fund_id` = ( SELECT MAX(`fund_id`) `fund_id` IN( SELECT MAX(`fund_id`)
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function GetCommulative($id){
        $sql = "SELECT SUM(`ded_amount`) AS ded_amount,`ded_name`,`ded_id`,`ded_name`  FROM `emp_non_percent_deduction_permonth`   WHERE  `em_id` = '$id'
      GROUP BY  `ded_name`  "; //AND `ded_id` = ( SELECT MAX(`ded_id`)   `ded_id` IN( SELECT MAX(`ded_id`)
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

      public function GetCommulative0($id){
        $sql = "SELECT MAX(`ded_amount`) AS ded_amount,`ded_name`,`ded_id`,`ded_name`  FROM `emp_non_percent_deduction_permonth`   WHERE  `em_id` = '$id'
      GROUP BY  `ded_name`  "; //AND `ded_id` = ( SELECT MAX(`ded_id`)   `ded_id` IN( SELECT MAX(`ded_id`)
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }

  public function getAllSalaryData(){
      $sql = "SELECT `emp_salary`.*,
              `employee`.*
              FROM `emp_salary`
              LEFT JOIN `employee` ON `emp_salary`.`emp_id`=`employee`.`em_id`
              WHERE `employee`.`status` = 'ACTIVE' AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`) ORDER BY `employee`.`em_code` ASC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }

    public function getAllSalaryDataID(){
      $sql = "SELECT `employee`.em_id
              FROM `emp_salary`
              LEFT JOIN `employee` ON `emp_salary`.`emp_id`=`employee`.`em_id`
              WHERE `employee`.`status` = 'ACTIVE' AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`) ORDER BY `employee`.`em_code` ASC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }
  public function commulative_value($id){
    $sql = "SELECT * FROM `emp_non_percent_deduction` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getBankInfo($id){
    $sql = "SELECT * FROM `bank_info` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

  }
  public function getTaxDeduction($id){
    $sql = "SELECT * FROM `emp_percent_deduction` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getTradeUnion($id){
        $sql = "SELECT * FROM `emp_non_percent_deduction`
        WHERE  (`ded_name`='COTWU(T)' OR `ded_name`='TEWUTA') AND `em_id` = '$id'";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function getAfricaAssurance($id){
        $sql = "SELECT * FROM `assuarance_infor`
        WHERE `em_id` = '$id' ORDER BY assur_id DESC ";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function Add_Emp_Addition($data){
      $this->db->insert('emp_addition',$data);
      }

  public function Delete_Emp_Addition($addid){
        $this->db->delete('emp_addition',array('add_id'=> $addid));
      }
  public function Delete_Pension_Fund($emid){
        $this->db->delete('pension_funds',array('em_id'=> $emid));
      }
  public function remove_commulative($id){
        $this->db->delete('emp_non_percent_deduction_permonth',array('ded_id' => $id ));
      }
  public function remove_commulative_psssf($id){
        $this->db->delete('pension_fund_contribution',array('fund_id' => $id ));
      }
  public function Delete_Emp_Non_Percent($dedid){
        $this->db->delete('emp_non_percent_deduction',array('ded_id'=> $dedid));
      }
  public function Delete_Non_Tax_Addition($addid){
        $this->db->delete('non_tax_addition',array('add_id'=> $addid));
      }
  public function delete_tax_relief($trid){
        $this->db->delete('taxt_relief',array('tr_id' => $trid ));
      }
  public function Delete_Emp_Assuarance($assId){
        $this->db->delete('assuarance_infor',array('assur_id'=> $assId));
      }
   public function Delete_emp_percent_deduction($dedid){
        $this->db->delete('emp_percent_deduction',array('ded_id'=> $dedid));
      }
  public function Delete_others_deduction_permonth($id){
        $this->db->delete('others_deduction',array('others_id'=> $id));
      }
  public function getNonTaxDeduction($id){
    $sql = "SELECT * FROM `emp_non_percent_deduction` WHERE `em_id` = '$id' AND `ded_name`!='TEWUTA' AND `ded_name`!='COTWU(T)'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function update_emp_Addition($data,$addid){
        $this->db->where('add_id', $addid);
        $this->db->update('emp_addition',$data);
      }
   public function Update_Africa_Assurance($update,$salary_id){
        $this->db->where('salary_id', $salary_id);
        $this->db->update('assuarance_infor',$update);
      }
  public function Update_Non_Tax_Addition($data,$addid){
        $this->db->where('add_id', $addid);
        $this->db->update('non_tax_addition',$data);
      }
  public function update_heslb($data,$salary_id){
        $this->db->where('salary_id', $salary_id);
        $this->db->update('others_deduction', $data);
    }

     public function update_others_amountDed($data,$salary_id,$installmentName){
        //$this->db->where('salary_id', $salary_id);
         $this->db->where('salary_id', $salary_id);
         $this->db->where('other_names', $installmentName);
        $this->db->update('others_deduction', $data);
    }


    public function get_salary_record(){
      $sql = "SELECT `emp_salary`.*,`non_tax_addition`.* FROM `non_tax_addition` 
      INNER JOIN `emp_salary` ON `emp_salary`.`id` = `non_tax_addition`.`salary_id` WHERE `non_tax_addition`.`add_name` = 'SUNDRY ALLOWANCE'";
        $query=$this->db->query($sql);
    $result = $query->result();
    return $result;
    }

    public function getAllSalaryPayedData_Slips($month,$year){

      // $month = date('m');
      //       $dateObj   = DateTime::createFromFormat('!m', $month);
      //       $monthName = $dateObj->format('F');
      $sql = "SELECT `pay_salary`.`year`,`month`,`paid_date`,`net_payment`,`basic_payment`,`salary_scale`,
              `employee`.`first_name`,`last_name`,`em_code`,`des_id`,`dep_id`,`middle_name`,
              `emp_salary`.`id`,`emp_id`
              FROM `pay_salary`
              INNER JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              INNER JOIN `emp_salary` ON `emp_salary`.`emp_id`=`employee`.`em_id`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year` = '$year' AND `emp_salary`.`id` IN( SELECT MAX(`emp_salary`.`id`) FROM `emp_salary` GROUP BY `emp_salary`.`emp_id`) ORDER BY `employee`.`em_code` ASC";
      $query = $this->db->query($sql);
      $result = $query->result();
      return $result;
    }

    public function Check_Roster_Pay($month,$year){
      $sql = "SELECT  `payroll_sheet`.*,`employee`.*
        FROM `payroll_sheet` 
        INNER JOIN `employee` ON `employee`.`em_id` = `payroll_sheet`.`em_id`
      WHERE `month`='$month' AND `year` = '$year' ORDER BY `employee`.`em_code` ASC";
        $query=$this->db->query($sql);
    $result = $query->result();
    return $result;
    }

    public function getpayeSum($month,$year){

       $sql = "SELECT SUM(`paye`) as paye  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getPsssfSum($month,$year){

       $sql = "SELECT SUM(`psssf`) as psssf  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getSanslamSum($month,$year){

       $sql = "SELECT SUM(`sanslam`) as sanslam  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getKkrefundSum($month,$year){

       $sql = "SELECT SUM(`kkrefund`) as kkrefund  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
     public function getNhifSum($month,$year){

       $sql = "SELECT SUM(`nhif`) as nhif  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getSumSunAll($month,$year){

       $sql = "SELECT SUM(`sundryallowance`) as sundryallowance  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getshortaccessSum($month,$year){

       $sql = "SELECT SUM(`shortaccess`) as shortaccess  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function gethouserecoverySum($month,$year){

       $sql = "SELECT SUM(`houserecovery`) as houserecovery  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getsalaryrecoverySum($month,$year){

       $sql = "SELECT SUM(`salaryrecovery`) as salaryrecovery  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getcourtorderSum($month,$year){

       $sql = "SELECT SUM(`courtorder`) as courtorder  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getheslbSum($month,$year){

       $sql = "SELECT SUM(`heslb`) as heslb  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getzheslbSum($month,$year){

       $sql = "SELECT SUM(`zheslb`) as zheslb  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
    public function getSumtewuta1($month,$year){

       $sql = "SELECT SUM(`tewuta`) as tewuta  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumcotwu1($month,$year){

       $sql = "SELECT SUM(`cotwu`) as cotwu  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumkksaving($month,$year){

       $sql = "SELECT SUM(`kksaving`) as kksaving  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumsalaryarrers($month,$year){

       $sql = "SELECT SUM(`salaryarrers`) as salaryarrers  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSuminsurance($month,$year){

       $sql = "SELECT SUM(`insurance`) as insurance  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumhouserent($month,$year){

       $sql = "SELECT SUM(`houserent`) as houserent  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumactingallowance($month,$year){

       $sql = "SELECT SUM(`actingallowance`) as actingallowance  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumfuelallowance($month,$year){

       $sql = "SELECT SUM(`fuelallowance`) as fuelallowance  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumtelephoneallowancearrears($month,$year){

       $sql = "SELECT SUM(`telephoneallowancearrears`) as telephoneallowancearrears  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumtelephoneallowance($month,$year){

       $sql = "SELECT SUM(`telephoneallowance`) as telephoneallowance  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumsundryallowancerecovery($month,$year){

       $sql = "SELECT SUM(`sundryallowancerecovery`) as sundryallowancerecovery  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumovertime($month,$year){

       $sql = "SELECT SUM(`overtime`) as overtime  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumemergencyloan($month,$year){

       $sql = "SELECT SUM(`emergencyloan`) as emergencyloan  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

     public function getkkchapchaploan($month,$year){

       $sql = "SELECT SUM(`kkchapchaploan`) as kkchapchaploan  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumkkloan($month,$year){

       $sql = "SELECT SUM(`kkloan`) as kkloan  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumpurchaseloan($month,$year){

       $sql = "SELECT SUM(`purchaseloan`) as purchaseloan  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumNetSalary($month,$year){

       $sql = "SELECT SUM(`net_salary`) as net_salary  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumGrossSalary($month,$year){

       $sql = "SELECT SUM(`gross_salary`) as gross_salary 
               FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumBasicSalary($month,$year){

       $sql = "SELECT SUM(`basic_salary`) as basic_salary
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function getSumwadu($month,$year){

       $sql = "SELECT SUM(`wadu`) as wadu  
              FROM `payroll_sheet` WHERE `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }

    public function Save_Payroll_Model($pay){
        $this->db->insert('payroll_sheet',$pay);
    }

    public function getTelephoneAllowanceAreas($salaryId,$teleareas,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$teleareas' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
      public function getKkRefundAreas($salaryId,$refund,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$refund' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

   

     public function getKkRefundsheet($refund,$month,$year)
    {
      $sql = "SELECT `emp_addition_permonth`.*,`employee`.* FROM `emp_addition_permonth`
              INNER JOIN `employee` ON `employee`.`em_id` = `emp_addition_permonth`.`em_id` 

             WHERE  `emp_addition_permonth`.`add_name` LIKE '%$refund%' AND `emp_addition_permonth`.`month` = '$month' AND `emp_addition_permonth`.`year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getAfricanLifesheet($africanlife,$month,$year)
    {
      $sql = "SELECT `assurance_info_months`.`ded_amount` as add_amount,`employee`.*  FROM `assurance_info_months` 
       INNER JOIN `employee` ON `employee`.`em_id` = `assurance_info_months`.`em_id` 
       WHERE ( `assurance_info_months`.`ded_name` LIKE '%$africanlife%' OR `assurance_info_months`.`ded_name` LIKE 'SANLAM INSURANCE')AND `assurance_info_months`.`month` = '$month' AND `assurance_info_months`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getnonPercentagesheet($africanlife,$month,$year)
    {
      $sql = "SELECT `emp_non_percent_deduction_permonth`.`ded_amount` as add_amount,`employee`.*  FROM `emp_non_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_non_percent_deduction_permonth`.`em_id` 
       WHERE  `emp_non_percent_deduction_permonth`.`ded_name`LIKE '%$africanlife%' AND `emp_non_percent_deduction_permonth`.`month` = '$month' AND `emp_non_percent_deduction_permonth`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


     public function getnonPercentageWadusheet($africanlife,$month,$year)
    {
      $sql = "SELECT `emp_non_percent_deduction_permonth`.`ded_amount` as add_amount,`employee`.*  FROM `emp_non_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_non_percent_deduction_permonth`.`em_id` 
       WHERE  (`emp_non_percent_deduction_permonth`.`ded_name`LIKE '%$africanlife%' OR `emp_non_percent_deduction_permonth`.`ded_name`LIKE '%WADU%' ) AND `emp_non_percent_deduction_permonth`.`month` = '$month' AND `emp_non_percent_deduction_permonth`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


      public function getKkRefundAreaamount($refund,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE  `add_name` = '$refund' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getKkRefundTotalAreas($refund,$month,$year)
    {
      $sql = "SELECT SUM(`add_amount`) as kktotal FROM `emp_addition_permonth` WHERE  `add_name` = '$refund' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function getTelephoneAllowance($salaryId,$tele,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$tele' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getFuelArears($salaryId,$fuealareas,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$fuealareas' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getAdditionOvertime($salaryId,$over,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$over' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getKKeloan($salaryId,$kkel,$month,$year)
    {
      // $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkel' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
      //   $query = $this->db->query($sql);
      //   $result = $query->row();
      //   return $result;

        $currentMonth = $month;
      $month=Date('M', strtotime($currentMonth));
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkel' 
       AND `month` LIKE '%$month%' AND `year` = '$year'
        ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getKKeloanchap($salaryId,$kkelchap,$month,$year)
    {
      $currentMonth = $month;
      $month=Date('M', strtotime($currentMonth));
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkelchap' 
      AND `month` LIKE '%$month%' AND `year` = '$year'
      ORDER BY `others_id` DESC ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getKKeloanchap2($salaryId,$kkelchap,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkelchap' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function getKKloan($salaryId,$kkl,$month,$year)
    {
      $currentMonth = $month;
      $month=Date('M', strtotime($currentMonth));
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkl'  
      AND `month` LIKE '%$month%' AND `year` = '$year'
      ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getKKloan2($salaryId,$kkl,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkl'  AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getSundryRecovery($salaryId,$sunr,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$sunr' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getParcheLoan($salaryId,$parc,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$parc' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getCourtOrder($salaryId,$court,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$court' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getSalaryRecovery($salaryId,$salr,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$salr' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getHouseRecovery($salaryId,$hou,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$hou' AND `month` = '$month' AND `year` = '$year'  ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getShortAccess($salaryId,$sha,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$sha' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getSundryReport($salaryId,$sundry)
    {
      $sql = "SELECT * FROM `emp_addition` WHERE `salary_id` = '$salaryId' AND `add_name` = '$sundry'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getZHeslbReport($salaryId,$zheslb,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$zheslb' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function get_loan_ded_sheet($africanlife,$month,$year)
    {
      $currentMonth = $month;
      $month=Date('M', strtotime($currentMonth));

      $sql = "SELECT `loans_deduction`.`installment_Amount` as add_amount,`employee`.*  FROM `loans_deduction` 
       INNER JOIN `employee` ON `employee`.`em_id` = `loans_deduction`.`em_id` 
       WHERE  `loans_deduction`.`other_names` LIKE '%$africanlife%' 
       AND `loans_deduction`.`month` LIKE '%$month%' 
       AND `loans_deduction`.`year` = '$year'
       AND `loans_deduction`.`status` != 'COMPLETE'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_loanchap_ded_sheet($africanlife,$month,$year)
    {
      $currentMonth = $month;
      $month=Date('M', strtotime($currentMonth));

      $sql = "SELECT `loans_deduction`.`installment_Amount` as add_amount,`employee`.*  FROM `loans_deduction` 
       INNER JOIN `employee` ON `employee`.`em_id` = `loans_deduction`.`em_id` 
       WHERE  `loans_deduction`.`other_names` LIKE '%$africanlife%' 
       AND `loans_deduction`.`month` LIKE '%$month%' 
       AND `loans_deduction`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_loan_ded_sheet2($africanlife,$month,$year)
    {
      $sql = "SELECT `loans_deduction`.`installment_Amount` as add_amount,`employee`.*  FROM `loans_deduction` 
       INNER JOIN `employee` ON `employee`.`em_id` = `loans_deduction`.`em_id` 
       WHERE  `loans_deduction`.`other_names` LIKE '%$africanlife%' AND `loans_deduction`.`month` = '$month' AND `loans_deduction`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }




    public function getHeslbReport($salaryId,$heslb,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = 'HESLB' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function get_emp_percsheet($africanlife,$month,$year)
    {
      $sql = "SELECT `emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

   

 public function get_emp_percsheetnhifregion($africanlife,$month,$year)
    {
      $sql = "SELECT `employee`.`em_region` as region, COUNT(*)  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       GROUP BY `employee`.`em_region`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function get_emp_percsheetnhifhqdepartment($africanlife,$month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `employee`.`em_region` = '$region' AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office')
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


     public function get_emp_percsheetnhifhqdepartmentall($africanlife,$month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `employee`.`em_region` = '$region'
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


     public function get_emp_percsheetnhif($africanlife,$month,$year)
    {
      $sql = "SELECT `emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       GROUP BY `employee`.`em_region`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     public function get_emp_percsheetnhifbyregion($africanlife,$month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
        LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month'
       AND `employee`.`em_region` = '$region'";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

   


     public function get_emp_wcfregion($month,$year)
    {
      $sql = "SELECT `employee`.`em_region` as region, COUNT(*)   FROM `employee`  
        INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month'
       GROUP BY `employee`.`em_region`";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function get_emp_percsheetwcfbyregion($month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee`  
        INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month'
       AND `employee`.`em_region` = '$region'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_emp_percsheetwcf($month,$year)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee`  
        INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

      public function get_emp_percsheetwcfhqlist($month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee` 
         INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region'  AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office') 
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_emp_percsheetwcfhqdepartment($month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `employee` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
          INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region' AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office')
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function get_emp_percsheetwcfhqdepartmentall($month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `employee` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
          INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region' 
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

      public function get_emp_percsheetwcfnothqlist($month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee` 
         INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region'  AND `employee`.`em_branch` != 'Posta Head Office '
        AND `employee`.`em_branch` != 'Post Head Office'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


      public function get_emp_percsheetwcfhqdepartmentlists($month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region'  AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office') AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }



      public function get_emp_percsheetwcfhqdepartmentlistsall($month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`employee`.*  FROM `employee` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         INNER JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `employee`.`em_region` = '$region'   AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }




    public function get_emp_percsheetnhifbyregionnothq($africanlife,$month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
        LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND `employee`.`em_branch` != 'Posta Head Office '
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month'
        AND `employee`.`em_branch` != 'Post Head Office' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

      public function get_emp_percsheetnhifhqdepartmentlist($africanlife,$month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office') AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }



     public function get_emp_percsheetnhifhqdepartmentlistALL($africanlife,$month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`emp_percent_deduction_permonth`.`ded_amount`as add_amount,`employee`.*  FROM `emp_percent_deduction_permonth` 
       INNER JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `emp_percent_deduction_permonth`.`ded_name` = '$africanlife' AND `emp_percent_deduction_permonth`.`month` = '$month' AND `emp_percent_deduction_permonth`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getNhifReport($salaryId,$nhif,$month,$year)
    {
      $sql = "SELECT * FROM `emp_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$nhif' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getPsssfReport($salaryId,$pssf,$month,$year)
    {
      $sql = "SELECT * FROM `pension_fund_contribution` WHERE `salary_id` = '$salaryId' AND `fund_name` = '$pssf' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getPsssfSheet($refund,$month,$year)
    {
      $sql = "SELECT `pension_fund_contribution`.`fund_amount` as add_amount,`employee`.* FROM `pension_fund_contribution`
              INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 

             WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

       public function get_emp_percsheetpssfhqlist($refund,$month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`pension_fund_contribution`.`fund_amount`as add_amount,`employee`.*  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office') 
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
      }
   
    public function get_emp_percsheetpssfhqdepartmentlistsall($refund,$month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`pension_fund_contribution`.`fund_amount`as add_amount,`employee`.*  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function get_emp_percsheetpssfhqdepartmentlists($refund,$month,$year,$region,$department)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`pension_fund_contribution`.`fund_amount`as add_amount,`employee`.*  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
          LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office') AND `musedepartment`.`dep_name`='$department'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function get_emp_percsheetpssfbyregionnothq($refund,$month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`pension_fund_contribution`.`fund_amount`as add_amount,`employee`.*  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region'  AND `employee`.`em_branch` != 'Posta Head Office '
        AND `employee`.`em_branch` != 'Post Head Office'
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


     public function get_emp_percsheetpssfbyregion($refund,$month,$year,$region)
    {
      $sql = "SELECT `payroll_sheet`.`basic_salary`as basic_salary,`pension_fund_contribution`.`fund_amount`as add_amount,`employee`.*  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
         LEFT JOIN `payroll_sheet` ON `employee`.`em_id`=`payroll_sheet`.`em_id`
       WHERE   `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region' 
        AND `payroll_sheet`.`year`='$year' AND `payroll_sheet`.`month`='$month' ";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    
public function get_emp_percsheetpssfhqdepartment($refund,$month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `pension_fund_contribution` 
      INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
       WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region' AND (`employee`.`em_branch` = 'Posta Head Office '
        OR `employee`.`em_branch` = 'Post Head Office')
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }



public function get_emp_percsheetpssfhqdepartmentall($refund,$month,$year,$region)
    {
      $sql = "SELECT `musedepartment`.`dep_name` as department, COUNT(*)  FROM `pension_fund_contribution` 
      INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
         LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
       WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       AND `employee`.`em_region` = '$region' 
       GROUP BY `musedepartment`.`dep_name`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }




    public function get_emp_pssfregion($refund,$month,$year)
    {
      $sql = "SELECT `employee`.`em_region` as region, COUNT(*)  FROM `pension_fund_contribution` 
       INNER JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id` 
       WHERE  `pension_fund_contribution`.`fund_name` LIKE '%$refund%' AND `pension_fund_contribution`.`month` = '$month' AND `pension_fund_contribution`.`year` = '$year'
       GROUP BY `employee`.`em_region`";

     
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

   

    public function getAdditionFuel($salaryId,$fuel,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$fuel' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getAdditionActing($salaryId,$act,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$act' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAdditionSalAreas($salaryId,$salarr,$month,$year)
    {
      $sql = "SELECT * FROM `emp_addition_permonth` WHERE `salary_id` = '$salaryId' AND `add_name` = '$salarr' AND `month` = '$month' AND `year` = '$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
public function getDedAmountInsurance($salaryId,$insu,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$insu' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getDedAmountHouse($salaryId,$house,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$house' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getDedAmountWadu($salaryId,$wadu,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$wadu' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getDedAmountKKSaving($salaryId,$kks,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$kks' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getDedAmountCotwu($salaryId,$cotwu,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$cotwu' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getDedAmount($salaryId,$tewuta,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$tewuta' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAfricanLifeAmount($africanlife,$month,$year)
    {
      $sql = "SELECT * FROM `assurance_info_months` WHERE  `ded_name` = '$africanlife' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAfricanLifeAmounts($salaryId,$africanlife,$month,$year)
    {
      $sql = "SELECT * FROM `assurance_info_months` WHERE `salary_id` = '$salaryId' AND `ded_name` = '$africanlife' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAfricanLifeAmounts1($africanlife,$month,$year)
    {
      $sql = "SELECT * FROM `assurance_info_months` WHERE  `ded_name` = '$africanlife' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }



     public function getAfricanLifeAmountss1($africanlife,$month,$year)
    {
      $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `ded_name` = '$africanlife' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getAfricanLifeAmountss($emid1,$africanlife,$month,$year)
    {
      $sql = "SELECT * FROM `assurance_info_months` WHERE `ded_name` = '$africanlife' AND `month` = '$month' AND `emp_id` = '$emid1' AND `year` = '$year' ";
       //$this->db->query("SET sql_mode = '' ");
           $query  = $this->db->query($sql);
           //$result = $query->result_array();
           $result = $query->result();
          //$result ->fetch_row()[0];
        // if ($query->num_rows() > 0) {
        //     return $query->result();
        // } else {
        //     return NULL;
        // }
         
       
       
      return $result;
    }

 public function getAfricanLifeTotalAmount($africanlife,$month,$year)
    {
      $sql = "SELECT SUM(`ded_amount`) as africantotal FROM `assurance_info_months` WHERE  `ded_name` = '$africanlife' AND `month` = '$month' AND `year` = '$year'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_Em_Id($month,$year){
  $sql = "SELECT * FROM `pay_salary`
      WHERE `month`='$month' AND `year` = '$year'";
        $query=$this->db->query($sql);
    $result = $query->result();
    return $result;
}

 public function getPayeChart(){
    $sql = "SELECT * FROM `paye_chart`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getPensionChart(){
    $sql = "SELECT `pension_fund_contribution`.*,`employee`.*
    FROM `pension_fund_contribution`
    LEFT JOIN `employee` ON `employee`.`em_id` = `pension_fund_contribution`.`em_id`  
    WHERE `employee`.`status` = 'ACTIVE' AND `pension_fund_contribution`.`month` != 'April' ORDER BY `employee`.`em_code` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getPercentageDeduction(){

    $sql = "SELECT `emp_percent_deduction_permonth`.*,`employee`.*
        FROM `emp_percent_deduction_permonth`
        LEFT JOIN `employee` ON `employee`.`em_id` = `emp_percent_deduction_permonth`.`em_id`  
        WHERE `employee`.`status` = 'ACTIVE' ORDER BY `employee`.`em_code` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

    public function getNonPercentageDeduction2($salary_id,$month,$year){
    $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `ded_id` IN( SELECT MAX(`ded_id`) FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salary_id' AND `month`='$month' AND `year` = '$year' GROUP BY `ded_name`)";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }
   public function getNonPercentageDeduction21($salary_id,$month,$year,$id){  
    $sql = "SELECT * FROM `emp_non_percent_deduction_permonth` WHERE `ded_id` IN( SELECT MAX(`ded_id`) FROM `emp_non_percent_deduction_permonth` WHERE `salary_id` = '$salary_id' AND `em_id`='$id' AND `month`='$month' AND `year` = '$year' GROUP BY `ded_name`)";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }



  public function getNonPercentageDeduction(){
    $sql = "SELECT `emp_non_percent_deduction_permonth`.*,`employee`.*
        FROM `emp_non_percent_deduction_permonth`
        LEFT JOIN `employee` ON `employee`.`em_id` = `emp_non_percent_deduction_permonth`.`em_id`  
        WHERE `employee`.`status` = 'ACTIVE' ORDER BY `employee`.`em_code` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getLoanPermonthDeduction(){

    $sql = "SELECT `loans_deduction`.*,`employee`.*
        FROM `loans_deduction`
        LEFT JOIN `employee` ON `loans_deduction`.`em_id` = `employee`.`em_id` 
        WHERE `employee`.`status` = 'ACTIVE' ORDER BY `loans_deduction`.`others_id` ASC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

  public function getdesignation1($des_id){
      $sql    = "SELECT * FROM `designation` WHERE `id`='$des_id' ORDER BY `id` DESC LIMIT 1";
          $query  = $this->db->query($sql);
          $result = $query->row();
      return $result;
      }

  public function getSheetToBankEmpty($month,$year,$bank_name,$musedept){

    if(!empty($musedept) && $musedept !='ALL'){
      if (empty($bank_name)) {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*,`musedepartment`.*
              FROM `pay_salary`
              LEFT JOIN `employee`  ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
              AND `employee`.`muse_dept_id`='$musedept'
              ORDER BY `employee`.`em_code` ASC";

      } elseif($bank_name='ALL') {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*,`musedepartment`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
               LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' 
               AND `employee`.`muse_dept_id`='$musedept'
              ORDER BY `employee`.`em_code` ASC";
      }
      else {

        $sql ="SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*,`musedepartment`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
               LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name` = '$bank_name'
               AND `employee`.`muse_dept_id`='$musedept'
              ORDER BY `employee`.`em_code` ASC";
      }
    }else if( $musedept =='ALL'){

       if (empty($bank_name)) {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee`  ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
              ORDER BY `employee`.`em_code` ASC";

      } elseif($bank_name='ALL') {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' 
              ORDER BY `employee`.`em_code` ASC";
      }
      else {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name` = '$bank_name'
              ORDER BY `employee`.`em_code` ASC";
      }

    }


        $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
    }

    
    public function getSheetToBankSumEmpty($month,$year,$bank_name,$musedept){

       if(!empty($musedept) && $musedept !='ALL'){

      if (empty($bank_name)) {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
               LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `employee`.`muse_dept_id`='$musedept'
            ";

      }
      elseif($bank_name='ALL') {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
                LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
               LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'  AND `employee`.`muse_dept_id`='$musedept'";
      } else {

       $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
                LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
               LEFT JOIN `musedepartment`  ON `musedepartment`.`id`=`employee`.`muse_dept_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name`='$bank_name'
              AND `employee`.`muse_dept_id`='$musedept'
            ";

      }
    }else if( $musedept =='ALL'){

       if (empty($bank_name)) {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
            ";

      }
      elseif($bank_name='ALL') {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'  ";
      } else {

       $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name`='$bank_name'
            ";

      }

    }

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }



     public function getSheetToBankEmpty0($month,$year,$bank_name){
      if (empty($bank_name)) {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee`  ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
              ORDER BY `employee`.`em_code` ASC";

      } elseif($bank_name='ALL') {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' 
              ORDER BY `employee`.`em_code` ASC";
      }
      else {

        $sql = "SELECT `pay_salary`.*,
              `employee`.*,
              `bank_info`.*,`bank_name`.*
              FROM `pay_salary`
              LEFT JOIN `employee` ON `pay_salary`.`em_id`=`employee`.`em_id`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `employee`.`status` = 'ACTIVE' AND `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name` = '$bank_name'
              ORDER BY `employee`.`em_code` ASC";
      }


        $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
    }

    
    public function getSheetToBankSumEmpty0($month,$year,$bank_name){

      if (empty($bank_name)) {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
            ";

      }
      elseif($bank_name='ALL') {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'  ";
      } else {

       $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year' AND `bank_info`.`bank_name`='$bank_name'
            ";

      }

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }
}
