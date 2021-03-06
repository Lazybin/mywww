<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	/**
     * 传递到对应视图的数据
     *
     * @access private
     * @var array
     */
	private $_data;

	/**
     * 当前用户ID
     *
     * @access private
     * @var integer
     */	
	private $_uid = 0;

	/**
     * Referer
     *
     * @access public
     * @var string
     */
	public $referrer;

	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(TRUE);

		$this->load->library('auth');
		$this->load->helper('form');//引入CI框架 form辅助函数
		$this->load->library('form_validation');
		
		$this->load->model('user', 'user_mdl');
		
		$this->_check_referrer();
		
		$this->_data['page_title'] = '登录';
	}

	 /**
     * 检查referrer
     * 即他从什么地方来的，这样登陆之后可以回到原来的页面。
     * @access private
     * @return void
     */
	private function _check_referrer()
	{
		$ref = $this->input->get('ref', TRUE);
		
		$this->referrer = (!empty($ref)) ? $ref : '/blogs/index';
	}

	/**
     * 配置表单验证规则
     * 
     * @access private
     * @return void
     */
	private function _load_validation_rules()
	{
		$this->form_validation->set_rules('userName', '用户名', 'required|trim|callback__username_check|strip_tags');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|matches[confirm]');
		$this->form_validation->set_rules('confirm', 'Password Confirmation', 'required|min_length[5]');
		
		$this->form_validation->set_rules('screenName', '昵称', 'required|trim|callback__screenName_check|strip_tags');
		$this->form_validation->set_message('required', '%s不能为空');
		$this->form_validation->set_message('min_length', '%s不能少于%s 位');
		//$this->form_validation->set_rules('group', '用户组', 'trim');
	}
	
	 /**
     * 回调函数：检查用户名是否唯一
     * 
     * @access 	public
     * @param 	$str 输入值
     * @return 	bool
     */
	public function _username_check($str)
	{
		if($this->user_mdl->check_exist('userName', $str))
		{
			$this->form_validation->set_message('_email_check', '系统已经存在一个为 '.$str.' 的邮箱');
			
			return FALSE;
		}
		return TRUE;
	}
	
	 /**
     * 回调函数：检查screenName是否唯一
     * 
     * @access 	public
     * @param 	$str 输入值
     * @return 	bool
     */
	public function _screenName_check($str)
	{
		if($this->user_mdl->check_exist('screenName', $str))
		{
			$this->form_validation->set_message('_screenName_check', '系统已经存在一个为 '.$str.' 的昵称');
			
			return FALSE;
		}
			
		return TRUE;
	}

	/**
     *注册
     * 
     * @access private
     * @return void
     */
	public function register()
	{
		$this->load->helper('url');
		$this->_data['page_title'] = '注册';

		if($this->auth->hasLogin())
		{
			redirect($this->referrer);
		}

		$this->_load_validation_rules();
		if ($this->form_validation->run() == FALSE)
	  	{
	   		$this->load->view('register');
	  	}
	  	else
	  	{
	  		$this->user_mdl->add_user(
				array(
					'username' 	=>	$this->input->post('userName',TRUE),
					'password' 	=>	$this->input->post('password',TRUE),
					'screenName'=>	$this->input->post('screenName',TRUE),					
					'created'	=>	time(),
					'activated'	=>	0,
					'logged'	=>	0
				)
			);
			
			$this->session->set_flashdata('success', '成功添加一个用户账号');
			echo $this->referrer;
			redirect($this->referrer);
			//go_back();
	  	}
	}

	/**
     * 登陆
     * 
     * @access private
     * @return void
     */
	public function login()
	{
		if($this->auth->hasLogin())
		{
			redirect($this->referrer);
		}

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[2]|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE)
	  	{
	   		$this->load->view('login');
	  	}
	  	else
	  	{
	  		$user = $this->user_mdl->validate_user(
								$this->input->post('username', TRUE), 
								$this->input->post('password', TRUE)
								);
			
			if(!empty($user))
			{
				if($this->auth->process_login($user))
				{
					redirect($this->referrer);
				}
			}
			else
			{
				sleep(1);//嘿嘿，谁爆破密码就让谁睡
				
				$this->session->set_flashdata('login_error', 'TRUE');
				
				$this->form_validation->error_string = '用户名或密码无效';
				
				$this->load->view('admin/login', $this->_data);
			}
	   		//$this->load->view('formsuccess');
	  	}
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */