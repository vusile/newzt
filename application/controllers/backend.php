<?php

/**
* 
*/
class Backend extends CI_Controller
{
	
	function index()
	{
		//if ($this->ion_auth->logged_in())
			$this->_crud((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		//else
		//	redirect('login');
	}

	function making_urls()
	{
		$sections = $this->db->get('sections');
		foreach($sections->result() as $section)
		{
			$data['SectionID'] = $section->SectionID;
			$data['URLSafeTitleDashed'] = $this->make_url_from_title(str_replace('&', 'And', $section->Title),'sections','SectionID',$section->SectionID);
			$datas[]=$data;
		}

		$this->db->update_batch('sections',$datas,'SectionID');
	}

	function _crud($output = null)
	{
		//if ($this->ion_auth->logged_in())
			$this->load->view('backend/crud.php',$output);
		//else
			//redirect('login');
	}

	function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD');	
		$this->load->model('backendmodel');
				
		//$this->load->library('image_CRUD');
	}



	function make_url_from_title($title,$table,$pk,$id)
	{
		
		$url = strtolower(url_title($title));
		

		$this->db->where('URLSafeTitleDashed',$url);
		$obj=$this->db->get($table);

		if($obj->num_rows() > 0)
		{
			$this->db->where($pk,$id);
			$this->db->where('URLSafeTitleDashed',$url);
			$obj=$this->db->get($table);
			
			if( $obj->num_rows() == 0 )
				$url = $this->make_url_from_title($url . '-' . $url,$table,$pk,$id);
		
		}
	
		return $url;
		
	}
	


	function sections()
	{

		$this->grocery_crud->set_relation('ParentSectionID','sections','Title');
		$this->backendmodel->crud('sections');

	}

	function categories()
	{
		$this->grocery_crud->set_field_upload('ImageFile','images/categories');
		$this->grocery_crud->set_relation('ParentSectionID','sections','Title');

		$this->grocery_crud->set_relation('SectionID','sections','Title');

		$this->backendmodel->crud('categories');

	}

	function ngotypes()
	{
		$this->backendmodel->crud('ngotypes');
	}


	function autoemails()
	{
		$this->grocery_crud->set_relation('AutoEmailTypeID','autoemailtypes','Title');
		$this->backendmodel->crud('autoemails');
		
	}


	function badlistingreasons()
	{
		$this->backendmodel->crud('badlistingreasons');	
	}	

	function sectionforms()
	{
		$this->grocery_crud->set_relation('Section','sections','Title');
		$this->grocery_crud->set_relation_n_n('fields', 'sectionformfields', 'input_type_tbl', 'SectionFormID', 'FieldID', 'input_name','OrderNum');
		$this->grocery_crud->callback_after_insert(array($this, 'sectionformscallback'));
		$this->grocery_crud->callback_after_update(array($this, 'sectionformscallback'));
		$this->grocery_crud->unset_fields('view_fields');
		$this->grocery_crud->unset_columns('fields');	
		$this->backendmodel->crud('sectionforms');	
	}

	function sectionformscallback($post_array, $primary_key) 
	{
		$data['view_fields'] = "<a href = '" . base_url() . "backend/sectionformfields/" . $primary_key . "'>View</a>";
		$this->db->where('SectionFormID', $primary_key);
		$this->db->update('sectionforms', $data);


	}

	function sectionformfields($SectionFormID)
	{
		$this->grocery_crud->where('SectionFormID',$SectionFormID);
		$this->grocery_crud->set_relation('FieldID','input_type_tbl','input_name');
		$this->grocery_crud->set_relation_n_n('validation', 'sectionformsvalidation', 'forminputvalidationrules', 'SectionFormFieldsID', 'ValidationRuleID', 'input_rules');
		$this->grocery_crud->unset_fields('SectionFormID');
		$this->grocery_crud->unset_columns('SectionFormID');
		$this->grocery_crud->order_by('OrderNum');
		$this->backendmodel->crud('sectionformfields');	
	}

	function categoryforms()
	{
		$this->grocery_crud->set_relation('Category','categories','Title');
		$this->grocery_crud->set_relation_n_n('fields', 'categoryformfields', 'input_type_tbl', 'CategoryFormID', 'FieldID', 'input_name','OrderNum');
		$this->grocery_crud->callback_after_insert(array($this, 'categoryformscallback'));
		$this->grocery_crud->callback_after_update(array($this, 'categoryformscallback'));
		$this->grocery_crud->unset_fields('view_fields');
		$this->grocery_crud->unset_columns('fields');	
		$this->backendmodel->crud('categoryforms');	
	}

	function categoryformscallback($post_array, $primary_key) 
	{
		$data['view_fields'] = "<a href = '" . base_url() . "backend/categoryformfields/" . $primary_key . "'>View</a>";
		$this->db->where('CategoryFormID', $primary_key);
		$this->db->update('categoryforms', $data);


	}

	function categoryformfields($CategoryFormID)
	{
		$this->grocery_crud->where('CategoryFormID',$CategoryFormID);
		$this->grocery_crud->set_relation('FieldID','input_type_tbl','input_name');
		$this->grocery_crud->set_relation_n_n('validation', 'categoryformsvalidation', 'forminputvalidationrules', 'CategoryFormFieldsID', 'ValidationRuleID', 'input_rules');
		$this->grocery_crud->unset_fields('CategoryFormID');
		$this->grocery_crud->unset_columns('CategoryFormID');
		$this->grocery_crud->order_by('OrderNum');
		$this->backendmodel->crud('categoryformfields');	
	}


	function searchforms()
	{
		$this->grocery_crud->set_relation('SectionID','sections','Title');
		$this->grocery_crud->set_relation_n_n('search_fields', 'searchformfields', 'input_type_tbl', 'SearchFormID', 'SearchFieldID', 'input_name','OrderNum');
		$this->grocery_crud->callback_after_insert(array($this, 'searchformscallback'));
		$this->grocery_crud->callback_after_update(array($this, 'searchformscallback'));
		$this->grocery_crud->unset_fields('view_fields');
		$this->grocery_crud->unset_columns('fields');	
		$this->backendmodel->crud('searchforms');
	}

	function searchformscallback($post_array,$primary_key)
	{
		$data['view_fields'] = "<a href = '" . base_url() . "backend/searchformfields/" . $primary_key . "'>View</a>";
		$this->db->where('SearchFormID', $primary_key);
		$this->db->update('searchforms', $data);
	}

	function searchformfields($SearchFormID)
	{
		$this->grocery_crud->where('SearchFormID',$SearchFormID);
		$this->grocery_crud->set_relation('SearchFieldID','input_type_tbl','input_name');
		$this->grocery_crud->set_relation_n_n('validation', 'searchformsvalidation', 'forminputvalidationrules', 'SearchFormFieldID', 'ValidationRuleID', 'input_rules');
		$this->grocery_crud->unset_fields('SearchFormID');
		$this->grocery_crud->unset_columns('SearchFormID');
		$this->grocery_crud->order_by('OrderNum');
		$this->backendmodel->crud('searchformfields');	

	}


	function parks()
	{
		$this->backendmodel->crud('parks');	
	}

	function input_type_tbl()
	{
		$this->backendmodel->crud('input_type_tbl');	
	}

	function areas()
	{
		$this->backendmodel->crud('areas');	
	}

	function listingtypes()
	{
		$this->backendmodel->crud('listingtypes');	
	}

	function cuisines()
	{
		$this->backendmodel->crud('cuisines');	
	}

	function locations()
	{
		$this->backendmodel->crud('locations');	
	}


	function amenities()
	{
		$this->backendmodel->crud('amenities');	
	}

	function relevantlinks()
	{
		$this->backendmodel->crud('relevantlinks');	
	}


	function listings($status)
	{

		$this->grocery_crud->where('Reviewed',$status);
		$this->backendmodel->crud('listings');	
	}

	function tenders()
	{

		$this->grocery_crud->edit_fields('Email','SubjectLine','EmailBody','Listings','Attachments','DateCreated','Reviewed');

		$this->grocery_crud->unset_columns('Reviewed','Attachments');

		$this->grocery_crud->set_theme('datatables');

		

		$this->grocery_crud->set_relation_n_n('Listings','tenderlistings','listings','TenderID','ListingID','Title','',array('ListingTypeID' => '1,2,20,14'));
		// $this->grocery_crud->callback_edit_field('Listings',array($this,'edit_tenders_field_callback_1'));
		$this->grocery_crud->callback_edit_field('Attachments',array($this,'edit_tenders_field_callback_2'));
		$this->grocery_crud->callback_edit_field('Reviewed',array($this,'edit_tenders_field_callback_3'));
		$this->grocery_crud->callback_after_update(array($this, 'tenders_call_back_after_update'));
		$this->backendmodel->crud('tenders');	
	}

	function edit_tenders_field_callback_1($value, $primary_key)
	{
		$listingsLinks = "";
		$this->db->where('TenderID', $primary_key);
		$listings=$this->db->get('tenderlistings');
		foreach ($listings->result() as $listing) {
			$listingsLinks .= $listing->ListingID . '<br>';
		}

		return $listingsLinks;
	}

	function edit_tenders_field_callback_2($value, $primary_key)
	{
		$docLinks = "";
		$this->db->where('TenderID', $primary_key);
		$docs=$this->db->get('tenderdocs');
		foreach ($docs->result() as $doc) {
			$docLinks .= "<a href= '" . base_url() . "tempuploads/" . $doc->FileName . "'>" . $doc->FileName . "</a><br>";
		}

		return $docLinks;
	}

	function edit_tenders_field_callback_3($value, $primary_key)
	{
		if($value == 1)
			return '<input type="checkbox" checked maxlength="50"  name="Reviewed">';
		else
			return '<input type="checkbox" maxlength="50"  name="Reviewed">';

	}

	function tenders_call_back_after_update($post_array,$primary_key)
	{
		if(isset($post_array['Reviewed']))
		{

			$UserID = $this->ion_auth->user()->row()->UserID;
			$this->db->where('TenderID',$primary_key);
			$this->db->update('tenders', array('Reviewed'=>1,'DateReviewed'=>date('Y-m-d H:i:s'),'ReviewedByID'=>$UserID));


			$this->db->where('TenderID',$primary_key);
			$tender=$this->db->get('tenders')->row();

			$this->db->where('TenderID', $primary_key);
			$attachments=$this->db->get('tenderdocs');

			$this->db->where('TenderID', $primary_key);
			$listings = $this->db->get('tenderlistings');

			if($listings->num_rows() > 0)
			{

				$this->load->library('email');
				$this->email->from('inquiry@ZoomTanzania.com', 'inquiry@ZoomTanzania.com');
				$this->email->subject($tender->SubjectLine);

				
				


				if($attachments->num_rows() >0)
				{
					foreach ($attachments->result() as $attachment) {
						$this->email->attach('tempuploads/' . $attachment->FileName);
					}
				}

				$where_in_listings = array();
				foreach ($listings->result() as $listing) {
					$where_in_listings[]=$listing->ListingID;
				}

				$this->db->where_in('ListingID', $where_in_listings);
				$listings=$this->db->get('listingsview');

				foreach ($listings->result() as $listing) {
					// $this->email->to($listing->PublicEmail); 
	                $this->email->bcc('terence@ZoomTanzania.com'); 

	                $message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html><head><title>' . $tender->SubjectLine . '</title></head><body>';

					$message .= "A request regarding your listing on ZoomTanzania.com for " . $listing->Title . " :<br>Listing ID: " . $listing->ListingID . " - <a href='" . url_title($listing->Title) . "'>" . $listing->Title . "</a><br><br>Please Do Not Reply to This Email. Instead, copy and paste the senders email address " . $tender->Email . " into your email program.<br><br>Message: ";

    				$message .= $tender->EmailBody;
					$message .= "</body></html>";
					$this->email->message($message);
					$this->email->send();

				}
			}

		}

		else
		{
			$this->db->where('TenderID',$primary_key);
			$this->db->update('tenders', array('Reviewed'=>0));
		}
	}



	function messages($spamStatus)
	{
		if($spamStatus==0)
		{
			$this->grocery_crud->where('IsSent',1);
			$this->grocery_crud->where('IsSpam',$spamStatus);
			$this->backendmodel->crud('messages');	
		}
		else
		{
			$this->db->where('IsSpam',$spamStatus);
			$this->db->where('Reviewed',0);
			$this->db->where('IsSent',0);
			$data['data'] = $this->db->get('messages');

			$this->load->view('mymessagescrud', $data);

			// $this->grocery_crud->unset_columns('DefensioPass','DefensioSignature','DefensioSpaminess','MessageWrapper','Attachments','CFFormProtectPass');
			// $this->grocery_crud->where('IsSent',0);
			// $this->grocery_crud->where('IsSpam',$spamStatus);
			// $this->backendmodel->crud('messages');	

		}
	}

	function reviewmessages()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('MessagesIDs[]', 'Message','required');
        if($this->form_validation->run() == TRUE)
        {
        	print_r($this->input->post('MessagesIDs'));

        }
        else
        {
        	$this->messages(1);
        }
	}

