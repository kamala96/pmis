<?php
class BureauModel extends CI_Model{

public  function get_currency(){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "select * from bureau_currency where currency_status=1";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
}

public  function get_identity(){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "select * from bureau_identity where identity_status=1";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
}

public function checkstrongroomIDExist($id){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from bureau_branch_stock where strongroomstockid='$id'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public  function get_country(){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "select * from country";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_receipt_info($receiptid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_transactions INNER JOIN bureau_identity ON bureau_identity.identity_id=bureau_transactions.customer_identity
	INNER JOIN bureau_purpose ON bureau_purpose.purpose_id=bureau_transactions.purposeid where bureau_transactions.receipt='$receiptid'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
 }

public function get_purpose(){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "select * from bureau_purpose where purpose_status=1";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_fifo_currency_stock_by_id($value){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT 
bureau_strong_room_stock_id,
stock_amount-stock_amount_out as Quantityoffifo,
stock_amount_out,
stock_amount,
buying_price,
selling_price,
stock_status,
stock_region,
currencyid,
bureau_stock_created_at
FROM bureau_strong_room_stock_transactions WHERE stock_status='INCOMPLETE' AND stock_region='$region' AND currencyid='$value' ORDER BY bureau_stock_created_at ASC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function strong_room_opening_balance(){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT currencyid,currency_desc, currency_name, stock_region, stock_status, SUM(stock_amount) AS total, SUM(stock_amount_out) AS totalout, SUM(stock_amount-stock_amount_out) AS totaldiff from bureau_strong_room_stock_transactions INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_strong_room_stock_transactions.currencyid WHERE stock_status='INCOMPLETE' AND stock_region='$region' GROUP BY currencyid";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function strong_room_opening_balance_by_ID($currencyid){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT currencyid, currency_desc, currency_name, stock_region, stock_status, SUM(stock_amount) AS total, SUM(stock_amount_out) AS totalout, SUM(stock_amount-stock_amount_out) AS totaldiff from bureau_strong_room_stock_transactions INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_strong_room_stock_transactions.currencyid WHERE stock_status='INCOMPLETE' AND stock_region='$region' AND currencyid='$currencyid' GROUP BY currencyid";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function strong_room_opening_balance_summary_by_ID($currencyid){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$region = $this->session->userdata('user_region');
$sql = "SELECT * from bureau_strong_room_stock_transactions
INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_strong_room_stock_transactions.currencyid
WHERE stock_region='$region' AND currencyid='$currencyid' AND stock_status='INCOMPLETE'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_fifo_currency_stock_by_id_latest($currencyid){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM bureau_strong_room_stock_transactions 
WHERE stock_region='$region' AND currencyid='$currencyid'  ORDER BY bureau_stock_created_at DESC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_branch_bclno(){
        $branch = $this->session->userdata('user_branch');
        $sql = "select * from em_branch where branch_name='$branch'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;
}

public function get_currency_information($currencyid){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * from bureau_currency where currency_id='$currencyid'";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
}

public function stock_transaction_results($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$region = $this->session->userdata('user_region');
$sql = "SELECT * from bureau_strong_room_stock_transactions
INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_strong_room_stock_transactions.currencyid
WHERE date(bureau_stock_created_at) BETWEEN '$fromdate' and '$todate' AND stock_region='$region'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

	public function list_transaction($fromdate,$todate,$status){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
	$sql = "SELECT * from bureau_transactions INNER JOIN bureau_identity ON bureau_identity.identity_id=bureau_transactions.customer_identity
	INNER JOIN bureau_purpose ON bureau_purpose.purpose_id=bureau_transactions.purposeid
    INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_transactions.currencyid 
    LEFT JOIN bureau_bot_transaction_status ON bureau_bot_transaction_status.bot_serial=bureau_transactions.serial
	where date(transaction_created_at) BETWEEN '$fromdate' and '$todate'  and operator='$empid' and transaction_type='$status' group by bureau_transactions.receipt order by transaction_id desc";
	}
	elseif ($this->session->userdata('user_type') == 'RM') {
    $sql = "SELECT * from bureau_transactions INNER JOIN bureau_identity ON bureau_identity.identity_id=bureau_transactions.customer_identity
	INNER JOIN bureau_purpose ON bureau_purpose.purpose_id=bureau_transactions.purposeid
    INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_transactions.currencyid
    LEFT JOIN bureau_bot_transaction_status ON bureau_bot_transaction_status.bot_serial=bureau_transactions.serial
    where date(transaction_created_at) BETWEEN '$fromdate' and '$todate'  and region='$region' and transaction_type='$status' group by bureau_transactions.receipt order by transaction_id desc";
	}
	else{
    $sql = "SELECT * from bureau_transactions INNER JOIN bureau_identity ON bureau_identity.identity_id=bureau_transactions.customer_identity
	INNER JOIN bureau_purpose ON bureau_purpose.purpose_id=bureau_transactions.purposeid
    INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_transactions.currencyid
    LEFT JOIN bureau_bot_transaction_status ON bureau_bot_transaction_status.bot_serial=bureau_transactions.serial
    where date(transaction_created_at) BETWEEN '$fromdate' and '$todate'  and transaction_type='$status' group by bureau_transactions.receipt order by transaction_id desc";
	}
    $query=$db2->query($sql);
	$result = $query->result();
	return $result;
	}

	public function get_customer_info($serial){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_transactions INNER JOIN bureau_identity ON bureau_identity.identity_id=bureau_transactions.customer_identity
	INNER JOIN bureau_purpose ON bureau_purpose.purpose_id=bureau_transactions.purposeid where bureau_transactions.serial='$serial'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function get_customer_transaction($serial){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_transactions INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_transactions.currencyid where bureau_transactions.serial='$serial'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_main_stock(){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_stock 
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_stock.currencyid
    WHERE stock_region='$region'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function currency_rates(){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
    $sql = "SELECT * from bureau_currency_rates 
	LEFT JOIN bureau_currency ON bureau_currency.currency_id=bureau_currency_rates.currencyid WHERE stock_region='$region' ORDER BY bureau_stock_created_at DESC";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;	
    }

    public function get_ciunter_buying_rates($id){
    $db2 = $this->load->database('otherdb', TRUE);
    $region = $this->session->userdata('user_region');
    $sql = "SELECT * from bureau_currency_rates WHERE currencyid='$id' AND stock_region='$region'";
    $query = $db2->query($sql);
    $result = $query->row();
    return $result;	
    }

    public function strongroom_verification_information($value){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_stock 
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_stock.currencyid
    WHERE stock_region='$region' AND currencyid='$value'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function get_strong_room_balance_information($id){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_stock 
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_stock.currencyid
    WHERE stock_region='$region' AND currencyid='$id'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function get_bureau_account_expenses(){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_account_expenses WHERE region='$region'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_bureau_account_list(){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_account_list WHERE region='$region'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_bureau_account_banks(){
    $db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
	$sql = "SELECT * from bureau_bank_accounts WHERE region='$region'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_stock_branch_balance_list($branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_branch_stock
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_branch_stock.currencyid where bclno='$branch'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

public function get_stock_branch_opening_balance($branch){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT currencyid,currency_id,currency_desc, currency_name, bclno, bureau_branch_stock_status, SUM(stock_balance) AS total, SUM(stock_balance_out) AS totalout, SUM(stock_balance-stock_balance_out) AS totaldiff from bureau_branch_stock INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_branch_stock.currencyid WHERE bclno='$branch' GROUP BY currencyid";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function COUNTER_BALANCE_get_stock_branch_opening_balance($branch,$id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT currencyid,currency_id,currency_desc, currency_name, bclno, bureau_branch_stock_status, SUM(stock_balance) AS total, SUM(stock_balance_out) AS totalout, SUM(stock_balance-stock_balance_out) AS totaldiff from bureau_branch_stock INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_branch_stock.currencyid WHERE bureau_branch_stock_status='INCOMPLETE' AND bclno='$branch' AND currencyid='$id' GROUP BY currencyid";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($branch,$id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT 
currencyid, 
bclno, 
strongroomstockid,
bureau_branch_stock_id,
stock_balance_out,
stock_balance,
bureau_branch_stock_status, 
bureau_stock_branch_created_at,
stock_balance-stock_balance_out AS Quantityoffifo
FROM bureau_branch_stock 
WHERE bureau_branch_stock_status='INCOMPLETE' AND bclno='$branch' AND currencyid='$id' ORDER BY bureau_stock_branch_created_at ASC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance_TZS($branch,$id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT 
currencyid, 
bclno, 
strongroomstockid,
bureau_branch_stock_id,
stock_balance_out,
stock_balance,
bureau_branch_stock_status, 
bureau_stock_branch_created_at,
stock_balance-stock_balance_out AS Quantityoffifo
FROM bureau_branch_stock 
WHERE bureau_branch_stock_status='INCOMPLETE' AND bclno='$branch' AND currencyid='$id' ORDER BY bureau_stock_branch_created_at ASC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function COUNTER_CURRENCY_FIFO_get_stock_branch_opening_balance($branch,$id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM bureau_branch_stock WHERE bureau_branch_stock_status='INCOMPLETE' AND bclno='$branch' AND currencyid='$id' ORDER BY bureau_stock_branch_created_at ASC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function COUNTER_CURRENCY_FIFO_LATEST_PRICE_get_stock_branch_opening_balance($branch,$id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM bureau_branch_stock WHERE bureau_branch_stock_status='INCOMPLETE' AND bclno='$branch' AND currencyid='$id' ORDER BY bureau_stock_branch_created_at DESC";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

    public function list_stock_request_currency($requestcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_currency_request_list
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_currency_request_list.currencyid where bureau_currency_request_list.requestcode='$requestcode'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function list_denominated_currency($requestcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_request_denomation
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_currency_request_denomation.currencyid where bureau_currency_request_denomation.requestcode='$requestcode'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function list_denominated_currency_branch_listed_specifi($requestcode,$currencyid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_request_denomation
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_currency_request_denomation.currencyid where bureau_currency_request_denomation.requestcode='$requestcode' and bureau_currency_request_denomation.currencyid='$currencyid'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function list_denominated_currency_branch($branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_request_denomation
	INNER JOIN bureau_currency ON bureau_currency.currency_id=bureau_currency_request_denomation.currencyid where bureau_currency_request_denomation.bclno='$branch'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function stock_currency_qty_balance($value){
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_stock WHERE currencyid='$value' AND stock_region='$region'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function branch_stock_currency_qty_balance($currencyid,$bclno){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_branch_stock where currencyid='$currencyid' AND bclno='$bclno'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function check_currency_stock($currency){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_stock where currencyid='$currency'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }

    public function count_stock_pending_request(){
    $db2 = $this->load->database('otherdb', TRUE);
    $empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$sql = "SELECT * from bureau_currency_request where request_status='pending' AND region='$region'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }

    public function get_stock_pending_request(){
    $db2 = $this->load->database('otherdb', TRUE);
    $empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$sql = "SELECT * from bureau_currency_request where request_status='pending' AND region='$region' order by request_created_at DESC";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function currency_stock_information($currency){
       $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_stock where currencyid='$currency'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function currency_stock_branch_information($currency,$branch){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_branch_stock where currencyid='$currency' and bclno='$branch'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function tz_currency_stock_branch_information($branch){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_branch_stock where currencyid=55 and bclno='$branch'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function get_tanzania_balance_list($blcnobranch){
        $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_branch_stock where currencyid=55 AND bclno='$blcnobranch' AND bureau_branch_stock_status='INCOMPLETE'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_stock_request(){
    $empid = $this->session->userdata('user_emid');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_request where requested_by='$empid' and request_status='pending'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_voucher_information($fromdate,$todate,$status){
    $empid = $this->session->userdata('user_emid');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_accounts WHERE DATE(account_created_at) BETWEEN '$fromdate' AND '$todate' 
	AND account_type='$status' AND operator='$empid' AND account_status='SUCCESS' ORDER BY account_created_at ASC";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function get_stock_branch_request(){
    $empid = $this->session->userdata('user_emid');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_branch_request where requested_by='$empid' and request_status='pending'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function count_stock_branch_request($bclno){
    $db2 = $this->load->database('otherdb', TRUE);
    if ($this->session->userdata('user_type') == 'SUPERVISOR'){
	$sql = "select * from bureau_currency_branch_request where tobclno='$bclno' and request_status='pending'";
    } else {
    $sql = "select * from bureau_currency_branch_request where tobclno='$bclno' and request_status='approved'";
    }
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }

    public function list_pending_stock_branch_request($bclno){
    $db2 = $this->load->database('otherdb', TRUE);
    if ($this->session->userdata('user_type') == 'SUPERVISOR'){
	$sql = "select * from bureau_currency_branch_request where tobclno='$bclno' and request_status='pending' ORDER BY request_created_at DESC";
    } else {
    $sql = "select * from bureau_currency_branch_request where tobclno='$bclno' and request_status='approved' ORDER BY request_created_at DESC";
    }
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }

    public function check_branch_bcl_currency_stock($currency,$branch){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_branch_stock where currencyid='$currency' and bclno='$branch'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }

    public function stock_send_get_info($requestcode){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_request where request_code='$requestcode'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function stock_send_get_branch_info($requestcode){
         $db2 = $this->load->database('otherdb', TRUE);
	$sql = "select * from bureau_currency_branch_request where request_code='$requestcode'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function Rate_checkCurrencyExist_StrongRoom($currencyid){
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_currency_rates where currencyid='$currencyid' AND stock_region='$region'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function branch_stock_currency_qty_balance_strog_room($value){
     $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * from bureau_stock where currencyid='$value' AND stock_region='$region'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function delete_stock($deleteid){
        $db2 = $this->load->database('otherdb', TRUE);
	$sql = "delete from bureau_stock where bureau_stock_id='$deleteid'";
	$query = $db2->query($sql);
	return $query;
    }

    public function delete_branch_stock($deleteid){
        $db2 = $this->load->database('otherdb', TRUE);
	$sql = "delete from bureau_branch_stock where bureau_branch_stock_id='$deleteid'";
	$query = $db2->query($sql);
	return $query;
    }

    public function delete_denominated_stock($deleteid){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "delete from bureau_currency_request_denomation where request_denomation_id='$deleteid'";
	$query = $db2->query($sql);
	return $query;
    }

    public function sum_customer_transaction($serial){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT SUM(currency_rate*exchange_amount) as totalamount from bureau_transactions where serial='$serial'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function check_serial_exist_bot($serial){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bureau_bot_transaction_status WHERE bot_serial='$serial'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }

	public function save_selling_transactions($value,$tamount,$tvat,$tcurrency,$name,$phone,$id,$idno,$serial,$purpose,$receipt,$appno,$country){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$sql = "insert into bureau_transactions (customer_name,customer_mobile,customer_identity,customer_identity_no,currencyid,currency_rate,exchange_amount,vat,operator,region,branch,serial,purposeid,receipt,appno,country) values ('$name','$phone','$id','$idno','$tcurrency','$value','$tamount','$tvat','$empid','$region','$branch','$serial','$purpose','$receipt','$appno','$country')";
	$query = $db2->query($sql);
	return $query;
    }

    public function save_buying_transactions($value,$tamount,$tvat,$tcurrency,$name,$phone,$id,$idno,$serial,$purpose,$receipt,$appno,$country){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$sql = "insert into bureau_transactions (customer_name,customer_mobile,customer_identity,customer_identity_no,currencyid,currency_rate,exchange_amount,vat,operator,region,branch,transaction_type,serial,purposeid,receipt,appno,country) values ('$name','$phone','$id','$idno','$tcurrency','$value','$tamount','$tvat','$empid','$region','$branch','02','$serial','$purpose','$receipt','$appno','$country')";
	$query = $db2->query($sql);
	return $query;
    }

public function save_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_stock',$data);
}

public function save_transactions($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_transactions',$data);
}

public function save_stock_request_currency_list($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_request_list',$data);
}

public function save_stock_request_currency_info($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_request',$data);
}

public function save_stock_branch_request_currency_info($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_branch_request',$data);
}

public function save_expenses($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_account_expenses',$data);
}

public function save_books_of_account($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_account_list',$data);
}

public function save_bank_account($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_bank_accounts',$data);
}

public function update_stock($data,$stockid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_stock_id',$stockid);
$db2->update('bureau_stock',$data); 
}

public function update_bureau_bot_status($UpdateBOTdata,$serial){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bot_serial',$serial);
$db2->update('bureau_bot_transaction_status',$UpdateBOTdata); 
}

public function update_bank_accounts($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_bank_accounts_id',$id);
$db2->update('bureau_bank_accounts',$data);
}

public function update_expense($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_account_list_id',$id);
$db2->update('bureau_account_expenses',$data); 
}

public function update_books_of_account($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_account_list_id',$id);
$db2->update('bureau_account_list',$data); 
}

public function Counter_UpdateStrongRoom($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_branch_stock_id',$id);
$db2->update('bureau_branch_stock',$data); 
}

public function update_stock_by_currenctvalue($data,$currencyid){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$region = $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$db2->where('currencyid',$currencyid);
$db2->where('stock_region',$region);
$db2->update('bureau_stock',$data); 
}

public function update_stock_by_currenctvalue_branch_stock_balance($data,$currencyid,$bclno){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('currencyid',$currencyid);
$db2->where('bclno',$bclno);
$db2->update('bureau_branch_stock',$data); 
}

public function update_stock_send_requests($data,$requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('request_code',$requestcode);
$db2->update('bureau_currency_request',$data); 
}

public function update_stock_send_branch_requests($data,$requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('request_code',$requestcode);
$db2->update('bureau_currency_branch_request',$data); 
}

public function update_stock_by_currencyID($data,$currency){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('currencyid',$currency);
$db2->update('bureau_stock',$data); 
}

public function update_stock_strongroom_transaction($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_strong_room_stock_id',$id);
$db2->update('bureau_strong_room_stock_transactions',$data); 
}

public function update_branch_stock_by_currencyID($data,$currency,$branch){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('currencyid',$currency);
$db2->where('bclno',$branch);
$db2->update('bureau_branch_stock',$data); 
}

public function tz_update_branch_stock_by_currencyID($data,$branch){
$currency=55;
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('currencyid',$currency);
$db2->where('bclno',$branch);
$db2->update('bureau_branch_stock',$data); 
}

public function UpdateStrongRoom($data,$stockid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_strong_room_stock_id',$stockid);
$db2->update('bureau_strong_room_stock_transactions',$data); 
}

public function update_currency_rate($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('bureau_currency_rates_id',$id);
$db2->update('bureau_currency_rates',$data); 
}

public function save_branch_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_branch_stock',$data);
}

public function save_accounts_information($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_accounts',$data);
}

public function bureau_currency_sold_out($savesoldout){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_sold',$savesoldout);
}

public function save_issued_branch_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_request_issued',$data);
}

public function Save_StockdHistory($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_strong_room_stock_transactions',$data);
}

public function Save_currency_rate($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_rates',$data);
}

public function save_denomination_branch_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_currency_request_denomation',$data);
}

public function save_bureau_bot_status($SaveBOTdata){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_bot_transaction_status',$SaveBOTdata);
}


public function save_branch_stock_logs($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('bureau_branch_stock_logs',$data);
}

public function get_regions(){
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM em_region WHERE region_name='$region' ORDER BY region_name ASC";
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}

public function get_regions_restriction(){
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM em_region WHERE region_name='$region' ORDER BY region_name ASC";
$query = $this->db->query($sql);
$results = $query->result();
return $results;
}


                  /////////////BCL Branches
		  public function GetBCLById($region_id){
		  $sql    = "SELECT * FROM em_region WHERE region_name='$region_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
				  $id = $result->region_id;
			$this->db->where('region_id',$id);
			$this->db->where('bcl IS NOT NULL', NULL, FALSE);
			$this->db->order_by('branch_name');
			$query = $this->db->get('em_branch');
			$output ='<option value="">Select Branch</option>';
			foreach ($query->result() as $row) {
			$output .='<option value="'.$row->bcl.'">'.$row->branch_name.' : BCLNo. '.$row->bcl.'</option>';
			}
			 return $output;
		  }
                  /////////End of BCL

}