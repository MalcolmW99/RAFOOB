<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<!doctype html>
 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title?RAF OOB Website</title>
	<link rel="stylesheet" href="css/jquery-ui-1.10.2.custom.css" />
<style type="text/css">@import url(css/jquery.datatables_themeroller.css);</style>
<style type="text/css">@import url(css/styles.css);</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>
<script>  
  $(function() {
    $( "#tabs" ).tabs();
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
		"sDom": '<"H"ilr>t<"F">',
		 bjQueryUI: true,
	  sPaginationType: "full_numbers"
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { "type": "text" },
				    { type: "text" },	
						]});
});
$(function() {
    $('#govt').dataTable( {
			"bAutoWidth": false,
			"bLengthChange": false,
			"iDisplayLength": 60,			
			"oLanguage": {
            "sZeroRecords": "There are no records that match your search criterion",
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)"
        }, 
		"aaSorting": [],
		"sDom": '<"H"ilr>t<"F">',
		 bjQueryUI: true,
	  sPaginationType: "full_numbers"
   }).columnFilter({sPlaceHolder: "head:before",
			aoColumns: [ { "type": "text" },
				    { type: "text" },
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

This is the <B>World</B> page <br><br>
    <h1> World Locations</h1> 
 
<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Geographical</a></li>
			<li><a href="#tabs-2">Political</a></li>
			<li><a href="#tabs-3">Military</a></li>
		</ul>
	<div id="tabs-1">
    
	<h3 class='centre'>Geographical</h3>
	<p class='centre'> The following Continents and Oceans are covered.</p>
	<?php
				echo"<br>";
// Show Continents
		$SQL = sprintf("SELECT continent.Continent, description.Description 
		FROM continent Inner Join description ON continent.DescriptionID = description.`description ID`
		ORDER BY continent.`Continent_Order`");
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
			echo "<table id = 'geog'>";
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
									echo "<a href='continent.php?cont=$value'>$value</a>";
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
		<h4 class='centre'>Major Countries Leaders</h3>
		<p class='centre'> The following lists the leaders of the major participants of the Second World War.</p>
<?php
// Show Major Leaders (unit type 98: Head of Major State)
		$SQL = sprintf("Select unit.Unit, countries.Country_Name AS Country, location.Location, unitlocn.`Start Date`, unitlocn.`End Date`
			From unit Inner Join countries On unit.Country = countries.Country_ID 
			Inner Join unitlocn On unitlocn.`Unit ID` = unit.Unit_ID 
			Inner Join location On unitlocn.`Location ID` = location.LocID 
			Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
			Where unit.`Unit Type` = 98 And `unit type`.`Level No` = 0
			Order By countries.Country_Name, unitlocn.`Start Date`, unitlocn.`End Date`");

//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Major Leader sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		echo $row_cnt;
		if ($row_cnt <> 0)	
		{
			echo "<table id = 'govt' class = 'poli'>";
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
										echo "<a href='country.php?Ctry=$value'>$value</a>";
										break;
								case 3:
									echo "<a href='location.php?locn=$value'>$value</a>";
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
// No Major Leaders Found found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
?>
	</div>
	 <div id="tabs-3">

		<h3 class='centre'>Military</h3>
		<h4 class='centre'>Major Countries Top Miliary Units</h3>
		<p class='centre'> The following lists the top military units of the major participants of the Second World War. It is ordered alphabetically by Country.</p>
<?php
// Show Major Units
		$SQL = sprintf("Select unit.Unit, countries.Country_Name AS Country, location.Location, unitlocn.`Start Date`, unitlocn.`End Date`
			From	unit Inner Join countries On unit.Country = countries.Country_ID 
			Inner Join unitlocn On unitlocn.`Unit ID` = unit.Unit_ID 
			Inner Join location On unitlocn.`Location ID` = location.LocID 
			Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
			Where (unit.`Unit Type` = 3 OR unit.`Unit Type` = 100 OR unit.`Unit Type` = 101) AND `unit type`.`Level No` < 3 AND location.`Location Type` <> 1
			Order By countries.Country_Name, unitlocn.`Start Date`, unitlocn.`End Date`");

//		echo $SQL;
		$result = mysqli_query($selected, $SQL);
		if (!$result)
			{
				echo "Major Leader sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
		$row_cnt = mysqli_num_rows($result);
		echo $row_cnt;
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
								case 1:
										echo "<a href='displayunit.php?unit=$value'>$value</a>";
										break;
								case 2:
										echo "<a href='country.php?Ctry=$value'>$value</a>";
										break;
								case 3:
									echo "<a href='location.php?locn=$value'>$value</a>";
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
// No Major Leaders Found found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
?>
   </div>
</div>
</div>
 
 
</body>
</html>

