<!DOCTYPE html >
<html>
	<head>
	<title>WW2 Website</title>
	<meta http-equiv="description" content="page description" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/jquery-ui-1.10.2.custom.css" />
<style type="text/css">@import url(css/jquery.datatables_themeroller.css);</style>
<style type="text/css">@import url(css/styles.css);</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>
<!--	<link rel="stylesheet" href="/resources/demos/style.css" />-->

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
		$(document).ready(function(){
			$('#unitlocn').dataTable(
 {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 25,			
			 "aoColumnDefs": [
			{ "sWidth": "150px", "aTargets": [ 0,1,2 ] }
			],	
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
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
					 { type: "text" },
					 { type: "number" },
					null,
					null,
				]});
});
</script>


	</head>

	<body>
<!--<h1>World War 2 Database</h1>-->
<div class = 'header'>
<?php
include "includes/navigation.php";
include ("includes/header.php");
?>
</div>
<div class = 'content'>
<br><br>

This is the <B>LOCATION</B> page <br><br>

<?php
// Is an argument passed?
	if (isset($_GET['locn']))
		{ $location = $_GET['locn']; }
	else
//
		{	echo "<h1> No Location Given</h1>";
			exit();
		}
	echo"<h1> Details of: $location</h1>";		

// Database is opened in header.php
//		$host = "127.0.0.1";
//		$user = "root";
//		$pass = "nortonjuxta";
//       $dbase = "ww2db";

//        $selected = mysqli_connect($host, $user, $pass, $dbase);
//		if (mysqli_connect_errno()) 
//			{
//				printf("Connect failed: %s\n", mysqli_connect_error());
//				die();
//			}
// Display Location entry in location table
		$SQL = sprintf("SELECT location.LocID, location.Description
		FROM location WHERE location.Location='%s' ", $location );
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
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such location
			{echo "<p class='centre'>Location Not Found</p>";
			exit();}
		if ($row_cnt > 1)
// at least two Locations with same name
			{echo "<p class='centre'>ERROR: $row_cnt Locations Found</p>";}
		if ($row_cnt == 1)
// one Location found
			{
//echo "debug001";
						$row = mysqli_fetch_assoc($result);
// Look at row
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						$j = 0;
						foreach($row as $key => $value)
							{
								$j++;
								if ($j == 1)  // get location ID
									{ $locationid = $value; }
								else // only two fields....display location Description
									{ echo "<p class = 'centre'>$value</p>";}
							}
					}
	echo "DEBUG:::Location ID is: $locationid";

		}
// Display Location's position in world
		echo"<br>";
		$SQL = sprintf("SELECT location.Location, subdivisions.`Sub Division Name`, divisions.Division_Name, countries.Country_Name, theatre.Theatre, subcontinent.`Sub Continent`, continent.Continent
		FROM (((((location INNER JOIN subdivisions ON location.`Sub Division` = subdivisions.SubDivisionID) 
		INNER JOIN divisions ON subdivisions.Division = divisions.Division_ID) 
		INNER JOIN countries ON divisions.Country = countries.Country_ID) 
		INNER JOIN theatre ON countries.Theatre = theatre.TheatreID) 
		INNER JOIN subcontinent ON theatre.`Sub Continent` = subcontinent.Sub_Continent_ID) 
		INNER JOIN continent ON subcontinent.Continent = continent.Continent_ID
		WHERE location.LocID='%s'", $locationid );
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
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such person
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug unitco";
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
// Write row - NO dates
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = 0;
						foreach($row as $key => $value)
							{
								$j++;
								echo "<td>";
									switch ($j)
									{
										case 1:
											echo $value;
											break;
										case 2:
											echo "<a href='subdivision.php?subdivn=$value'>$value</a>";
											break;
										case 3:
											echo "<a href='division.php?divn=$value'>$value</a>";
											break;
										case 4:
											echo "<a href='country.php?country=$value'>$value</a>";
											break;
										case 5:
											echo "<a href='theatre.php?theatre=$value'>$value</a>";
											break;
										case 6:
											echo "<a href='subcontinent.php?subcont=$value'>$value</a>";
											break;
										case 7:
											echo "<a href='continent.php?cont=$value'>$value</a>";
											break;
									}
								echo "</td>";
							}
						echo "</tr>";
					}
				echo "</tbody>";
			echo "</table>";
			}
		echo"<br>";
// 
		echo "<h3 class ='centre'>Units at $location on $DateSelected</h3>";
		echo"<br>";
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("SELECT unit.Unit, `unit type`.`Unit Type`, `force index`.Force, `unit type`.`Level No`, unitlocn.`Start Date` AS 'FROM', unitlocn.`End Date` AS 'TO'
		FROM ((unitlocn INNER JOIN unit ON unitlocn.`Unit ID` = unit.Unit_ID) 
		INNER JOIN `unit type` ON unit.`Unit Type` = `unit type`.`Unittype ID`) 
		INNER JOIN `force index` ON unit.Force = `force index`.`Force ID`
		WHERE ((unitlocn.`Location ID`)='%s' AND ('%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`))
		ORDER BY `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`", $locationid, $datesel );
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
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such person
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug unitco";
		echo"<div class = 'desc'>";
			echo "<table id='unitlocn' class = 'center'>";
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
								switch ($j)
								{
									case 1:
											echo "<a href='displayunit.php?unit=$value'>$value</a>";
											break;
									case 2:
									case 3:
									case 4:
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
		echo "</div>";
			}
		echo"<br>";
		$datesel = $DateSelected;
		echo"<p class='centre'> Change Selected Date from $datesel</p>";
		if ($datesel=="")
			{echo "<p class='centre'> Please Enter a valid Subcampaign first</p>";}
		else
			{echo "<p class=centre><Button type = 'button' onclick=\"javascript:popUp('calendar.php')\">Change Date</button></p>";}

?>

		<FORM class='centre'>
			<INPUT TYPE="button" onClick="history.go(0)" VALUE="Refresh">
		</FORM>

<pre class="temp">
    <h2> Programming Notes</h2>
     
     <h3>1.Load Pre-Conditions</h3>
              1.1 The Location (passed as a parameter) must exist.
			  1.2 The Selected Date must be set (for item 2.3) This implies that the Subcampaign must be set.
     <h3>2.Notes on design</h3>
     <ol>
          2.1 Display the location entry from the location table - if there are no entries then display error message and quit. - done
          2.2 Display details of location in world. - done
          2.3 Display the list of units at the location on the selected date withe their start and End Dates. - done 
          2.4 Add means of changing "Selected Date" between "Start Date" and "End Date". 
          2.5 
          2.6 
          </ol>

    <h3>3 Exit conditions</h3>
        3.1 There are no Exit conditions - you can always exit.
</pre>
</div>

<br>

<!--<?php

include ("includes/header.html");

?>-->

</body>
</html>


