<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<title>WW2 Website</title>
<meta http-equiv="description" content="page description" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">@import url(css/jquery.datatables_themeroller.css);</style>
<style type="text/css">@import url(css/styles.css);</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>

	<SCRIPT LANGUAGE="JavaScript">
<!-- 

// Generated at http://www.csgnetwork.com/puhtmlwincodegen.html 
			function popUp(URL) {
						day = new Date();
						id = day.getTime();
						eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=1000,height=500,left = 470,top = 140');");
			}

// -->
		</script>
<script>
$(function() {
    $('#location').dataTable( {
	  "oLanguage": {
            "sZeroRecords": "There are no records that match your search criterion",
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)"
        }, 
		"aaSorting": [],
		"sDom": '<"H"lr>t<"F"ip>',
		 bjQueryUI: true,
	  sPaginationType: "full_numbers"
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { type: "text" },
				     { type: "text" },
						null,
						null,
				]});
});
</script>
</head>

<body>
<div>

<div class = 'header'>
	<?php
		include ("includes/navigation.php");
		include ("includes/header.php");

		if ($UnitSelected=="" || $DateSelected=="" || $SubCampaignSelected=="")
			{
				if ($UnitSelected=="")
					{
						$errormsg = "Please Select a Unit first";                    
					}
				else if ($DateSelected=="")
					{
						$errormsg = "Please Select a Date first";                    
					}
				else if ($SubCampaignSelected=="")
					{
						$errormsg = "Please Select a Sub Campaign first";
					}
				print "<h1>";
				print $errormsg;
				print "</h1>";
				die;
			}
	?>
</div>
	<div class = 'content'>
	<br><br>
    <h1> Detail of: <?php echo $UnitSelected;?></h1><br>


    <?php
//		$temp = include "includes/library.php";
		$host = "127.0.0.1";
		$user = "root";
		$pass = "nortonjuxta";
        $dbase = "w2db";

        $selected = mysqli_connect($host, $user, $pass, $dbase);
		if (mysqli_connect_errno()) 
			{
				printf("Connect failed: %s\n", mysqli_connect_error());
				die();
			}
// Display Selected Unit entry in Unit table
		$SQL = sprintf("Select unit.Unit_ID, `unit type`.`Unit Type`, unit.Unit, `force index`.`Force`, countries.Country_Name As Country,
		unit.`Start Date`, unit.`End Date`
		From unit Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
		Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
		Inner Join countries On unit.Country = countries.Country_ID
		WHERE unit.Unit='%s' ", $UnitSelected);
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
			{
//echo "debug001";
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//						echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
							{
//								echo "debug003";
								echo "<th>";
								echo $col;
								echo "</th>\n";
							}
					echo "</tr>";
				echo "</thead>\n";
				echo "<tbody>";
// Write rows
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = 0;
						foreach($row as $key => $value)
							{
								echo "<td>";
								$j++;
								switch ($j)
								{
									case 1:
										$unitid = $value;
										echo $value;
										break;
									case 2:
									case 3:
									case 4:
										echo $value;
										break;
									case 5:
										echo "<a href='country.php?country=$value'>$value</a>";
										break;
									default:		// date fields
										echo dt2dmy($value);
								}
								echo "</td>\n";
							}
						echo "</tr>\n";
					}
				echo "</tbody>\n";
			echo "</table>\n";
			}
// Unit not in database
		else {
			echo "<p class='centre'>Unit Not Found</p>";
			exit();
			}
		echo"<br>";
// Display unit description

echo "<div class=desc>";
		$SQL = sprintf("SELECT Description FROM unit WHERE Unit='%s' ", $UnitSelected);
				$result = mysqli_query($selected, $SQL);
				$db_field = mysqli_fetch_assoc($result);
				echo $db_field['Description'];
