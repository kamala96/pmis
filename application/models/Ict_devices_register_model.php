<?php
class Ict_devices_register_model extends CI_Model
{
	public  function list_items()
	{
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "select * from officialuse_items";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	private function ordinal($number)
	{
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number%100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}

	public function get_all_ict_devices() 
	{
		$this->db->join('ict_register_category cat', 'cat.category_id    = r.dev_title', 'left');
		$query = $this->db->get('ict_device_register r');

		$data = [];   
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = array(
					"title"=>$row['category_name'],
					"model"=>$row['dev_model'],
					"serial"=>$row['dev_serial_number'],
					"asset"=>$row['dev_asset_number'],
					"detailed_specs"=>$row['dev_detailed_specs'],
				);

			}
		} 
		return $data;
	}

	public function save_data_to_table($table, $data)
	{
		if($this->db->insert($table, $data)){
			return TRUE;
		}
		else{
			return $this->db->error();
		}
	}


	public function check_if_exists($table, $column, $value, $upper=True)
	{
		$value = $upper ? strtoupper($value) : strtolower($value);
		$this->db->where($column, $value);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_if_exists_based_on_other_column($table, $column, $other_column, $value, $other_value, $upper=True)
	{
		$value = $upper ? strtoupper($value) : strtolower($value);
		$this->db->where($column, $value);
		$this->db->where($other_column, $other_value);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_all_ict_device_categories($work=1) 
	{
		$data = [];  
		$query = $this->db->get('ict_register_category'); 
		if($query->num_rows() > 0)
		{
			if ($work == 1)
			{
				return $query->result_array();
			}
			else
			{
				foreach ($query->result_array() as $row) 
				{
					$data[] = array(
						"title"=>$row['category_name'],
						"date_created"=>date('d F, Y', strtotime($row['category_created_date'])),
						"description"=>$row['category_description'],
					);

				}
			}
		} 
		return $data;
	}

	public function get_all_ict_category_specs_ajax() 
	{
		$data = [];
		$this->db->select('spec.spec_id, spec.spec_label, spec.spec_type, cat.category_name');
		$this->db->join('ict_register_category cat', 'cat.category_id    = spec.spec_category', 'left');
		$query = $this->db->get('ict_device_specifications spec');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = array(
					"category"=>$row['category_name'],
					"label"=>$row['spec_label'],
					"input_field"=>$row['spec_type'],
				);                     
			}
		} 
		return $data;
	}

	public function get_all_ict_device_specifications($category) 
	{
		$this->db->where('spec_category', $category); 
		$query = $this->db->get('ict_device_specifications');
		return $query->result_array();
	}

}

?>