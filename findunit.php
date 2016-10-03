<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>WW2 Website - Unit</title>
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
<script>
$(function() {
    $('#unitfind').dataTable( {
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
					 { type: "number" },
				]});
});
</script>

</head>

<body>
<!-- <h1>World War 2 Database</h1>-->

<div class = 'header'>
<?php 
	include ("includes/sqllibrary.php");
	include("includes/navigation.php");
	include("includes/header.php");
?>
</div>
<div class = 'content'>
    This is the <B>SELECT UNIT</B> page <br><br>
    <h2 class='centre'> Select Unit from the selected country</h2>
	<p class = 'centre'>To select a unit from another country change the selection from the country buttons above.</p>
        <p> Current Unit: <?php echo $UnitSelected; ?></p>

<?php
		echo"<br>";
// Show All Units
		$SQL = sprintf("Select countries.Country_Name AS Country, `force index`.`Force`, unit.Unit, `unit type`.`Unit Type`, `unit type`.`Level No`
		From unit Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
		Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
		Inner Join countries On unit.Country = countries.Country_ID
		WHERE countries.Country_Name = '%s'
		Order By `unit type`.`Level No`, `force index`.`Force`", $CountrySelected);
		echo $SQL;
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
			echo "<div>";
			echo "<table id = 'unitfind' class = 'poli'>";
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
									echo "<a href='country.php?country=$value'>$value</a>";
									break;
								case 3:
									echo "<a href='displayunit.php?unit=$value'>$value</a>";
									break;
								case 2:
								case 4:
								case 5:
									echo $value;
									break;
							}
									echo "</td>";
						}
					echo "</tr>";
				}
				echo "</tbody>";
			echo "</table>";
		echo "</div>";
		}
		
// No continents found!!!
		else {echo "<p class='centre'>None Found</p>";}			
		echo"<br>";
	?>
	
    <pre>
    <strong> 1 Programming Notes</strong>
        <strong> 1.1 Load Pre-Conditions</strong>
            1.1.1 'SubCampaign' must be set (so that 'Start Date' and 'End Date' are valid. Only Units existing between those dates can be selected.????
            1.1.2 Filter by Country only available if 'country set'
            1.1.3 Filter by Location only available if 'Location' added as a variable and if it is set
            1.1.4 Other filters are possible. E.g. Front, Campaign, Subcampaign, all levels of location - only works if location table has ALL higher levels properly identified by Location Type
            
         <strong> 1.2 Notes on design</strong>
            1.2.1 Page displays Selection Options and local copies of ALL variables.
            1.2.2 Page displays N buttons one for each filter option.
            1.2.3 Press FILTER BY FORCE button.
                1.2.3.1 Display pop-up Form with a Combo box with all Forces.
                1.2.3.2 Select any Force in Combo box.
                1.2.3.3 Press SUBMIT - popup disappears.
                1.2.3.4 Page rewritten with new 'FORCE' displayed and two new buttons FILTER BY COUNTRY and SELECT COUNTRY.
                1.2.3.5 Press FILTER BY COUNTRY button.
                1.2.3.5.1 Display pop-up Form with a Combo box with all Countries.
                1.2.3.5.2 Select any Country in Combo box.
                1.2.6.5.6 Press SUBMIT - popup disappears.
                1.2.6.5.7 Page rewritten with new 'Country' and new button for level Buttons remain the same.
            1.2.4 Press CAMPAIGN button - this can be after FRONT or on first load
                1.2.4.1 Display pop-up Form with a table with all Campaigns on selected FRONT
                1.2.4.2 Select any Campaign in table
                1.2.4.3 Press SUBMIT - popup disappears
                1.2.4.4 Page rewritten with existing FRONT and new CAMPAIGN displayed but Subcampaign and Unit are blank and Unit button is disabled
            1.2.5 Press SUBCAMPAIGN button this can be after Campaign or on first load
                1.2.5.1 Display pop-up Form with a table with all SubCampaigns on selected Campaign
                1.2.5.2 Select any SubCampaign in table
                1.2.5.3 Press SUBMIT - popup disappears
                1.2.5.4 Page rewritten with existing FRONT and CAMPAIGN and new SUBCAMPAIGN displayed but Unit is blank. All buttons are enabled
            1.2.6 Press UNIT button this can be after SubCampaign or on first load
                1.2.6.1 Display pop-up Form with a table with all <b>top-level</b> units on selected SubCampaign
                1.2.6.2 Select any Unit in table
                1.2.6.3 Record the COUNTRY for the Unit (from the table)
                1.2.6.3 Press SUBMIT - popup disappears
                1.2.6.4 Page rewritten with existing FRONT, CAMPAIGN and SUBCAMPAIGN and new Unit displayed. All buttons are enabled
            1.2.7 This can be repeated until the desired combination is achieved
            1.2.8 Press the SUBMIT button for the Form.
                1.2.8.1 If FRONT, CAMPAIGN and SUBCAMPAIGN are valid then update the sessionvars with the new data (FRONT, CAMPAIGN and SUBCAMPAIGN
                1.2.8.2 If UNIT and COUNTRY are valid then update the sessionvars with the new data for UNIT and COUNTRY
                1.2.8.3 Redisplay the page and remain on this page until another button is pressed
            1.2.9 Notes
                1.2.9.1 At any point you can change an earlier selection - but doing so loses all selections below the one changed as noted above
                1.2.9.2 e.g. if you change Front you lose Campaign, Subcampaign and Unit.  If you change Campaign you lose SubCampaign and Unit.  If you change Subcampaign you lose only the Unit
                1.2.9.3 If another navigation button is pressed at any time during this process then the sessionvars are <b>not</b> updated. Thus it is permissable to leave the page safely at any time
                1.2.9.4 Once the page is left it is not possible to restore any previous partial attempts to change the sessionvars
                
    </pre>
</div>
<!--<?php include("includes/header.html");?>-->

</body>
</html>