echo "</div>";
// Display status for selected unit from unitstatusb table
		echo "<h3 class ='centre'> Timeline </h3>";
		echo"<br>";
		$SQL = sprintf("SELECT unitstatusb.`Seq No`, status.Status, unit.Unit as `Unit changed`, unitstatusb.Comment,
		location.Location as `AT`, person.`Full Name` as `CO`, unit1.Unit, unitstatusb.`Start Date`, unitstatusb.`End Date`
		FROM unitstatusb LEFT JOIN status ON unitstatusb.status=status.StatusID
		LEFT JOIN unit on unitstatusb.`unit changed`=unit.Unit_ID
		Left Join location on unitstatusb.Location = location.LocID
		Left Join person on unitstatusb.CO = person.ID
		Left Join unit unit1 on unitstatusb.Higher = unit1.Unit_ID
		WHERE unitstatusb.Unit='%s' ORDER BY unitstatusb.`Seq No`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
			{
			echo "<table class = 'center'>\n";
				echo "<thead>\n";
					echo "<tr>";
//						echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
						{
//							echo "debug004";
							echo "<th>";
							echo $col;
							echo "</th>\n";
						}
					echo "</tr>\n";
				echo "</thead>\n";
				echo "<tbody>";
			// Write rows
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = 0;
						foreach($row as $key => $value)
						{
							echo "<td>";
							$j++;
							switch ($j)
							{
								case 1:
								case 2:
									echo $value;
									break;
								case 3:
								case 7:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
									break;
								case 4:
									echo $value;
									break;
								case 5:
									echo "<a href='location.php?locn=$value'>$value</a>";
									break;
								Case 6:
									echo "<a href='person.php?person=$value'>$value</a>";
									break;
								default:	// date fields
									if ($value) 
										{ echo dt2dmy($value);}
									else echo "";
							}

							echo "</td>\n";
						}
						echo "</tr>";
					}
				echo "</tbody>";

				echo "</table>\n";
			}
			else
// No status data found
			{ echo "<p class=centre>No Status Data Found</p>";}
		echo"<br>";
		echo "<h3 class ='centre'> Head(s) of $UnitSelected</h3>";

// Display COs for selected unit from unitco table
		echo"<br>";
		$SQL = sprintf("SELECT person.`Full Name`, unitco.Acting, unitco.Rank, unitco.Position, unitco.`Start Date`, unitco.`End Date` 
		FROM unitco LEFT JOIN person ON unitco.`Person ID` = person.ID
		WHERE unitco.`Unit ID`='%s' AND (unitco.`Rank Index` = 1 OR unitco.`Rank Index` = 5) ORDER BY unitco.`Start Date`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
		{
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//						echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
						{
//							echo "debug004";
							echo "<th>";
							echo $col;
							echo "</th>";
						}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			// Write rows
				mysqli_data_seek($result, 0);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					$j = 0;
					foreach($row as $key => $value)
					{
						echo "<td>";
						$j++;
						switch ($j)
							{
								case 1:
									echo "<a href='person.php?person=$value'>$value</a>";
									break;
								case 2:
									echo $value == 0 ? '' : 'Y';
									break;
								case 3:
								case 4:
									echo $value;
									break;
								default:	// date fields
								if ($value) 
									{ echo dt2dmy($value);}
								else {echo "";}
							}
						echo "</td>";
					}
					echo "</tr>";
				}
			echo "</tbody>";
		echo "</table>";
		}
		else
			{echo"<p class=centre>No Heads found</p>";}
		echo "<br>";
		echo "<h3 class = 'centre'> sources for Head </h3>";
		echo "<p class='centre'>To be added later</p>";
		echo"<br>";

		echo "<h3 class ='centre'> Members of $UnitSelected on $DateSelected</h3>";

		// Display all people for selected unit from unitco table
		$datesel = dt2ymd($DateSelected);
		echo"<br>";
		$SQL = sprintf("SELECT person.`Full Name`, rank.`Rank name`, unitco.Rank, unitco.Position, unitco.`Start Date`, unitco.`End Date`
		FROM unitco LEFT JOIN person ON unitco.`Person ID` = person.ID
		LEFT JOIN rank ON rank.RankID = unitco.`Rank Index`
		WHERE unitco.`Unit ID`='%s' AND unitco.`Start Date` <= '%s' and unitco.`End Date` >= '%s' 
		ORDER BY unitco.`Rank Index`", $unitid, $datesel,  $datesel);
		//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
		{
			echo "sql failed<br>";
			printf("Errormessage: %s\n", mysqli_error($selected));
			mysqli_close($selected);
			die();
		}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)
		{
			echo "<table class = 'center'>";
			echo "<thead>";
			echo "<tr>";
			//						echo "debug002";
			$row = mysqli_fetch_assoc($result);
			foreach ($row as $col => $value)
			{
				//							echo "debug004";
				echo "<th>";
				echo $col;
				echo "</th>";
			}
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			// Write rows
			mysqli_data_seek($result, 0);
			while ($row = mysqli_fetch_assoc($result))
			{
				echo "<tr>";
				$j = 0;
				foreach($row as $key => $value)
				{
					echo "<td>";
					$j++;
					switch ($j)
					{
						case 1:
							echo "<a href='person.php?person=$value'>$value</a>";
							break;
						case 2:
						case 3:
						case 4:
							echo $value;
							break;
						default:	// date fields
							if ($value) 
								{ echo dt2dmy($value);}
							else {echo "";}
					}

						echo "</td>";
				}
					echo "</tr>";
			}
				echo "</tbody>";
				echo "</table>";
		}
		else
			{echo"<p class=centre>No Members found</p>";}
			echo "<br>";
		
		// Display Locations for selected unit from unitlocn table
		echo "<h3 class ='centre'> Locations </h3>";