	function edit_message($messageID)
	{
		$this->db->where('MessageID',$messageID);
		$data['message']=$this->db->get('messages')->row();

		$this->load->view('mymessagescrudedit', $data);

	}

	function update_message()
	{
		$this->load->library('Defensio',array("api_key"=>DEFENSIOAPIKEY));
		$defensio = new Defensio(DEFENSIOAPIKEY);

		if($this->input->post('messageID') and !$this->input->post('IsSpam'))
		{
			$spamStatus = array('IsSpam' => 0,'Reviewed'=>1);
			$this->db->where('MessageID', $this->input->post('messageID'));
			$this->db->update('messages', $spamStatus);
			try {
				$defensio->putDocument($this->input->post('signature'), array('allow' => 'true'));
				
			} catch (DefensioUnexpectedHTTPStatus $e) {
				redirect('backend/edit_message/' . $this->input->post('messageID') . '	?message=Something%20went%20wrong%20call%20Terence');
				
			}
			redirect('backend/edit_message/' . $this->input->post('messageID') . '?message=Message%20has%20been%20updated');

		}
		else
		{
			$spamStatus = array('IsSpam' => 1,'Reviewed'=>1);
			$this->db->where('MessageID', $this->input->post('messageID'));
			$this->db->update('messages', $spamStatus);

			try {
				$defensio->putDocument($this->input->post('signature'), array('allow' => 'false'));
				
			} catch (DefensioUnexpectedHTTPStatus $e) {
				redirect('backend/edit_message/' . $this->input->post('messageID') . '	?message=Something%20went%20wrong%20call%20Terence');
				
			}
			redirect('backend/edit_message/' . $this->input->post('messageID') . '?message=Message%20has%20been%20updated');
		}
	}

