<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends BF_Model {

	protected $table		= "upload";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created";
	protected $modified_field = "modified";
}
