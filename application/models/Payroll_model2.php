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
      public function getPayedSalary($em_code,$month,$year){
      $sql = "SELECT * FROM `pay_salary`
      WHERE `em_id`='$em_code' AND `month` = '$month' AND `year`='$year'";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
   public function getTaxRelief($salary_id)
    {
      $sql = "SELECT * FROM `taxt_relief` WHERE `salaryId` = '$salary_id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
  public function Add_Salary($data){
      $this->db->insert('emp_salary',$data);
      }
  public function save_paye_value($save){
        $this->db->insert('paye_per_region',$save);
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
  public function Add_Others_Deduction($data){
      $this->db->insert('others_deduction',$data);
      }
  public function insertPDeductioCommulative($dataP){
        $result = $this->db->insert('emp_percent_deduction_permonth',$dataP);
        return $result;
    }
  public function Add_Emp_Percent($data){
      $this->db->insert('emp_percent_deduction',$data);
      }
    public function getTotalPDeductionAmount($salary_id)
    {
      $sql = "SELECT SUM(ded_amount) as ded_amount FROM `emp_percent_deduction` WHERE `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getOthersDeduction($salary_id){
    $sql = "SELECT * FROM `others_deduction` WHERE `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
    public function getTotalDeductionAmount($salary_id)
    {
      $sql = "SELECT SUM(installment_amount) as others_amount FROM `others_deduction` WHERE `salary_id` = '$salary_id' AND `status` = 'ACTIVE' ORDER BY `others_id` DESC";
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
    public function getTotalNonPDeductionAmount($salary_id)
    {
      $sql = "SELECT SUM(ded_amount) as ded_amount FROM `emp_non_percent_deduction` WHERE `salary_id` = '$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getTotalAdditionAmount($id,$salary_id)
    {



      $month  = date('m');
      $year  = date('Y');
      $sql = "SELECT SUM(add_amount) as add_amount FROM `emp_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR (`end_month` ='0000-00-00 00:00:00')) OR ((MONTH(`end_month`) >= '$month') AND (YEAR(`end_month`) >= '$year')))";
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
      $sql = "SELECT SUM(add_amount) as add_amount FROM `non_tax_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR (`end_month` ='0000-00-00 00:00:00')) OR ((MONTH(`end_month`) >= '$month') AND (YEAR(`end_month`) >= '$year')))";

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
    public function getAssuarance2($id)
    {
      $sql = "SELECT * FROM `assuarance_infor` WHERE `em_id` = '$id' ORDER BY  `em_id` DESC  LIMIT 1";
        $query  = $this->db->query($sql);
        $result = $query->row();
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

  public function Get_SalaryID($id){
      $sql = "SELECT `emp_salary`.*
      FROM `emp_salary`
      WHERE `emp_salary`.`emp_id`='$id' ORDER BY `emp_salary`.`id` DESC LIMIT 1";
        $query=$this->db->query($sql);
    $result = $query->row();
    return $result;
    }
  public function Others_Employee_Deduction($salary_id,$id){
    $sql = "SELECT * FROM `others_deduction` WHERE `salary_id` = '$salary_id'  AND `em_id` = '$id' ORDER BY `others_id`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function Others_Employee_Deduction_Permonth($installmentName,$salary_id){
    $sql = "SELECT * FROM `loans_deduction` WHERE `other_names` = '$installmentName' AND `salary_id` = '$salary_id' ORDER BY `others_id` DESC LIMIT 1";
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
  public function getTaxAddition($id,$salary_id){
// SELECT * FROM `emp_addition` WHERE `salary_id` = '$salary_id' 
// AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
// OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year')))
    $month = date('m');
    $year  = date('Y');

    $sql = "SELECT * FROM `emp_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR (`end_month` ='0000-00-00 00:00:00')) OR ((MONTH(`end_month`) >= '$month') AND (YEAR(`end_month`) >= '$year')))";

//      $sql = "SELECT * FROM `emp_addition` WHERE `salary_id` = '$salary_id' 
// AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
//  OR (`end_month` ==''))";


    //$sql = "SELECT * FROM `emp_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }

   public function getTaxAdditions($id,$salary_id){
    $month = date('m');
    $year  = date('Y');

    $sql = "SELECT * FROM `emp_addition` WHERE (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR (`end_month` ='0000-00-00 00:00:00')) OR ((MONTH(`end_month`) >= '$month') AND (YEAR(`end_month`) >= '$year')))";

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
  }
  public function getNonTaxAddition($id,$salary_id){
        $month = date('m');
        $year  = date('Y');
         $sql = "SELECT * FROM `non_tax_addition` WHERE  (`em_id` = '$id' AND  `salary_id` = '$salary_id') AND (((`end_month` IS NULL) OR (`end_month` ='0000-00-00 00:00:00')) OR ((MONTH(`end_month`) >= '$month') AND (YEAR(`end_month`) >= '$year')))";
      

        // $sql = "SELECT * FROM `non_tax_addition` WHERE `em_id` = '$id' AND `salary_id`='$salary_id' AND `end_month` < date()";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function getPensionFund($id){
        $sql = "SELECT * FROM `pension_funds`
        WHERE  `em_id` = '$id'";
        $query=$this->db->query($sql);
        $result = $query->row();
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
  public function getLoanDeduction($id){
    $sql = "SELECT * FROM `others_deduction` WHERE `em_id` = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

  }
  public function GetCommulativePension($id){
        $sql = "SELECT * FROM `pension_fund_contribution`
        WHERE  `em_id` = '$id' AND `month` = 'April'";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
      }
  public function GetCommulative($id){
        $sql = "SELECT * FROM `emp_non_percent_deduction_permonth`
        WHERE  `em_id` = '$id' AND `month` = 'April'";
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
        $result = $query->row();
        return $result;
      }
  public function getAfricaAssurance($id){
        $sql = "SELECT * FROM `assuarance_infor`
        WHERE `em_id` = '$id' ORDER BY assur_id DESC LIMIT 1";
        $query=$this->db->query($sql);
        $result = $query->row();
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
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = '$kkel' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getKKloan($salaryId,$kkl,$month,$year)
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

    public function getHeslbReport($salaryId,$heslb,$month,$year)
    {
      $sql = "SELECT * FROM `loans_deduction` WHERE `salary_id` = '$salaryId' AND `other_names` = 'HESLB' AND `month` = '$month' AND `year` = '$year' ORDER BY `others_id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->row();
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

  public function getSheetToBankEmpty($month,$year,$bank_name){
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

      } else {

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

    public function getSheetToBankSumEmpty($month,$year,$bank_name){

      if (empty($bank_name)) {

        $sql = "SELECT SUM(`net_payment`) as total
              FROM `pay_salary`
              LEFT JOIN `bank_info` ON `pay_salary`.`em_id`=`bank_info`.`em_id`
              LEFT JOIN `bank_name` ON `bank_info`.`bank_name`=`bank_name`.`bank_nanme`
              WHERE `pay_salary`.`month` = '$month' AND `pay_salary`.`year`='$year'
            ";

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
