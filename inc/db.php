<?php 
/**
* DB class for CRUD operation
*/
class DB {
	
	private $tableName;
	private $db;

	function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->tableName = $wpdb->prefix.BBITABLENAME;
	}

	public function show_all_installers(){
		echo $this->get_all_installers();
	}

	public function get_all_installers(){
		$html = '';
		$results = $this->db->get_results('SELECT * FROM '. $this->tableName);
		$tableColumns = $this->get_table_columns();

		$html .= '<table class="table table-hover table-bordered ShowTable">';
		$html .= '<thead><tr>';
		foreach ($tableColumns as $tableColumn) {
			$html .= '<th class="text-center text-capitalize">'.$this->prepare_title($tableColumn->Field).'</th>';
		}
		$html .= '<th class="text-center" style="width: 100px;">Action</th>';
		$html .= '</tr> </thead>';

		$html .= '<tbody>';
		foreach ($results as $result) {
			$html .= '<tr id="'. $result->id .'">';
			foreach ($tableColumns as $tableColumn) {
				$fieldName = $tableColumn->Field;
				$html .= '<td>'.$result->$fieldName.'</td>';
			}
			$html .= '<td>';
			$html .= '<button type="submit" id="installer_edit" data_id="'.$result->id.'" class="btn btn-xs btn-primary">Edit</button> ';
			$html .= ' <button type="submit" id="installer_delete" data_id="'.$result->id.'" class="btn btn-xs btn-danger">Delete</button>';
			$html .= '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		// echo "<pre>"; print_r($tableColumns); echo "</pre>";
		return $html;
	}

	private function prepare_title($title){
		return str_replace('_', ' ', $title);
	}

	private function get_table_columns(){
		return $this->db->get_results('SHOW columns FROM '. $this->tableName);
	}

	public function edit_installer(){

		$tableColumns = $this->get_table_columns();

		$html = '';
		$html .= '<a class="btn btn-primary" data-toggle="modal" href="#editInstaller">Trigger modal</a>';
		$html .= '<div class="modal fade" id="editInstaller">';
		$html .= '<div class="modal-dialog">';
		$html .= '<div class="modal-content">';
		$html .= '<div class="modal-header">';
		$html .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		$html .= '<h4 class="modal-title">Edit Installer</h4>';
		$html .= '</div>';
		$html .= '<div class="modal-body">';

		$html .= '<form id="installerForm" action="" method="POST" role="form">';
		foreach ($tableColumns as $tableColumn) {
			$html .= '<div class="form-group">';
			$html .= '<label for="'.$tableColumn->Field.'">'.$this->prepare_title($tableColumn->Field).'</label>';
			$html .= '<input type="text" class="form-control" name="'.$tableColumn->Field.'" placeholder="'.$this->prepare_title($tableColumn->Field).'">';
			$html .= '</div>';
		}
		$html .= '</form>';

		$html .= '</div>';
		$html .= '<div class="modal-footer">';
		$html .= '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
		$html .= '<button id="editInstallerBtn" type="button" class="btn btn-primary">Save changes</button>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}
}

$db = new DB();