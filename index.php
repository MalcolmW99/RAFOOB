<!DOCTYPE html >
<head>
<title>RAF OOB Website</title>
<meta http-equiv="description" content="page description" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">@import url(css/jquery.datatables_themeroller.css);</style>
<style type="text/css">@import url(css/styles.css);</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.columnFilter.js"></script>
<script>
$(function() {
	$('#location').dataTable( {
	  "oLanguage": {
            "sZeroRecords": "There are no records that match your search criterion",
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)"
        },
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
<!--<h1>World War 2 Database</h1>-->
<div class= 'header'>
<?php
	include ("includes/navigation.php");
	include ("includes/header.php");
?>
</div>



<div class = 'content'>
This is the <B>INDEX</B> page <br><br>
<h1> Introduction to RAF OOB Website</h1>
<?php
//	echo "<p>$UnitSelected</p>";
// Reset Date to 1/9/1939
//	echo "change date";
//	changedate(Date="1939-09-01");
	
?>

<br><br>
<p class = 'centre'>This is a demonstration of a number of tables on this site.   Description to follow....</p>
<?php
$unitid = 340;
// Display Locations for selected unit from unitlocn table
		echo "<div class = 'desc'>";
		$SQL = sprintf("SELECT location.Location, unit.Unit as Redesignated, unitlocn.`Start Date`, unitlocn.`End Date` 
		FROM unitlocn LEFT JOIN location ON unitlocn.`Location ID`=location.LocID
		LEFT JOIN unit on unitlocn.Redesignated=unit.Unit_ID
		WHERE unitlocn.`Unit ID`='%d' ORDER BY unitlocn.`Start Date`", $unitid);
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
		}
		else {echo "<p class=centre>No Locations found</p>";}
		echo "<br>";
		echo "</div>";
		
		echo "This is a test";

?>

<pre class="temp">
    <h2> Programming Notes</h2>
     
     <h3>1.Load Pre-Conditions</h3>
              1.1 There are no pre-conditions it will always load
     <h3>2.Notes on design</h3>
     <ol>
          <strong>2.1 This database must NOT be published on the internet.</strong>
          2.2 This page will always display.
          2.3 Describe the layout of the site.
          2.4 Describe Database.
          2.5 Describe Navigation method.
          2.6 Describe Colour Scheme.
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