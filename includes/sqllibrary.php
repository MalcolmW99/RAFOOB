<?PHP
// Library of SQL for Area and Military division


	function inarea($service, $area, $datepicked, $area_id, $level, $selected)
	{
		// Show units IN Area on Selected Date.
			echo "DEBUG - entering inarea";			
			switch ($area) // numeric
			{
				case 1:  //continent
					echo"DEBUG Entering case 1 - continent $area";
					$SQL = sprintf("SELECT subcontinent.`Sub Continent`, theatre.Theatre, countries.Country_Name AS Country, unit.Unit, location.LOCATION AS AT,
					`unit type`.`Unit Type`, combatants.Combatant_Type AS Allegiance, `unit type`.`Level No`,
					unitlocn.`Start Date` AS `Locn Start`, unitlocn.`End Date` AS `Locn End`, `country allegiance`.Start_Date AS CASD, `country allegiance`.End_Date AS CAED,
					unit.`Start Date` AS `Unit Start`, unit.`End Date` AS `Unit End`
					FROM theatre INNER JOIN subcontinent ON theatre.`Sub Continent` = subcontinent.Sub_Continent_ID
					INNER JOIN countries ON countries.Theatre = theatre.TheatreID
					Inner Join divisions On divisions.Country = countries.Country_ID
					Inner Join `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
					Inner Join combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
					Inner Join subdivisions On subdivisions.Division = divisions.Division_ID
					Inner Join location On location.`Sub Division` = subdivisions.SubDivisionID
					Inner Join unitlocn On unitlocn.`Location ID` = location.LocID
					Inner Join unit On unitlocn.`Unit ID` = unit.Unit_ID
					Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE `force index`.Arm = '%s' AND subcontinent.Continent = '%s' AND  `unit type`.`Level No` %s AND '%s' BETWEEN unit.`Start Date` AND unit.`End Date`
					AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date` AND '%s' BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date
					ORDER BY combatants.Combatant_Type, `unit type`.`Level No`, theatre.Theatre, countries.Country_Name", 
					$service, $area_id, $level, $datepicked, $datepicked, $datepicked);
					break;

				case 2:  //subcontinent
					echo"DEBUG Entering case 2 - subcontinent $area";
					$SQL = sprintf("SELECT theatre.Theatre, countries.Country_Name AS Country, unit.Unit, location.Location AS AT, `unit type`.`Unit Type`,
					combatants.Combatant_Type, `unit type`.`Level No`,
					unitlocn.`Start Date`, unitlocn.`End Date`, `country allegiance`.Start_Date AS CASD, `country allegiance`.End_Date AS CAED
					FROM theatre INNER JOIN countries On countries.Theatre = theatre.TheatreID
					INNER JOIN divisions On divisions.Country = countries.Country_ID
					INNER JOIN subdivisions On subdivisions.Division = divisions.Division_ID
					INNER JOIN location On location.`Sub Division` = subdivisions.SubDivisionID
					INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					LEFT JOIN `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
					LEFT JOIN combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
					WHERE theatre.`Sub Continent` = '%s' AND `unit type`.`Level No` %s AND `force index`.Arm = '%s'
					AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date` AND '%s' BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date
					ORDER BY combatants.Combatant_Type, `unit type`.`Level No`, theatre.Theatre, countries.Country_Name, location.Location", 
					$area_id, $level, $service, $datepicked, $datepicked);
					break;
				case 3:  //theatre
					echo"DEBUG Entering case 3 - theatre $area";
					$SQL = sprintf("SELECT countries.Country_Name AS Country, unit.Unit, location.Location AS AT, `unit type`.`Level No`,
					unitlocn.`Start Date`, unitlocn.`End Date` 
					FROM countries INNER JOIN divisions On divisions.Country = countries.Country_ID
					INNER JOIN subdivisions On subdivisions.Division = divisions.Division_ID
					INNER JOIN location On location.`Sub Division` = subdivisions.SubDivisionID
					INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE countries.Theatre = '%s' AND `unit type`.`Level No` %s AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, countries.Country_Name, location.Location", $area_id, $level, $service, $datepicked);
					break;
				case 40:  //country
					echo"DEBUG Entering case 4 - country $area";
					$SQL = sprintf("SELECT divisions.Division_Name AS Division, unit.Unit, location.Location AS AT, `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`
					FROM divisions INNER JOIN subdivisions On subdivisions.Division = divisions.Division_ID
					INNER JOIN location On location.`Sub Division` = subdivisions.SubDivisionID
					INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE divisions.Country = '%s' AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, location.Location", $area_id, $service, $datepicked);
					break;
				case 50:  //division
					echo"DEBUG Entering case 50 - division $area";
					$SQL = sprintf("SELECT subdivisions.`Sub Division Name` AS `Sub Division`, unit.Unit, location.Location AS AT, `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`
					FROM subdivisions INNER JOIN location On location.`Sub Division` = subdivisions.SubDivisionID
					INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE subdivisions.Division = '%s' AND `unit type`.`Level No` %s AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, subdivisions.`Sub Division Name`, location.Location", $area_id, $level, $service, $datepicked);
					break;
				case 60:  //sub division
					echo"DEBUG Entering case 60 - subdivision $area";
					$SQL = sprintf("SELECT unit.Unit, location.Location AS AT, `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`
					FROM location INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE location.`Sub Division` = '%s' AND `unit type`.`Level No` <= '%s' AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, location.Location", $area_id, $level, $service, $datepicked);
					break;
				default:
					echo "ERROR area number is incorrect";
					$SQL ="";
					break;
			}
			echo "<br>Area:$area<br> $SQL<br>";
			$result = mysqli_query($selected, $SQL);
			if (!$result)
			{
				echo "Unit sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
			$row_cnt = mysqli_num_rows($result);
			echo "Row Count: $row_cnt";
			$idname = $service . "_" . $area ."IN";
			echo "Table idname: $idname";
//			echo "table id:MilIN";
			if ($row_cnt <> 0)
			{
				echo "<table id = $idname class = 'center'>";
					echo "<thead>";
						echo "<tr>";
	//					echo "debug002";
						$row = mysqli_fetch_assoc($result);
						foreach ($row as $col => $value)
						{
//							echo "debug004";
							echo "<th>";
								echo $col;
							echo "</th>";
						}
						echo "</tr>";
						$row = mysqli_fetch_assoc($result);
/*						foreach ($row as $col => $value)
						{
//							echo "debug004";
							echo "<th>";
								echo $col;
							echo "</th>";
						}
						echo "</tr>"; */
					echo "</thead>";
					echo "<tbody>";
// Write rows
					mysqli_data_seek($result, 0);
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo "<tr>";
						$j = $area - 1;
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
										echo "<a href='theatre.php?theatre=$value'>$value</a>";
										break;
									case 3:
										echo "<a href='country.php?Ctry=$value'>$value</a>";
										break;
									case 4:
										echo "<a href='displayunit.php?unit=$value'>$value</a>";
										break;
									case 5:
										echo "<a href='location.php?locn=$value'>$value</a>";
										break;
									case 6:
										echo $value;
											if ($area >= 40)
												{$j = 100;}
										break;
									case 40:
										echo "<a href='division.php?divn=$value'>$value</a>";
										$j = 3;
										break;
									case 50: 
										echo "<a href='subdivision.php?subdivn=$value'>$value</a>";
										$j = 3;
										break;
									case 60: 
										echo "<a href='displayunit.php?unit=$value'>$value</a>";
										$j = 4;
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
// No Units found!!!
		else {echo "<p class='centre'>No units found</p>";}			
		echo"<br>";

	}
	function fromarea($service, $area, $datepicked, $area_id, $level, $selected)
	{
		// Show  units FROM Area on Selected Date.
		echo "DEBUG - entering fromarea";
		switch ($area) // numeric
		{
				case 1:  //continent
					echo"Entering case 1 - continent $area";
					$format = 'Select subcontinent.`Sub Continent`, theatre.Theatre, countries.Country_Name As COUNTRY, unit.Unit, location.Location As At, person.`Full Name` AS CO, combatants.Combatant_Type As ALLEGIANCE,
					`unit type`.`Level No`, unitlocn.`Start Date` AS `Locn Start`, unitlocn.`End Date` AS `Locn End`, `country allegiance`.Start_Date As CASD, `country allegiance`.End_Date As CAED,
					unit.`Start Date` As `Unit Start`, unit.`End Date` As `Unit End`, unitco.`Start Date` As `CO Start`, unitco.`End Date` As `CO End`
					From theatre Inner Join subcontinent On theatre.`Sub Continent` = subcontinent.Sub_Continent_ID
					Inner Join countries On countries.Theatre = theatre.TheatreID
					Inner Join `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
					Inner Join combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
					Inner Join unit On countries.Country_ID = unit.Country
					Inner Join unitlocn On unitlocn.`Unit ID` = unit.Unit_ID
					Inner Join location On unitlocn.`Location ID` = location.LocID
					Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
					Inner Join unitco On unitco.`Unit ID` = unit.Unit_ID
					Inner Join person On unitco.`Person ID` = person.ID
					WHERE `force index`.Arm = "%1$s" AND subcontinent.Continent = %2$s AND `unit type`.`Level No` %3$s  AND unitco.`Rank Index` = 1
					AND "%4$s" BETWEEN unitco.`Start Date` AND unitco.`End Date` AND "%4$s" BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date AND "%4$s" BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					AND "%4$s" BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, subcontinent.`Sub Continent`, countries.Country_Name, unitco.`Start Date`';
					$SQL = sprintf($format, $service, $area_id, $level, $datepicked);
					break;
				case 2:  //subcontinent
					echo"Entering case 2 - subcontinent $area";
					$format = 'SELECT theatre.Theatre, countries.Country_Name As Country, unit.Unit, location.Location AS AT, person.`Full Name` AS Name, combatants.Combatant_Type AS Allegiance, `unit type`.`Level No`,
					unitco.`Start Date`, unitco.`End Date`, `country allegiance`.Start_Date, `country allegiance`.End_Date, unitlocn.`Start Date` As `Locn SD`, unitlocn.`End Date` As `Locn ED`
					FROM theatre INNER JOIN countries On countries.Theatre = theatre.TheatreID
					LEFT JOIN unit On unit.Country = countries.Country_ID
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					INNER JOIN unitco On unitco.`Unit ID` = unit.Unit_ID
					INNER JOIN person On unitco.`Person ID` = person.ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
					INNER JOIN combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
					INNER JOIN unitlocn On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN location On unitlocn.`Location ID` = location.LocID
					WHERE `force index`.Arm = "%1$s" AND theatre.`Sub Continent` = %2$s AND `unit type`.`Level No` %3$s AND unitco.`Rank Index` = 1
					AND "%4$s" BETWEEN unitco.`Start Date` AND unitco.`End Date` AND "%4$s" BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date AND "%4$s" BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY combatants.Combatant_Type, `unit type`.`Level No`, theatre.Theatre, countries.Country_Name, unitco.`Start Date`';
					$SQL = sprintf($format, $service, $area_id, $level, $datepicked);
					break;
				case 3:  //theatre
					$SQL = sprintf("SELECT countries.Country_Name As Country, unit.Unit, location.Location AS AT, person.`Full Name` AS Name, combatants.Combatant_Type AS Allegiance, `unit type`.`Level No`,
					unitco.`Start Date`, unitco.`End Date`, `country allegiance`.Start_Date, `country allegiance`.End_Date, unitlocn.`Start Date` As `Locn SD`, unitlocn.`End Date` As `Locn ED`
					FROM countries LEFT JOIN unit On unit.Country = countries.Country_ID
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					INNER JOIN unitco On unitco.`Unit ID` = unit.Unit_ID
					INNER JOIN person On unitco.`Person ID` = person.ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					LEFT JOIN `country allegiance` On `country allegiance`.Country_ID = countries.Country_ID
					LEFT JOIN combatants On `country allegiance`.Allegiance = combatants.Combatant_ID
					INNER JOIN unitlocn On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN location On unitlocn.`Location ID` = location.LocID
					WHERE `force index`.Arm = '%s' AND countries.Theatre = '%s' AND `unit type`.`Level No` %s AND unitco.`Rank Index` = 1
					AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN `country allegiance`.Start_Date AND `country allegiance`.End_Date AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, countries.Country_Name, unitco.`Start Date`", $service, $area_id,
					$level, $datepicked, $datepicked, $datepicked);
					break;
				case 40:  //country  RETHINK!!!
					$SQL = sprintf("SELECT unit.Unit, location.Location As At, person.`Full Name` As Incumbent, `unit type`.`Level No`, unitlocn.`Start Date` As `Locn Start`, unitlocn.`End Date` As `Locn End`,
					unitco.`Start Date` As `CO Start`, unitco.`End Date` As `CO End`, unit.`Start Date` As `Unit Start`, unit.`End Date` As `Unit End`
					From unit Inner Join unitlocn On unitlocn.`Unit ID` = unit.Unit_ID
					Inner Join location On unitlocn.`Location ID` = location.LocID
					Inner Join `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					Inner Join `force index` On unit.`Force` = `force index`.`Force ID`
					Inner Join unitco On unitco.`Unit ID` = unit.Unit_ID
					Inner Join person On unitco.`Person ID` = person.ID
					Where unit.Country = '%s' AND `force index`.Arm = '%s' And  unitco.`Rank Index` = 1 AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					AND '%s' BETWEEN unitco.`Start Date` AND unitco.`End Date` AND '%s' BETWEEN unit.`Start Date` AND unit.`End Date`
					Order By `unit type`.`Level No`, location.Location"
					, $area_id, $service, $datepicked, $datepicked, $datepicked);
					break;
				case 5:  //division
					$SQL = sprintf("SELECT subdivisions.`Sub Division Name` AS `Sub Division`, unit.Unit, location.Location AS AT, `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`
					FROM subdivisions INNER JOIN location On location.`Sub Division` = subdivisions.SubDivisionID
					INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE subdivisions.Division = '%s' AND `unit type`.`Level No` <= '%s' AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, subcontinent.`Sub Continent`, countries.Country_Name, location.Location
			", $area_id, $level, $service, $datepicked);
					break;
				case 6:  //sub division
					$SQL = sprintf("SELECT unit.Unit, location.Location AS AT,  `unit type`.`Level No`, unitlocn.`Start Date`, unitlocn.`End Date`
					FROM location INNER JOIN unitlocn On unitlocn.`Location ID` = location.LocID
					INNER JOIN unit On unitlocn.`Unit ID` = unit.Unit_ID
					INNER JOIN `unit type` On unit.`Unit Type` = `unit type`.`Unittype ID`
					INNER JOIN `force index` On unit.`Force` = `force index`.`Force ID`
					WHERE subdivisions.Division = '%s' AND `unit type`.`Level No` <= '%s' AND `force index`.Arm = '%s' AND '%s' BETWEEN unitlocn.`Start Date` AND unitlocn.`End Date`
					ORDER BY `unit type`.`Level No`, subcontinent.`Sub Continent`, countries.Country_Name, location.Location
			", $area_id, $level, $service, $datepicked);
					break;
		}
		echo "<br>Area:$area<br> $SQL<br>";
		
					$result = mysqli_query($selected, $SQL);
			if (!$result)
			{
				echo "Units FROM sql failed<br>";
				printf("Errormessage: %s\n", mysqli_error($selected));
				mysqli_close($selected);
				die();
			}
			$row_cnt = mysqli_num_rows($result);
			echo "Row Count: $row_cnt";
			if ($row_cnt <> 0)	
			{
				echo "<table class = 'center'>";
					echo "<thead>";
						echo "<tr>";
	//					echo "debug002";
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
						$j = $area - 1;
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
										echo "<a href='theatre.php?theatre=$value'>$value</a>";
										break;
									case 3:
										echo "<a href='country.php?country=$value'>$value</a>";
										break;
									case 4:
										echo "<a href='displayunit.php?unit=$value'>$value</a>";
										break;
									case 5:
										echo "<a href='location.php?locn=$value'>$value</a>";
										break;
									case 6:
										echo "<a href='person.php?person=$value'>$value</a>";
										break;
									case 7:
										if ($area == 4)
											{$j++;}
									case 8:
										echo "$value";										
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
// No Naval Units found!!!
		else {echo "<p class='centre'>No naval units found</p>";}			
		echo"<br>";

	}

?>
