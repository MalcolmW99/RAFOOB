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
<style type="text/css">@import url(css/styles.css);</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>
<!--	<link rel="stylesheet" href="/resources/demos/style.css" />-->
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
			"bLengthChange": false,
			"iDisplayLength": 25,
			 "aoColumnDefs": [
			{ "sWidth": "200px", "aTargets": [ 0,1,2,3 ] }
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
					 { type: "text" },
					null,
					null,
					null,
					null,

				]});
});
</script>
<script>
$(function() {
    $('#govt2').dataTable( {
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
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
					 { type: "text" },
					 { type: "text" },
					 { type: "text" },
					null,
					null,
					null,
					null,

				]});
});
</script>
<script>
$(function() {
    $('#geog').dataTable( {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 15,			
			"oLanguage": {
            "sZeroRecords": "There are no records that match your search criterion",
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)"
        }, 
		"aaSorting": [],
		"sDom": '<"H"lr>t<"F">',
		 bjQueryUI: true,
	  sPaginationType: "full_numbers"
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { "type": "text" },
				    { type: "text" },	
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
		if (isset($_GET['country']))
		{ 	$country = $_GET['country'];}
		echo "<h3 class='centre'>Country: $country</h3>";
		$SQL = sprintf("Select countries.Country_ID, countries.`Country_Name`, description.Description, theatre.Theatre, subcontinent.`Sub Continent`, continent.Continent
		From theatre Inner Join subcontinent On theatre.`Sub Continent` = subcontinent.Sub_Continent_ID
		Inner Join continent On subcontinent.Continent = continent.Continent_ID
		Inner Join countries On countries.Theatre = theatre.TheatreID
		Inner Join description ON countries.descriptionID = description.`description ID`
		Where countries.Country_Name = '%s'", $country );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Theatre sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 1)	
		{
			$db_field = mysqli_fetch_assoc($result);
			$description = $db_field['Description'];
			if ($description == "")
				{$description = "TEMP Describe $country";}
			$countryid = $db_field['Country_ID'];
//			$theatre = $db_field['Theatre'];
//			$subcontinent = $db_field['Sub Continent'];
//			$continent = $db_field['Continent'];
			echo "Country ID = $countryid";
			echo "<div class = 'desc'>$description</div>";
		}
		else
		{	echo "Theatre Not Found";
			die();
		}
		
// Display Country's position in world
		echo"<br>";
		$SQL = sprintf("SELECT countries.Country_Name AS Country, theatre.Theatre, subcontinent.`Sub Continent`, continent.Continent
		FROM  countries Inner Join theatre On countries.Theatre = theatre.TheatreID
		Inner Join subcontinent On theatre.`Sub Continent` = subcontinent.Sub_Continent_ID
		Inner Join continent On subcontinent.Continent = continent.Continent_ID
		WHERE countries.Country_ID='%s'", $countryid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Country sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such country
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug countries";
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
											echo "<a href='theatre.php?theatre=$value'>$value</a>";
											break;
										case 3:
											echo "<a href='subcontinent.php?subcont=$value'>$value</a>";
											break;
										case 4:
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


This is the <B>Country</B> page <br><br>
 
<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Geographical</a></li>
			<li><a href="#tabs-2">Political</a></li>
			<li><a href="#tabs-3">Military</a></li>
		</ul>
	<div id="tabs-1">
    
		<h3 class='centre'>Geographical</h3>

	<?php
		echo "<p class='centre'> $country is divided into the following divisions.</p>";
		echo"<br>";

// Show Countries
		$SQL = sprintf("Select divisions.Division_Name, `location type`.`Location Type`
		From divisions Inner Join `location type` On divisions.Location_Type = `location type`.LocationTypeID
		Where divisions.Country = '%s' ORDER BY divisions.`Division_Name`", $countryid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Division sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt <> 0)	
		{
			echo "<table id = 'geog' class = 'geog'>";
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
									echo "<a href='division.php?divn=$value'>$value</a>";
									break;
								case 2:
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
		
// No countries found!!!
		else {echo "<p class='centre'>No Divisions Found</p>";}			
		echo"<br>";
	?>
  </div>
  <div id="tabs-2">

		<h3 class='centre'>Political</h3>
<?php		echo "<h4 class='centre'>Government of $country on $DateSelected </h3>";
			echo "<p class='centre'> The following lists all the Government ministries of $country on $DateSelected.</p>";

// Show Government organisations OF country
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("Select unit.Unit, location.Location As At, person.`Full Name` As Incumbent, `unit type`.`Level No`, unit.`Start Date` AS `Unit Start`, unit.`End Date` AS `Unit End`,
		unitco.`Start Date` As `CO Start`, unitco.`End Date` As `CO End`, unitlocn.`Start Date` As `Locn Start`, unitlocn.`End Date` As `Locn End`
		From countries Inner Join unit On unit.Country = countries.Country_ID
		Inner Join unitco On unitco.`Unit ID` = unit.Unit_ID
		Inner Join person On unitco.`Person ID` = person.ID
		Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
		Inner Join unitlocn On unitlocn.`Unit ID` = unit.Unit_ID
		Inner Join location On unitlocn.`Location ID` = location.LocID
		Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
		Where countries.Country_ID = '%s' And `force index`.Arm = 'P' And unitco.`Rank Index` = 1
		AND '%s' BETWEEN  unit.`Start Date` AND unit.`End Date` AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
		Order By  `unit type`.`Level No`, unit.Unit", $countryid, $datesel, $datesel, $datesel );
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
									echo "<a href='person.php?person=$value'>$value</a>";
									break;
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
		}
// No Govt Found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
		echo "<h4 class='centre'>Government organisations in $country from elsewhere on $DateSelected </h3>";
			echo "<p class='centre'> The following lists all the Government organisations in (but not from) $country on $DateSelected.</p>";

// Show Government organisations IN country from elsewhere
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("Select unit.Unit, location.Location As At, countries1.Country_Name As `From`, person.`Full Name` As `Full Name`, `unit type`.`Level No`,
		unitco.`Start Date` As `CO Start`, unitco.`End Date` As `CO End`,
		unit.`Start Date` As `Unit Start`, unit.`End Date` As `Unit End`,
		unitlocn.`Start Date` As `Locn Start`, unitlocn.`End Date` As `Locn End`
		From location Inner Join unitlocn On unitlocn.`Location ID` = location.LocID
		Inner Join unit On unitlocn.`Unit ID` = unit.Unit_ID
		Inner Join unitco On unitco.`Unit ID` = unit.Unit_ID
		Inner Join person On unitco.`Person ID` = person.ID
		Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
		Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
		Inner Join subdivisions On location.`Sub Division` = subdivisions.SubDivisionID
		Inner Join divisions On subdivisions.Division = divisions.Division_ID
		Inner Join countries On divisions.Country = countries.Country_ID
		Inner Join countries countries1 On unit.Country = countries1.Country_ID
		Where countries.Country_ID = %s And unit.Country <> %s And `force index`.Arm = 'P' And unitco.`Rank Index` = 1
		AND '%s' BETWEEN  unit.`Start Date` AND unit.`End Date` AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
		Order By  `unit type`.`Level No`, unit.Unit, countries.Country_Name, unit.Unit, location.Location"
		, $countryid, $countryid, $datesel, $datesel, $datesel );
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
			echo "<table id = 'govt2' class = 'center'>";
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
									break;								default:	// date fields
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
		
			<ul>
			<li><a href="#tabs-311">Level 1 to 3</a></li>
			<li><a href="#tabs-312">Level 4</a></li>
			<li><a href="#tabs-313">Level 5</a></li>
			<li><a href="#tabs-314">Level 6</a></li>
			<li><a href="#tabs-315">Level 7</a></li>
			<li><a href="#tabs-316">Level 8</a></li>
			<li><a href="#tabs-317">Level 9</a></li>
			<li><a href="#tabs-318">Level 10</a></li>
			</ul>
			<div id=tabs-311>	
		
				<?php 
// Show Level 1 to 3 Naval units IN Continent on Selected Date.
					echo "<h3 class='centre'>Level 1 to 3 Naval Units IN $country on $DateSelected</h3>"; 
					inarea("S", COUNTRY, $datesel, $countryid, ' <= 3 ', $selected);
		
// Show Level 1 to 3 Naval units FROM Continent on Selected Date.
					echo "<h3 class='centre'>Level 1 to 3 Naval Units FROM $country on $DateSelected</h3>"; 
					fromarea("S", COUNTRY, $datesel, $countryid, ' <= 3 ', $selected);

				?>
			</div>
			<div id=tabs-312>	
		
				<?php 
// Show Level 4 Naval units IN Continent on Selected Date.
					echo "<h3 class='centre'>Level 4 Naval Units IN $country on $DateSelected</h3>"; 
					inarea("S", COUNTRY, $datesel, $countryid, ' = 4 ', $selected);
		
// Show :evel 4 Naval units FROM Continent
					echo "<h3 class='centre'>Level 4 Naval Units FROM $country on $DateSelected</h3>"; 
					fromarea("S", COUNTRY, $datesel, $countryid, ' = 4 ', $selected);
						
				?>
			</div>
			<div id=tabs-313>	
		
				<?php 
// Show Level 5 Naval units IN Continent on Selected Date.
					echo "<h3 class='centre'>Level 4 Naval Units IN $country on $DateSelected</h3>"; 
					inarea("S", COUNTRY, $datesel, $countryid, ' = 5 ', $selected);
		
// Show level 5 Naval units FROM Continent
					echo "<h3 class='centre'>Level 4 Naval Units FROM $country on $DateSelected</h3>"; 
//					fromarea("S", COUNTRY, $datesel, $countryid, ' = 5 ', $selected);
						
				?>
			</div>
		</div> 
		<div id=tabs-32>
			<?php 
// Show Army units IN Continent
				echo "<h3 class='centre'>Army Units IN $country on $DateSelected</h3>"; 
				inarea("L", COUNTRY, $datesel, $countryid, 20, $selected);

// Show Army units FROM Continent
				echo "<h3 class='centre'>Army Units FROM $country on $DateSelected</h3>"; 
//				fromarea("L", COUNTRY, $datesel, $countryid, 20, $selected);
			?>
		</div>


		<div id=tabs-33>
		<?php 
// Show Air Force units IN Sub Continent
				echo "<h3 class='centre'>Air Force Units in $country on $DateSelected</h3>"; 
				inarea("A", COUNTRY, $datesel, $countryid, 20, $selected);

// Show Air units FROM Continent
			echo "<h3 class='centre'>Major Air Force Units FROM $country on $DateSelected</h3>"; 
//			fromarea("A", COUNTRY, $datesel, $countryid, 20, $selected);
		?>
		</div>

		</div>
			
	</div>	
</div>
 
</body>
</html>