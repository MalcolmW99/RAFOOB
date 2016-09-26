<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>
<title>WW2 Website - OOB</title>
<meta http-equiv="description" content="page description" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
			include ("header2.php");
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
			echo "<div class = 'ucount'>";
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
										echo "No of Units (Simple): $value</br>";
										break;
									case 3:
										echo "No of Units (Admin): $value</br>";
										break;
									case 4:
										echo "No of Units (Operational): $value</br>";
										break;
									case 5:
										echo "No of Units (Pseudo): $value</br>";
										break;
									case 6:
										echo "No of Units (Construction): $value</br>";
										break;
								}
						}
				}
			echo "</div></br>";
		?>
</body>
</html>
