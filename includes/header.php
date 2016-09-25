<?php
// Constants for defining which type is to be used
const CONTINENT = 1;
const SUBCONTINENT = 2;
const THEATRE = 3;
const COUNTRY = 40;
const DIVISION = 50;
const SUBDIVISION = 60;
const LOCATION = 70;

//Function dt2dmy($arg_1)
//	{
//		$temp = strtotime($arg_1);
//		$return = date("d-M-Y",$temp);

//return $return;	
//	} 

//$host = "127.0.0.1";
//$user = "root";
//$pass = "nortonjuxta";
//$dbase = "ww2db";

//$conn = mysql_connect($host, $user, $pass) or die (mysqli_error());


$temp = include "library.php";
// Global $OOBCount;
Global $ErrorMsg;
Global $selected;
		$ErrorMsg = "This is an error message";
$selected = connectdb();

if ($selected)
	{
		$SQL = "SELECT * FROM sessionvars WHERE user = 'malcolm'";
		$result = mysqli_query($selected, $SQL);
//		print_r ($result);
	if(!$result)
		{
			print "Database NOT Found ";
			mysqli_close($selected);
			exit();
		}
	else
		{
			while ( $db_field = mysqli_fetch_assoc($result) ) 
			{
//convert date fields to d-M-y
				$dates = $db_field['CurrentDate'];
				if ($dates)
				{
					$DateSelected = dt2dmy($dates);
					$ErrorMsg=".";
				}
				else 
				{
					$DateSelected = "";
					$ErrorMsg = "Please Select a Subcampaign";
				}
	
//				$dates = $db_field['StartDate'];
//				$StartDate = dt2dmy($dates);

				$dates = dt2ymd($DateSelected);
//				$EndDate = dt2dmy($dates);
//get remaining fields
Global			$CountrySelected;
				$CountrySelected = $db_field['Country'];
Global			$Allegiance;
				$Allegiance = $db_field['Allegiance'];
Global			$ForceSelected;
				$ForceSelected = $db_field['Force'];
//				$FrontSelected = $db_field['Front'];
//				$CampaignSelected = $db_field['Campaign'];
Global			$SubCampaignSelected;
				$SubCampaignSelected = $db_field['SubCampaign'];
				if ($SubCampaignSelected=="")
				{	$SubCampaignSelected = "General Forces";
					$DateSelected = "01-Sep-1939";
					echo "SC: $SubCampaignSelected";
					echo "   $DateSelected";
				}
				
				
Global 			$UnitSelected;
// Is an argument passed?
				if (isset($_GET['unit']))
				{ 	$UnitSelected = $_GET['unit'];
					$SQL = sprintf("SELECT `unit`.`Unit`,`countries`.`Country_Name`,`combatants`.`Combatant_Type`,`country allegiance`.`Start_Date`,`country allegiance`.`End_Date` FROM unit
						LEFT JOIN `w2db`.`countries` ON `unit`.`Country` = `countries`.`Country_ID` 
						LEFT JOIN `w2db`.`country allegiance` ON `countries`.`Country_ID` = `country allegiance`.`Country_ID` 
						LEFT JOIN `w2db`.`combatants` ON `country allegiance`.`Allegiance` = `combatants`.`Combatant_ID`
						WHERE unit.Unit = '%s' AND '%s' BETWEEN `country allegiance`.`Start_Date` AND `country allegiance`.`End_Date`"
						, $UnitSelected, $dates);
//					echo $SQL;
					$countryresult = mysqli_query($selected, $SQL);
					if (!$countryresult)
					{	printf("Errormessage: %s\n", mysqli_error($selected));
						echo "No result returned"; }
					else
					{
						$row_cnt = mysqli_num_rows($countryresult);
//						echo "Rows: $row_cnt";
						$db_field = mysqli_fetch_assoc($countryresult);
						$CountrySelected = $db_field['Country_Name'];
//						echo "Country: $CountrySelected\n";
						$Allegiance = $db_field['Combatant_Type'];
//						echo "Allegiance: $Allegiance\n";
					}
					$updatesql = sprintf("UPDATE sessionvars SET sessionvars.Unit = '%s', sessionvars.Country = '%s', sessionvars.Allegiance = '%s'
					WHERE (((sessionvars.User)='malcolm'));", $UnitSelected, $CountrySelected, $Allegiance);
//	echo $updatesql;
					$updateresult = mysqli_query($selected, $updatesql);
					$forcesql = sprintf("SELECT `unit`.`Unit`,`force index`.`Force`,`force`.`Force` AS `Force Type`, `countries`.`Country_Name` FROM unit\n"
						. "LEFT JOIN `w2db`.`force index` ON `unit`.`Force` = `force index`.`Force ID` \n"
						. "LEFT JOIN `w2db`.`force` ON `force index`.`Force Type` = `force`.`Force ID`\n"
						. "LEFT JOIN `w2db`.`countries` ON `unit`.`Country` = `countries`.`Country_ID`\n"
						. "WHERE `unit`.`Unit` = '%s' ", $UnitSelected);
//	echo $forcesql;
					$forceresult = mysqli_query($selected, $forcesql);
					if (!$forceresult)
					{	printf("Errormessage: %s\n", mysqli_error($selected));
						echo "No result returned"; }
					else
					{
						$db_field = mysqli_fetch_assoc($forceresult);
						$ForceSelected = $db_field['Force Type'];
						$CountrySelected = $db_field['Country_Name'];
//						echo "Country: $CountrySelected";
						$updatesql = sprintf("UPDATE sessionvars SET sessionvars.Force = '%s', sessionvars.Country = '%s'
							WHERE (((sessionvars.User)='malcolm'));", $ForceSelected, $CountrySelected);
						$updateresult = mysqli_query($selected, $updatesql);}
				}
				else
				{	$UnitSelected = $db_field['Unit'];}
//				$ErrorMsg = "This is an error message";
			}
		}	
	$sqlfront = sprintf("SELECT keyword_campaign_list.`Campaign Keyword` AS Campaign, keywordfrontlist.Front, `keyword sub campaign list`.`Start Date`, `keyword sub campaign list`.`End Date`
		FROM (`keyword sub campaign list` INNER JOIN keyword_campaign_list ON `keyword sub campaign list`.CampaignID = keyword_campaign_list.Campaign_ID) 
		INNER JOIN keywordfrontlist ON keyword_campaign_list.`Front ID` = keywordfrontlist.FrontID
		WHERE `keyword sub campaign list`.Sub_Campaign = '%s'", $SubCampaignSelected);
//echo $sqlfront;
	$frontresult = mysqli_query($selected, $sqlfront);
		if (!$frontresult)
		{	echo"Subcampaign Not Found";
			exit();
		}
		else
// Update sessionvar fields
		{
			$db_field = mysqli_fetch_assoc($frontresult);
			$CampaignSelected = $db_field['Campaign'];
			$FrontSelected = $db_field['Front'];
			$dates = $db_field['Start Date'];
			$StartDate = dt2dmy($dates);
			$dates = $db_field['End Date'];
			$EndDate = dt2dmy($dates);
			if (!$DateSelected)
				{	$DateSelected = $StartDate; }
			elseif (dt2ymd($DateSelected) < dt2ymd($StartDate))
				{	$DateSelected = $StartDate; }
			elseif (dt2ymd($DateSelected) > dt2ymd($EndDate))
				{	$DateSelected = $EndDate; }
		}
	}
	else	// Database Open Error
		{
			echo "Could not open Database";
			die();
		}
	
?>


<table border="1" cellpadding="0" cellspacing="0" style="width: 100%; height: 100%" bgcolor=cyan>
       <tr>
         <td align="right" width="13%"> Date Selected:  </td>
           <td align="center" bgcolor="LightYellow" width="12%"><span id="datesel"	><?php echo$DateSelected?></span></td>
           <td align="center" width="13%"> Country Selected:  </td>
           <td id="country" align="center" bgcolor="LightYellow" width="12%"><?php echo$CountrySelected?></td>
           <td align="center" width="13%"> Allegiance:  </td>
           <td id="allegiance" align="center" bgcolor="LightYellow" width="12%"><?php echo$Allegiance?></td>
           <td align="center" width="13%"> Force Selected:  </td>
           <td id="force"align="center" bgcolor="LightYellow" width="12%"><?php echo$ForceSelected?></td>
       </tr>
       <tr>
           <td align="right"> Front:  </td>
           <td id="front" align="center" bgcolor="LightYellow"><?php echo$FrontSelected?></td>
           <td align="center"> Campaign:  </td>
           <td id="campaign" align="center" bgcolor="LightYellow"><?php echo$CampaignSelected?></td>
           <td align="center"> Sub Campaign:  </td>
           <td id="subcamp"align="center" bgcolor="LightYellow"><?php echo$SubCampaignSelected?></td>
           <td style="height: 26px" rowspan="3" colspan="2" align="center">Picture of the Day</td>
       </tr>
       <tr>
           <td align="right"> Start Date:  </td>
           <td align="center" bgcolor="LightYellow"><span id="sdate"><?php echo$StartDate?></span></td>
           <td align="center"> End Date:  </td>
           <td align="center" bgcolor="LightYellow"><span id="edate"><?php echo$EndDate?></span></td>
           <td align="center" width="100"> Unit Selected:  </td>
           <td id="unit" align="center" bgcolor="LightYellow"><?php echo$UnitSelected?></td>
       </tr>
       <tr>
           <td colspan="6" align="center" style="height: 10px; background-color: LightYellow; color: red"><?php echo$ErrorMsg?></td>

       </tr>
</table>

