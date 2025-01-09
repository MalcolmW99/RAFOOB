<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; height: 100%">

            <tr>
                <td style="height: 23px" bgcolor="#cccccc" width="120">
                    <Button type = "button" Name = "btnhome" style="background-color: Silver" Width="120px" onclick="window.location.href='index.php'">Home</button></td>
                <td bgcolor="#cccccc" style="height: 23px" width="120">
                    <Button type = "button" Width="120px" onclick="window.location.href='OOB.php'">OOB</button></td>
                <td bgcolor="#cccccc" style="height: 23px" width="240">
                    <Button type = "button" Width="120px" onclick="window.location.href='campaign.php'">Select Campaign</button></td>
                <td bgcolor="#cccccc" style="height: 23px" width="120">
                    <Button type = "button" Width="106px" onclick="window.location.href='findunit.php'">Select Unit</button></td>
                <td bgcolor="#cccccc" style="height: 23px" width="120">
                    <Button type = "button" Width="118px" onclick="window.location.href='displayunit.php'">Display Unit</button></td>
                <td bgcolor="#cccccc" style="height: 23px; width: 240px;">
                    <Button type = "button" Width="120px" onclick="window.location.href='world.php'"> World Locations</button></td>
                <td bgcolor="#cccccc" style="width: 108px; height: 23px">
                    <Button type = "button" Width="120px" onclick="JavaScript:alert('Links pressed')">Links</button></td>
            </tr>

            <tr>
                <td bgcolor="#cccccc" style="height: 10px; text-align: right" width="120">
                    Select Country-&gt;</td>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Chairman of China";
                echo "<Button type = \"button\" style=\"background-color: aqua\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">China</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Fr President";
                echo "<Button type = \"button\" style=\"background-color: aqua\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">France</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Fuehrer";
                echo "<Button type = \"button\" style=\"background-color: red\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">Germany</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Italian Monarchy";
                echo "<Button type = \"button\" style=\"background-color: red\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">Italy</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Emperor of Japan";
                echo "<Button type = \"button\" style=\"background-color: red\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">Japan</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "British Monarchy";
                echo "<Button type = \"button\" style=\"background-color: aqua\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">UK</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "US President";
                echo "<Button type = \"button\" style=\"background-color: aqua\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">USA</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px" width="120">
<?php			$temp = "Leader of the Soviet Union";
                echo "<Button type = \"button\" style=\"background-color: aqua\" Width=\"120px\" onclick=\"window.location.href='displayunit.php?unit=$temp'\">USSR</button></td>";?>
                <td bgcolor="#cccccc" style="height: 10px">
                    <Button type = "button" style="background-color: lightyellow" Width="120px" onclick="window.location.href='selectcountry.php'">Other Country</button></td>

            </tr>
</table>