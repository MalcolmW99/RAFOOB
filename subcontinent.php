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
		if (isset($_GET['subcont']))
		{ 	$subcontinent = $_GET['subcont'];}
		echo "<h2 class='centre'>Sub Continent of $subcontinent</h2>";
		$SQL = sprintf("SELECT subcontinent.Sub_Continent_ID, subcontinent.`Sub Continent`, description.Description, continent.Continent
		FROM subcontinent Inner Join continent On subcontinent.Continent = continent.Continent_ID
		Inner Join description ON subcontinent.DescriptionID = description.`description ID`
		WHERE subcontinent.`Sub Continent` = '%s'", $subcontinent );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "SubContinent sql failed<br>";
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
			$subcontinentid = $db_field['Sub_Continent_ID'];
//			$continent = $db_field['Continent'];
			echo "SubContinent ID = $subcontinentid";
			echo "<div class = 'desc'>$description</div>";
			echo "<br>";
		}
		else
		{	echo "Sub Continent Not Found";
			die();
		}
// Display Subcontinent's position in world
		echo"<br>";
		$SQL = sprintf("SELECT subcontinent.`Sub Continent`, continent.Continent
		FROM  subcontinent Inner Join continent On subcontinent.Continent = continent.Continent_ID
		WHERE subcontinent.Sub_Continent_ID = '%s'", $subcontinentid );
//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Sub Continent sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
//		echo "Row Count: $row_cnt";
		if ($row_cnt == 0)
// No such theatre
			{echo "<p class='centre'>None Found</p>";}
		else
// entries found
			{
//echo "debug sub continents";
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


This is the <B>Sub Continent</B> page <br><br>
 
<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Geographical</a></li>
			<li><a href="#tabs-2">Political</a></li>
			<li><a href="#tabs-3">Military</a></li>
		</ul>
	<div id="tabs-1">
    
		<h3 class='centre'>Geographical</h3>
		<p class='centre'> The following Theatres are included.</p>
	<?php
		echo"<br>";
		
// Show Theatres
		$SQL = sprintf("Select theatre.Theatre, `location type`.`Location Type` 
		FROM theatre Inner Join description ON theatre.DescriptionID = description.`description ID`
		Inner Join `location type` On description.`LocationType` = `location type`.LocationTypeID
		WHERE  theatre.`Sub Continent` = '%s' ORDER BY theatre.`Theatre Order`", $subcontinentid );
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
									echo "<a href='theatre.php?theatre=$value'>$value</a>";
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
		
// No theatres found!!!
		else {echo "<p class='centre'>No Theatres Found</p>";}			
		echo"<br>";
	?>
  </div>
  <div id="tabs-2">

		<h3 class='centre'>Political</h3>
<?php		echo "<h4 class='centre'>Governments in $subcontinent on $DateSelected </h3>";
			echo "<p class='centre'> The following lists the Governments of all countries in $subcontinent on $DateSelected and their allegiance.</p>";

// Show Governments
		$datesel = dt2ymd($DateSelected);
		$SQL = sprintf("Select theatre.Theatre, countries.Country_Name As Country, unit.Unit AS `Govt`, person.`Full Name` AS Incumbent,  combatants.Combatant_Type AS Allegiance,
			unitco.`Start Date`, unitco.`End Date`, `country allegiance`.Start_Date as CASD, `country allegiance`.End_Date AS CAED
			FROM theatre Inner Join countries On countries.Theatre = theatre.TheatreID 
			LEFT JOIN unit On unit.Country = countries.Country_ID 
			INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID` 
			INNER JOIN unitco On unitco.`Unit ID` = unit.Unit_ID
			INNER JOIN person On unitco.`Person ID` = person.ID 
			INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
			LEFT JOIN `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
			LEFT JOIN combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
			WHERE `force index`.Arm = 'P' And theatre.`Sub Continent` = '%s' And (`unit type`.`Unit Type` Like '%%Govt' OR `unit type`.`Unit Type` Like '%%State') AND unitco.`Rank Index` = 1
			AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date
			ORDER BY theatre.Theatre, countries.Country_Name, unitco.`Start Date`", $subcontinentid, $datesel, $datesel );

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
		echo "No of country entries = $row_cnt";
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
										echo "<a href='theatre.php?thtr=$value'>$value</a>";
										break;
								case 2:
									echo "<a href='country.php?ctry=$value'>$value</a>";
									break;
								case 3:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
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
			echo "<h3 class='centre'>Naval Units IN $subcontinent on $DateSelected</h3>"; 
			inarea("S", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);
		
// Show Naval units FROM Continent
			echo "<h3 class='centre'>Naval Units FROM $subcontinent on $DateSelected</h3>"; 
			fromarea("S", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);
						
		?>
		</div>

		<div id=tabs-32>
			<?php 
// Show Army units IN Continent
				echo "<h3 class='centre'>Army Units IN $subcontinent on $DateSelected</h3>"; 
				inarea("L", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);

// Show Army units FROM Continent
				echo "<h3 class='centre'>Army Units FROM $subcontinent on $DateSelected</h3>"; 
				fromarea("L", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);
			?>
		</div>


		<div id=tabs-33>
		<?php 
// Show Air Force units IN Sub Continent
				echo "<h3 class='centre'>Air Force Units in $subcontinent on $DateSelected</h3>"; 
				inarea("A", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);

// Show Air units FROM Continent
			echo "<h3 class='centre'>Major Air Force Units FROM $subcontinent on $DateSelected</h3>"; 
			fromarea("A", SUBCONTINENT, $datesel, $subcontinentid, ' <= 4 ', $selected);
		?>
		</div>

		</div>
			
	</div>	
</div>
</div> 
</body>
</html>