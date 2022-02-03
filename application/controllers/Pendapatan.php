<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 
 * @author     Srimonika Br Brahmana <srimonika19.sembiring@gmail.com>
 * @copyright  2017
 * @license    Unikom
 *
 */

class Pendapatan extends MY_Controller 
{

	public function index()
	{
		$this->load->view('pendapatan/data');
	}





	public function list_pendapatan_json()
	{
		$this->load->model('M_transaksi_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_transaksi_master->fetch_data_pendapatan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			
			$nestedData[]	= tanggal($row['tanggal']);
			$nestedData[]	= $row['nama'];
			$nestedData[]	= ucfirst($row['keterangan']);
			$nestedData[]	= $row['nilai'];
			

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}

	
}