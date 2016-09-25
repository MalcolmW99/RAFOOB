<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<!doctype html>

 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>WW2 Website</title>
	<link rel="stylesheet" href="css/jquery-ui-1.10.2.custom.css" />
	<style type="text/css">@import url(css/jquery.datatables_themeroller.css);</style>
	<style type="text/css">@import url(css/styles.css);</style>	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>
	
<!--	<link rel="stylesheet" href="/resources/demos/style.css" /> -->
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
    $(function() {
    $( "#tabs-3" ).tabs();
  });
  </script>
<script>
$(function() {
    $('#govt').dataTable( {
			"bAutoWidth": false,
			 "aoColumnDefs": [
			{ "sWidth": "200px", "aTargets": [ 0,1,2,3,4,5 ] }
			],
			"bLengthChange": false,
			"iDisplayLength": 50,			
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
					{ type: "text" },
					null,
					null,
					null,
					null,
					null,
					null,
				]});
});
</script>
  	<script>
		$(document).ready(function(){
			$('#S_60IN').dataTable( {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 25,
			 "aoColumnDefs": [
			{ "sWidth": "200px", "aTargets": [ 0,1,2,3,4,5 ] }
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
   }).columnFilter({sPlaceHolder: "head:after",
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
					 { type: "text" },
					 { type: "number" },
					null,
					null
				]});
});

		$(document).ready(function(){
			$('#L_60IN').dataTable( {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 25,
			 "aoColumnDefs": [
			{ "sWidth": "200px", "aTargets": [ 0,1,2,3,4 ] }
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
   }).columnFilter({sPlaceHolder: "head:after",
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
					 { type: "text" },
					 { type: "number" },
					null,
					null
				]});
});

		$(document).ready(function(){
			$('#A_60IN').dataTable( {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 25,
			 "aoColumnDefs": [
			{ "sWidth": "200px", "aTargets": [ 0,1,2,3,4,5 ] }
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
   }).columnFilter({sPlaceHolder: "head:after",
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
					 { type: "text" },
					 { type: "number" },
					null,
					null
				]});
});
	</script>

</head>
<body>

<!--	<h1>World War 2 Database</h1>-->
	<div class = 'header'>
	<?php
		include ("includes/sqllibrary.php");
		include ("includes/navigation.php");
		include ("includes/header.php");
?>
</div>
<div class = 'content'>
<br><br>

<?php		
		// Is an argument passed?
		if (isset($_GET['subdivn']))
		{ 	$subdivision = $_GET['subdivn'];}
		echo "<h3 class='centre'>Detail of Subdivision: $subdivision</h3>";

		// Database is opened in header.php

// Display Division entry in divisions table
		$SQL = sprintf("SELECT subdivisions.SubDivisionID, description.Description
		FROM subdivisions Inner Join description ON subdivisions.DescriptionID = description.`description ID`
		WHERE subdivisions.`Sub Division Name`='%s' ", $subdivision );
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
// No such sub division
			{echo "<p class='centre'>Subdivision Not Found</p>";
			exit();}
		if ($row_cnt > 1)
// at least two Divisions with same name
			{echo "<p class='centre'>ERROR: $row_cnt Subdivisions Found</p>";}
		if ($row_cnt == 1)
// one Division found
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
								if ($j == 1)  // get subdivision ID
									{ $subdivisionid = $value; }
								else // only two fields....display subdivision Description
									{if ($value == "")
										{ $value = "TEMP $subdivision Description";}
									 echo "<div class = 'desc'>$value</div>";}
							}
					}
	echo "DEBUG:::Subdivision ID is: $subdivisionid";

		}
