<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Listings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('listingsmodel');
    }

    function testmenu() {
        $this->common->menu();
    }

    public function index($pageURL = '') {

        if ($pageURL != '') {

            if ($pageURL == 'forms')
            {
                echo $this->tryForms(1);

            }

            if (method_exists($this, $pageURL))
            {
                $this->$pageURL();//Of course this has to be checked. Now I'm passing one as the only parameter.
            }

            else
            {
            

            $res = $this->listingsmodel->determiner($pageURL);
            //echo $this->db->last_query();


            if (isset($res->row()->ListingID)) {
                $this->listingdetail($res->row()->ListingID);

            } 

            else if (isset($res->row()->ParentPageID)) {

            $function = explode('.', $res->row()->FileName);


            if (method_exists($this, $function[0]))
                $this->$function[0]($res);
            else
                $this->page($res);
            }

            else if (isset($res->row()->CategoryID) and !isset($res->row()->ListingID)) {
            
                if(!$res->row()->ParentSectionID)
                    $res->row()->ParentSectionID = $res->row()->SectionID;

                switch ($res->row()->ParentSectionID) {
                    case '1':
                        $this->tanzania_business_directory($res->row()->secURL, $res->row()->catURL);
                        break;

                    case '4':
                        $details = array();
                        if ($res->row()->SectionID) {

                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        $this->steals_deals_and_classifieds($details,$res->row()->CategoryID);
                        break;
                  

                    case '5':
                        $details = array();
                        if ($res->row()->ParentSectionID) {
                            $details['ParentSectionID'] = $res->row()->ParentSectionID;
                            $details['SectionID'] = $res->row()->ParentSectionID;
                        }
                        $this->tanzania_real_estate($details,$res->row()->CategoryID);
                        break;

                     case '8':
                        $details = array();


                        if ($res->row()->ParentSectionID) {
                            $details['ParentSectionID'] = $res->row()->ParentSectionID;
                            $details['SectionID'] = $res->row()->ParentSectionID;
                        }

                        $this->tanzania_jobs_and_employment($details,$res->row()->CategoryID);
                        break;

                    case '21':
                        $this->travel_and_tourism_directory($res->row()->catURL);
                        break;

                    case '32':
                        $this->restaurants_and_nightlife($res->row()->catURL);
                        break;

                    case '55':

                        $details = array();


                        if ($res->row()->ParentSectionID) {
                            $details['ParentSectionID'] = $res->row()->ParentSectionID;
                            $details['SectionID'] = $res->row()->ParentSectionID;
                        }

                        $this->used_cars_trucks_and_boats($details,$res->row()->CategoryID);
                        break;

                    case '59':
                        $details = array();
                        if ($res->row()->SectionID) {

                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        $this->tanzania_events_calendar($details,$res->row()->CategoryID);
                        break;

                    case '66':
                        $this->arts_and_entertainment($res->row()->catURL);
                        break;




                    default:
                        echo "Ha" . $res->row()->ParentSectionID;
                        break;
                }
            } else if (isset($res->row()->SectionID) and !isset($res->row()->CategoryID) and !isset($res->row()->ListingID) and $res->row()->ParentSectionID != 0) {
                switch ($res->row()->ParentSectionID) {
                    case '1':
                        $this->tanzania_business_directory($res->row()->URLSafeTitleDashed);
                        break;




                    default:
                        echo "ha";
                        break;
                }
            } else if (isset($res->row()->SectionID) and !isset($res->row()->CategoryID) and !isset($res->row()->ListingID) and $res->row()->ParentSectionID == 0) {


                switch ($res->row()->SectionID) {
                    case '1':
                        $this->tanzania_business_directory();
                        break;

                    case '21':
                        $this->travel_and_tourism_directory();
                        break;

                    case '32':
                        $this->restaurants_and_nightlife();
                        break;

                    case '5':
                        $details = array();

                        if ($res->row()->SectionID) {
                            $details['ParentSectionID'] = $res->row()->SectionID;
                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        $this->tanzania_real_estate($details);
                        break;

                    case '4':
                        $details = array();
                        if ($res->row()->SectionID) {

                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        $this->steals_deals_and_classifieds($details);
                        break;

                    case '8':
                        $details = array();


                        if ($res->row()->SectionID) {
                            $details['ParentSectionID'] = $res->row()->SectionID;
                            $details['SectionID'] = $res->row()->SectionID;
                        }

                        $this->tanzania_jobs_and_employment($details);
                        break;

                    case '55':

                        $details = array();

                        // if($res->row()->ParentSectionID)
                        //  $details['ParentSectionID']=$res->row()->ParentSectionID;
                        if ($res->row()->SectionID) {
                            $details['ParentSectionID'] = $res->row()->SectionID;
                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        $this->used_cars_trucks_and_boats($details);
                        break;

                    case '59':
                        $details = array();
                        if ($res->row()->SectionID) {

                            $details['SectionID'] = $res->row()->SectionID;
                        }
                        
                        $this->tanzania_events_calendar($details);
                        break;

                    default:
                        echo "ha";
                        break;
                }
            }
        }

            
        } else {

            $header['Meta']->BrowserTitle = 'Tanzania Directory for Business, Entertainment & Travel Info';
            $header['Meta']->MetaDescr = 'Welcome to ZoomTanzania, where locals go to find  accurate and up-to-date business, entertainment, jobs, real estate, cars, travel and classified information.';

            
            $data=$this->listingsmodel->getHomePageListings();

            $data['rates'] = $this->listingsmodel->getExchangeRates();

            $data['tidesObj'] = $this->listingsmodel->getTides();


            $header['home'] = 1;

            $this->load->view('header', $header);
            $this->load->view('menu');
            $this->load->view('home-new', $data);
            $this->load->view('footer');
        }
    }




    function tanzania_business_directory($URLSafeTitleDashed = '', $categoryURLSafeTitleDashed = '') {
        $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(1);

        $leftSide['relatedEventsObj'] = $this->getRelatedEvents(406, 342, 347);


        if ($categoryURLSafeTitleDashed != '') {
            $this->category($categoryURLSafeTitleDashed, $leftSide);
        } else if ($URLSafeTitleDashed != '' and $categoryURLSafeTitleDashed == '') {

            $this->subsection($URLSafeTitleDashed, $leftSide);
        } else {

            $this->section_subsections(1, $leftSide);
        }
    }

    function travel_and_tourism_directory($URLSafeTitleDashed = '') {

        $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(21);
        $leftSide['travelSpecialsObj']=$this->listingsmodel->getTravelSpecials();

        if ($URLSafeTitleDashed != '') {
            $this->category($URLSafeTitleDashed, $leftSide);
        } else {
            $this->section_categories(21, $leftSide);
        }
    }

    function restaurants_and_nightlife($URLSafeTitleDashed = '') {


        $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(32);
        $leftSide['relatedEventsObj'] = $this->getRelatedEvents(357, 338, 408, 360, 413);

        if ($URLSafeTitleDashed != '') {
            $this->category($URLSafeTitleDashed, $leftSide);
        } else {
            $this->section_categories(32, $leftSide);
        }
    }

    function arts_and_entertainment($URLSafeTitleDashed = '') {
        $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(66);
        $leftSide['relatedEventsObj'] = $this->getRelatedEvents(413, 339, 344, 356);

        if ($URLSafeTitleDashed != '') {

            $this->category($URLSafeTitleDashed, $leftSide);
        } else {
            $this->section_categories(66, $leftSide);
        }
    }

    function tanzania_jobs_and_employment($details, $categoryID = '') {

        if ($details['ParentSectionID'] != '' and $categoryID == '')
            $this->section_listings($details);
        else
            $this->section_listings($details,$categoryID);

    }

    function steals_deals_and_classifieds($details, $categoryID = '') {
        if ($details['SectionID'] != '' and $categoryID == '')
            $this->section_listings($details);
        else
            $this->section_listings($details,$categoryID);
    }

    function used_cars_trucks_and_boats($details, $categoryID = '') {
        //print_r($details);

         if ($details['ParentSectionID'] != '' and $categoryID == '')
            $this->section_listings($details);
        else
            $this->section_listings($details,$categoryID);
    }

    function tanzania_real_estate($details, $categoryID = '') {
        //print_r($details);
         if ($details['ParentSectionID'] != '' and $categoryID == '')
            $this->section_listings($details);
        else
            $this->section_listings($details,$categoryID);
    }

    function testpage($view) {
        $this->load->view('header');
        $this->load->view($view);
        $this->load->view('footer');
    }

    function tanzania_events_calendar($details,$categoryID='') {

        if ($details['SectionID'] != '' and $categoryID == '')
            $this->section_listings($details);
        else
            $this->section_listings($details,$categoryID);
    }

    function getFeaturedListings($ParentSectionID) {
        return $this->listingsmodel->getFeaturedListings($ParentSectionID);
    }

    function getRelatedEvents($eventcategories) {
        return $this->listingsmodel->getRelatedEvents($eventcategories);
    }

    function section_subsections($SectionID, $leftSide = '') {
        $this->db->where('SectionID', $SectionID);
        $header['Meta'] = $data['sectionMeta'] = $this->db->get('sections')->row();
        $header['PageLocation'] = 'Tanzania';



        $data['subsections'] = $this->listingsmodel->getSection($SectionID);

        ///print_r($header);
        $hints = $this->listingsmodel->getHints($SectionID);
        $data['pageTextObj'] = $hints['pageTextObj'];
        $data['PageLocation'] = 'Tanzania';
        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        $this->load->view('header', $header);
        $this->load->view('menu');
        $this->load->view('left-sidetower', $leftSide);
        $this->load->view('section-landing', $data);
        //die();
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    function section_categories($SectionID, $leftSide = '') {

        $data['categories'] = $this->listingsmodel->getSection($SectionID);
        $this->db->where('SectionID', $SectionID);
        $header['Meta'] = $data['sectionMeta'] = $this->db->get('sections')->row();
        $header['PageLocation'] = 'Tanzania';
        $hints = $this->listingsmodel->getHints($SectionID);
        $data['pageTextObj'] = $hints['pageTextObj'];
        $data['PageLocation'] = 'Tanzania';

        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        $this->load->view('header', $header);
        $this->load->view('menu');
        if (isset($leftSide))
            $this->load->view('left-sidetower', $leftSide);
        else
            $this->load->view('left-sidetower');
        $this->load->view('sub-section-landing', $data);
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    function subsection($URLSafeTitleDashed, $leftSide = '') {
        $this->db->where('URLSafeTitleDashed', strtolower($URLSafeTitleDashed));
        $header['Meta'] = $data['sectionMeta'] = $this->db->get('sections')->row();
        $header['PageLocation'] = 'Tanzania';

        $hints = $this->listingsmodel->getHints($data['sectionMeta']->ParentSectionID, $data['sectionMeta']->SectionID);
        $data['pageTextObj'] = $hints['pageTextObj'];
        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        $data['subsection'] = true;
        $data['categories'] = $this->listingsmodel->getSection($data['sectionMeta']->SectionID);
        $data['PageLocation'] = 'Tanzania';

        $this->load->view('header', $header);
        // $this->load->view('menu-new');
        $this->load->view('menu');
        $this->load->view('left-sidetower', $leftSide);
        $this->load->view('sub-section-landing', $data);
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    function section_listings($details, $categoryID=0) {

        // print_r(($details));
        $data['PageLocation'] = '';
        $data['locations'] = $this->listingsmodel->getTables('locations');

        $params = array();
         

        $params['SectionID'] = $details['SectionID'];
        if (isset($details['ParentSectionID']))
            $params['ParentSectionID'] = $details['ParentSectionID'];


         // $leftSide['searchForm'] = $this->search($details['SectionID']);
         $leftSide['searchForm'] = $this->loadsearchform($details['SectionID']);

         if(!$leftSide['searchForm'])
             $leftSide['searchForm'] = $this->search($details['ParentSectionID']);


         if(isset($details['ParentSectionID']) and $details['ParentSectionID']==55)
         {
            $this->db->where('active',1);
            $this->db->where('ParentSectionID',55);
            $this->db->order_by('Title');
            $leftSide['carCategoriesObj']=$this->db->get('categories');
         }


        //print_r($categoryDetails);

        if ($this->input->get('LocationID') > 0)
        {
            $categoryDetails['LocationID'] = $this->input->get('LocationID');


            $LocationIDs = explode('-', $this->input->get('LocationID'));
            $this->db->where_in('LocationID', $LocationIDs);
            $pageLocation=$this->db->get('locations');

            //echo $this->db->last_query();

            if($pageLocation->num_rows() == 0)
                $data['PageLocation'] = ' Tanzania';
            else if($pageLocation->num_rows() == 1)
                $data['PageLocation'] = $pageLocation->row()->Title;
            else
            {
                foreach($pageLocation->result() as $pgLoc)
                    $data['PageLocation'] .= $pgLoc->Title . ' & '; 

                $data['PageLocation'] = substr($data['PageLocation'], 0,-2);
            }

        }
        else
            $data['PageLocation'] = ' Tanzania';
        

        if($categoryID != 0 or $this->input->get("CategoryID"))
        {
            if($this->input->get("CategoryID"))
                $categoryID = $this->input->get("CategoryID"); 
            
            $this->db->select('categories.Title as Category, parentsectionsview.title as ParentSection, parentsectionsview.H1Text as ParentSectionH1Text, sections.Title as Section, sections.H1Text as SectionH1Text, categories.H1Text as CategoryH1Text, sections.ParentSectionID, sections.SectionID');
            $this->db->from('categories');
            $this->db->join('sections','categories.SectionID = sections.SectionID');
            $this->db->join('parentsectionsview','categories.ParentSectionID = parentsectionsview.ParentSectionID','left');
            $this->db->where('CategoryID', $categoryID);
            $header['Meta'] = $data['sectionMeta'] = $this->db->get()->row();

        }

        else
        {

            if (isset($details['ParentSectionID']))
                $this->db->where('SectionID', $details['ParentSectionID']);
            else
                $this->db->where('SectionID', $details['SectionID']);

            $this->db->select('sections.Title as Section, sections.H1Text as SectionH1Text, ParentSectionID, SectionID');
            $header['Meta'] = $data['sectionMeta'] = $this->db->get('sections')->row();
        }

        $header['PageLocation'] = $data['PageLocation'];

        if(isset($header['Meta']->ParentSectionID))       
            $hints = $this->listingsmodel->getHints($header['Meta']->ParentSectionID, $header['Meta']->SectionID);
        elseif(isset($header['Meta']->SectionID)) 
            $hints = $this->listingsmodel->getHints(0, $header['Meta']->SectionID);


        $data['pageTextObj'] = $hints['pageTextObj'];

        // print_r(($data['pageTextObj']));

        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        if (isset($leftSide['featuredBusinessObj']))
            unset($leftSide['featuredBusinessObj']);


        $this->db->where('active', 1);
        $this->db->where('SectionID', $details['SectionID']);
        $categories = $this->db->get('categories');


        if ($categories->num_rows() == 0) {
            $this->db->where('active', 1);
            $this->db->where('ParentSectionID', $details['SectionID']);
            $categories = $this->db->get('categories');
        }

        $params['categoryID'] = '';

        foreach ($categories->result() as $category) {
            $params['categoryID'] .= $category->CategoryID . ',';
        }

        $string = $params['CategoryID'] = substr($params['categoryID'], 0, -1);




        $catID = explode(",", $params['CategoryID']);




        $params = $this->listingsmodel->getCategory($catID[0]);
        $params['CategoryIDs'] = $string;
        $params['showThumbNail']=true;

        if ($details['SectionID'] == 8) {
            $params['JETID'] = 1;
            $params['InJobSectionOverview'] = 1;
            $params['ParentSectionID'] = $details['SectionID'];
            $params['showThumbNail']=false;
            //unset($params['CategoryIDs']);
        }

        $params['limit'] = true;
        $params['SortBy'] = 'MostRecent';

        if($details['SectionID']==59)
        {
            $params['SortBy'] = 'EventSort';
        }

        $data['SectionID'] = $details['SectionID'];
        if ($this->input->get('LocationID') > 0)
            $params['LocationID'] = $this->input->get('LocationID');



        if($categoryID)
            $params['catID']=$categoryID;

        //echo $params['catID'] . 'hehehe';

       // print_r($params);
        $data['listings'] = $this->listingsmodel->getListings($params);


        //echo $this->db->last_query();

        $this->load->view('header', $header);
        $this->load->view('menu');

        if (isset($leftSide))
            $this->load->view('left-sidetower', $leftSide);
        else
            $this->load->view('left-sidetower');

        switch ($details['SectionID']) {

            case '8':
                $this->load->view('jobs-landing', $data);
                break;

            case '5':
            case '4':
            case '55':
            case '59':
                $this->load->view('classifieds-landing-page', $data);
                break;

            default:
                # code...
                break;
        }

        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    function category($categoryURLSafeTitleDashed, $leftSide = '') {
        $data['locations'] = $this->listingsmodel->getTables('locations');
       

        $this->db->select('categories.Title as catTitle, categories.H1Text as catH1Text, CategoryID, categories.ParentSectionID, categories.SectionID, sections.Title secTitle');
        $this->db->from('categories');
        $this->db->join('sections', 'categories.ParentSectionID = sections.SectionID');
        $this->db->where('categories.URLSafeTitleDashed', strtolower($categoryURLSafeTitleDashed));
        $category=$this->db->get()->row();

        $categoryDetails = $this->listingsmodel->getCategory($category->CategoryID);

        $header['Meta'] = $data['catMeta'] = $category;

        $data['PageLocation'] = "";
        if ($this->input->get('LocationID') > 0)
        {
            $categoryDetails['LocationID'] = $this->input->get('LocationID');


            $LocationIDs = explode('-', $this->input->get('LocationID'));
            $this->db->where_in('LocationID', $LocationIDs);
            $pageLocation=$this->db->get('locations');

            //echo $this->db->last_query();

            if($pageLocation->num_rows() == 0)
                $header['PageLocation']=$data['PageLocation'] = ' Tanzania';
            else if($pageLocation->num_rows() == 1)
                $header['PageLocation']=$data['PageLocation'] = $pageLocation->row()->Title;
            else
            {
                foreach($pageLocation->result() as $pgLoc)
                    $data['PageLocation'] .= $pgLoc->Title . ' & '; 

                $header['PageLocation']=$data['PageLocation'] = substr($data['PageLocation'], 0,-2);
            }

        }
        else
            $header['PageLocation']=$data['PageLocation'] = ' Tanzania';
        


        $hints = $this->listingsmodel->getHints($category->ParentSectionID, $category->SectionID, $category->CategoryID);



        //print_r($categoryDetails);



        $data['pageTextObj'] = $hints['pageTextObj'];

        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        // if (isset($leftSide['featuredBusinessObj']))
        //     unset($leftSide['featuredBusinessObj']);



        $data['Featured_listings_result_obj'] = $this->listingsmodel->getListings($categoryDetails, 1);


        $listings = $data['Listings_result_obj'] = $this->listingsmodel->getListings($categoryDetails);

        $data['quoteRequestString'] = '';
        $forlocation = array();
        foreach ($listings->result() as $listing) {
            $data['quoteRequestString'] .= $listing->ListingID . ',';
        }

        $data['quoteRequestString'] = substr($data['quoteRequestString'], 0, -1);




        $this->load->view('header', $header);
        $this->load->view('menu');
        if (isset($leftSide))
            $this->load->view('left-sidetower', $leftSide);
        else
            $this->load->view('left-sidetower');

        $this->load->view('category-landing', $data);

        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    private function randomAlphaNum($length){ 

        /*$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
        $rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
        $base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
        $newRand = base_convert($base10Rand, 10, 36); //convert it 
        
        return $newRand; //spit it out */
        
        $arr = str_split('ABCDEFGHJKMNPQRSTUVWXYZ23456789'); // get all the characters into an array
        shuffle($arr); // randomize the array
        $arr = array_slice($arr, 0, $length); // get the first six (random) characters out
        return implode('', $arr); // smush them back into a string

    } 

    public function generateCaptcha($ajax=0)
    {
        
        
        $word = strtoupper($this->randomAlphaNum(7));
        
        
        $this->load->helper('captcha');
        $vals = array(
        'word' => $word,
        'img_path'   => './captcha/',
        'img_url'    => 'captcha/',
        'font_path'  => './captcha/fonts/arial.ttf',
        'img_width'  => '200',
        'img_height' => 50,
        );
        
        $cap = create_captcha($vals);
    
        $cap_data = array(
        'captcha_time'  => $cap['time'],
        'ip_address'    => $this->input->ip_address(),
        'word'   => $cap['word']
        );
        
        $query = $this->db->insert_string('captcha', $cap_data); 
        $this->db->query($query);

       // echo($cap['image']);

        if($ajax==1)
            echo json_encode($cap);
        else
            return $cap;


    }

    function ajax_validate_captcha()
    {

        $captcha = $this->input->get('CaptchaEntry');
        $expiration = time()-7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);   

    
        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";

        $binds = array($captcha, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        
        
        if($row->count == 0){       // validate??
            echo json_encode(FALSE);
        }else{
            echo json_encode(TRUE);
        }
        
    }

    function validate_captcha($captcha)
    {
        $expiration = time()-7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);   

    
        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($captcha, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        
        
        if($row->count == 0){       // validate??
            $this->form_validation->set_message('validate_captcha', 'You Entered Incorrect Captcha');
            return FALSE;
        }else{
            return TRUE;
        }
        
    }
   
    public function listingdetail($ListingID = '',$error=0,$errorMessage="") {


        $data['error']=$errorMessage;

        if($error != 0)
        {
            $data['display']="";
            $data['otherDisplay'] = "display:none";
        }
        else 
        {
            $data['display'] = "display:none";
            $data['otherDisplay']="";
        }

        if ($this->input->get('ListingID'))
            $ListingID = $this->input->get('ListingID');

        $listingObj = $this->listingsmodel->getsinglelisting($ListingID);

        $data['target'] = '';

        
        if($listingObj->num_rows() == 0)
        {
                $listingObj = $this->listingsmodel->getsinglelisting($ListingID,1);   
        }
            
        $data['listing'] = $listingObj->row();

        if(isset($data['listing']->SectionID))
         $leftSide['searchForm'] = $this->loadsearchform($data['listing']->SectionID);

         if(!$leftSide['searchForm'])
             $leftSide['searchForm'] = $this->loadsearchform($data['listing']->ParentSectionID);

        switch ($data['listing']->ParentSectionID) {

            case '1':
            case '21':
            case '32':
            case '59':
                $header['Meta']->BrowserTitle = $data['listing']->ListingTitle . ' in ' . $data['listing']->Location . ', Tanzania';
                $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle . $data['listing']->ShortDescr;
                

                if($data['listing']->ParentSectionID==1)
                {
                    $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(1);
                    $leftSide['relatedEventsObj'] = $this->getRelatedEvents(406, 342, 347);
                }

                if($data['listing']->ParentSectionID==21)
                {
                    $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(21);
                    $leftSide['travelSpecialsObj'] = $this->listingsmodel->getTravelSpecials();
                }
                
                if($data['listing']->ParentSectionID==32)
                {
                    $leftSide['featuredBusinessObj'] = $this->getFeaturedListings(32);
                    $leftSide['relatedEventsObj'] = $this->getRelatedEvents(357, 338, 408, 360, 413);
                }

                if ($data['listing']->HasExpandedListing and $data['listing']->ExpandedListingPDF) {
                    $file_parts = pathinfo(LISTINGUPLOADEDDOCS . $data['listing']->ExpandedListingPDF);

                    switch ($file_parts['extension']) {
                        case 'jpeg':
                        case 'jpg':
                        case 'png':
                        case 'gif':
                            $data['featuredURL'] = 'zoomedlisting?ListingID=' . $data['listing']->ListingID;

                            break;



                        case 'pdf':
                            $data['target'] .= "target = '_blank'";
                            $data['featuredURL'] = LISTINGUPLOADEDDOCS . $data['listing']->ExpandedListingPDF;
                            break;

                        default:
                            $data['target'] .= "target = '_blank'";
                            $data['featuredURL'] = LISTINGUPLOADEDDOCS . $data['listing']->ExpandedListingPDF;
                            break;
                    }
                }

                else
                {
                     $data['featuredURL'] = 'zoomedlisting?ListingID=' . $data['listing']->ListingID;
                }

                break;

            case '8':
                $header['Meta']->BrowserTitle = $data['listing']->ShortDescr . ' Job in ' . $data['listing']->Location . ', Tanzania';
                $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle;

                break;




            case '5':

                $header['Meta']->BrowserTitle = $data['listing']->ListingTitle;  

                    switch ($data['listing']->ListingTypeID) {
                        case '7':
                        case '6':
                            $header['Meta']->BrowserTitle .= ' For Rent in ';
                            break;  

                        case '8':
                            $header['Meta']->BrowserTitle .= ' For Sale in ';
                            break;

                 }
                $header['Meta']->BrowserTitle .= $data['listing']->Location . ', Tanzania' ;
                $header['Meta']->MetaDescr .=  $header['Meta']->BrowserTitle;

             break;       

             case '55':
                
                if ($data['listing']->ListingTypeID == 3) {
                    $header['Meta']->BrowserTitle = $data['listing']->ListingTitle . ' For Sale in ' . $data['listing']->Location . ', Tanzania | Classified';
                    $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle . $data['listing']->ShortDescr;
                } else {
                    $header['Meta']->BrowserTitle = $data['listing']->VehicleYear . ' ' . $data['listing']->Make . ' ' . $data['listing']->ModelOther . ' For Sale in ' . $data['listing']->Location . ', Tanzania | Classified';
                    $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle . $data['listing']->ShortDescr;
                }

                break;

            case '4':

                $header['Meta']->BrowserTitle = $data['listing']->ListingTitle . ' For Sale in ' . $data['listing']->Location . ', Tanzania';
                $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle . $data['listing']->ShortDescr;

                break;
                
                default:
                    echo $data['listing']->ParentSectionID;
                    break;
            }

        $data['cap'] = $this->generateCaptcha();

        $this->load->view('header', $header);
        $this->load->view('menu');

        if($data['listing']->CategoryID != 105)
        {
            if (isset($leftSide))
                $this->load->view('left-sidetower', $leftSide);
            else
                $this->load->view('left-sidetower');
        }

               // echo $data['listing']->CategoryID;

        switch ($data['listing']->ParentSectionID) {

            case '1':
            case '21':
            case '32':
                if($data['listing']->CategoryID == 105)
                {
                    $data['movies']=$this->listingsmodel->getMovieTheater($data['listing']->ListingID);
                    $this->load->view('movies-landing',$data);
                    
                }

                else
                    $this->load->view('businesses-detail-page', $data);
                break;

            case '8':
                
                if(!$this->ion_auth->logged_in())
                {
                    $array = array('ListingID' => $data['listing']->ListingID);
                    $this->session->set_userdata($array);
                }


                  if($this->session->userdata('ListingID') and $this->ion_auth->logged_in())
                  {
                      $data['display'] = "";
                      $data['otherDisplay'] = "display:none";
                      $this->session->unset_userdata('ListingID');
                  } 

                $this->load->view('job-detail-page', $data);
                break;

            case '55':
                $this->load->view('cars-detail-page', $data);
                break;

            case '5':
                $this->load->view('realestate-detail-page', $data);
                break; 

            case '4':
                $this->load->view('fsbo-detail-page', $data);
                break;

            case '59':
                $this->load->view('events-detail-page', $data);
                break;

            default:
                # code...
                break;
        }
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }


    public function ELP($res) {
        $listingObj = $this->listingsmodel->getsinglelisting($this->input->get('ListingID'));

        $listing = $listingObj->row();

        if($listing->ExpandedListingPDF)
          $data['flier'] = "<img src = '" . LISTINGUPLOADEDDOCS . $listing->ExpandedListingPDF . "' style = 'max-width:1020px; ' />";
        else
          $data['flier'] = $listing->ExpandedListingHTML;

        $header['Meta']->BrowserTitle = $listing->ListingTitle . ' in ' . $listing->Location . ', Tanzania';
        $header['Meta']->MetaDescr = $header['Meta']->BrowserTitle . $listing->ShortDescr;


        $this->load->view('header', $header);
        $this->load->view('menu');
        $this->load->view('plain', $data);
        $this->load->view('footer');
    }

    function sendlistingemail() {

        $sent=0;
        $spam=0;
        $DefensioPass=0;
        $attachments="";
        $tenderAttachments = array();

        if($this->input->post('firstname') and $this->input->post('firstname') != "")
        {
            $this->common->sendErrorEmail('spam');
            redirect('listingdetail?ListingID=' . $this->input->post('ListingID'));
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('SubjectLine', 'Subject', 'trim|required');
            $this->form_validation->set_rules('EmailBody', 'Message', 'trim|required');
            $this->form_validation->set_rules('Email', 'Your Email', 'required|valid_email');
            $this->form_validation->set_rules('ConfirmEmail', 'Confirm Email', 'required|matches[Email]|valid_email');
            $this->form_validation->set_rules('CaptchaEntry', 'The Captcha', 'required|callback_validate_captcha');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == TRUE)
            {
                $this->load->library('email');

                if(count( $_FILES ) > 0 )
                {
                    
                    foreach($_FILES as $key => $value)
                    {
                        
                        if(!empty($value['name']) and !empty($key))
                        {
                            $config['upload_path'] = 'tempuploads/';
                            $config['allowed_types'] = 'txt|pdf|doc|docx|rtf|xls|xlsx|ppt|pptx|gif|jpg|jpeg|tiff';
                            $config['max_size'] = '2048';


                            $this->load->library('upload', $config);

                            if ( ! $this->upload->do_upload($key))
                            {
                                $error = $this->upload->display_errors();
                                 
                                $this->listingdetail($this->input->post('ListingID'), 1 ,$error);
                            }
                            else
                            {
                                

                                $data = array('upload_data' => $this->upload->data());
                                
                                $attachments .= $data['upload_data']['file_name'] . ',';

                                // echo $attachments;


                                $this->email->attach($data['upload_data']['full_path']);
                            }
                        }
                    }
                    
                    if(isset($attachments) and strlen($attachments) > 0)
                        $attachments = substr($attachments, 0,-1);
                }

                $this->db->select('PublicEmail');
                $this->db->where('ListingID',$this->input->post('ListingID'));
                $PublicEmail=$this->db->get('listingsview')->row()->PublicEmail;
               

                $message = "";
                $wrapper = "";


                $autoEmail=$this->listingsmodel->getMessage(19);

                

                $this->email->subject($this->input->post('SubjectLine'));
                // $wrapper .= $message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html><head><title>' . $this->input->post('SubjectLine') . '</title></head><body>';
                
                $message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html><head><title>' . $this->input->post('SubjectLine') . '</title></head><body>';

                $message .= $autoEmail->Body;
                foreach ($this->input->post(NULL, TRUE) as $key => $value) {

                   $message = str_replace('%insert'. $key .'%', $value, $message);

                    // if($key != 'EmailBody')
                    //     $wrapper = str_replace('%insert'. $key .'%', $value, $wrapper);
                    // else
                    //     $wrapper = str_replace('%insert'. $key .'%', '#Message#', $wrapper);
                }

                $message .= '</body></html>';
                // $wrapper .= '</body></html>';

                if( !in_array($this->input->post('ListingTypeID'), array(1,2,20,14)) )
                {

                    if(in_array($this->input->post('ListingTypeID'), array("10","12")))
                    {
                        if($this->session->userdata('jobclicks') >= 3)
                        {
                            $data['message']='<p style = "font-weight: bold; font-size:16px; color:red">Sorry, you have already applied to 3 jobs today</p>';
                                $data['title']="You have already applied to 3 jobs today";
                                $header['Meta']->H1Text = "You have already applied to 3 jobs today";

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
                            $this->db->where('UserID', $this->session->userdata('user_id'));
                            $jobClicksObj=$this->db->get('jobclicks');

                            if($jobClicksObj->num_rows() == 0)
                            {
                                $jobClicksInsert = array(
                                    'UserID' => $this->session->userdata('user_id'),
                                    'ClickDate' => date('Y-m-d'),
                                    'ClickCount' => 1
                                );
                               $this->db->insert('jobclicks', $jobClicksInsert);
                               

                                $array = array(
                                    'jobclicks' => $jobClicksObj->row()->ClickCount
                                );
                                
                               $this->session->set_userdata( $array );
                                
                            }

                            elseif ($jobClicksObj->row()->ClickCount + 1 > 3) {
                                 $data['message']='<p style = "font-weight: bold; font-size:16px; color:red">Sorry, you have already applied to 3 jobs today</p>';
                                $data['title']="You have already applied to 3 jobs today";
                                $header['Meta']->H1Text = "You have already applied to 3 jobs today";

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

                                $array = array(
                                    'jobclicks' => $jobClicksObj->row()->ClickCount + 1
                                );
                                $this->session->set_userdata( $array );
                                    

                                $jobClicksUpdate = array(
                                    'ClickDate' => date('Y-m-d'),
                                    'ClickCount' => $jobClicksObj->row()->ClickCount + 1
                                );
                                $this->db->where('UserID', $this->session->userdata('user_id'));
                                $this->db->update('jobclicks',$jobClicksUpdate);

                            }
                        }
                    } 
                    
                    $this->email->from('inquiry@ZoomTanzania.com', 'inquiry@ZoomTanzania.com');
                    // $this->email->to($PublicEmail); 
                    $this->email->bcc('terence@ZoomTanzania.com'); 

                    $testForSpam = $this->input->post('SubjectLine') . ' ' . $this->input->post('EmailBody');


                    $spamScore= $this->listingsmodel->checkEmailForSpam($testForSpam);

                    if($spamScore!==false)
                    {
                        if($spamScore[1]->allow == 'true'  and ($spamScore[1]->classification != 'spam' or $spamScore[1]->classification != 'malicious') and !$spamScore[1]->{'profanity-match'} == 'false')
                        {     

                            $sent=1;   
                            $DefensioPass=1;

                            $this->email->message($message);

                            if($this->email->send())
                            {
                                $emailData = array(
                                'FromAddress'=>$this->input->post('Email'),
                                'ToAddress'=>$PublicEmail,
                                'Subject'=>$this->input->post('SubjectLine'),
                                'Message'=>$this->input->post('EmailBody'),
                                'MessageWrapper'=> $message,
                                'Attachments' => $attachments,
                                'ListingID' =>  $this->input->post('ListingID'),
                                'DateAdded' => date('Y-m-d H:i:s'),
                                'IsSpam' => $spam,
                                'Reviewed' => 0,
                                'CFFormProtectPass' => 1,
                                'DefensioPass' => $DefensioPass,
                                'DefensioSignature' => (string)$spamScore[1]->signature,
                                'DefensioSpaminess' => $spamScore[1]->spaminess,
                                'IsSent' => $sent
                                );

                                $this->db->insert('messages',$emailData);

                                redirect('listingdetail?ListingID=' . $this->input->post('ListingID') . '&success=1' );
                            }

                            else
                            {
                                $this->common->sendErrorEmail('email');
                                redirect('listingdetail?ListingID=' . $this->input->post('ListingID') . '&success=2' );
                            }


                        }
                }

                    else
                    {

                        
                        $spam = 1;

                        $emailData = array(
                            'FromAddress'=>$this->input->post('Email'),
                            'ToAddress'=>$PublicEmail,
                            'Subject'=>$this->input->post('SubjectLine'),
                            'Message'=>$this->input->post('EmailBody'),
                            'MessageWrapper'=> $message,
                            'Attachments' => $attachments,
                            'ListingID' =>  $this->input->post('ListingID'),
                            'DateAdded' => date('Y-m-d H:i:s'),
                            'IsSpam' => $spam,
                            'Reviewed' => 0,
                            'CFFormProtectPass' => 1,
                            'DefensioPass' => $DefensioPass,
                            'DefensioSignature' => (string)$spamScore[1]->signature,
                            'DefensioSpaminess' => $spamScore[1]->spaminess,
                            'IsSent' => $sent
                        );

                        $this->db->insert('messages',$emailData);
                        
                        redirect('listingdetail?ListingID=' . $this->input->post('ListingID') . '&success=1' );

                    }

                }
                else
                {
                    $tenderData = array(
                        'Email'=>$this->input->post('Email'),
                        'SubjectLine'=>$this->input->post('SubjectLine'),
                        'EmailBody' => $this->input->post('EmailBody'),
                        'DateCreated' => date('Y-m-d H:i:s'),
                        'Reviewed'=> 0
                        );
                    $this->db->insert('tenders',$tenderData);
                    
                    $TenderID=$this->db->insert_id();


                    $tenderListingsData = array(
                        'TenderID' => $TenderID,
                        'ListingID' => $this->input->post('ListingID')
                        );

                    $this->db->insert('tenderlistings',$tenderListingsData);

                    if(strlen($attachments) > 0)
                    {
                        foreach(explode(',', $attachments) as $attachment)
                        {
                            $tenderAttachments[] = array('TenderID'=>$TenderID, 'FileName'=>$attachment);
                        }

                        $this->db->insert_batch('tenderdocs',$tenderAttachments);

                    }

                    redirect('listingdetail?ListingID=' . $this->input->post('ListingID') . "&success=1"  );

                }
            }

            else
            {
                $this->listingdetail($this->input->post('ListingID'),1);
            }
        }
    }

    public function getquotes($CategoryID=0,$error="")
    {

        if($CategoryID != 0)
            {}
        else
            $CategoryID = $this->input->get('CategoryID',TRUE);

        $data['error']=$error;
       
        $data['featuredBusinessesObj'] = $this->listingsmodel->getQueryBusinesses($CategoryID, 1);
        $data['otherBusinessesObj'] = $this->listingsmodel->getQueryBusinesses($CategoryID);

        $this->db->where('CategoryID', $CategoryID );
        $header['Meta'] = $data['catMeta'] = $category = $this->db->get('categories')->row();
        $header['getQuotes']=1;

        $hints = $this->listingsmodel->getHints($category->ParentSectionID, $category->SectionID, $category->CategoryID);

        $data['pageTextObj'] = $hints['pageTextObj'];

        $leftSide['youMayAlsoLikeObj'] = $hints['youMayAlsoLikeObj'];

        $data['cap'] = $this->generateCaptcha();    
        $data['CategoryID'] = $CategoryID;




        $this->load->view('header', $header);
        $this->load->view('menu');
        if(isset($leftSide))
            $this->load->view('left-sidetower', $leftSide);
        else
            $this->load->view('left-sidetower');
        $this->load->view('listing-enquiry-form', $data);
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    function querysix()
    {
         if($this->input->post('firstname') and $this->input->post('firstname') != "")
        {
            $this->common->sendErrorEmail('spam');
            redirect('listingdetail?ListingID=' . $this->input->post('ListingID'));
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('SubjectLine', 'Subject', 'trim|required');
            $this->form_validation->set_rules('EmailBody', 'Message', 'trim|required');
            $this->form_validation->set_rules('ListingIDs[]', 'Listing','required');
            $this->form_validation->set_rules('CaptchaEntry', 'The Captcha', 'required|callback_validate_captcha');
            $this->form_validation->set_rules('Email', 'Your Email', 'required|valid_email');
            $this->form_validation->set_rules('ConfirmEmail', 'Confirm Email', 'required|matches[Email]|valid_email');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == TRUE)
            {
                $tenders = array(
                    'Email'=>$this->input->post('Email'),
                    'SubjectLine'=>$this->input->post('SubjectLine'),
                    'EmailBody'=>$this->input->post('EmailBody'),
                    'DateCreated'=> date('Y-m-d H:i:s'),
                    'Reviewed'=>0
                );

                $this->db->insert('tenders', $tenders);

                $TenderID = $this->db->insert_id();

                $TenderDocs = array();
                $TenderListings = array();

                foreach ($this->input->post('ListingIDs') as $ListingID ) {
                    $TenderListings[] = array('TenderID'=>$TenderID, 'ListingID'=>$ListingID);
                    echo($ListingID);
                }

                $this->db->insert_batch('tenderlistings', $TenderListings);


                
                if(count( $_FILES ) > 0 )
                {
                    foreach($_FILES as $key => $value)
                    {
                        if(!empty($value['name']) and !empty($key))
                        {
                            $config['upload_path'] = 'tempuploads/';
                            $config['allowed_types'] = 'txt|pdf|doc|docx|rtf|xls|xlsx|ppt|pptx|gif|jpg|jpeg|tiff';
                            $config['max_size'] = '2048';


                            $this->load->library('upload', $config);

                            if ( ! $this->upload->do_upload($key))
                            {
                                $error = $this->upload->display_errors();
                                $this->getquotes($this->input->post('CategoryID'), $error);
                            }
                            else
                            {
                                

                                $data = array('upload_data' => $this->upload->data());
                                
                                
                                $TenderDocs[] = array('TenderID'=>$TenderID, 'FileName'=>$data['upload_data']['file_name']);


                                
                            }
                        }
                    }
                    
                    if(!empty($TenderDocs))
                        $this->db->insert_batch('tenderdocs', $TenderDocs);

                }

                redirect($this->input->post('CategoryURL'). "?success=1");

            }
            else // Validation Not True
            {
                
                $this->getquotes($this->input->post('CategoryID'));
            }   
        }
    }

    public function TideDetail($pageObj) {

        if ($this->input->post('StartDate'))
            $startDate = date("Y-m-d", strtotime($this->input->post('StartDate'))) . ' 00:00:00';
        elseif ($this->input->get('StartDate'))
            $startDate = date("Y-m-d", strtotime($this->input->get('StartDate'))) . ' 00:00:00';
        else
            $startDate = date("Y-m-d") . ' 00:00:00';

        if ($this->input->post('EndDate'))
            $endDate = date("Y-m-d", strtotime($this->input->post('EndDate'))) . ' 23:59:00';
        elseif ($this->input->get('EndDate'))
            $endDate = date("Y-m-d", strtotime($this->input->get('EndDate'))) . ' 23:59:00';
        else
            $endDate = date("Y-m-d") . ' 23:59:00';

        $tidesQuery = "select CONVERT(t.tideDate,date) day, t.tideDate, t.High, t.Measurement,l.LunarDate,l.MoonTypeID,mt.descr, SunriseDate, SunsetDate
        from Tides t left join lunar l 
    ON CONVERT(t.TideDate,  date)=CONVERT(l.LunarDate ,  date)
    left join moontype mt  ON l.moonTypeID = mt.moonTypeID
    inner join sunrise s ON CONVERT(t.TideDate,date) = CONVERT(s.SunriseDate,date)
    inner join sunset st ON CONVERT(t.TideDate,date) = CONVERT(st.SunsetDate,date)
    where TideDate >= '" . $startDate . "'
    AND TideDate <= '" . $endDate . "'";

        $data['tidesObj'] = $this->db->query($tidesQuery);

        $highCheckerQuery = "select CONVERT(t.tideDate,date) day, COUNT( CONVERT( t.tideDate, DATE ) ) valuescount, t.tideDate, t.High, t.Measurement,l.LunarDate,l.MoonTypeID,mt.descr, SunriseDate, SunsetDate
        from Tides t left join lunar l 
    ON CONVERT(t.TideDate,  date)=CONVERT(l.LunarDate ,  date)
    left join moontype mt  ON l.moonTypeID = mt.moonTypeID
    inner join sunrise s ON CONVERT(t.TideDate,date) = CONVERT(s.SunriseDate,date)
    inner join sunset st ON CONVERT(t.TideDate,date) = CONVERT(st.SunsetDate,date)
    where TideDate >= '" . $startDate . "'
    AND TideDate <= '" . $endDate . "' group by day";

        $data['highChecker'] = $this->db->query($highCheckerQuery);


        $this->db->where('PageID', $pageObj->row()->PageID);
        $data['pageContent'] = $this->db->get('lh_pageparts')->row();
        $data['pageMeta'] = $pageObj->row();

        $header['Meta'] = $data['pageMeta'];
        $this->load->view('header', $header);
        $this->load->view('menu');
        if (isset($left_side))
            $this->load->view('left-sidetower', $left_side);
        else
            $this->load->view('left-sidetower');
        $this->load->view('tidesDetailPage', $data);
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    public function page($pageObj) {


        $this->db->where('PageID', $pageObj->row()->PageID);
        $data['pageContent'] = $this->db->get('lh_pageparts')->row();
        $data['pageMeta'] = $pageObj->row();

        $header['Meta'] = $data['pageMeta'];


        $this->load->view('header', $header);
        $this->load->view('menu');
        if (isset($left_side))
            $this->load->view('left-sidetower', $left_side);
        else
            $this->load->view('left-sidetower');
        $this->load->view('page',$data);
        // $this->load->view('category_detail');
        $this->load->view('right-sidetower');
        $this->load->view('footer');
    }

    
    function tryForms($SectionID)
    {
        $this->load->view('header');
        // $this->db->select("*, GROUP_CONCAT(forminputvalidationrules.input_rules SEPARATOR ', ') ValidationsRules",FALSE);
        // // $this->db->select("*");
        // $this->db->from('sectionforms');
        // $this->db->join('sectionformfields', 'sectionformfields.SectionFormID = sectionforms.SectionFormID');
        // $this->db->join('input_type_tbl', 'input_type_tbl.input_id = sectionformfields.FieldID');
        // $this->db->join('sectionformsvalidation', 'sectionformsvalidation.SectionFormFieldsID = sectionformfields.SectionFormFieldsID');
        // $this->db->join('forminputvalidationrules', 'sectionformsvalidation.ValidationRuleID=forminputvalidationrules.validation_id');
        // $this->db->where('sectionforms.Section', $SectionID);
        // $this->db->order_by('sectionformfields.OrderNum');

        // $query = "(SELECT draws_from, column_id, display_id, input_name, input_type, GROUP_CONCAT(forminputvalidationrules.input_rules SEPARATOR ', ') ValidationsRules FROM sectionforms JOIN sectionformfields ON sectionformfields.SectionFormID = sectionforms.SectionFormID JOIN input_type_tbl ON input_type_tbl.input_id = sectionformfields.FieldID JOIN sectionformsvalidation ON sectionformsvalidation.SectionFormFieldsID = sectionformfields.SectionFormFieldsID JOIN forminputvalidationrules ON sectionformsvalidation.ValidationRuleID=forminputvalidationrules.validation_id WHERE sectionforms.Section = 1 ORDER BY sectionformfields.OrderNum)";

        // $query .= " UNION (SELECT draws_from, column_id, display_id, input_name, input_type, null FROM sectionforms JOIN sectionformfields ON sectionformfields.SectionFormID = sectionforms.SectionFormID JOIN input_type_tbl ON input_type_tbl.input_id = sectionformfields.FieldID WHERE sectionforms.Section = 1 ORDER BY sectionformfields.OrderNum)";

        $query = "(SELECT fieldtypename, draws_from, column_id, display_id,input_name, input_type, GROUP_CONCAT(forminputvalidationrules.input_rules SEPARATOR ' ') ValidationsRules FROM sectionforms JOIN sectionformfields ON sectionformfields.SectionFormID = sectionforms.SectionFormID JOIN input_type_tbl ON input_type_tbl.input_id = sectionformfields.FieldID LEFT OUTER JOIN sectionformsvalidation ON sectionformsvalidation.SectionFormFieldsID = sectionformfields.SectionFormFieldsID LEFT OUTER JOIN forminputvalidationrules ON sectionformsvalidation.ValidationRuleID=forminputvalidationrules.validation_id WHERE sectionforms.Section = 1 GROUP BY sectionformfields.SectionFormFieldsID ORDER BY sectionformfields.OrderNum)";



        $result=$this->db->query($query);

        echo "<form method = 'post' action = 'testsubmit' enctype='multipart/form-data' >";

        foreach ($result->result() as $res) {
            echo $res->input_name . ': ';

            $class = "class = '";
            if(isset($res->ValidationsRules))
                $class .=   $res->ValidationsRules  ;


            $name = preg_replace("/[^a-zA-Z0-9]+/", "", $res->fieldtypename);
            switch ($res->input_type) {
                case 'textinput':
                case 'dateinput':
                case 'time':
                case 'phone':
                case 'time2':

                    if($res->input_type == 'dateinput')
                        $class .= ' calendar ';  

                    if($res->input_type == 'time')
                        $class .= ' time ';                        

                    if($res->input_type == 'phone')
                        $class .= ' phone ';                   

                     if($res->input_type == 'time2')
                        $class .= ' time2 ';

            
                    
                    $class .= "'";

                    echo '<input ' . $class . ' type = "text" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;

                case 'textarea':

                    $class .= "'";
                    echo '<textarea ' . $class . ' name = "'  . $name .  '" id = "' . $name . '" ></textarea>';
                    break;               

               

                case 'multiselect':
                case 'select':
                    $this->db->order_by('OrderNum');
                    $options=$this->db->get($res->draws_from);

                    if($res->input_type == 'multiselect')
                        $multiple = 'multiple';
                    else $multiple = '';

                    $class .= "'";

                    echo '<select ' . $class . ' '  . $multiple .  ' name = "'  . $name .  '" id = "' . $name . '" >';
                    //echo '<option value = "">Select One</option>';
                    foreach($options->result() as $option)
                    {
                        
                        $valueColumn= $res->column_id;
                        $showColumn = $res->display_id;
                       
                       echo '<option value = "' . $option->$valueColumn . '">' . $option->$showColumn . '</option>';
                    }
                    echo '</select>';
                    break;


                    case 'file':
                         $class .= "'";
                        echo '<input ' . $class . ' type = "file" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;                    

                    case 'checkbox':
                     $class .= "'";
                        echo '<input ' . $class . ' type = "checkbox" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;
                
                default:
                    $class .= "'";
                    echo '<input ' . $class . ' type = "text" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;
            }

            echo '<br>';
        }

        echo "<input type = 'submit'>";

        echo "</form>";
    }



    function loadsearchform($SectionID)
    {
        

        $query = "(SELECT *, GROUP_CONCAT(forminputvalidationrules.input_rules SEPARATOR ' ') ValidationsRules FROM searchforms JOIN searchformfields ON searchformfields.SearchFormID = searchforms.SearchFormID JOIN input_type_tbl ON input_type_tbl.input_id = searchformfields.SearchFieldID LEFT OUTER JOIN searchformsvalidation ON searchformsvalidation.SearchFormFieldID = searchformfields.SearchFormFieldID LEFT OUTER JOIN forminputvalidationrules ON searchformsvalidation.ValidationRuleID=forminputvalidationrules.validation_id WHERE searchforms.SectionID = " . $SectionID . " GROUP BY searchformfields.SearchFormFieldID ORDER BY searchformfields.OrderNum)";



        $result=$this->db->query($query);

        if($result->num_rows() == 0)
            return false;

        $searchFormsString = "";

         $searchFormsString .= "<form id='form" . $result->row()->SearchFormID . "' method = 'get' action = '" . $result->row()->Action . "' enctype='multipart/form-data' >";

        foreach ($result->result() as $res) {
            $name = preg_replace("/[^a-zA-Z0-9]+/", "", $res->fieldtypename);

            $searchFormsString .= '<div id ="' . $name . 'DIV">';
            $searchFormsString .= '<label  for="' . $name . '">' . $res->FieldName . ':</label><br />';
            $class = "class = '";
            if(isset($res->ValidationsRules))
                $class .=   $res->ValidationsRules  ;


            switch ($res->input_type) {
                case 'textinput':
                case 'dateinput':
                case 'time':
                case 'phone':
                case 'time2':

                    if($res->input_type == 'dateinput')
                        $class .= ' calendar ';  

                    if($res->input_type == 'time')
                        $class .= ' time ';                        

                    if($res->input_type == 'phone')
                        $class .= ' phone ';                   

                     if($res->input_type == 'time2')
                        $class .= ' time2 ';

            
                    
                    $class .= "'";

                    $searchFormsString .= '<input ' . $class . ' type = "text" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;

                case 'textarea':

                    $class .= "'";
                    $searchFormsString .= '<textarea ' . $class . ' name = "'  . $name .  '" id = "' . $name . '" ></textarea>';
                    break;               

                case 'currency':
                    $class .= "'";
                    $searchFormsString .= '<select ' . $class . ' name = "'  . $name .  '" id = "' . $name . '" >';
                        $searchFormsString .= '<option value="US">USD</option>';
                        $searchFormsString .= '<option value="TZS">TZS</option>';
                    $searchFormsString .= '</select>';
                break;

                case 'multiselectsimple':
                case 'selectsimple':
                    $id = $name;
                    $this->db->order_by('OrderNum');
                    if(!$res->draws_from_table_two)
                    {

                        $options=$this->db->get($res->draws_from);
                    }

                    else
                    {
                        $tab1ID= $res->column_id;
                        $tab2ID= $res->column_id_two;

                        $this->db->select('*');
                        $this->db->from($res->draws_from);
                        $this->db->join($res->draws_from_table_two, $res->draws_from ."." . $tab1ID . "=" . $res->draws_from_table_two . "." . $tab2ID );
                        $options=$this->db->get();

                    }

                       
                    if($res->input_type == 'multiselectsimple')
                    {

                        $name .= '[]';
                        $multiple = 'multiple';
                    }
                    else $multiple = '';

                    $class .= "'";

                    $searchFormsString .= '<select ' . $class . ' '  . $multiple .  ' name = "'  . $name .  '" id = "' . $id . '" >';
                    $searchFormsString .= '<option value = "">-- Select --</option>';
                    foreach($options->result() as $option)
                    {
                        
                        $valueColumn= $res->column_id;
                        $showColumn = $res->display_id;
                       
                       $searchFormsString .= '<option value = "' . $option->$valueColumn . '">' . $option->$showColumn . '</option>';
                    }
                    $searchFormsString .= '</select>';
                    break;


                case 'multiselect':
                case 'select':

                    $onchage = "";
                    $this->db->order_by('OrderNum');
                    $this->db->where($res->column_id,$res->SectionID);
                    $this->db->where("Active",1);
                    $options=$this->db->get($res->draws_from);

                    if($options->num_rows() == 0)
                    {
                        $this->db->order_by('OrderNum');
                        $this->db->where($res->column_id_two,$res->SectionID);
                        $this->db->where("Active",1);
                        $options=$this->db->get($res->draws_from);  
                    }

                    if($options->row()->ParentSectionID == 5)
                    {
                        $this->db->where("Active",1);
                        $this->db->where("ParentSectionID",$options->row()->ParentSectionID);
                        $this->db->order_by('OrderNum');
                        $subsections=$this->db->get('sections');
                    }


                    if($res->input_type == 'multiselect')
                        $multiple = 'multiple';
                    else $multiple = '';

                    $class .= "'";


                    $searchFormsString .= '<select ' . $class . ' '  . $multiple .  ' name = "'  . $name .  '" id = "' . $name . '" >';


                    $searchFormsString .= '<option value = "">-- Select --</option>';

                    if($options->row()->ParentSectionID != 5)
                    {  
                        foreach($options->result() as $option)
                        {
                            
                            $valueColumn= $res->fieldtypename;
                            $showColumn = $res->display_id;
                           
                           $searchFormsString .= '<option value = "' . $option->$valueColumn . '">' . $option->$showColumn . '</option>';
                        }
                    }

                    else
                    {
                        foreach($subsections->result() as $subsection)
                        {
                            $searchFormsString .= '<optgroup label = "' . $subsection->Title . '">';

                            
                            foreach($options->result() as $option)
                            {
                                
                                $valueColumn= $res->fieldtypename;
                                $showColumn = $res->display_id;

                                if($subsection->SectionID == $option->SectionID)
                                    $searchFormsString .= '<option value = "' . $option->$valueColumn . '">' . $option->$showColumn . '</option>';
                            }
                        

                            $searchFormsString .= '</optgroup>';
                        }
                    }

                    $searchFormsString .= '</select>';
                    break;

                 case 'checkbox':
                     $class .= "'";
                        $searchFormsString .= '<input ' . $class . ' type = "checkbox" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;
                
                default:
                    $class .= "'";
                    $searchFormsString .= '<input ' . $class . ' type = "text" name = "'  . $name .  '" id = "' . $name . '" />';
                    break;
            }

            $searchFormsString .= '<br><br></div>';
        }

        $searchFormsString .= "<input id = 'search' type = 'submit' value = 'Search'>";

        $searchFormsString .= "</form>";

        return $searchFormsString;
    }


    function myaccount()
    {
        redirect('users/myaccount');
    }



    function missing() {
        $db1['hostname'] = 'zoom';
        $db1['username'] = 'sa';
        $db1['password'] = '5tokwerue';
        $db1['database'] = 'ZoomTanzania';
        $db1['dbdriver'] = 'odbc';
        $db1['dbprefix'] = '';
        $db1['pconnect'] = TRUE;
        $db1['db_debug'] = TRUE;
        $db1['cache_on'] = FALSE;
        $db1['cachedir'] = '';
        $db1['char_set'] = 'utf8';
        $db1['dbcollat'] = 'utf8_general_ci';
        $db1['swap_pre'] = '';
        $db1['autoinit'] = TRUE;
        $db1['stricton'] = FALSE;

        $DB1 = $this->load->database($db1, TRUE);


        $db2['hostname'] = 'localhost';
        $db2['username'] = 'root';
        $db2['password'] = '';
        $db2['database'] = 'zoomtanzania';
        $db2['dbdriver'] = 'mysql';
        $db2['dbprefix'] = '';
        $db2['pconnect'] = TRUE;
        $db2['db_debug'] = TRUE;
        $db2['cache_on'] = FALSE;
        $db2['cachedir'] = '';
        $db2['char_set'] = 'utf8';
        $db2['dbcollat'] = 'utf8_general_ci';
        $db2['swap_pre'] = '';
        $db2['autoinit'] = TRUE;
        $db2['stricton'] = FALSE;
        $DB2 = $this->load->database($db2, TRUE);

        $table = 'Listings';

        $max = 49000;
        $min = 46999;

        $DB2->where('ListingID <', $max);
        $DB2->where('ListingID >', $min);
        $DB2->select('ListingID');
        $listings = $DB2->get($table);

//echo $listings->num_rows();

        $data = array();
        foreach ($listings->result() as $listing) {
            $miss[] = $listing->ListingID;
        }

        $DB1->where('ListingID <', $max);
        $DB1->where('ListingID >', $min);
        $DB1->where_not_in('ListingID', $miss);
        $missing = $DB1->get($table);

        echo $missing->num_rows();

        $fields = $DB2->list_fields($table);

        foreach ($missing->result() as $listing) {

            foreach ($fields as $field) {

                if ($field == 'PaymentConfirmationEmailDateSent')
                    $field = 'PaymentConfirmationSent';
// //die();
                $data[$field] = $listing->$field;
            }


            $datas[] = $data;
        }

        print_r($datas);

// $DB2->insert_batch($table,$datas);
//print_r($miss);
//echo $listings->num_rows();
    }

    function test() {


        $db1['hostname'] = 'zoom';
        $db1['username'] = 'sa';
        $db1['password'] = '5tokwerue';
        $db1['database'] = 'ZoomTanzania';
        $db1['dbdriver'] = 'odbc';
        $db1['dbprefix'] = '';
        $db1['pconnect'] = TRUE;
        $db1['db_debug'] = TRUE;
        $db1['cache_on'] = FALSE;
        $db1['cachedir'] = '';
        $db1['char_set'] = 'utf8';
        $db1['dbcollat'] = 'utf8_general_ci';
        $db1['swap_pre'] = '';
        $db1['autoinit'] = TRUE;
        $db1['stricton'] = FALSE;

        $DB1 = $this->load->database($db1, TRUE);


        $db2['hostname'] = 'localhost';
        $db2['username'] = 'root';
        $db2['password'] = '';
        $db2['database'] = 'zoomtanzania';
        $db2['dbdriver'] = 'mysql';
        $db2['dbprefix'] = '';
        $db2['pconnect'] = TRUE;
        $db2['db_debug'] = TRUE;
        $db2['cache_on'] = FALSE;
        $db2['cachedir'] = '';
        $db2['char_set'] = 'utf8';
        $db2['dbcollat'] = 'utf8_general_ci';
        $db2['swap_pre'] = '';
        $db2['autoinit'] = TRUE;
        $db2['stricton'] = FALSE;
        $DB2 = $this->load->database($db2, TRUE);


        $max_min = $DB2->get('max_min');

        $max = $max_min->row()->max;
        $min = $max_min->row()->min;

        $update['min'] = $max - 1;
        $update['max'] = $max + 200;




//1899; 2000

        $table = 'ListingResultsPageImpressions';
        $DB1->where('ListingID <', $max);
        $DB1->where('ListingID >', $min);
//$DB1->select('DueDate');
// $DB1->where('OrderID', 904);

        $listings = $DB1->get($table);
        echo $listings->num_rows();

//echo gettype($listings->row()->DueDate);
//$filds=$listings->result_array();
//print_r($filds);
//  echo    $listings->row()->PaymentConfirmationEmailDateSent;

        $data = array();
        $datas = array();

        $fields = $DB2->list_fields($table);

        foreach ($listings->result() as $listing) {

            foreach ($fields as $field) {

                if ($field == 'PaymentConfirmationEmailDateSent')
                    $field = 'PaymentConfirmationSent';
// //die();
                $data[$field] = $listing->$field;
            }


            $datas[] = $data;
        }

//print_r($datas);

        if ($DB2->insert_batch($table, $datas))
            $DB2->update('max_min', $update);
    }


    public function listings() {
        $this->Common->is_logged_in();
    }

    public function post_a_listing($type = 0) {
        $this->Common->is_logged_in();
    }

    public function save_listing($type = 0) {
        $this->Common->is_logged_in();
    }

    public function edit_listing($listing_id) {
        $this->Common->is_logged_in();
    }

    public function test_login() {
//$this->ion_auth->login();
        $identity = 'admin@swahilimusicnotes.com';
        $password = '12GrownUp;';
        $remember = false; // remember the user
        if ($this->ion_auth->login($identity, $password, $remember))
            echo "Hehehehe";
        else
            echo $this->ion_auth->errors();

//echo $this->db->last_query();
    }


    public function login()
    {
        redirect('myaccount/login');
    }

    public function logout()
    {
        if($this->ion_auth->logout())
            echo "Logged Out";
        else
            echo "Still logged in";
    }



}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */