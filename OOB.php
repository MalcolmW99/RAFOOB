<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<title>WW2 Website - OOB</title>
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
			function popUpwindow(URL, campaign) {
						day = new Date();
						id = day.getTime();
						URL = URL + "?setcmpgn=" + campaign;
						eval("window.open(URL, '" + "?=" + "', 'toolbar=0,scrollbars=0,location=1,statusbar=0,menubar=0,resizable=0,width=1000,height=500,left = 470,top = 140');");
			}

// -->

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
    $( "#tabs" ).tabs();
  });
  </script>
			  

</head>

<body>
	<div class = 'header'>
	<?php
		include ("includes/sqllibrary.php");
		include ("includes/navigation.php");
		include ("includes/header.php");
?>
</div>
<div class = 'content'>

<div id = 'oob'>
    <br><br>
	This is the <b>ORDER OF BATTLE</b> page <br><br>
<?php
			$SQL = sprintf("Select unit_count.Unit, unit_count.Simple, unit_count.Admin, unit_count.Operational, unit_count.Pseudo, unit_count.Construction
				From unit_count
				WHERE unit_count.Unit='%s' ", $UnitSelected);
			$result = mysqli_query($selected, $SQL);
			if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
			$row_cnt = mysqli_num_rows($result);
//			echo "No of rows = $row_cnt</br>";
			if ($row_cnt == 1)
				{
					$dbentry = True;
					$row = mysqli_fetch_assoc($result);
					$j = 0;
					foreach($row as $key => $value)
						{
							$j++;
							switch ($j)
								{
									case 2:
										$Simple = $value;
										break;
									case 3:
										$Admin = $value;
										break;
									case 4:
										$Operational = $value;
										break;
									case 5:
										$Pseudo = $value;
										break;
									case 6:
										$Construction = $value;
										break;
								}
						}
				}
			else
				{ 
					$dbentry = False;
				}
?>
	
	Note that this page may take a long time to load.
	
	<div class = 'centre' id = 'NoUnits'> This will be replaced by Unit totals </div>
	

	<FORM class='centre'>
			<INPUT TYPE="button" onClick="history.go(0)" VALUE="Refresh">
		</FORM>
<?php
		set_time_limit(0);  // never timeout
		echo "<p class = 'centre'><a href = 'displaycampaign.php?cmpgn=$SubCampaignSelected'>$SubCampaignSelected</a> selected</p>";
	$datesel = $DateSelected;
//	echo $datesel;
		if ($datesel=="")
			{echo "<p class='centre'> Please Enter a valid Subcampaign first</p>";}
		else
			{echo "<p class=centre><Button type = 'button' onclick=\"javascript:popUp('calendar.php')\">Change Date</button></p>";}
?>
			
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Simple</a></li>
			<li><a href="#tabs-2">Admin</a></li>
			<li><a href="#tabs-3">Operational</a></li>
			<li><a href="#tabs-4">Pseudo</a></li>
			<li><a href="#tabs-5">Construction</a></li>
		</ul>
		
		<div id="tabs-1">
		<?php
			$SimpleOOBCount = 0;
			echo "<h3>Order of Battle for $UnitSelected on $DateSelected<?> - Links only</h3>";
			echo "<ul id='treeData1'>";
			echo "<li id = 'id1'><a href='displayunit.php?unit=$UnitSelected'>$UnitSelected</a></li>";
			echo "<ul>";
				
// Database is opened in header.php
			$datesel = dt2ymd($DateSelected);
			$level = 0;
			$SimpleOOBCount = getOOBSimple($UnitSelected, $datesel, $level, $selected, $SimpleOOBCount);
			echo"<br>";
			echo "Number of units: $SimpleOOBCount";
		?>
	
	</div>
	<div id="tabs-2">
	<?php
		$AdminOOBCount = 0;
		echo "<h3>Order of Battle for $UnitSelected on $DateSelected<?> - Admin Links plus CO and Location</h3>";
			echo "<ul id='treeData1'>";
			echo "<li id = 'id1'><a href='displayunit.php?unit=$UnitSelected'>$UnitSelected</a></li>";
			echo "<ul>";
				
// Database is opened in header.php
		$datesel = dt2ymd($DateSelected);
		$level = 0;
		
		$AdminOOBCount = getOOB($UnitSelected, $datesel, $level, $selected, '%Admin', $AdminOOBCount);
		echo "</ul>";
		echo"<br>";
		echo "Number of units: $AdminOOBCount";
					if ($dbentry == True)
				{
				if ($AdminOOBCount <> $Admin)
					{ 	echo "Update DB with new data for Admin ";
					}
				else 
				{ echo "no update needed for Admin"; }
				}
			else 
					{ echo "Append new DB entry for Admin";
					}


	?>

	</div>
	<div id="tabs-3">
	<?php
		$OpOOBCount = 0;
		echo "<h3>Order of Battle for $UnitSelected on $DateSelected - Operational Links plus Commanding Officer, Location and Status</h3>";
			echo "<ul id='treeData1'>";
			echo "<li id = 'id1'><a href='displayunit.php?unit=$UnitSelected'>$UnitSelected</a></li>";
			echo "<ul>";
				
// Database is opened in header.php
		$datesel = dt2ymd($DateSelected);
		$level = 0;
		
		$OpOOBCount = getOOB($UnitSelected, $datesel, $level, $selected, 'Operational%', $OpOOBCount);
		echo "</ul>";
		echo"<br>";
		echo "Number of units: $OpOOBCount";

	?>
	</div>
	<div id="tabs-4">
	<?php
		$PseudoOOBCount = 0;
		echo "<h3>Order of Battle for $UnitSelected on $DateSelected<?> - Pseudo links only</h3>";
			echo "<ul id='treeData1'>";
			echo "<li id = 'id1'><a href='displayunit.php?unit=$UnitSelected'>$UnitSelected</a></li>";
			echo "<ul>";
				
// Database is opened in header.php
		$datesel = dt2ymd($DateSelected);
		$level = 0;
		
		$PseudoOOBCount = getOOB($UnitSelected, $datesel, $level, $selected, 'Pseudo', $PseudoOOBCount);
		echo "</ul>";
		echo"<br>";	
		echo "Number of units: $PseudoOOBCount";
		
	?>
	</div>
	<div id="tabs-5">
	<?php
		$ConstrOOBCount = 0;
		echo "<h3>Order of Battle for $UnitSelected on $DateSelected<?> - Construction Links only</h3>";
			echo "<ul id='treeData1'>";
			echo "<li id = 'id1'><a href='displayunit.php?unit=$UnitSelected'>$UnitSelected</a></li>";
			echo "<ul>";
				
// Database is opened in header.php
		$datesel = dt2ymd($DateSelected);
		$level = 0;
		
		$ConstrOOBCount = getOOB($UnitSelected, $datesel, $level, $selected, 'Construction', $ConstrOOBCount);
		echo "</ul>";
		echo"<br>";		
		echo "Number of units: $ConstrOOBCount";
		
	?>

	</div>
</div>

</div>
	<?php
		if ($dbentry == True)
			{
				if ($SimpleOOBCount <> $Simple)
					{ 	echo "1.Update DB with new data </br>";
						UpdateUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);}
				else 
					{ 	echo "no update needed for Simple </br>"; 
						If ($AdminOOBCount <> $Admin)
						{ 	echo "2.Update DB with new data </br>";
							UpdateUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);}
						else 
							{	echo "no update needed for Admin </br>";
								If ($OpOOBCount <> $Operational)
									{ 	echo "3.Update DB with new data  </br>";
										UpdateUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);}
								else 
									{ echo "no update needed for Operational </br>";
									If ($PseudoOOBCount <> $Pseudo)
										{ 	echo "4.Update DB with new data </br>";
											UpdateUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);}
									else 
										{ echo "no update needed for Pseudo </br>";
										If ($ConstrOOBCount <> $Construction)
											{ 	echo "5. Update DB with new data </br>";
												UpdateUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);}
										else 
											{ echo "no update needed at all </br>";}
										}
									}
							}
					}
			}

		else 
			{ 	echo "Append new DB entry  </br>";
				AppendUnitCount($selected, $UnitSelected, $SimpleOOBCount, $AdminOOBCount, $OpOOBCount, $PseudoOOBCount, $ConstrOOBCount);
			}
			
	Function UpdateUnitCount($selected, $Unit, $S, $A, $O, $P, $C)
		{
			echo "Update Unit Count for $Unit </br>";
			$SQL = "UPDATE unit_count SET Simple = $S, Admin = $A, Operational = $O, Pseudo = $P, Construction = $C
					Where Unit = '$Unit'";
			echo $SQL;
			$result = mysqli_query($selected, $SQL);
			if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
			
			return;
		}
	Function AppendUnitCount($selected, $Unit, $S, $A, $O, $P, $C)
		{
			echo "Append Unit Count for $Unit </br>";
			$SQL = "INSERT INTO unit_count VALUES ('$Unit', $S, $A, $O, $P, $C)";
			echo $SQL;
			$result = mysqli_query($selected, $SQL);
			if (!$result)
			{
				echo "sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}

			return;
		}
	?>
		<script>
			$("#NoUnits").load("includes/unit_count.php", function(responseTxt, statusTxt, xhr){
				if(statusTxt == "error")
					alert("Error: " + xhr.status + ": " + xhr.statusText);
			});
		</script>
</div>

</body>
</html>