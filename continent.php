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
			"iDisplayLength": 60,			
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
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { "type": "text" },
				     { type: "text" },	
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
		if (isset($_GET['cont']))
		{ 	$continent = $_GET['cont'];}
		echo "<h2 class='centre'> $continent</h2>";
		$SQL = sprintf("SELECT continent.Continent_ID, continent.Continent, description.Description
		FROM continent Inner Join description on continent.DescriptionID = description.`description ID`
		WHERE continent.Continent = '%s'", $continent );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Continent sql failed<br>";
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
			$continentid = $db_field['Continent_ID'];
			echo "<div class = 'desc'>$description</div>";
			echo "Continent ID = $continentid";
		}
		else
		{	echo "Continent Not Found";
			die();
		}
		
	?>

<br><br>
This is the <B>Continent</B> page <br><br>
 
<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Geographical</a></li>
			<li><a href="#tabs-2">Political</a></li>
			<li><a href="#tabs-3">Military</a></li>
		</ul>
	<div id="tabs-1">
    
		<h3 class='centre'>Geographical</h3>
	<?php	
		echo "<p class='centre'> The following Sub Continents are included in $continent.</p>";
		echo"<br>";
// Show Sub Continents
		$SQL = sprintf("Select subcontinent.`Sub Continent`, `location type`.`Location Type` 
		FROM subcontinent Inner Join description ON subcontinent.DescriptionID = description.`description ID`
		Inner Join `location type` On description.`LocationType` = `location type`.LocationTypeID
		WHERE  subcontinent.continent = '%s' ORDER BY subcontinent.`SubCont Order`", $continentid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Continent sql failed<br>";
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
									echo "<a href='subcontinent.php?subcont=$value'>$value</a>";
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
		
// No continents found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
	?>
  </div>
  <div id="tabs-2">

		<h3 class='centre'>Political</h3>
<?php		echo "<h4 class='centre'>Political Leaders in $continent on $DateSelected </h3>";
			echo "<p class='centre'> The following lists the Head of State of all countries in $continent on $DateSelected and their allegiance.</p>";

// Show Heads of State
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("Select subcontinent.`Sub Continent`, theatre.Theatre, countries.Country_Name As Country, unit.Unit AS `Head of State`, person.`Full Name` AS Incumbent,  combatants.Combatant_Type AS Allegiance,
			unitco.`Start Date`, unitco.`End Date`, `country allegiance`.Start_Date as CASD, `country allegiance`.End_Date AS CAED
			FROM subcontinent Inner Join theatre On theatre.`Sub Continent` = subcontinent.Sub_Continent_ID 
			INNER JOIN countries On countries.Theatre = theatre.TheatreID 
			LEFT JOIN unit On unit.Country = countries.Country_ID 
			INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID` 
			INNER JOIN unitco On unitco.`Unit ID` = unit.Unit_ID
			INNER JOIN person On unitco.`Person ID` = person.ID 
			INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
			LEFT JOIN `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
			LEFT JOIN combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
			WHERE `force index`.Arm = 'P' And subcontinent.Continent = '%s' And (unit.`Unit Type` = 323 OR unit.`Unit Type` = 324 OR unit.`Unit Type` = 98) AND unitco.`Rank Index` = 1
			AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date
			ORDER BY subcontinent.`Sub Continent`, theatre.Theatre, countries.Country_Name, unitco.`Start Date`", $continentid, $datesel, $datesel );

//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Head of State sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		echo "No of countries = $row_cnt";
		if ($row_cnt <> 0)	
		{
			echo "<table id='govt' class = 'center'>";
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
										echo "<a href='subcontinent.php?subcont=$value'>$value</a>";
										break;
								case 2:
										echo "<a href='theatre.php?thtr=$value'>$value</a>";
										break;
								case 3:
									echo "<a href='country.php?ctry=$value'>$value</a>";
									break;
								case 4:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
									break;
								case 5:
									echo "<a href='person.php?person=$value'>$value</a>";
									break;
								case 6:
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
// No Heads of State Found!!!
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
// Show Naval units IN Continent on Selected Date.
			echo "<h3 class='centre'>Major Naval Units IN $continent on $DateSelected</h3>";
			inarea("S", CONTINENT, $datesel, $continentid,  '<= 3'  , $selected);
			
		
// Show Naval units FROM Continent
			echo "<h3 class='centre'>Major Naval Units FROM $continent on $DateSelected</h3>"; 
			fromarea("S", CONTINENT, $datesel, $continentid, ' <=3 ', $selected);
		?>
		</div>
			
			

		<div id=tabs-32>
		<?php 
// Show Army units IN Continent
			echo "<h3 class='centre'>Major Army Units IN $continent on $DateSelected</h3>"; 
			inarea("L", CONTINENT, $datesel, $continentid, ' <=3 ', $selected);

// Show Army units FROM Continent
			echo "<h3 class='centre'>Major Army Units FROM $continent on $DateSelected</h3>"; 
			fromarea("L", CONTINENT, $datesel, $continentid, ' <=3 ', $selected);

		?>
		</div>


		<div id=tabs-33>
		<?php 
// Show Air Force units IN Continent
			echo "<h3 class='centre'>Major Air Force Units in $continent on $DateSelected</h3>"; 
			inarea("A", CONTINENT, $datesel, $continentid, ' <=3 ', $selected);

// Show Air units FROM Continent
			echo "<h3 class='centre'>Major Air Force Units FROM $continent on $DateSelected</h3>"; 
			fromarea("A", CONTINENT, $datesel, $continentid, ' <=3 ', $selected);			

		?>
		</div>

		</div>
			
	</div>	
</div>
</div>	
</body>
</html>