<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Myaccount extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->model('listingsmodel');
	}


	function index()
	{
		if(!$this->ion_auth->logged_in())
			$this->login();
		else $this->account();
	}

	function login()
	{
		if(!$this->ion_auth->logged_in())
		{

			$header['Meta']->H1Text = "Login";
	        $this->load->view('header', $header);
	        $this->load->view('menu');
	        if (isset($left_side))
	            $this->load->view('left-sidetower', $leftSide);
	        else
	            $this->load->view('left-sidetower');
	        $this->load->view('login');
	        
	        $this->load->view('right-sidetower');
	        $this->load->view('footer');
	    }
	    else
	    	redirect(base_url());
			
	}

	function login_user()
	{
		$identity = $this->input->post('Email');
		$password = $this->input->post('Password');

		if(!$this->ion_auth->login($identity, $password))
			$this->login();
		else
		{
			$this->db->where('UserID', $this->session->userdata('user_id'));
			$jobClicksObj=$this->db->get('jobclicks');

			if($jobClicksObj->num_rows() == 0)
			{
				$array = array(
					'jobclicks' => 0
				);
				
				$this->session->set_userdata( $array );
			}
			else
			{
				$array = array(
					'jobclicks' => $jobClicksObj->row()->ClickCount
				);
				
				$this->session->set_userdata( $array );
			}

			 echo $this->ion_auth->errors(); 
			 echo $this->ion_auth->messages(); 
			 print_r($this->session->all_userdata());

			if($this->session->userdata('ListingID'))
			{
				redirect('listingdetail?ListingID=' . $this->session->userdata('ListingID'));
			}
			else
			{
				redirect('myaccount');
			}
		}
	}

	function logout()
	{
		if($this->ion_auth->logout())
			$this->login();
	}

	function update()
	{

	}

	function update_details($UserID)
	{
		
		$this->load->library('form_validation');

		// $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		// $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		// $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[lh_users.email]');
		$this->form_validation->set_rules('BirthYearID', 'Birth Year', 'required');
		$this->form_validation->set_rules('BirthMonthID', 'Birth Month', 'required');
		$this->form_validation->set_rules('SelfIdentifiedTypeID', 'How you describe yourself', 'required');
		$this->form_validation->set_rules('EducationLevelID', 'Education Level', 'required');
		$this->form_validation->set_rules('FirstName', 'First Name', 'required');
		$this->form_validation->set_rules('LastName', 'Last Name', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$date = new DateTime($this->input->post('BirthYearID') . '/' . $this->input->post('BirthMonthID') . '/01'  );
			$AgeGroupID = $this->calculate_agegroup($date);

			$additional = array(
				'FirstName'=> $this->input->post('FirstName'),
				'LastName'=> $this->input->post('LastName'),
				'AreaID' => $this->input->post('AreaID'),
				'BirthYearID' => $this->input->post('BirthYearID'),
				'BirthMonthID' => $this->input->post('BirthMonthID'),
				'SelfIdentifiedTypeID' => $this->input->post('SelfIdentifiedTypeID'),
				'EducationLevelID' => $this->input->post('EducationLevelID'),
				'GenderID'=>$this->input->post('GenderID'),
				'AgeGroupID' => $AgeGroupID
				);

			$this->ion_auth->update($UserID, $additional);
		}
		else
		{
			$this->update();
		}
	}

	function createaccount()
	{

	}


	function calculate_agegroup($date)
	{

		$now = new DateTime();
		$interval = $now->diff($date);
		$age = $interval->y;

		switch ($age) {
			case ($age <= 21) :
				$AgeGroupID = 1;
				break;			
			case ($age >= 21 and $age <=30) :
				$AgeGroupID = 2;
				break;

			case ($age >= 31 and $age <=44) :
				$AgeGroupID = 3;
				break;

			case ($age >= 45 and $age <=60) :
				$AgeGroupID = 4;
				break;

			case ($age > 60) :
				$AgeGroupID = 5;
				break;
			
			default:
				$AgeGroupID = 0;
				break;
		}

		return $AgeGroupID;
	}

	function register()
	{
		if(!$this->ion_auth->logged_in())
		{

			$this->db->order_by('OrderNum');
			$data['areas'] = $this->db->get('areas');

			$this->db->order_by('OrderNum');
			$data['selfidentifiedtypes'] = $this->db->get('selfidentifiedtypes');

			$this->db->order_by('OrderNum');
			$data['educationlevels'] = $this->db->get('educationlevels');

			$header['Meta']->H1Text = "Register";
	        $this->load->view('header', $header);
	        $this->load->view('menu');
	        if (isset($left_side))
	            $this->load->view('left-sidetower', $leftSide);
	        else
	            $this->load->view('left-sidetower');
	        $this->load->view('register',$data);
	        
	        $this->load->view('right-sidetower');
	        $this->load->view('footer');
	    }
	    else
	    	redirect(base_url());
			
	}

	function registeruser()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'This email is already registered. Please try to login');
		$this->form_validation->set_rules('Password', 'Password', 'required|matches[PassConf]');
		$this->form_validation->set_rules('PassConf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('Email', 'Email', 'required|matches[EmailConf]valid_email|is_unique[lh_users.Username]');
		$this->form_validation->set_rules('BirthYearID', 'Birth Year', 'required');
		$this->form_validation->set_rules('BirthMonthID', 'Birth Month', 'required');
		$this->form_validation->set_rules('SelfIdentifiedTypeID', 'How you describe yourself', 'required');
		$this->form_validation->set_rules('EducationLevelID', 'Education Level', 'required');
		$this->form_validation->set_rules('FirstName', 'First Name / Alias', 'required');
		// $this->form_validation->set_rules('LastName', 'Last Name', 'required');

		if ($this->form_validation->run() == TRUE)
		{

			$date = new DateTime($this->input->post('BirthYearID') . '/' . $this->input->post('BirthMonthID') . '/01'  );
			$AgeGroupID = $this->calculate_agegroup($date);
			
				// 'LastName'=> $this->input->post('LastName'),

			$username = $this->input->post('Email');
			$password = $this->input->post('Password');
			$email = $this->input->post('Email');
			$additional = array(
				'ContactFirstName'=> $this->input->post('FirstName'),
				'ContactEmail'=> $this->input->post('Email'),
				'AreaID' => $this->input->post('AreaID'),
				'BirthYearID' => $this->input->post('BirthYearID'),
				'BirthMonthID' => $this->input->post('BirthMonthID'),
				'SelfIdentifiedTypeID' => $this->input->post('SelfIdentifiedTypeID'),
				'EducationLevelID' => $this->input->post('EducationLevelID'),
				'GenderID'=>$this->input->post('GenderID'),
				'AgeGroupID' => $AgeGroupID,
				'DateCreated' => date('Y-m-d H:i:s')
				);

			if($this->ion_auth->register($username,$password,$email,$additional))
			{

				$data['message']="Your have been registered. An email has been sent to your email address to confirm your account. Please click on the link provided in the email to activate your account.";
				$data['title']="Registration Successful";
				$header['Meta']->H1Text = "Register";

		        $this->load->view('header', $header);
		        $this->load->view('menu');
		        if (isset($left_side))
		            $this->load->view('left-sidetower', $leftSide);
		        else
		            $this->load->view('left-sidetower');
		        $this->load->view('message',$data);
		        
		        $this->load->view('right-sidetower');
		        $this->load->view('footer');
			}
				
			else
			{
				$data['message']=$this->ion_auth->errors();

				$data['title']="Registration Not Successful";
				$header['Meta']->H1Text = "Register";
				
		        $this->load->view('header', $header);
		        $this->load->view('menu');
		        if (isset($left_side))
		            $this->load->view('left-sidetower', $leftSide);
		        else
		            $this->load->view('left-sidetower');
		        $this->load->view('message',$data);
		        
		        $this->load->view('right-sidetower');
		        $this->load->view('footer');
				
			}
		}
		
		else
		{
			$this->register();
		}	
	}

	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			// redirect("auth", 'refresh');

			$activationData = array(
				'ConfirmationID'=>$code,
				'ConfirmedDate'=>date('Y-m-d H:i:s')
				);

			$this->db->where('UserID', $id);
			$this->db->update('lh_users', $activationData);

			$data['message']=$this->ion_auth->messages();
			$data['title']="Activation Successful";
			$header['Meta']->H1Text = "Register";

	        $this->load->view('header', $header);
	        $this->load->view('menu');
	        if (isset($left_side))
	            $this->load->view('left-sidetower', $leftSide);
	        else
	            $this->load->view('left-sidetower');
	        $this->load->view('message',$data);
	        
	        $this->load->view('right-sidetower');
	        $this->load->view('footer');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			// redirect("auth/forgot_password", 'refresh');
			$data['message']=$this->ion_auth->errors();

			$data['title']="Activation Not Successful";
			$header['Meta']->H1Text = "Register";
			
	        $this->load->view('header', $header);
	        $this->load->view('menu');
	        if (isset($left_side))
	            $this->load->view('left-sidetower', $leftSide);
	        else
	            $this->load->view('left-sidetower');
	        $this->load->view('message',$data);
	        
	        $this->load->view('right-sidetower');
	        $this->load->view('footer');
		}
	}
	

	function forgotpassword()
	{

	}

	function send_password()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == TRUE)
		{
//			$this->db->where('UPPER(Username)', strtoupper($this->input->post('email')),true);

			$this->db->where('UPPER(Username)', strtoupper('terence@ZoomTanzania.com'),true);
			$user=$this->db->get('lh_users');

			if($user->num_rows() > 0)
			{

				$password = $user->row()->Password;

				$this->load->library('email');
				
				$this->email->from('inquiry@zoomtanzania.com', 'ZoomTanzania.com');
				$this->email->to($this->input->post('email'));
		
				$this->db->where('AutoEmailID', 18);
				$emailObj = $this->db->get('AutoEmails');

				$subject = $emailObj->row()->SubjectLine;
				$message = $emailObj->row()->Body;

				$search = array(
				     '%password%'
				);
				$replace = array(
				     $password
				);
				$message = str_replace($search, $replace, $message);

				//echo $message;

				$this->email->subject('subject');
				$this->email->message('message');
				
				$this->email->send();
				
				//echo $this->email->print_debugger();
			}

			else
			{
				echo "That email address is not registered";
			}
		}

		else
		{
			$this->forgotpassword();
		}

	}


	

	function account()
	{

		if(!$this->ion_auth->logged_in())
			$this->login();
		else
		{
			$ListingStatuses = array('Pending Review','Live');
			$data['accountListingsObj']=$accountListingsObj=$this->listingsmodel->getMyListings();

			$ListingIDs = "";

			foreach ($accountListingsObj->result() as $Listing) {
				$ListingIDs .= $Listing->ListingID . ', ';
			}



			// $data['listingOrders'] = $this->listingsmodel->getListingOrders(substr($ListingIDs, 0,-2));

			
			$header['Meta']->H1Text = "My Account";
	        $this->load->view('header', $header);
	        $this->load->view('menu');
	        if (isset($left_side))
	            $this->load->view('left-sidetower', $leftSide);
	        else
	            $this->load->view('left-sidetower');
	        
			$this->load->view('myaccount_listings',$data);
	        
	        $this->load->view('right-sidetower');
	        $this->load->view('footer');
		}
		
	}
}