//		echo"<br>";
		$SQL = sprintf("SELECT location.Location, unit.Unit as Redesignated, unitlocn.`Start Date`, unitlocn.`End Date` 
		FROM unitlocn LEFT JOIN location ON unitlocn.`Location ID`=location.LocID
		LEFT JOIN unit on unitlocn.Redesignated=unit.Unit_ID
		WHERE unitlocn.`Unit ID`='%s' ORDER BY unitlocn.`Start Date`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		echo "rows = $row_cnt";
		if ($row_cnt <> 0)	
		{  
		echo "<div class = 'desc'>";	
			echo "<table id= 'location' class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//						echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
						{
//							echo "debug004";
							echo "<th>";
							echo $col;
							echo "</th>";
						}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			// Write rows
				mysqli_data_seek($result, 0);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					$j = 0;
					foreach($row as $key => $value)
						{
							echo "<td>";
							$j++;
							switch($j)
							{
							case 1:
								echo "<a href='location.php?locn=$value'>$value</a>";
								break;
							case 2:
								echo $value;
								break;
							default:	// date fields
								if ($value) 
									{ echo dt2dmy($value);}
								else echo "";
							}
							echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		echo "</div>";
		}
		else {echo "<p class=centre>No Locations found</p>";}
		echo "<br><br>";

		echo "<h3 class ='centre'> Superior Units </h3>";
		echo"<br>";
// Display Superior Units for selected unit from unithigh table

		$SQL = sprintf("SELECT unit.Unit, combatants.Combatant_Type AS 'Allegiance', unithigh.`Higher Type`, unithigh.`Start Date`, unithigh.`End Date`
		FROM unithigh LEFT JOIN unit ON unithigh.`Higher ID`=unit.Unit_ID
		LEFT JOIN combatants on unithigh.Allegiance=combatants.Combatant_ID
		WHERE unithigh.`Unit ID`='%s' ORDER BY unithigh.`Start Date`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)
		{
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//					echo "debug002";
			
					$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
							{
//								echo "debug004";
								echo "<th>";
								echo $col;
								echo "</th>";
							}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
// Write rows
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = 0;
						foreach($row as $key => $value)
							{
								echo "<td>";
								$j++;
								switch ($j)
								{
									case 1:
										echo "<a href='displayunit.php?unit=$value'>$value</a>";
										break;
									case 2:
									case 3:
										echo $value;
										break;
									default:	// date fields
										if ($value)
											{ echo dt2dmy($value); }
										else {echo "";}
								}
								echo "</td>";
							}
						echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		}
// no superiors found
		else {echo "<p class='centre'>None</p>";}
		echo"<br>";

		echo "<h3 class ='centre'> Subordinate Units on $DateSelected</h3>";
		echo"<br>";
// Display Subordinate Units for selected unit on Selected Date from unithigh table
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("SELECT unit.Unit, combatants.Combatant_Type AS 'Allegiance', unithigh.`Higher Type`, unithigh.`Start Date`, unithigh.`End Date`
		FROM unithigh LEFT JOIN unit ON unithigh.`Unit ID`=unit.Unit_ID
		LEFT JOIN combatants on unithigh.Allegiance=combatants.Combatant_ID
		WHERE unithigh.`Higher ID`='%s' and unithigh.`Start Date` <= '%s' and unithigh.`End Date` >= '%s' 
		ORDER BY unithigh.`Start Date`", $unitid, $datesel,  $datesel);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
		{
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//					echo "debug002";
					$row = mysqli_fetch_assoc($result);
					foreach ($row as $col => $value)
					{
//						echo "debug004";
						echo "<th>";
						echo $col;
						echo "</th>";
					}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			// Write rows
				mysqli_data_seek($result, 0);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					$j = 0;
					foreach($row as $key => $value)
						{
							echo "<td>";
							$j++;
							switch($j)
							{
								case 1:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
									break;
								case 2:
								case 3:
									echo $value;
									break;
								default:	// date fields
									if ($value) 
										{ echo dt2dmy($value); }
									else echo "";
							}
									echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		}
// No subordinates found
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
		echo "<h3 class ='centre'> Campaigns</h3>";
		echo"<br>";
// Display Campaigns for selected unit from unitcampaign table
		$SQL = sprintf("SELECT `keyword sub campaign list`.Sub_Campaign, combatants.Combatant_Type AS 'Allegiance', unitcampaign.`Senior Unit Flag` as Senior, unit.Unit, unitcampaign.`Start Date`, unitcampaign.`End Date` 
		FROM unitcampaign LEFT JOIN unit ON unitcampaign.`Higher Unit`=unit.Unit_ID
		LEFT JOIN combatants ON unitcampaign.Allegiance=combatants.Combatant_ID
		LEFT JOIN `keyword sub campaign list` ON unitcampaign.`Sub Campaign ID`=`keyword sub campaign list`.SubCampaignID
		WHERE unitcampaign.`Unit ID`='%s' ORDER BY unitcampaign.`Start Date`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
		{
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//					echo "debug002";
					$row = mysqli_fetch_assoc($result);
					foreach ($row as $col => $value)
					{
//						echo "debug004";
						echo "<th>";
						echo $col;
						echo "</th>";
					}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			// Write rows
				mysqli_data_seek($result, 0);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					$j = 0;
					foreach($row as $key => $value)
						{
							echo "<td>";
							$j++;
							switch($j)
							{
								case 1:
									 echo "<a href='displaycampaign.php?cmpgn=$value'>$value</a>";
									 break;
								case 2:
								case 3:
								case 4:
									{ echo $value;}
									break;
						// date fields
								default:
									{if ($value) 
										{ echo dt2dmy($value);}
									else echo "";}
							}
							echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		}
// No Campaigns found
		else {echo "<p class='centre'>None Found</p>";}
		echo"<br>";
		echo "<h3 class ='centre'> Equipment</h3>";
		echo"<br>";
// Display Equipment for selected unit from unitequp table
		$SQL = sprintf("SELECT equipment.Equipment, unit.Unit, unitequp.`Start Date`, unitequp.`End Date` 
		FROM unitequp LEFT JOIN equipment ON unitequp.`Equipment ID`=equipment.Equipment_ID
		LEFT JOIN unit ON unitequp.Manufacturer=unit.Unit_ID
		WHERE unitequp.`Unit ID`='%s' ORDER BY unitequp.`Start Date`", $unitid);
//		echo $SQL;
		$result="";
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
		{
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//					echo "debug002";
					$row = mysqli_fetch_assoc($result);
					foreach ($row as $col => $value)
					{
//						echo "debug004";
						echo "<th>";
						echo $col;
						echo "</th>";
					}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			// Write rows
				mysqli_data_seek($result, 0);
				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo "<tr>";
					$j = 0;
					foreach($row as $key => $value)
						{
							echo "<td>";
							$j++;
							switch ($j)
							{
								case 1:
									echo "<a href='equipment.php?equp=$value'>$value</a>";
									break;
								case 2:
									echo $value;
									break;
								default:	// date fields
									if ($value) 
										{ echo dt2dmy($value); }
									else echo "";
							}
							echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		}
// No Equipment found
		else {echo "<p class='centre'>None Found</p>";}		
		echo "<br>";
		echo "<h3 class = 'centre'> sources for equipment </h3>";
		echo "<p class='centre'>To be added later</p>";
		echo "<br>";
// Display Selected Unit events from indexlistunit and dateref tables

		echo "<h3 class ='centre'>Events on $DateSelected</h3>";
		echo"<br>";
		$SQL = sprintf("SELECT booklist.Book_No, memo.Comments, memo.`Level No`, dateref.Date AS 'From', dateref.End_Date AS 'To'
			FROM ((indexlistunit INNER JOIN dateref ON indexlistunit.`Sequence Num` = dateref.Entry_No) 
			INNER JOIN memo ON dateref.Memo_ID = memo.`Entry Number`) 
			INNER JOIN booklist ON dateref.Book_ID = booklist.Book_Index
			WHERE indexlistunit.`Unit ID`='%s' AND ('%s' BETWEEN dateref.Date AND dateref.End_Date) ORDER BY dateref.Date, memo.`Level No`",
			$unitid, $datesel);
//	echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No events for person
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug indexlistindividual";
			echo "<table class = 'center'>";
				echo "<thead>";
					echo "<tr>";
//						echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
							{
//								echo "debug003";
								echo "<th>";
								echo $col;
								echo "</th>";
							}
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
// Write row
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = 0;
						foreach($row as $key => $value)
							{
								echo "<td>";
								$j++;
								switch($j)
								{
									case 1:
										echo "<a href='book.php?book=$value'>$value</a>";
										break;
									case 2:
									case 3:
										echo $value;
										break;
									default: // date fields
										if ($value)
											{ echo dt2dmy($value); }
										else echo "";
								}
								echo "</td>";
							}
						echo "</tr>";
					}
				echo "</tbody>";
			echo "</table>";
			}
		echo"<br>";
	?>
</div>
	<p class=centre><Button type = 'button' onclick="javascript:popUp('calendar.php')">Change Date</button></p>
	<FORM class='centre'>
		<INPUT TYPE="button" onClick="history.go(0)" VALUE="Refresh">
	</FORM>
	
	<div class="temp">
    <pre>
        <strong> 1. Programming Notes</strong>
        
        <strong> 1.1 Load Pre-Conditions</strong>
            1.1.1 'Selected Unit' must be set.
            1.1.2 'Selected Date must be set.
            1.1.3 'SubCampaign' must be set (so that 'Start Date' and 'End Date' are valid).
            1.1.4 If any condition is not met then an appropriate error page is displayed instead of the proper page - continue by selecting another page.
            
        <strong> 1.2 Notes on design</strong>
            1.2.1 Display Unit info. - done
            1.2.2 Display all Unit status. - done
            1.2.3 Display all Unit COs - with dates and sources. - dates done - sources to follow
            1.2.4 Display all Unit locations - with dates and sources.  dates done - sources to follow
            1.2.5 Display all Unit superiors - with dates. - done
            1.2.6 Display Unit subordinates on selected date. - done
            1.2.7 Display all Unit campaigns - with dates. - done
            1.2.8 Display all Unit equipment - with dates and sources. - dates done - sources to follow
			1.2.9 Display all "Actions" (from status)
			1.2.10 Display all Events
            1.2.11 Can change 'Selected Date' within range Start Date to End Date - by calling the "CALENDAR" pop-up.
            1.2.12 The 'Selected Date' can be changed directly to Start Date or End Date.
        <strong>1.3 Exit conditions</strong>
            1.3.1 There are no Exit conditions - you can always exit.
            
	</pre>
	</div>
    
<!-- force a break-->
<br>
</div>
<!--<?php

include ("includes/header.html");

?>-->

</body>
</html>
