<?php

class E_reports_Model extends CI_Model{

public function get_supervisor_braches(){
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM em_branch INNER JOIN em_region ON em_region.region_id=em_branch.region_id WHERE em_region.region_name='$region'";
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function get_regions(){
$region = $this->session->userdata('user_region');
if ($this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT"){
$sql = "SELECT * FROM em_region WHERE region_name='$region' ORDER BY region_name ASC";
}
else 
{
$sql = "SELECT * FROM em_region ORDER BY region_name ASC";
}
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function get_user_regions(){
$region = $this->session->userdata('user_region');
if ($this->session->userdata('user_type') == 'SUPER ADMIN'|| $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP"){
$sql = "SELECT * FROM em_region ORDER BY region_name ASC";
}
else 
{
$sql = "SELECT * FROM em_region WHERE region_name='$region' ORDER BY region_name ASC";
}
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function get_all_regions(){
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM em_region ORDER BY region_name ASC";
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function retrieve_branch($branchid){
$region = $this->session->userdata('user_region');
if($branchid=="all"){
$sql = "SELECT * FROM em_branch INNER JOIN em_region ON em_region.region_id=em_branch.region_id WHERE em_region.region_name='$region'";
}
else
{
$sql = "SELECT * FROM em_branch WHERE branch_id='$branchid'";
}

$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function get_region_branch($regionid){
$sql = "SELECT * FROM em_branch INNER JOIN em_region ON em_region.region_id=em_branch.region_id WHERE em_region.region_id='$regionid'";
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function retrieve_regions($regionid){
$region = $this->session->userdata('user_region');
if($regionid=="all"){
$sql = "SELECT * FROM em_region ORDER BY region_name ASC";
}
else
{
$sql = "SELECT * FROM em_region WHERE region_id='$regionid'";
}

$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function count_domestic_postage($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) ='$month' AND YEAR(transactiondate)='$year' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function download_history($fileName,$report){
$empid = $empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "INSERT INTO download_history (attach,type,empid) VALUES ('$fileName','$report','$empid')";
$query=$db2->query($sql);
return $query;
}

public function list_download_history(){
$empid = $empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);

if($this->session->userdata('user_type') == 'ADMIN'){
$sql = "SELECT * FROM download_history ORDER BY history_id DESC";
}
else
{
$sql = "SELECT * FROM download_history WHERE empid='$empid' ORDER BY history_id DESC"; 
}

$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function sum_domestic_postage($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function count_cash_international($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND 
PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' AND 
PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_cash_international($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' 
AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year'
AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function count_cash_pcum($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('PCUM') 
AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate)='$year' AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_cash_pcum($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('PCUM') 
AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' 
AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' 
AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function count_cash_emscargo($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS-CARGO') AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND 
PaymentFor IN('EMS-CARGO') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year'  AND PaymentFor IN('EMS-CARGO') 
AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_cash_emscargo($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS-CARGO') 
AND district = '$branch' AND status='Paid'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' 
AND PaymentFor IN('EMS-CARGO') AND district = '$branch' AND status='Paid'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' 
AND PaymentFor IN('EMS-CARGO') AND district = '$branch' AND status='Paid'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

//BILLING
public function count_domestic_bill_postage($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Bill'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_domestic_bill_postage($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS')
AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' AND PaymentFor IN('EMS_HESLB','LOAN BOARD','EMS') AND district = '$branch' AND status='Bill'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function count_bill_international($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND 
PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' AND 
PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Bill'";
}

$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_bill_international($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('EMS_INTERNATIONAL') 
AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' 
AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year'
AND PaymentFor IN('EMS_INTERNATIONAL') AND district = '$branch' AND status='Bill'";
}

$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function count_bill_pcum($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT * from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND PaymentFor IN('PCUM') 
AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT * from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate)='$year' AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Bill'";
}


$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function sum_bill_pcum($branch,$fromdate,$todate,$date,$month,$year,$report){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);

if($report=="Daily"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) = '$date' AND PaymentFor IN('PCUM') 
AND district = '$branch' AND status='Bill'";
}
elseif($report=="Weekly"){
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' 
AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Bill'";
}
else
{
$sql = "SELECT SUM(paidamount) AS postage_amount from transactions WHERE MONTH(transactiondate) = '$month' AND YEAR(transactiondate) = '$year' 
AND PaymentFor IN('PCUM') AND district = '$branch' AND status='Bill'";
}


$query=$db2->query($sql);
$result = $query->row();
return $result;
}



///EMS SUMMARY REPORT

public  function get_credit_customer_list_byAccnoMonth($acc_no,$month,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];


            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

                if(!empty($date)){

                    $sql = "SELECT DISTINCT date(`sender_info`.`date_registered`) AS 'date' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }else{

                    $sql = "SELECT DISTINCT date(`sender_info`.`date_registered`) AS 'date' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`operator` = '$id'
                     -- AND `transactions`.`isBill_Id` = 'No'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }

            

        }else{

            if(!empty($date)){

            $sql = "SELECT DISTINCT date(`sender_info`.`date_registered`) AS 'date' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
             AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC ";
            
            }else{

                $sql = "SELECT DISTINCT date(`sender_info`.`date_registered`) AS 'date' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
            AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC ";

            }

        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }
//END SUMMARY REPORT

//BREAKDOWN EMS SUMMARY
public  function breakdown_credit_customer_list_byAccnoMonth($acc_no,$month,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];


            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

                if(!empty($date)){

                    $sql = "SELECT DISTINCT `sender_info`.`s_region` AS 'region' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'
                    ORDER BY `sender_info`.`s_region` ASC ";

                }else{

                    $sql = "SELECT DISTINCT `sender_info`.`s_region` AS 'region' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`operator` = '$id'
                     -- AND `transactions`.`isBill_Id` = 'No'
                    ORDER BY `sender_info`.`s_region` ASC ";

                }

            

        }else{

            if(!empty($date)){

            $sql = "SELECT DISTINCT `sender_info`.`s_region` AS 'region' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
             AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`s_region` ASC ";
            
            }else{

                $sql = "SELECT DISTINCT `sender_info`.`s_region` AS 'region' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
            AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`s_region` ASC ";

            }

        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


public function breakdown_credit_customer_list_byAccnoMonth_list($acc_no,$sender_region,$month,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');
        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];
        

            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

                if(!empty($date)){

                            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`
                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region`='$sender_region'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }else{

                    $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`
                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region`='$sender_region'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }

            

        }else{

            if(!empty($date)){

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
             AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region`='$sender_region' ORDER BY `sender_info`.`date_registered` ASC ";
            
            }else{

                $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
            AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region`='$sender_region'
            ORDER BY `sender_info`.`date_registered` ASC ";

            }

        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
}

//END OF BREAKDOWN SUMMARY

public  function get_transaction_summary($acc_no,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        $db2 = $this->load->database('otherdb', TRUE);
        
    

            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

            $sql = "SELECT COUNT(sender_info.date_registered) AS count_trans, SUM(transactions.paidamount) AS trans_amount FROM sender_info
                    LEFT JOIN transactions ON sender_info.sender_id=transactions.CustomerID
                    WHERE sender_info.s_region = '$o_region' AND sender_info.s_district = '$o_branch' AND transactions.customer_acc = '$acc_no' AND transactions.status = 'Bill' AND date(sender_info.date_registered) = '$date'
                    AND sender_info.operator = '$id'"; 
        } else {

            $sql = "SELECT COUNT(sender_info.date_registered) AS count_trans, SUM(transactions.paidamount) AS trans_amount FROM sender_info
                    LEFT JOIN transactions ON sender_info.sender_id=transactions.CustomerID
                    WHERE  transactions.customer_acc = '$acc_no' AND transactions.status = 'Bill' AND date(sender_info.date_registered) = '$date'"; 

            }

      
        
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    //PENDING INVOICE REPORT
    public function get_pending_invoice($fromdate,$todate,$status){
    $db2 = $this->load->database('otherdb', TRUE);

    $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
             INNER JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
             WHERE DATE(`invoice`.`invoice_date`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' 
             AND `transactions`.`PaymentFor` = 'EMSBILLING'"; 
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
    }

    public function mails_get_pending_invoice($fromdate,$todate,$status){
    $db2 = $this->load->database('otherdb', TRUE);

    $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
             INNER JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
             WHERE DATE(`invoice`.`invoice_date`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' 
             AND `transactions`.`PaymentFor` = 'MAILSBILLING'"; 
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
    }

    public function mails_list_pending_transaction($region,$fromdate,$todate,$status){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
             INNER JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
             WHERE DATE(`invoice`.`invoice_date`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' 
             AND `transactions`.`PaymentFor` = 'MAILSBILLING' AND `transactions`.`region` = '$region'"; 
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
    }

    public function list_pending_transaction($region,$fromdate,$todate,$status){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
             INNER JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
             WHERE DATE(`invoice`.`invoice_date`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' 
             AND `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`region` = '$region'"; 
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
    }

    //END OF PENDING INVOICE REPORT

public function pending_invoice_all_region($region){

if($region=="all"){
$sql = "SELECT * FROM em_region ORDER BY region_name ASC";
} else {
$sql = "SELECT * FROM em_region where region_name='$region'";
}

$query = $this->db->query($sql);
$results = $query->result();
return $results;
}



////////////////////////////TTCL SHEET
public  function get_ttcl_credit_customer_list_byAccnoMonth($acc_no,$month,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];


            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

                if(!empty($date)){

                    $sql = "SELECT DISTINCT DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') AS 'date' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }else{

                    $sql = "SELECT DISTINCT DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') AS 'date' FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`operator` = '$id'
                     -- AND `transactions`.`isBill_Id` = 'No'
                    ORDER BY `sender_info`.`date_registered` ASC ";

                }

            

        }else{

            if(!empty($date)){

            $sql = "SELECT DISTINCT DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') AS 'date' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
             AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC ";
            
            }else{

                $sql = "SELECT DISTINCT DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') AS 'date' FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
            AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC ";

            }

        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


public  function get_transaction_summary_ttcl($acc_no,$date){
        $o_region = $this->session->userdata('user_region');
        $o_branch =  $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        $db2 = $this->load->database('otherdb', TRUE);
        
    

            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

            $sql = "SELECT sender_info.date_registered AS regdate, COUNT(sender_info.date_registered) AS count_trans, SUM(transactions.paidamount) AS trans_amount FROM sender_info
                    LEFT JOIN transactions ON sender_info.sender_id=transactions.CustomerID
                    WHERE sender_info.s_region = '$o_region' AND sender_info.s_district = '$o_branch' AND transactions.customer_acc = '$acc_no' AND transactions.status = 'Bill' AND DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') = '$date'
                    AND sender_info.operator = '$id'"; 
        } else {

            $sql = "SELECT sender_info.date_registered AS regdate, COUNT(sender_info.date_registered) AS count_trans, SUM(transactions.paidamount) AS trans_amount FROM sender_info
                    LEFT JOIN transactions ON sender_info.sender_id=transactions.CustomerID
                    WHERE  transactions.customer_acc = '$acc_no' AND transactions.status = 'Bill' AND DATE_FORMAT(`sender_info`.`date_registered`,'%Y-%d-%m %H') = '$date'"; 

            }

      
        
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

/////////////////////END OF TTCL SHEET


}