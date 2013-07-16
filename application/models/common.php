<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
* 
*/
class Common extends CI_Model
{


	function __construct()
	{
		parent::__construct();
	}

	function is_logged_in()
	{

		$array = array(
		 	'login_redirect_url'=>current_url()
		 );
		 
	 	$this->session->set_userdata( $array ); 
	 	//echo $this->session->userdata('login_redirect_url');
		if (!$this->ion_auth->logged_in())
		 	redirect('alerts');
	}



	function menu()
	{
		

		// $this->db->group_by('CategoryID');
		// $this->db->select('CategoryID, count(listingcategories.ListingID) as catCount',FALSE);
		// $this->db->from("listingsview");
		// $this->db->join('listingcategories', 'listingsview.ListingID = listingcategories.ListingID');
		// $this->db->where('listingsview.Active',1);
		// $this->db->where('listingsview.Reviewed',1);
		// $this->db->where('listingsview.DeletedAfterSubmitted',0);
		// $this->db->where('listingsview.Blacklist_fl',0);
		// $this->db->where('listingsview.Deadline','is null');
		// $this->db->or_where('listingsview.Deadline >=',CURRENT_DATE_IN_TZ);
		// $categoryListingsCount=$this->db->get();


		$listingsQuery = "Select  
		
		LC.CategoryID,  count(L.ListingID) as catCount
		
		FROM listingcategories LC  
		Inner Join listingsview L  on LC.ListingID=L.ListingID 

	
		";

		$listingsQuery .= "
		WHERE L.Active=1

		and L.Reviewed=1 

		and L.DeletedAfterSubmitted=0 

		and L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "'

		and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "')

		AND (L.ListingTypeID <> 15
			OR EXISTS (SELECT ListingID FROM listingeventdays  WHERE ListingID=L.ListingID ";

		$listingsQuery .= " AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "'))";


		

			
		$listingsQuery .= ' Group By LC.CategoryID';

		$categoryListingsCount = $this->db->query($listingsQuery);
		// echo $this->db->last_query();

		foreach($categoryListingsCount->result() as $categoryListingCount)
		{
			$categoryListingsCountArray[$categoryListingCount->CategoryID] = $categoryListingCount->catCount;
		}


		$this->db->where('active', 1);
		$this->db->order_by('Title');
		$sections = $this->db->get('sections');

		foreach ($sections->result() as $section) {
			if(!$section->ParentSectionID)
				$mainMenu[$section->SectionID] = $section->URLSafeTitleDashed;

			$sections_array[$section->ParentSectionID][$section->URLSafeTitleDashed] = $section->Title;
		}


		$this->db->order_by('Title');
		$this->db->where('active', 1);
		$categories = $this->db->get('categories');

		foreach ($categories->result() as $category) {

			if(isset($categoryListingsCountArray[$category->CategoryID]))
				$count =  $categoryListingsCountArray[$category->CategoryID];
			else $count = 0;

			if(!$category->ParentSectionID)
			{
				$category_array[$category->SectionID][$category->URLSafeTitleDashed] = $category->Title ;
				$category_id_url[$category->URLSafeTitleDashed]=$category->CategoryID;
				// $category_array[$category->SectionID][$category->URLSafeTitleDashed] = $category->Title . ' (' . $count . ')';
			}
			else
			{
				$category_array[$category->ParentSectionID][$category->URLSafeTitleDashed] = $category->Title ;
				$category_id_url[$category->URLSafeTitleDashed]=$category->CategoryID;

				// $category_array[$category->ParentSectionID][$category->URLSafeTitleDashed] = $category->Title . ' (' . $count . ')';
			}

		}
		// echo "<pre>";
		// print_r($mainMenu);
		// echo "</pre>";

		$this->db->order_by('OrderNum');
		$main=$this->db->get('main_menu_items');

		//print_r($category_array);


		$menu = '<div class="menubox" align="center"><div><nav id="cbp-hrmenu" class="cbp-hrmenu"><ul>';
		$menu .= '<li><a href="' . base_url() . '">HOME</a></li>';

		$item_num = 0;
		foreach ($main->result() as $item) {

			switch ($item->SectionID) {
				case 1:
				case 4:
				case 21:
				case 55:
				case 59:
				if($item->DrawsFrom != '')
				{
				$menu .= '<li><a href="' . $mainMenu[$item->SectionID] . '" class="drop">' . $item->MenuTitle . '</a>';
    			
				if($item->DrawsFrom == 'sections')
					$sub_menu_array = $sections_array;
				else if($item->DrawsFrom == 'categories')
					$sub_menu_array = $category_array;


				$countChecker=$flag =1;
				$count = count($sub_menu_array[$item->SectionID]); //total sub menu number of rows
				

				$col_complete = 14;
				$col1 = false;

				//echo $col_complete . '<br>';

				$menu .= '<div class="cbp-hrsub"><div class="cbp-hrsub-inner">';
				$travelSpecials = "";
				foreach($sub_menu_array[$item->SectionID] as $url => $sub_menu)
				{


    				if($flag==1 )
    				{
						$menu .= '<div>';//Start Col of Menu Items

						if(!$col1)
						{
							if($item->SectionID==55)	
								$menu .= "<h4>Choose a Vehicle Type</h4>";
							if($item->SectionID==59)
								$menu .= "<h4>Event Types</h4>";
						}
						$menu .= '<ul>';//Start Col of Menu Items
					}

					if($item->SectionID==21 )
					{
						if($category_id_url[$url]==94 or $category_id_url[$url]==439 or $category_id_url[$url]==336 or $category_id_url[$url]==337)
						{
							$flag--;
							$countChecker--;
							$travelSpecials .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

						}
						else
							$menu .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';
					}
					else
						$menu .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($flag == $col_complete and !$col1)
					{
						$menu .= '</ul></div>'; // If col is full, close col 
						$flag = 1;
						$col1=true;

					}

    				else
    				{
						$flag++;
						$countChecker++;
					}
				}

				if($item->SectionID==21)
				{
					$menu .= "</ul><h4>Travel Specials</h4><ul>";
					$menu .= $travelSpecials;
					$menu .= "</ul><h4>Tanzania National Parks Guide</h4><ul>";
					$menu .= "<li><a href ='tanzania-national-parks-guide'>National Parks</a></li>";
					$menu .= "<li><a href ='tanzania-national-park-fees'>National Park Fees</a></li>";

				}

				if($item->SectionID==4)
				{
					$menu .= "<ul><li><a href='steals-deals-and-classifieds'><img src='images/sitewide/button_viewall.png' width='127' height='36' alt='view all events' /></a><a href='#'><img src='images/sitewide/button_classified.png' width='127' height='36' /></a></li></ul>";
				}

				if($item->SectionID==59) //Event Businesses
				{
					$menu .= "<ul><li><a href='tanzania-events-calendar'><img src='images/sitewide/button_viewall.png' width='127' height='36' alt='view all events' /></a><a href='#'><img src='images/sitewide/button_event.png' width='127' height='36' /></a></li></ul>";
					$menu .= "</ul><h4>Related Businesses</h4><ul>";
					$menu .= "<li><a href = 'Bands-And-DJs-for-Hire'>Bands & DJs for Hire</a></li>";
					$menu .= "<li><a href = 'Catering'>Catering</a></li>";
					$menu .= "<li><a href = 'Conference-And-Event-Planners'>Conference & Event Planners</a></li>";
					$menu .= "<li><a href = 'Conference-And-Seminar-Facilities'>Conference & Seminar Facilities</a></li>";
					$menu .= "<li><a href = 'Party-And-Event-Venues'>Party & Event Venues</a></li>";
					$menu .= "<li><a href = 'Wedding-And-Party-Planners'>Wedding & Party Planners</a></li>";
				}				

				if($item->SectionID==55) //Car Businesses 
				{
					$menu .= "<ul><li><a href='used-cars-trucks-and-boats'><img src='images/sitewide/button_viewall.png' width='127' height='36' alt='view all events' /></a><a href='#'><img src='images/sitewide/button_vehicle.png' width='127' height='36' /></a></li></ul>";
					$menu .= "</ul></div><div><h4>Related Businesses</h4><ul>";
					$menu .= "<li><a href = 'Auto-Parts-And-Accessories'>Auto Parts & Accessories</a></li>";
					$menu .= "<li><a href = 'Battery-And-Tyre-Companies'>Battery And Tyre Companies</a></li>";
					$menu .= "<li><a href = 'Clearing-Registration-And-Licensing-Agents'>Clearing Registration And Licensing Agents</a></li>";
					$menu .= "<li><a href = 'Mechanics-And-Garages'>Car Mechanics & Garages</a></li>";
					$menu .= "<li><a href = 'New-Car-Dealers'>New Car Dealers</a></li>";
					$menu .= "<li><a href = 'Used-Car-Dealers'>Used Car Dealers</a></li>";
					$menu .= "<li><a href = 'Marine-And-Boat-Supplies'>Marine & Boat Supplies</a></li>";
					$menu .= "<li><a href = 'Motorcycle-And-Kibajaji-Dealers'>Motorcycle & Kibajaji Dealers</a></li>";
				}

				$menu .= "</ul></div><div>";
				if($item->promotional_title_1 and $item->promotional_image_1 and $item->promotional_text_1)
				{
						$menu .= "<h4>".$item->promotional_title_1."</h4>";
						$menu .= "<ul>
									<li><a href='#'><img src='images/sitewide/" . $item->promotional_image_1 . "'></a></li>
									<li><a href='#'>" . $item->promotional_text_1 . "</a></li>
								</ul>";
				}
				if($item->promotional_title_2 and $item->promotional_image_2 and $item->promotional_text_2)
				{
						$menu .= "<h4>".$item->promotional_title_2."</h4>";
						$menu .= "<ul>
									<li><a href='#'><img src='images/sitewide/" . $item->promotional_image_2 . "'></a></li>
									<li><a href='#'>" . $item->promotional_text_2 . "</a></li>
								</ul>";
				}
				$menu .= "</div>";

				$menu .= '</div></li>';

			}
			else
				$menu .= '<li><a href="' . $item->URLSafeTitleDashed . '">' . $item->MenuTitle . '</a></li>';

			$item_num++;
					break;

				case 32:
				if($item->DrawsFrom != '')
				{
				$menu .= '<li><a href="' . $mainMenu[$item->SectionID] . '" class="drop">' . $item->MenuTitle . '</a>';
    			

				$sub_menu_array = $category_array;
				

				$menu .= '<div class="cbp-hrsub"><div class="cbp-hrsub-inner">';
				$dining ="<h4>Dining</h4><ul>";
				$entertainment="<h4>Entertainment</h4><ul>";
				$nightlife ="<h4>Nightlife</h4><ul>";
				$thearts = "<h4>The Arts</h4><ul>";
					
				foreach($sub_menu_array[$item->SectionID] as $url => $sub_menu)
				{

					if($category_id_url[$url]==72)
						$dining .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($category_id_url[$url]==105 or $category_id_url[$url]==107 or $category_id_url[$url]==175 or $category_id_url[$url]==412)
						$entertainment .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($category_id_url[$url]==71 or $category_id_url[$url]==188)
						$nightlife .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($category_id_url[$url]==66 or $category_id_url[$url]==424)
						$thearts .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';
	
				}
				$menu .= "<div>";
					$menu .= $dining . "</ul>" . $entertainment . "</ul>";
				$menu .= "</div>";

				$menu .= "<div>";
					$menu .= $nightlife . "</ul>" . $thearts . "</ul>";
				$menu .= "</div>";


				$menu .= "<div>";
				if($item->promotional_title_1 and $item->promotional_image_1 and $item->promotional_text_1)
				{
						$menu .= "<h4>".$item->promotional_title_1."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_1 ."'><img src='images/sitewide/" . $item->promotional_image_1 . "'></a></li>
									<li><a href='". $item->promotional_link_1 ."'>" . $item->promotional_text_1 . "</a></li>
								</ul>";
				}
				if($item->promotional_title_2 and $item->promotional_image_2 and $item->promotional_text_2)
				{
						$menu .= "<h4>".$item->promotional_title_2."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_2 ."'><img src='images/sitewide/" . $item->promotional_image_2 . "'></a></li>
									<li><a href='". $item->promotional_link_2 ."'>" . $item->promotional_text_2 . "</a></li>
								</ul>";
				}
				$menu .= "</div>";

				$menu .= '</div></li>';



			}


					break;


				case 5:
				if($item->DrawsFrom != '')
				{
				$menu .= '<li><a href="' . $mainMenu[$item->SectionID] . '" class="drop">' . $item->MenuTitle . '</a>';
    			

				$sub_menu_array = $category_array;
				

				$menu .= '<div class="cbp-hrsub"><div class="cbp-hrsub-inner">';
				$housingRentals ="<h4>Housing Rentals</h4><ul>";
				$commercialRentals="<h4>Commercial Rentals</h4><ul>";
				$homesProperties ="<h4>Properties For Sale</h4><ul>";

					
				foreach($sub_menu_array[$item->SectionID] as $url => $sub_menu)
				{

					if($category_id_url[$url]==87 or $category_id_url[$url]==322 or $category_id_url[$url]==323 or $category_id_url[$url]==324)
						$housingRentals .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($category_id_url[$url]==286 or $category_id_url[$url]==398 or $category_id_url[$url]==399 )
						$commercialRentals .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';

					if($category_id_url[$url]==287 or $category_id_url[$url]==288 or $category_id_url[$url]==89 )
						$homesProperties .= '<li><a href="' . $url . ' ">' . $sub_menu . '</a></li>';


	
				}
				$menu .= "<div>";
					$menu .= $housingRentals . "</ul>" . $commercialRentals . "</ul>" ;
				$menu .= "</div>";				
				$menu .= "<div>";
					$menu .=  $homesProperties . "</ul>";
					$menu .= "<ul><li><a href='tanzania-real-estate'><img src='images/sitewide/button_viewall.png' width='127' height='36' alt='view all events' /></a><a href='#'><img src='images/sitewide/button_property.png' width='127' height='36' /></a></li></ul>";
					$menu .= "<h4>Related Businesses</h4><ul>";
					$menu .= "<li><a href = 'Property-Management'>Property Management</a></li>";
					$menu .= "<li><a href = 'Real-Estate-Development-Companies'>Real Estate Development Companies</a></li>";
					$menu .= "<li><a href = 'Tanzania-Real-Estate-Agents'>Tanzania Real Estate Agents</a></li>";
					

				$menu .= "</div>";

				$menu .= "<div>";
				if($item->promotional_title_1 and $item->promotional_image_1 and $item->promotional_text_1)
				{
						$menu .= "<h4>".$item->promotional_title_1."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_1 ."'><img src='images/sitewide/" . $item->promotional_image_1 . "'></a></li>
									<li><a href='". $item->promotional_link_1 ."'>" . $item->promotional_text_1 . "</a></li>
								</ul>";
				}
				if($item->promotional_title_2 and $item->promotional_image_2 and $item->promotional_text_2)
				{
						$menu .= "<h4>".$item->promotional_title_2."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_2 ."'><img src='images/sitewide/" . $item->promotional_image_2 . "'></a></li>
									<li><a href='". $item->promotional_link_2 ."'>" . $item->promotional_text_2 . "</a></li>
								</ul>";
				}
				$menu .= "</div>";

				$menu .= '</div></li>';
				

				

			}


					break;

			case 8:
				if($item->DrawsFrom != '')
				{
				$menu .= '<li><a href="' . $mainMenu[$item->SectionID] . '" class="drop">' . $item->MenuTitle . '</a>';
    			

				$sub_menu_array = $category_array;
				

				$menu .= '<div class="cbp-hrsub"><div class="cbp-hrsub-inner">';


				$menu .= "<div><h4>Vacancies In:</h4><ul>";
				$menu .= "<li><a href = '#'>NGO</a></li>";
				$menu .= "<li><a href = '#'>Governamental</a></li>";
				$menu .= "<li><a href = '#'>Parastatal</a></li>";
				$menu .= "<li><a href = '#'>Private Sector</a></li></ul>";


				$menu .= "<h4>Vacancy Type:</h4><ul>";
				$menu .= "<li><a href = '#'>Full Time</a></li>";
				$menu .= "<li><a href = '#'>Consultancy</a></li>";
				$menu .= "<li><a href = '#'>Volunteer</a></li>";
				$menu .= "<li><a href = '#'>Internship</a></li></ul></div>";


				$jobCategories ="<h4>Choose a Job Category</h4><ul><li><form action = '' method = 'post'><select name='CategorySelect' id='CategorySelect' class='CategorySelect'>";

				$jobCategories .= "<option value=''>Select One</option>";
				foreach($sub_menu_array[$item->SectionID] as $url => $sub_menu)
				{

					$jobCategories .= "<option value="  . $url .  ">" . $sub_menu . "</option>";
	
				}
				$menu .= "<div>";
					$menu .= $jobCategories . "</select></form></li></ul>";
					$menu .= "<ul><li><a href='tanzania-jobs-and-employment'><img src='images/sitewide/button_viewall.png' width='127' height='36' alt='view all events' /></a><a href='#'><img src='images/sitewide/button_job.png' width='127' height='36' /></a></li></ul>";
					$menu .= "<h4>Related Businesses</h4><ul>";
					$menu .= "<li><a href = 'HR-And-Administration-Services'>HR & Administration Services</a></li>";
					$menu .= "<li><a href = 'Tanzania-Recruitment-Agencies'>Tanzania Recruitment Agencies</a></li>";
					$menu .= "<li><a href = 'Training-And-Career-Development'>Training & Career Development</a></li>";
				$menu .= "</div>";


				$menu .= "<div>";
				if($item->promotional_title_1 and $item->promotional_image_1 and $item->promotional_text_1)
				{
						$menu .= "<h4>".$item->promotional_title_1."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_1 ."'><img src='images/sitewide/" . $item->promotional_image_1 . "'></a></li>
									<li><a href='". $item->promotional_link_1 ."'>" . $item->promotional_text_1 . "</a></li>
								</ul>";
				}
				if($item->promotional_title_2 and $item->promotional_image_2 and $item->promotional_text_2)
				{
						$menu .= "<h4>".$item->promotional_title_2."</h4>";
						$menu .= "<ul>
									<li><a href='". $item->promotional_link_2 ."'><img src='images/sitewide/" . $item->promotional_image_2 . "'></a></li>
									<li><a href='". $item->promotional_link_2 ."'>" . $item->promotional_text_2 . "</a></li>
								</ul>";
				}
				$menu .= "</div>";

				$menu .= '</div></li>';

			}


					break;
				
				// default:
				// 	# code...
				// 	break;
			}




		}

		$menu .= '</ul></nav></div></div>';

		echo $menu;
	}

	function sendErrorEmail($type)
	{

		$message = "<html><body>";

		switch ($type) {
			case 'email':
				$message .= $this->email->print_debugger();
				break;

			case 'spam':
				foreach ($this->input->post() as $key => $value) {
					$message .= "<strong>" . $key . "</strong>:" . $value . '<br />';
				}
				break;
			
			default:
				# code...
				break;
		}

		$message .= "</html></body>";

		$this->load->library('email');
		
		$this->email->from('inquiry@ZoomTanzania.com', 'inquiry@ZoomTanzania.com');
		$this->email->to('terence@ZoomTanzania.com');

		
		$this->email->subject('An Error Has Occured');
		$this->email->message($message);
		
		$this->email->send();
		
		//echo $this->email->print_debugger();
	}


	
}