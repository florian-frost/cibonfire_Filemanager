<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_upload_permissions extends Migration {

	// permissions to migrate
	private $permission_values = array(
		array('name' => 'Upload.Testcontext.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Testcontext.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Testcontext.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Testcontext.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Content.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Content.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Content.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Content.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Reports.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Reports.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Reports.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Reports.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Settings.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Settings.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Settings.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Settings.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Developer.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Developer.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Developer.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Upload.Developer.Delete', 'description' => '', 'status' => 'active',),
	);

	//--------------------------------------------------------------------

	public function up()
	{
		$prefix = $this->db->dbprefix;

		// permissions
		foreach ($this->permission_values as $permission_value)
		{
			$permissions_data = $permission_value;
			$this->db->insert("permissions", $permissions_data);
			$role_permissions_data = array('role_id' => '1', 'permission_id' => $this->db->insert_id(),);
			$this->db->insert("role_permissions", $role_permissions_data);
		}
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

        // permissions
		foreach ($this->permission_values as $permission_value)
		{
			$query = $this->db->select('permission_id')->get_where("permissions", array('name' => $permission_value['name'],));
			foreach ($query->result_array() as $row)
			{
				$permission_id = $row['permission_id'];
				$this->db->delete("role_permissions", array('permission_id' => $permission_id));
			}
			$this->db->delete("permissions", array('name' => $permission_value['name']));

		}
	}

	//--------------------------------------------------------------------

}