// Display Sub Division's position in world
		echo"<br>";
		$SQL = sprintf("Select subdivisions.`Sub Division Name` As `Sub Division`, divisions.Division_Name As Division, countries.Country_Name As Country,
		theatre.Theatre, subcontinent.`Sub Continent`, continent.Continent
		From continent Inner Join subcontinent On subcontinent.Continent = continent.Continent_ID
		Inner Join theatre On theatre.`Sub Continent` = subcontinent.Sub_Continent_ID
		Inner Join countries On countries.Theatre = theatre.TheatreID
		Inner Join divisions On divisions.Country = countries.Country_ID
		Inner Join subdivisions On subdivisions.Division = divisions.Division_ID
		WHERE subdivisions.SubDivisionID='%s'", $subdivisionid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Subdivision sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such subdivision
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug sub divisions";
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
											echo "<a href='division.php?divn=$value'>$value</a>";
											break;
										case 3:
											echo "<a href='country.php?country=$value'>$value</a>";
											break;
										case 4:
											echo "<a href='theatre.php?theatre=$value'>$value</a>";
											break;
										case 5:
											echo "<a href='subcontinent.php?subcont=$value'>$value</a>";
											break;
										case 6:
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

?>
		This is the <B>Sub Divisions</B> page <br><br>
 
<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Geographical</a></li>
			<li><a href="#tabs-2">Political</a></li>
			<li><a href="#tabs-3">Military</a></li>
		</ul>
	<div id="tabs-1">
    
		<h3 class='centre'>Geographical</h3>

	<?php
		echo "<p class='centre'> $subdivision contains the following locations.</p>";
		echo"<br>";

// Show Sub Divisions
		$SQL = sprintf("Select location.`Location`, `location type`.`Location Type`
		From location Inner Join description ON location.DescriptionID = description.`description ID`
		INNER JOIN `location type` On description.`LocationType` = `location type`.LocationTypeID
		Where location.`Sub Division` = '%s' ORDER BY location.`Location`", $subdivisionid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Sub Division sql failed<br>";
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
							echo "<td text-align: left>";
							$j++;
							switch($j)
							{
								case 1: //Location Name
									echo "<a href='location.php?locn=$value'>$value</a>";
									break;
								case 2:  // Location Type
									echo $value;
									break;
							}
							echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		}
		
// No Locations found!!!
		else {echo "<p class='centre'>No Locations Found</p>";}			
		echo"<br>";
	?>
  </div>
  <div id="tabs-2">

		<h3 class='centre'>Political</h3>
<?php		echo "<h4 class='centre'>Government in $subdivision on $DateSelected </h3>";
			echo "<p class='centre'> The following lists all the Government department in $subdivision on $DateSelected.</p>";

// Show Government Departments
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("Select unit.Unit, location.Location As At, countries.Country_Name AS 'From', person.`Full Name` AS Incumbent, `unit type`.`Level No`, 
		unitco.`Start Date` As `CO Start`, unitco.`End Date` As `CO End`, unit.`Start Date` As `Unit Start`, unit.`End Date` As `Unit End`, 
		unitlocn.`Start Date` As `Locn Start`, unitlocn.`End Date` As `Locn End`
		From location Inner Join unitlocn On unitlocn.`Location ID` = location.LocID
		Inner Join unit On unitlocn.`Unit ID` = unit.Unit_ID
		Inner Join unitco On unitco.`Unit ID` = unit.Unit_ID
		Inner Join person On unitco.`Person ID` = person.ID
		Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
		Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
		Inner Join countries ON unit.Country = countries.Country_ID
		WHERE location.`Sub Division` = '%s' And `force index`.Arm = 'P' And unitco.`Rank Index` = 1
		AND '%s' BETWEEN  unit.`Start Date` AND unit.`End Date`
		AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date`
		AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
		Order By `unit type`.`Level No`, countries.Country_Name, unit.Unit", $subdivisionid, $datesel, $datesel, $datesel );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Govt sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		echo "No of entries = $row_cnt";
		if ($row_cnt <> 0)	
		{
			echo "<table id = 'govt' class = 'center'>";
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
							echo "<td text-align: left>";
							$j++;
							switch($j)
							{
								case 1:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
									break;
								case 2:
									echo "<a href='location.php?locn=$value'>$value</a>";
									break;
								case 3:
									echo "<a href='country.php?country=$value'>$value</a>";
									break;
								case 4:
									echo "<a href='person.php?person=$value'>$value</a>";
									break;
								case 5:
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
// No Govt Found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";

?>
	</div>
	 <div id="tabs-3">
		<ul>
			<li><a href="#tabs-31">Navy</a></li>
			<li><a href="#tabs-32">Army</a></li>
			<li><a href="#tabs-33">Air Force</a></li>
		</ul>
		<div id=tabs-31>
		
		
			<?php 
// Show Naval units IN subdivision on Selected Date.
				echo "<h3 class='centre'>Naval Units IN $subdivision on $DateSelected</h3>"; 
				inarea("S", SUBDIVISION, $datesel, $subdivisionid, '20', $selected);
			?>
		</div>

		<div id=tabs-32>
			<?php 
// Show Army units IN Division
				echo "<h3 class='centre'>Army Units IN $subdivision on $DateSelected</h3>"; 
				inarea("L", SUBDIVISION, $datesel, $subdivisionid, '20', $selected);
			?>
		</div>

		<div id=tabs-33>
			<?php 
// Show Air Force units IN Division
				echo "<h3 class='centre'>Air Force Units in $subdivision on $DateSelected</h3>"; 
				inarea("A", SUBDIVISION, $datesel, $subdivisionid, '20', $selected);
			?>
		</div>

	</div>
			
</div>
</div> 
</body>
</html>