	function confirm_delete_message($messageID)
	{
		echo "Are you sure you want to delete this message? <a href = '" . base_url() . "backend/delete_message/" . $messageID . "'>Yes</a> - <a href = '" . base_url() . "backend/messages/1'>No</a>";
	}

	function delete_message($messageID)
	{
		$this->db->where('MessageID',$messageID);
		$this->db->delete('messages');
		redirect('backend/messages/1?message=Message%20has%20been%20deleted');
	}

	function send_message($messageID)
	{
		$this->db->where('MessageID',$messageID);
		$message=$this->db->get('messages')->row();
        $this->load->library('email');
        $this->email->subject($message->Subject);
        $this->email->from('inquiry@ZoomTanzania.com', 'inquiry@ZoomTanzania.com');
        // $this->email->to($message->ToAddress); 
        $this->email->bcc('terence@ZoomTanzania.com'); 

        if($message->Attachments)
        {
        	$Attachments=explode(',', $message->Attachments);
        	foreach ($Attachments as $key => $value) {
        		$this->email->attach('tempuploads/' . $value);
        	}
        }

        $this->email->message($message->MessageWrapper);

        if($this->email->send())
        {
        	$this->db->where('MessageID',$messageID);
        	$this->db->update('messages', array('IsSent'=>1));

        	redirect('backend/edit_message/' . $messageID . '?message=Message%20has%20been%20sent');
        }
        else
        	redirect('backend/edit_message/' . $messageID . '?message=Message%20has%20not%20sent%20inform%20Terence');
	}

	function main_menu_items()
	{

		$this->grocery_crud->set_relation('SectionID','sections','Title');
		// $this->grocery_crud->set_relation('promotional_link_1','sections','Title');
		// $this->grocery_crud->set_relation('promotional_link_2','sections','Title');
		$this->grocery_crud->set_field_upload('promotional_image_1','images/sitewide');
		$this->grocery_crud->set_field_upload('promotional_image_2','images/sitewide');
		$this->grocery_crud->unset_columns('URLSafeTitleDashed');
		$this->grocery_crud->unset_fields('URLSafeTitleDashed');

		//$this->grocery_crud->set_relation('ParentSectionID','sections','Title');
		$this->backendmodel->crud('main_menu_items');	

	}
}