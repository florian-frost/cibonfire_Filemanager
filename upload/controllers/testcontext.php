<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class testcontext extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Upload.Testcontext.View');
		$this->load->model('upload_model', null, true);
		$this->lang->load('upload');
		
		Template::set_block('sub_nav', 'testcontext/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->upload_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('upload_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('upload_delete_failure') . $this->upload_model->error, 'error');
				}
			}
		}

		$records = $this->upload_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Upload');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Upload object.
	*/
	public function create()
	{
		$this->auth->restrict('Upload.Testcontext.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_upload())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('upload_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'upload');

				Template::set_message(lang('upload_create_success'), 'success');
				redirect(SITE_AREA .'/testcontext/upload');
			}
			else
			{
				Template::set_message(lang('upload_create_failure') . $this->upload_model->error, 'error');
			}
		}
		Assets::add_module_js('upload', 'upload.js');

		Template::set('toolbar_title', lang('upload_create') . ' Upload');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Upload data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('upload_invalid_id'), 'error');
			redirect(SITE_AREA .'/testcontext/upload');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Upload.Testcontext.Edit');

			if ($this->save_upload('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('upload_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'upload');

				Template::set_message(lang('upload_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('upload_edit_failure') . $this->upload_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Upload.Testcontext.Delete');

			if ($this->upload_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('upload_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'upload');

				Template::set_message(lang('upload_delete_success'), 'success');

				redirect(SITE_AREA .'/testcontext/upload');
			} else
			{
				Template::set_message(lang('upload_delete_failure') . $this->upload_model->error, 'error');
			}
		}
		Template::set('upload', $this->upload_model->find($id));
		Assets::add_module_js('upload', 'upload.js');

		Template::set('toolbar_title', lang('upload_edit') . ' Upload');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_upload()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_upload($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('upload_name','Name','alpha_extra|max_length[200]');
		$this->form_validation->set_rules('upload_description','Description','alpha_extra');
		$this->form_validation->set_rules('upload_tags','Tags','alpha_extra|max_length[255]');
		$this->form_validation->set_rules('upload_public','Public','required|is_numeric|max_length[1]');
		$this->form_validation->set_rules('upload_md5_checksum','MD5 Checksum','required|alpha_numeric|max_length[255]');
		$this->form_validation->set_rules('upload_owner_userid','Owner','required|is_numeric|max_length[11]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['upload_name']        = $this->input->post('upload_name');
		$data['upload_description']        = $this->input->post('upload_description');
		$data['upload_tags']        = $this->input->post('upload_tags');
		$data['upload_public']        = $this->input->post('upload_public');
		$data['upload_md5_checksum']        = $this->input->post('upload_md5_checksum');
		$data['upload_owner_userid']        = $this->input->post('upload_owner_userid');

		if ($type == 'insert')
		{
			$id = $this->upload_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->upload_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}