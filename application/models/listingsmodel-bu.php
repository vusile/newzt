<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class listingsModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getHomePageListings()
	{

		$movieSchedulesQuery = "
                SELECT L.Title as TheatreName, LOC.Title as Location, L.URLSafeTitle, (Select MovieImage from listingmovies as LM where L.ListingID = LM.ListingID order by OrderNum limit 1) as Flier FROM listingsview as L inner join listinglocations as LL on L.ListingID = LL.ListingID inner join locations as LOC on LL.LocationID = LOC.LocationID where L.ListingTypeID = 20 and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0";

            $data['movieSchedulesObj'] = $this->db->query($movieSchedulesQuery);

            $specialEventsQuery = "
            Select L.ListingID, L.ListingTitle, L.EventStartDate, L.EventEndDate, L.RecurrenceID, L.RecurrenceMonthID,
        (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) as StartDate, (Select Max(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) as EndDate,
        
        CASE WHEN (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "'
            THEN (Select Max(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) 
            ELSE (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) 
            END as EventSortDate,   
        CASE WHEN RecurrenceID is NULL and (EventEndDate is null or cast(EventStartDate as char) = cast(EventEndDate as char)) THEN 1
            WHEN RecurrenceID is NULL and (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "' THEN 6 
            WHEN RecurrenceID is null THEN 5 
            WHEN RecurrenceID=3 THEN 2 
            WHEN RecurrenceID=2 THEN 3 
            WHEN RecurrenceID=1 THEN 4 
            ELSE 10 END as EventRank,
        
        CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing,
        L.ELPTypeThumbnailImage, L.ExpandedListingPDF       
        From listingsview L 
        Where (
                EXISTS (SELECT ListingID FROM listingeventdays  WHERE ListingID=L.ListingID AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "')
                
                    )
            
        and (RecurrenceID  in (3,4) or RecurrenceID is null)
        and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "'
        and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0 
        Order By EventSortDate, EventRank,  L.ListingTitle";

            $data['specialEventsObj'] = $this->db->query($specialEventsQuery);


             $featuredBusinessQuery = "Select L.ListingID, L.ListingTitle, L.ShortDescr, L.Deadline,
            L.ELPTypeThumbnailImage, L.LogoImage, L.ELPThumbnailFromDoc
            From listingsview L
            Where L.ListingTypeID  in (1,2,14)
            and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "'
            and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0
            Order by L.FeaturedListing desc, L.DateSort desc Limit 1";

            $data['featuredBusinessObj'] = $this->db->query($featuredBusinessQuery);

            $travelSpecialQuery = "Select L.ListingID, L.ListingTitle, L.ShortDescr, L.Deadline,
            L.ELPTypeThumbnailImage, L.LogoImage, L.ELPThumbnailFromDoc
            From listingsview L
            Where L.ListingTypeID  in (9)
            and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' and L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' 
            and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0
            Order by L.FeaturedTravelListing desc, L.DateSort desc Limit 1";

            $data['travelSpecialObj'] = $this->db->query($travelSpecialQuery);

            $jobsQuery = "  Select  L.ListingID, L.ListingTitle, L.ShortDescr, L.Deadline, L.LocationOther,
    (Select Title From locations Lo Inner Join listinglocations LL  on Lo.LocationID=LL.LocationID Where LL.ListingID = L.ListingID and Lo.LocationID <> 4 Limit 1) as Location
    From listingsview L 
    Where L.ListingTypeID = 10
    and L.Active=1

and L.Reviewed=1 

and L.DeletedAfterSubmitted=0 

and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )   
            
and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' and L.PaymentStatusID in (2,3)))
and L.Blacklist_fl = 0
    Order by DateSort desc Limit 1";


        $data['jobsObj'] = $this->db->query($jobsQuery);



        $fsboQuery = "  Select L.ListingID, L.ListingTitle, L.ShortDescr, L.PriceUS, L.PriceTZS, L.ListingTypeID, L.LocationOther,
    (Select  Title From locations Lo  Inner Join listinglocations LL on Lo.LocationID=LL.LocationID Where LL.ListingID = L.ListingID and Lo.LocationID <> 4 Limit 1) as Location,
    (Select FileName
            From listingimages 
            Where ListingID=L.ListingID
            Order By OrderNum, ListingImageID Limit 1) as FileNameForTN
    From listingsview L 
    Where L.ListingTypeID in (3,4,5)
    and exists (Select ListingID from listingparentsections Where ListingID=L.ListingID and ParentSectionID<>55)  
    and exists (Select ListingID from listingimages Where ListingID=L.ListingID)
        and L.Active=1

and L.Reviewed=1 

and L.DeletedAfterSubmitted=0 

and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )   
            
and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' and L.PaymentStatusID in (2,3)))
and L.Blacklist_fl = 0
    Order by DateSort desc Limit 1";

    $data['fsboObj'] = $this->db->query($fsboQuery);


    $vehiclesQuery = "  Select L.ListingID, L.ListingTitle, L.ShortDescr, L.PriceUS, L.PriceTZS, L.ListingTypeID, L.LocationOther, L.VehicleYear, L.Model as ModelOther, L.Make as MakeOther, (Select Title from makes where MakeID = L.MakeID) as Make,  
    (Select Title From locations Lo Inner Join listinglocations LL on Lo.LocationID=LL.LocationID Where LL.ListingID = L.ListingID and Lo.LocationID <> 4 Limit 1) as Location,
    (Select  FileName
            From listingimages
            Where ListingID=L.ListingID
            Order By OrderNum, ListingImageID Limit 1) as FileNameForTN
    From listingsview L 
    Where L.ListingTypeID in (3,4,5)
    and exists (Select ListingID from listingparentsections Where ListingID=L.ListingID and ParentSectionID=55)
    and exists (Select ListingID from listingimages Where ListingID=L.ListingID)
    and L.Active=1

and L.Reviewed=1 

and L.DeletedAfterSubmitted=0 

and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )   
            
and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' and L.PaymentStatusID in (2,3)))
and L.Blacklist_fl = 0
    Order by DateSort desc Limit 1";

    $data['vehiclesObj'] = $this->db->query($vehiclesQuery);


    $realEstateQuery = "Select L.ListingID, L.ListingTitle, L.ShortDescr, L.PriceUS, L.PriceTZS, L.RentUS, L.RentTZS, L.ListingTypeID, L.LocationOther,
    (Select Title From locations Lo Inner Join listinglocations LL on Lo.LocationID=LL.LocationID Where LL.ListingID = L.ListingID and Lo.LocationID <> 4 Limit 1) as Location,
    T.Title as Term,
    (Select FileName
            From listingimages
            Where ListingID=L.ListingID
            Order By OrderNum, ListingImageID Limit 1) as FileNameForTN
    From listingsview L 
    Left Outer Join terms T on L.TermID=T.TermID
    Where L.ListingTypeID  in (6,7,8)
    and exists (Select ListingID from listingimages Where ListingID=L.ListingID)
 and L.Active=1

and L.Reviewed=1 

and L.DeletedAfterSubmitted=0 

and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )   
            
and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' and L.PaymentStatusID in (2,3)))
and L.Blacklist_fl = 0
    Order by DateSort desc Limit 1";

    $data['realEstateObj'] = $this->db->query($realEstateQuery);

    return $data;
	}

    function getExchangeRates() {
        $this->db->order_by('orderNum');
        return $this->db->get('exchange_rates');
    }


    function getTides()
    {
    	 $tidesQuery = "select t.tideDate, t.High, t.Measurement,l.LunarDate,l.MoonTypeID,mt.descr 
        from tides t left join lunar l 
    ON CONVERT(t.TideDate,  date)=CONVERT(l.LunarDate ,  date)
    left join moontype mt  ON l.moonTypeID = mt.moonTypeID

    where TideDate >= '" . date("Y-m-d") . ' 00:00:00' . "'
    AND TideDate <= '" . date("Y-m-d") . ' 23:59:00' . "'";

            return $this->db->query($tidesQuery);
    }

	
	function getListingCategoryCount($SectionID)
	{
		$categoriesInSectionArray = array();
		$listingsInCategoryArray = array();
		$livelistingsArray = array();
		$categorylistingsCountArray = array();



		$this->db->where('ParentSectionID', $SectionID);
		$categoriesInSectionResultObj = $this->db->get('categories');

		if($categoriesInSectionResultObj->num_rows() == 0)
		{
			$this->db->where('SectionID', $SectionID);
			$categoriesInSectionResultObj = $this->db->get('categories');
		}

		foreach($categoriesInSectionResultObj->result() as $categoryInSection)
			$categoriesArray[]=$categoryInSection->CategoryID;

		$this->db->where_in('CategoryID',$categoriesArray);
		$listingsInCategoryObj=$this->db->get('listingcategories');

		foreach ($listingsInCategoryObj->result() as $ListingInCategory) {
			$listingsInCategoryArray[] = $ListingInCategory->ListingID;
		}

		$this->db->where('Reviewed', 1);
		$this->db->where('Active', 1);
		$this->db->where('DeletedAfterSubmitted', 0);
		$this->db->where_in('ListingID',$listingsInCategoryArray);
		$livelistings=$this->db->get('listings');

		foreach($livelistings->result() as $liveListing)
		{
			$livelistingsArray[]=$liveListing->ListingID;
		}


		$this->db->where_in('ListingID',$livelistingsArray);
		$this->db->group_by('CategoryID');
		$this->db->select('CategoryID, count(ListingID) as catCount',FALSE);
		$categorylistingsCount=$this->db->get('listingcategories');

		foreach($categorylistingsCount->result() as $categoryListingCount)
		{
			$categorylistingsCountArray[$categoryListingCount->CategoryID] = $categoryListingCount->catCount;
		}

		return $categorylistingsCountArray;

	}

	function getTables($tableName)
	{
		return $this->db->get($tableName);
	}


	function Filters()
	{
		$locations = "Select LocationID as SelectValue, Title as SelectText 
		From locations With 		Where Active=1
		Order By OrderNum";


		$seekingEmploymentcategories="Select C.SectionID, S.Title as SubSection, S.OrderNum as SectionOrderNum, S.ImageFile as SectionImage,
			C.CategoryID, C.Title as Category, C.OrderNum as CategoryOrderNum, C.SectionID, C.ParentSectionID, C.URLSafeTitleDashed as CategoryURLSafeTitle,
			C.ImageFile as CategoryImage,
			(Select Count(L.ListingID) 
			From listings L Inner Join listingcategories LC With on L.ListingID=LC.ListingID
			Where LC.CategoryID=C.CategoryID 
			and L.Active=1

			and L.Reviewed=1 

			and L.DeletedAfterSubmitted=0 

			and (L.Deadline is null or L.Deadline >= " . CURRENT_DATE_IN_TZ . ")

			AND (L.ListingTypeID <> 15
				OR EXISTS (SELECT ListingID FROM listingeventdays with WHERE ListingID=L.ListingID 
						AND ListingEventDate >= " . CURRENT_DATE_IN_TZ . "))		
						
			and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= " . CURRENT_DATE_IN_TZ . " and L.PaymentStatusID in (2,3)))
			and L.Blacklist_fl = 0
			and (L.ListingTypeID is null or L.ListingTypeID in (10,12))) as ListingCount
			From sections S With 			Left Outer Join categories C With on S.SectionID=C.SectionID or (C.ParentSectionID=S.SectionID and C.SectionID is null) 		
			Where S.Active=1
			and C.Active=1
			and C.ParentSectionID=8
			and S.SectionID <> 29
			Order By SectionOrderNum, CategoryOrderNum";
	}

	function getSection($ParentSectionID)
	{

		//and L.PaymentStatusID in (2,3) and L.Blacklist_fl = 0
				$section="Select C.SectionID, S.Title as SubSection, CASE WHEN C.SectionID IS null THEN null ELSE S.OrderNum END as SectionOrderNum, S.ImageFile as SectionImage, S.URLSafeTitleDashed as SectionURL, 
		C.CategoryID, C.Title as Category, C.OrderNum as CategoryOrderNum, C.ParentSectionID, C.URLSafeTitleDashed as CategoryURLSafeTitle,
		C.ImageFile as CategoryImage,
		(Select Count(L.ListingID) 
		From listings L Inner Join listingcategories LC on L.ListingID=LC.ListingID
		Where LC.CategoryID=C.CategoryID
		and L.Active=1

		and L.Reviewed=1 

		and L.DeletedAfterSubmitted=0 

		and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )

		AND (L.ListingTypeID <> 15
			OR EXISTS (SELECT ListingID FROM listingeventdays WHERE ListingID=L.ListingID 
					AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "'))		
					
		and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' ))
		) 
		as ListingCount
		From sections S Left Outer Join categories C on S.SectionID=C.SectionID or (C.ParentSectionID=S.SectionID and C.SectionID is null) 
		Where S.Active=1
		and C.ParentSectionID=" . $ParentSectionID . "
		and C.Active=1
		Order By SectionOrderNum, CategoryOrderNum";

		if($this->db->query($section)->num_rows() >0 )
			return $this->db->query($section);
		else
		{
			$section="Select C.SectionID, S.Title as SubSection, CASE WHEN C.SectionID IS null THEN null ELSE S.OrderNum END as SectionOrderNum, S.ImageFile as SectionImage,
			C.CategoryID, C.Title as Category, C.OrderNum as CategoryOrderNum, C.ParentSectionID, C.URLSafeTitleDashed as CategoryURLSafeTitle,
			C.ImageFile as CategoryImage,
			(Select Count(L.ListingID) 
			From listings L Inner Join listingcategories LC on L.ListingID=LC.ListingID
			Where LC.CategoryID=C.CategoryID
			and L.Active=1

			and L.Reviewed=1 

			and L.DeletedAfterSubmitted=0 

			and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' )

			AND (L.ListingTypeID <> 15
				OR EXISTS (SELECT ListingID FROM listingeventdays WHERE ListingID=L.ListingID 
						AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "'))		
						
			and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' ))
			) 
			as ListingCount
			From sections S Left Outer Join categories C on S.SectionID=C.SectionID or (C.ParentSectionID=S.SectionID and C.SectionID is null) 
			Where S.Active=1
			and C.SectionID=" . $ParentSectionID . "
			and C.Active=1
			Order By SectionOrderNum, CategoryOrderNum";			
			return $this->db->query($section);
		}

	}


	function getCategory($CategoryID)
	{

		//echo $CategoryID;
		$categoryQuery = "Select C.Title, C.ParentSectionID, C.SectionID, C.Descr as CallOut, C.H1Text, C.MetaKeywords, C.URLSafeTitle, PS.Title as ParentSection, S.Title as SubSection From categories C Left Outer Join parentsectionsview PS on C.ParentSectionID=PS.ParentSectionID Left Outer Join sections S on C.SectionID=S.SectionID Where C.CategoryID = ";

		$categoryQuery = $categoryQuery . $CategoryID;
		//echo $CategoryID;
		//echo $CategoryID;


		// echo $categoryQuery; die();
		$category['categoryMeta'] = $this->db->query($categoryQuery)->row(); 



		$ListingTypeQuery = "Select ListingTypeID From categorylistingtypes Where CategoryID = ";


		$ListingTypeQuery = $ListingTypeQuery . $CategoryID . " And ListingTypeID in (3,4,5,6,7,8)";
		//echo $ListingTypeQuery;

		$ListingTypeObj = $this->db->query($ListingTypeQuery);

		if($ListingTypeObj->num_rows() > 0)
			$category['showThumbNail'] = 1;

		else
			$category['showThumbNail'] = 0;


		if(strpos("4,5,8,55",$category['categoryMeta']->SectionID))
			$category['SortBy'] = 'MostRecent';
		else if($category['categoryMeta']->ParentSectionID == 59)
			$category['SortBy'] = 'EventSort';
		else
			$category['SortBy'] = '';


		$category['ParentSectionID'] = $category['categoryMeta']->ParentSectionID;
		$category['SectionID'] = $category['categoryMeta']->SectionID;

		if(isset($category['categoryMeta']->SectionID))
			$category['hassections'] = 1;
		else
			$category['hassections'] = 0;

		$category['CategoryIDs'] = $CategoryID;

	//	print_r($category);

		return $category;

	}

	function getlistings($category,$featured=0)
	{

		//print_r($category);STRAIGHT_JOIN
		$listingsQuery = "Select  L.Deadline, L.ExpirationDate, L.ListingID, L.ListingTypeID, L.ListingTitle, L.ShortDescr, L.DateListed, L.PriceUS, L.PriceTZS,
		L.RentUS, L.RentTZS, L.Bedrooms, L.Bathrooms, L.AmenityOther, L.LocationOther, L.LocationText,
		L.LongDescr, L.MakeID, L.DateSort, L.SquareFeet, L.SquareMeters,
		L.Make as MakeOther, L.Model as ModelOther, L.VehicleYear, L.Kilometers, L.FourWheelDrive,
		L.Deadline, L.WebsiteURL, L.PublicPhone,  L.PublicPhone2,  L.PublicPhone3,  L.PublicPhone4, L.PublicEmail, L.URLSafeTitle as ListingURL, 
		L.EventStartDate, L.EventEndDate, L.RecurrenceID, ( Select Descr from recurrencemonths where RecurrenceMonthID = L.RecurrenceMonthID) MonthlyRepeat, 
		L.ExpandedListingHTML, L.ExpandedListingPDF,
		L.CuisineOther, L.AccountName,";
		
		$listingsQuery .= " CASE WHEN L.ListingTypeID <> 9 or L.ListingTypeID is null THEN (SELECT GROUP_CONCAT(Title Order BY OrderNum SEPARATOR ', ') From listinglocations LL Inner Join locations LOC on LL.LocationID = LOC.LocationID where L.ListingID = LL.ListingID ";

		if($this->input->get("LocationID"))	
			$listingsQuery .= " AND LL.LocationID IN (" . str_replace('-', ',', $category['LocationID'])  .")";
						

		$listingsQuery .=") END as Location, ";


		if($category['SectionID'] == 59 )
			$listingsQuery .= "(SELECT GROUP_CONCAT(Descr Order BY OrderNum  SEPARATOR ', ') from listingrecurrences inner join recurrencedays on recurrencedays.RecurrenceDayID = listingrecurrences.RecurrenceDayID where ListingID = L.ListingID  group by ListingID) as RecurrenceDays, ";

		$listingsQuery .="

		CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing,
		L.SquareFeet, L.SquareMeters,
		L.LogoImage, L.ELPTypeThumbnailImage, L.ELPThumbnailFromDoc,
		PS.ParentSectionID, PS.Title as ParentSection, PS.URLSafeTitleDashed as ParentSectionURLSafeTitle,
		S.SectionID, S.Title as SubSection,
		C.CategoryID, C.Title as Category, 
		M.Title as Make, T.Title as Transmission,
		Te.Title as Term, RAND() as RandOrderID, ";

		/*For Events*/

		if($category['SectionID']==59)
		{
			$listingsQuery .= " CASE WHEN (Select Min(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "'" ;

			 // <!--- Multipday event already in progress, so set event sort date to event's end date --->
			$listingsQuery .= " THEN (Select Max(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) ";
			
			 // <!--- All others use Event's Start Date --->
			$listingsQuery .= " ELSE (Select Min(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) ";
			$listingsQuery .= " END as EventSortDate, ";

			// <!--- Non Repeating Single day --->
			$listingsQuery .= "	CASE WHEN RecurrenceID is NULL and (EventEndDate is null or cast(EventStartDate as char) = cast(EventEndDate as char)) THEN 1 ";

			// <!--- Multiday events that have already started --->
			$listingsQuery .= " WHEN RecurrenceID is NULL and (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '". CURRENT_DATE_IN_TZ  . "' THEN 6 ";

			// <!--- Multiday events that have not started --->
			$listingsQuery .= " WHEN RecurrenceID is null THEN 5 "; 

			// <!--- Monthly Repeating --->
			$listingsQuery .= " WHEN RecurrenceID=3 THEN 2 "; 

			// <!--- Bi weekly Repeating --->
			$listingsQuery .= " WHEN RecurrenceID=2 THEN 3 ";

			// <!--- Weekly Repeating --->
			$listingsQuery .= "	WHEN RecurrenceID=1 THEN 4 "; 

			// <!--- Yearly Repeating --->
			$listingsQuery .= " ELSE 10 END as EventRank, "; 

			// End for Events
		}	

		if($category['showThumbNail'])
			$listingsQuery .= "(Select FileName
			From listingimages 
			Where ListingID=L.ListingID
			Order By OrderNum, ListingImageID Limit 1) as FileNameForTN, ";

		if (isset($category['QID']))
			$listingsQuery .=	" CQL.LineID as QLineID, ";
		// else
		// 	$listingsQuery .= " 1 as QLineID, ";
		
//
		$listingsQuery .= "CASE WHEN L.UserID = " . PHONE_ONLY_USER . " THEN 1 ELSE 0 END as PhoneOnlyListing_fl
		From parentsectionsview PS";

		if($category['SectionID']==4 or $category['SectionID']==59  )
			$listingsQuery .= " Inner Join sections S  on PS.ParentSectionID=S.SectionID ";

		else
			$listingsQuery .= " Inner Join sections S  on PS.ParentSectionID=S.ParentSectionID ";
			
		$listingsQuery .="	
		Inner Join categories C  on S.SectionID=C.SectionID
		Inner Join listingcategories LC  on C.CategoryID=LC.CategoryID
		Inner Join listingsview L  on LC.ListingID=L.ListingID ";

	
		$listingsQuery .= "Left Outer Join makes M  on L.MakeID=M.MakeID

		Left Outer Join transmissions T  on L.TransmissionID=T.TransmissionID
		Left outer Join terms Te  on L.TermID=Te.TermID
		 Where S.Active=1";
		if (isset($category['ParentSectionID']) and $category['ParentSectionID'] == '8' and isset($category['JETID']))
		{

			$listingsQuery .= " and L.ListingTypeID in (10,12)";	
		}	
		
		else

		{
			 $listingsQuery .= " and (L.ListingTypeID IN (1,2,14,15) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' ))";
		}

		if(isset($category['ParentSectionID']) and !in_array($category['ParentSectionID'], array(1,21,32))  )
			$listingsQuery .= " and S.ParentSectionID = " . $category['ParentSectionID'] ;

		elseif (isset($category['SectionID']) and !in_array($category['ParentSectionID'], array(1,21,32))) {
			
			$listingsQuery .= " and S.SectionID = " . $category['SectionID'] ;
		}
			
		
		elseif(isset($category['CategoryIDs']))
			$listingsQuery .= " and C.CategoryID in ('" . $category['CategoryIDs'] . "')";


		if ( isset($category['InJobSectionOverview']))
			$listingsQuery .= " and LC.CategoryID = (Select CategoryID From listingcategories  where ListingID=L.ListingID Limit 1)";
		
		if(isset($category['catID']))
			$listingsQuery .= " and C.CategoryID = " . $category['catID'];

		if($this->input->get(NULL, TRUE))
		{
			foreach($this->input->get(NULL, TRUE) as $parameter=>$value)
			{
				switch ($parameter) {
					case 'CategoryID':
						if($value)
							$listingsQuery .= " AND C.CategoryID = " . $value;
						break;


					case 'MinDateRange':
						if($value)
						{
							if(!$this->input->get('MaxDateRange'))
								$listingsQuery .= " and exists (Select ListingID from listingeventdays LD  Where L.ListingID=LD.ListingID and LD.ListingEventDate >= '" . date('Y-m-d',strtotime($this->input->get('MinDateRange'))) . "')";
							else
							{
								if($this->input->get('MaxDateRange') == $this->input->get('MinDateRange'))
								{
									$listingsQuery .= " and exists (Select ListingID from listingeventdays LD  Where L.ListingID=LD.ListingID and LD.ListingEventDate = '" . date('Y-m-d',strtotime($this->input->get('MinDateRange'))) . "')";
								}
								else
								{
									$listingsQuery .= " and exists (Select ListingID from listingeventdays LD Where L.ListingID=LD.ListingID and LD.ListingEventDate >= '" . date('Y-m-d',strtotime($this->input->get('MinDateRange'))) . "' and LD.ListingEventDate <= '" . date('Y-m-d',strtotime($this->input->get('MaxDateRange'))) . "')";
								}
							}
						}

						break;


					case 'MaxDateRange':
						if($value)
						{
							if($this->input->get('MinDateRange')) {}
								// $listingsQuery .= " AND L.EventStartDate BETWEEN '" . date('Y-m-d',strtotime($this->input->get('MinDateRange'))) . "' AND '" . date('Y-m-d',strtotime($this->input->get('MaxDateRange'))) . "' ";

							else
								$listingsQuery .= " and exists (Select ListingID from listingeventdays LD  Where L.ListingID=LD.ListingID and LD.ListingEventDate <= '" . date('Y-m-d',strtotime($this->input->get('MaxDateRange'))) . "')";
						}
					
						break;


					case 'MinPrice':
						if($value)
						{
							if($this->input->get('Currency'))
							{	
								$Currency = 'Price'.$this->input->get('Currency');
								$listingsQuery .= " AND L." . $Currency . " >= " . $value ;
							}
						}
						break;

					case 'MaxPrice':
						if($value)
						{
							if($this->input->get('Currency'))
							{	
								$Currency = 'Price'.$this->input->get('Currency');
								$listingsQuery .= " AND L." . $Currency . " <= " . $value ;
							}
						}

						break;

					case 'Baths':
						if($value)
						{
							$listingsQuery .= " AND L.Bathrooms >= " . $value;
						}
						break;					

					case 'Beds':
						if($value)
						{
							$listingsQuery .= " AND L.Bedrooms >= " . $value;
						}
						break;

					case 'MinRent':
						if($value)
						{
							if($this->input->get('Currency'))
							{	
								$Currency = 'Rent'.$this->input->get('Currency');
								$Term = $this->input->get('TermID');
								$listingsQuery .= " AND L." . $Currency . " >= " . $value ;
								$listingsQuery .= " AND L.TermID = " . $Term;
							}
						}
						break;

					case 'MaxRent':
						if($value)
						{
							if($this->input->get('Currency'))
							{	
								$Currency = 'Rent'.$this->input->get('Currency');
								$Term = $this->input->get('TermID');
								$listingsQuery .= " AND L." . $Currency . " <= " . $value ;
								$listingsQuery .= " AND L.TermID = " . $Term;
							}
						}
						break;

					case 'AmenityID':
						if($value)
						{
							
							$AmenitiesString = '' 	;
							// print_r($value);
							foreach ($value as $Amenity) {
								$AmenitiesString .= "'" . $Amenity . "',";
							}

							$AmenitiesString = substr($AmenitiesString, 0,-1);

							$listingsQuery .= " AND EXISTS (Select ListingID from listingamenities where AmenityID in(" . $AmenitiesString . "))";
						}
						break;

					case 'MakeID':
						if($value)
						{
							$listingsQuery .= " AND L.MakeID = " . $value;
						}
						break;					

					case 'TransmissionID':
						if($value)
						{
							$listingsQuery .= " AND L.TransmissionID = " . $value;
						}
						break;				


					case 'FourWheelDrive':
						if($value)
						{
							$listingsQuery .= " AND L.FourWheelDrive = 1 ";
						}
						break;	

					case 'Kilometers':
						if($value)
						{
							$listingsQuery .= " AND L.Kilometers <= " . $value;
						}
						break;	



					default:
						# code...
						break;
				}
			}
		}

		$listingsQuery .= "
		and L.Active=1

		and L.Reviewed=1 

		and L.DeletedAfterSubmitted=0 

		and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "')

		AND (L.ListingTypeID <> 15
			OR EXISTS (SELECT ListingID FROM listingeventdays  WHERE ListingID=L.ListingID ";

		$listingsQuery .= " AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "'))";

		//Job listings can have multiple categories, so limit to one category so the listing does not appear mulitple times on the Section Overview page.

			
		$listingsQuery .= ' Group By L.ListingID';
	

		switch ($category['SortBy']) {
			case 'Year':
				$listingsQuery .= " Order By C.OrderNum, L.VehicleYear desc, L.Title, L.DateSort desc";
				break;			

			case 'MakeModel':
				if($CategoryID == 84)
					$listingsQuery .= " Order By C.OrderNum, M.Title, L.Model, L.VehicleYear, L.Title, L.DateSort desc";
				else
					$listingsQuery .= " Order By C.OrderNum, L.Make, L.Model, L.VehicleYear, L.Title, L.DateSort desc";
				break;

			case 'MostRecent':
					$listingsQuery .= " Order By L.DateSort desc, C.OrderNum, M.Title, L.Model, L.VehicleYear, L.Title";
				break;

			case 'EventSort':
					// $listingsQuery .= " Order By EventSortDate,  L.DateSort desc, C.OrderNum, L.Title";
					$listingsQuery .= " Order By EventSortDate, EventRank, L.DateSort desc, C.OrderNum, L.Title";
				break;
			
			default:
				if($featured==1)
					$listingsQuery .= " Order By HasExpandedListing desc, RandOrderID";
				else
					$listingsQuery .= " Order By ListingTitle";

				break;
		}

		// $listings['total_count'] = 

		$this->load->library('pagination');

		$config['base_url'] = base_url() . $this->uri->segment(1) . '?';
		$config['total_rows'] = $this->db->query($listingsQuery)->num_rows();
		$config['per_page'] = LISTINGS_PER_PAGE;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'offset'; 
		$config['full_tag_open'] = '<div class="pagination pagination-mini"><ul>';
		$config['full_tag_close'] = '</div></ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] = '< Prev';		
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['next_link'] = 'Next >';
		$config['cur_tag_open'] = '<li class="active" ><a style = "font-weight: bold;" >';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last >>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = '<< First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;


		$this->pagination->initialize($config);

		if(!$this->input->get('offset'))
			$offset = 0;
		else
			$offset = $this->input->get('offset');

		if(isset($category['limit']))
			$listingsQuery .= " Limit " . $offset . ', ' . LISTINGS_PER_PAGE ;

		$listings= $this->db->query($listingsQuery);

		// echo $category['ParentSectionID'];
		// echo $category['SectionID'];
		 //echo $listingsQuery; 

		// echo $this->db->last_query();


		return $listings;
	}

	function getsinglelisting($ListingID,$SectionID=0)
	{

		//print_r($category);STRAIGHT_JOIN
		$listingsQuery = "Select  L.Deadline, L.ExpirationDate, L.ListingID, L.ListingTypeID, L.ListingTitle, L.ShortDescr, L.DateListed, L.PriceUS, L.PriceTZS,
		L.RentUS, L.RentTZS, L.Bedrooms, L.Bathrooms, L.AmenityOther, L.LocationOther, L.LocationText,
		L.LongDescr, L.MakeID, L.DateSort, L.SquareFeet, L.MovieFees, L.SquareMeters,
		L.Make as MakeOther, L.Model as ModelOther, L.VehicleYear, L.Kilometers, L.FourWheelDrive,
		L.Deadline, L.WebsiteURL, L.PublicPhone,  L.PublicPhone2,  L.PublicPhone3,  L.PublicPhone4, L.PublicEmail, L.URLSafeTitle as ListingURL, 
		L.EventStartDate, L.EventEndDate, L.RecurrenceID, ( Select Descr from recurrencemonths where RecurrenceMonthID = L.RecurrenceMonthID) MonthlyRepeat, 
		L.ExpandedListingHTML, L.ExpandedListingPDF,
		L.CuisineOther, L.AccountName, L.UploadedDoc, L.Instructions,";
		


		$listingsQuery .= " CASE WHEN L.ListingTypeID <> 9 or L.ListingTypeID is null THEN (SELECT GROUP_CONCAT(Title Order BY OrderNum SEPARATOR ', ') From listinglocations LL Inner Join locations LOC on LL.LocationID = LOC.LocationID where L.ListingID = LL.ListingID and LL.LocationID <> 4) END as Location, ";

		// if($SectionID== 59 )
		// 	$listingsQuery .= "(SELECT GROUP_CONCAT(Descr Order BY OrderNum  SEPARATOR ', ') from listingrecurrences inner join recurrencedays on recurrencedays.RecurrenceDayID = listingrecurrences.RecurrenceDayID where ListingID = L.ListingID  group by ListingID) as RecurrenceDays, ";

	
			$listingsQuery .= " CASE WHEN S.SectionID=59 THEN(SELECT GROUP_CONCAT(Descr Order BY OrderNum  SEPARATOR ', ') from listingrecurrences inner join recurrencedays on recurrencedays.RecurrenceDayID = listingrecurrences.RecurrenceDayID where ListingID = L.ListingID  group by ListingID) END as RecurrenceDays, ";

		$listingsQuery .="

		CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing,
		L.SquareFeet, L.SquareMeters,
		L.LogoImage, L.ELPTypeThumbnailImage, L.ELPThumbnailFromDoc,
		PS.ParentSectionID, PS.Title as ParentSection, PS.URLSafeTitleDashed as ParentSectionURLSafeTitle,
		S.SectionID, S.Title as SubSection,
		C.CategoryID, C.Title as Category, 
		M.Title as Make, T.Title as Transmission,
		Te.Title as Term, RAND() as RandOrderID, ";

		/*For Events*/


		$listingsQuery .= " CASE WHEN S.SectionID = 59 AND (Select Min(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "'" ;

		 // <!--- Multipday event already in progress, so set event sort date to event's end date --->
		$listingsQuery .= " THEN (Select Max(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) ";
		
		 // <!--- All others use Event's Start Date --->
		$listingsQuery .= " ELSE (Select Min(ListingEventDate) From listingeventdays Where ListingID=L.ListingID) ";
		$listingsQuery .= " END as EventSortDate, ";

		// <!--- Non Repeating Single day --->
		$listingsQuery .= "	CASE WHEN S.SectionID = 59 AND RecurrenceID is NULL and (EventEndDate is null or cast(EventStartDate as char) = cast(EventEndDate as char)) THEN 1 ";

		// <!--- Multiday events that have already started --->
		$listingsQuery .= " WHEN RecurrenceID is NULL and (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '". CURRENT_DATE_IN_TZ  . "' THEN 6 ";

		// <!--- Multiday events that have not started --->
		$listingsQuery .= " WHEN RecurrenceID is null THEN 5 "; 

		// <!--- Monthly Repeating --->
		$listingsQuery .= " WHEN RecurrenceID=3 THEN 2 "; 

		// <!--- Bi weekly Repeating --->
		$listingsQuery .= " WHEN RecurrenceID=2 THEN 3 ";

		// <!--- Weekly Repeating --->
		$listingsQuery .= "	WHEN RecurrenceID=1 THEN 4 "; 

		// <!--- Yearly Repeating --->
		$listingsQuery .= " ELSE 10 END as EventRank, "; 

		// End for Events


		
		// else
		// 	$listingsQuery .= " 1 as QLineID, ";
		
//
		$listingsQuery .= "CASE WHEN L.UserID = " . PHONE_ONLY_USER . " THEN 1 ELSE 0 END as PhoneOnlyListing_fl,
		(Select GROUP_CONCAT(FileName SEPARATOR ',')
		 	From listingimages 
			Where ListingID=L.ListingID
		 	Order By OrderNum, ListingImageID) as ListingImages, 
		(Select GROUP_CONCAT(Title SEPARATOR ', ')
			From listingamenities la inner join amenities a on la.AmenityID = a.AmenityID 
			where la.ListingID = L.ListingID
			) as Amenities 
		From parentsectionsview PS";

		if($SectionID==1)
			$listingsQuery .= " Inner Join sections S  on PS.ParentSectionID=S.SectionID ";

		else
			$listingsQuery .= " Inner Join sections S  on PS.ParentSectionID=S.ParentSectionID ";
			
		$listingsQuery .="	
		Inner Join categories C  on S.SectionID=C.SectionID
		Inner Join listingcategories LC  on C.CategoryID=LC.CategoryID
		Inner Join listingsview L  on LC.ListingID=L.ListingID ";

		// Left Outer Join listinglocations LL on L.ListingID = LL.ListingID and LL.LocationID <> 4
		// Inner Join locations LOC on LL.LocationID = LOC.LocationID
	
		$listingsQuery .= "Left Outer Join makes M  on L.MakeID=M.MakeID
		Left Outer Join transmissions T  on L.TransmissionID=T.TransmissionID
		Left outer Join terms Te  on L.TermID=Te.TermID
		 Where S.Active=1";

		$listingsQuery .= "
		and L.Active=1

		and L.Reviewed=1 

		and L.DeletedAfterSubmitted=0 

		and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "')

		AND (L.ListingTypeID <> 15
			OR EXISTS (SELECT ListingID FROM listingeventdays  WHERE ListingID=L.ListingID ";

		$listingsQuery .= " AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "'))";

		$listingsQuery .= " AND L.ListingID = $ListingID";

		//Job listings can have multiple categories, so limit to one category so the listing does not appear mulitple times on the Section Overview page.

			
		$listingsQuery .= ' Group By L.ListingID';
	

		


		 // echo $listingsQuery;

		$listing= $this->db->query($listingsQuery);


		return $listing;
	}

	function getQueryBusinesses($featured=0)
	{
				//print_r($category);STRAIGHT_JOIN
		$listingsQuery = "Select  L.ListingID, L.ListingTypeID, L.ListingTitle, "

		$listingsQuery .=" CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing, L.LogoImage, RAND() as RandOrderID, ";

		$listingsQuery .= " CASE WHEN L.ListingTypeID <> 9 or L.ListingTypeID is null THEN (SELECT GROUP_CONCAT(Title Order BY OrderNum SEPARATOR ', ') From listinglocations LL Inner Join locations LOC on LL.LocationID = LOC.LocationID where L.ListingID = LL.ListingID ";

		if($this->input->get("LocationID"))	
			$listingsQuery .= " AND LL.LocationID IN (" . str_replace('-', ',', $this->input->get("LocationID"))  .")";
						

		$listingsQuery .=") END as Location, ";
	
		$listingsQuery .= "CASE WHEN L.UserID = " . PHONE_ONLY_USER . " THEN 1 ELSE 0 END as PhoneOnlyListing_fl "
	
			
		$listingsQuery .="	
		From categories C 
		Inner Join listingcategories LC  on C.CategoryID=LC.CategoryID
		Inner Join listingsview L  on LC.ListingID=L.ListingID ";
	

		if($this->input->get('CategoryID', TRUE))
			$listingsQuery .= " WHERE C.CategoryID = " . $this->input->get('CategoryID', TRUE);


		$listingsQuery .= "
		and L.Active=1

		and L.Reviewed=1 

		and L.DeletedAfterSubmitted=0 

		and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "')" ; 

		//Job listings can have multiple categories, so limit to one category so the listing does not appear mulitple times on the Section Overview page.

			
		$listingsQuery .= ' Group By L.ListingID';
	
		if($featured==1)
			$listingsQuery .= " Order By HasExpandedListing desc, RandOrderID";
		else
			$listingsQuery .= " Order By ListingTitle";

		$listings= $this->db->query($listingsQuery);


		return $listings;
	}


	function gethints($ParentSectionID=0, $SectionID=0,$CategoryID=0)
	{
		//Getting Page Text




		if($CategoryID != 0)
		{

			$pageText = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=1
			and exists (Select HintID From hintcategories Where CategoryID = $CategoryID and HintID=H.HintID)
			Order by Rand() Limit 1";

			$hints['pageTextObj'] = $this->db->query($pageText);

		}

		if((isset($SectionID) and $SectionID !=0 and $CategoryID == 0) or (isset($hints['pageTextObj']) and $hints['pageTextObj']->num_rows() == 0) and isset($SectionID) )
		{

			$pageText = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=1
			and exists (Select HintID From hintsections Where SectionID = $SectionID and HintID=H.HintID)
			Order by Rand() Limit 1";

			$hints['pageTextObj'] = $this->db->query($pageText);
		}

		if(($ParentSectionID != 0 and $SectionID ==0 and $CategoryID == 0) or (isset($hints['pageTextObj']) and $hints['pageTextObj']->num_rows() == 0))
		{

			$pageText = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=1
			and exists (Select HintID From hintparentsections Where ParentSectionID = $ParentSectionID and HintID=H.HintID)
			Order by Rand() Limit 1";

			$hints['pageTextObj'] = $this->db->query($pageText);
		}

		if($CategoryID != 0)
		{

			$youMayAlsoLike = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=2
			and exists (Select HintID From hintcategories Where CategoryID = $CategoryID and HintID=H.HintID)
			Order by Rand() Limit 3";

			$hints['youMayAlsoLikeObj'] = $this->db->query($youMayAlsoLike);

		}

		if((isset($SectionID) and $SectionID !=0 and $CategoryID == 0) or (isset($hints['youMayAlsoLikeObj']) and $hints['youMayAlsoLikeObj']->num_rows() == 0 ) and isset($SectionID))
		{

			$youMayAlsoLike = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=2
			and exists (Select HintID From hintsections Where SectionID = $SectionID and HintID=H.HintID)
			Order by Rand() Limit 3";

			$hints['youMayAlsoLikeObj'] = $this->db->query($youMayAlsoLike);
		}

		if(($ParentSectionID != 0 and $SectionID ==0 and $CategoryID == 0) or (isset($hints['youMayAlsoLikeObj']) and $hints['youMayAlsoLikeObj']->num_rows() == 0))
		{

			$youMayAlsoLike = "Select H.HintID, H.Descr
			From hints H
			Where H.Active=1
			and H.HintTypeID=2
			and exists (Select HintID From hintparentsections Where ParentSectionID = $ParentSectionID and HintID=H.HintID)
			Order by Rand() Limit 3";

			$hints['youMayAlsoLikeObj'] = $this->db->query($youMayAlsoLike);
		}
		



		return $hints;

	}

	function determiner($pageURL)
	{
		$this->db->where_in('ListingTypeID', array(1,2,20,14));
		$this->db->where('Active',1);
		$this->db->where('Reviewed',1);
		$this->db->where('DeletedAfterSubmitted',0);
		$this->db->where('upper(URLSafeTitle)', strtoupper(str_replace("-", "", $pageURL)), true);
		$listing=$this->db->get('listingsview');
			// echo $this->db->last_query();


		if ($listing->num_rows() > 0)
		{

			$ListingQuery = "
			Select STRAIGHT_JOIN L.ListingID, L.ListingTypeID, L.ListingTitle, L.ShortDescr, L.DateListed, L.LocationOther, L.LocationText,
			L.LongDescr,  
			
			L.Deadline, L.WebsiteURL, L.PublicPhone,  L.PublicPhone2,  L.PublicPhone3,  L.PublicPhone4, L.PublicEmail, L.URLSafeTitle as ListingURL, 
			
			L.ExpandedListingHTML, L.ExpandedListingPDF,
			 L.AccountName,
			GROUP_CONCAT(LOC.Title SEPARATOR ', ') Location,
			CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing,
			CASE WHEN L.UserID = " . PHONE_ONLY_USER . " THEN 1 ELSE 0 END as PhoneOnlyListing_fl,
			L.LogoImage, L.ELPTypeThumbnailImage, L.ELPThumbnailFromDoc,
			PS.ParentSectionID, PS.Title as ParentSection, PS.URLSafeTitleDashed as ParentSectionURLSafeTitle,
			S.SectionID, S.Title as SubSection,
			C.CategoryID, C.Title as Category, 
			(Select FileName
		 	From listingimages 
			Where ListingID=L.ListingID
		 	Order By OrderNum, ListingImageID Limit 1) as FileNameForTN
			From parentsectionsview PS 
			Inner Join sections S  on PS.ParentSectionID=S.ParentSectionID	
			Inner Join categories C  on S.SectionID=C.SectionID
			Inner Join listingcategories LC  on C.CategoryID=LC.CategoryID
			Inner Join listingsview L  on LC.ListingID=L.ListingID

			Left Outer Join listinglocations LL on L.ListingID = LL.ListingID and LL.LocationID <> 4
			Inner Join locations LOC on LL.LocationID = LOC.LocationID

			Where S.Active=1

			and L.Active=1

			and L.Reviewed=1 

			and L.DeletedAfterSubmitted=0 

			and (L.ListingTypeID IN (1) or (L.ExpirationDate >= '" . CURRENT_DATE_IN_TZ . "' ))

			and (L.Deadline is null or L.Deadline >= '" . CURRENT_DATE_IN_TZ . "')

			and L.ListingID = " . $listing->row()->ListingID;

			$row=$this->db->query($ListingQuery);

			// echo $this->db->last_query();
			// echo $row->num_rows();

			return $row;

		}

		else
		{
			$this->db->where('upper(URLSafeTitleDashed)', strtoupper($pageURL), true);
			$section=$this->db->get('sections');


			if($section->num_rows() == 0)
			{
				$this->db->select('*, categories.URLSafeTitleDashed as catURL, sections.URLSafeTitleDashed as secURL');
				$this->db->where('upper(categories.URLSafeTitle)', strtoupper(str_replace("-", "", $pageURL)), true);
				$this->db->from('categories');
				$this->db->join('sections','categories.SectionID = sections.SectionID');
				$category=$this->db->get();



				if($category->num_rows() == 0)
				{

					$this->db->select('*, categories.ParentSectionID as ParentSectionID, categories.URLSafeTitleDashed as catURL, sections.URLSafeTitleDashed as secURL');
					$this->db->where('upper(categories.URLSafeTitle)', strtoupper(str_replace("-", "", $pageURL)), true);
					$this->db->from('categories');
					$this->db->join('sections','categories.ParentSectionID = sections.SectionID');
					$category=$this->db->get();

					if($category->num_rows() == 0)
					{					

						$this->db->select('*');
						$this->db->from('lh_pages_live');
						$this->db->where('MembersOnly', 0);
						$this->db->where('upper(lh_pages_live.Name)', strtoupper($pageURL), true);
						$this->db->join('lh_templates', 'lh_templates.TemplateID = lh_pages_live.TemplateID');

						$page = $this->db->get();

						return $page;
					}	

					else return $category;			
				}

				else return $category;
			}

			else return $section;
		}
	}

	function getFeaturedlistings($ParentSectionID)
	{
				$featuredBusinessQuery = "Select L.ListingID, L.ListingTitle, L.ShortDescr, L.Deadline,
		L.ELPTypeThumbnailImage, L.LogoImage, L.ELPThumbnailFromDoc
		From listingsview L inner join listingcategories LC on L.ListingID = LC.ListingID
		Where L.ListingTypeID  in (1,2,14)
		and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "'
		and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0 and LC.CategoryID IN (SELECT CategoryID FROM categories WHERE ParentSectionID = " . $ParentSectionID . ") 
		Order by L.FeaturedListing desc, L.DateSort desc Limit 5";

		return $this->db->query($featuredBusinessQuery);
	}

	function getRelatedEvents($eventcategories)
	{
		$relatedEventsQuery = "
			Select L.ListingID, L.ListingTitle, L.EventStartDate, L.RecurrenceID, L.RecurrenceMonthID,
		(Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) as StartDate, (Select Max(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) as EndDate,
		
		CASE WHEN (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "'
			THEN (Select Max(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) 
			ELSE (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) 
			END as EventSortDate,	
		CASE WHEN RecurrenceID is NULL and (EventEndDate is null or cast(EventStartDate as char) = cast(EventEndDate as char)) THEN 1
			WHEN RecurrenceID is NULL and (Select Min(ListingEventDate) From listingeventdays  Where ListingID=L.ListingID) <= '" . CURRENT_DATE_IN_TZ . "' THEN 6 
			WHEN RecurrenceID is null THEN 5 
			WHEN RecurrenceID=3 THEN 2 
			WHEN RecurrenceID=2 THEN 3 
			WHEN RecurrenceID=1 THEN 4 
			ELSE 10 END as EventRank,
		
		CASE WHEN L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' Then 1 Else 0 END as HasExpandedListing,
		L.ELPTypeThumbnailImage, L.ExpandedListingPDF		
		From listingsview L inner join listingcategories LC on L.ListingID = LC.ListingID
		Where (
				EXISTS (SELECT ListingID FROM listingeventdays  WHERE ListingID=L.ListingID AND ListingEventDate >= '" . CURRENT_DATE_IN_TZ . "')
				
					)
			
		and (RecurrenceID  in (3,4) or RecurrenceID is null)
		and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "'
		and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0 and LC.CategoryID IN (". $eventcategories .")
		Order By EventSortDate, EventRank,  L.ListingTitle";

		return $this->db->query($relatedEventsQuery);
	}

	function getMovieTheater($ListingID)
	{
		$query = "Select LM.ListingMovieID, LM.Title as MovieTitle, LM.Starring, LM.NowPlayingID, 
						LM.DailyShowTimes, LM.OtherShowTimes, LM.Saturdays, LM.Sundays, LM.Holidays,
						LM.DirectedBy, LM.Descr, LM.OfficialURL, LM.YahooURL, LM.IMDBURL, 
						LM.MovieImage, LM.OrderNum
						From ListingMovies LM
						Where LM.ListingID= $ListingID
						Order By LM.NowPlayingID, LM.OrderNum";

		return $this->db->query($query);
	//	echo $this->db->last_query();


	}

	function getTravelSpecials()
	{
		    $travelSpecialQuery = "Select L.ListingID, L.ListingTitle, L.ShortDescr, L.Deadline,
            L.ELPTypeThumbnailImage, L.LogoImage, L.ELPThumbnailFromDoc
            From listingsview L
            Where L.ListingTypeID  in (9)
            and L.PaymentStatusID in (2,3) and L.HasExpandedListing=1 and L.ExpirationDateELP >= '" . CURRENT_DATE_IN_TZ . "' and L.Deadline >= '" . CURRENT_DATE_IN_TZ . "' 
            and L.Active=1 and L.Reviewed=1 and L.DeletedAfterSubmitted=0 and L.Blacklist_fl = 0
            Order by L.FeaturedTravelListing desc, L.DateSort desc";

            return $this->db->query($travelSpecialQuery);
	}

	function getMessage($EmailID)
	{
		
		$this->db->where('AutoEmailID',$EmailID);
		$emailObj=$this->db->get('autoemails');
		
		return $emailObj->row();
		
	}


	function checkEmailForSpam($message)
	{
		$this->load->library('Defensio',array("api_key"=>DEFENSIOAPIKEY));
		$defensio = new Defensio(DEFENSIOAPIKEY);

		$document = array('type' => 'comment', 'content' => $message, 'platform' => 'zoomtanzania', 'client' => 'ZoomTanzania Website | 3.0 | WebMaster | info@zoomtanzania.com', 'async' => 'false');

		$post_result = $defensio->postDocument($document);

		return $post_result;


	}




}

/* End of file listingsModel.php */
/* Location: ./application/models/listingsModel.php */