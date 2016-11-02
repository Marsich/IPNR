<!DOCTYPE html>
<html lang="en">
<head>
	<title>IPNR</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		table { border-collapse: collapse; }
		table, th, td {  border: 1px solid black;  }

		td, th {
			padding-top: 2px;
			padding-right: 5px;
			padding-bottom: 2px;
			padding-left: 5px;
		}

		/* css per la colonna che separa le classi di IP */
		.bg-separator {  background-color: hotpink;  }

		/* css per l'intestazione della griglia */
		.css-ip-head {font-family: "Courier"; background-color: gold}
		.css-description-head {font-family: "Courier"; background-color: gold}

		/* css per i dati della griglia */
		.css-ip {font-family: "Courier"; font-size:14px; background-color: aliceblue;}
		.css-description {font-family: "Courier";}

		/* css per i dati della griglia che sono vuoti */
		.css-empty-ip { text-align: center; background-color: aliceblue;}
		.css-empty-description {text-align: center; background-color: aliceblue;}

		/* css per l'ultima riga, quella col tasto submit */
		.css-submit-row { text-align: center; background-color: gold;}
	</style>
</head>
<body>
<?php
//- - - INIZIO CONFIGURAZIONE - - -
$username = 'root';
$password = '';
$hostname = '127.0.0.1';
$dbname = 'ipnr';
$table = 'ipnr';

$empty_char = '- -'; // stringa da usare quando non c'è l'IP
//- - - FINE CONFIGURAZIONE - - -


$ranges = array();
$ranges[0]['name'] = "Classe 212";
$ranges[0]['from'] = ip2long('212.97.34.1');
$ranges[0]['to'] = ip2long('212.97.34.128');

$ranges[1]['name'] = "Classe 10.3";
$ranges[1]['from'] = ip2long('10.3.0.1');
$ranges[1]['to'] = ip2long('10.3.0.254');

$ranges[2]['name'] = "Classe 128.65";
$ranges[2]['from'] = ip2long('128.65.127.1');
$ranges[2]['to'] = ip2long('128.65.127.64');

$ranges[3]['name'] = "Classe 10.120";
$ranges[3]['from'] = ip2long('10.120.120.1');
$ranges[3]['to'] = ip2long('10.120.120.254');

define('MAX_IP', 254);
$colspan = 11;



//connection to the database
$dbhandle = mysqli_connect($hostname, $username, $password)
or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysqli_select_db($dbhandle, $dbname)
or die("Could not select $dbname");


if(isset($_POST['submit']))
{
	foreach($_POST as $k => $v)
	{
		if(substr($k, 0, 8) == 'IPNR-ID-')
		{
			$ipnr_id = substr($k, 8) * 1;
			mysqli_query($dbhandle, "UPDATE $table SET description='" .  htmlentities($v, ENT_QUOTES) . "' WHERE ipnr_id=" . $ipnr_id);
		}
	}
}

//for($i = 1; $i <= 254; $i++)
//{
//	$sql = "insert into $table  (ip, descrizione) values ('10.120.120.$i', '')";
//	echo "$sql<br>";
//	mysqli_query($dbhandle, $sql);
//}


//$rs = mysqli_query($dbhandle,"select * from $table");
//foreach($rs as $r)
//{
//	mysqli_query($dbhandle, "update $table set ip2long='".ip2long($r['ip']) ."' where ipnr_id=".$r['ipnr_id']);
//}


$rs = mysqli_query($dbhandle, "SELECT * FROM $table WHERE ip2long >= {$ranges[0]['from']} AND ip2long <= {$ranges[0]['to']}");
while($row = mysqli_fetch_assoc($rs))
{
	$rs0[] = $row;
}

$rs = mysqli_query($dbhandle, "SELECT * FROM $table WHERE ip2long >= {$ranges[1]['from']} AND ip2long <= {$ranges[1]['to']}");
while($row = mysqli_fetch_assoc($rs))
{
	$rs1[] = $row;
}

$rs = mysqli_query($dbhandle, "SELECT * FROM $table WHERE ip2long >= {$ranges[2]['from']} AND ip2long <= {$ranges[2]['to']}");
while($row = mysqli_fetch_assoc($rs))
{
	$rs2[] = $row;
}

$rs = mysqli_query($dbhandle, "SELECT * FROM $table WHERE ip2long >= {$ranges[3]['from']} AND ip2long <= {$ranges[3]['to']}");
while($row = mysqli_fetch_assoc($rs))
{
	$rs3[] = $row;
}
?>

<?php
echo "<form name=\"5736060fda0070.55173567\" id=\"5736060fda0070.55173567\" action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">";
?>

<table align="center">

	<?php
	echo "<thead><tr>";
	echo "<td align=\"center\" colspan=\"$colspan\">";
	echo "<img alt=\"Embedded Image\" width=\"\" height=\"61\"
   src=\"data:image/png;base64,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%3D\" />";
	echo "</td></tr><tr>";
	echo "<th class=\"css-ip-head\">{$ranges[0]['name']}</th><th class=\"css-description-head\">Descrizione</th>";
	echo "<th class='bg-separator'></th>";
	echo "<th class=\"css-ip-head\">{$ranges[1]['name']}</th><th class=\"css-description-head\">Descrizione</th>";
	echo "<th class='bg-separator'></th>";
	echo "<th class=\"css-ip-head\">{$ranges[2]['name']}</th><th class=\"css-description-head\">Descrizione</th>";
	echo "<th class='bg-separator'></th>";
	echo "<th class=\"css-ip-head\">{$ranges[3]['name']}</th><th class=\"css-description-head\">Descrizione</th>";
	echo "</tr></thead><tbody>";

	for($row = 0; $row < MAX_IP; $row++)
	{
		echo "<tr>";
		if(isset($rs0[$row]))
		{
			echo "<td class=\"css-ip\">{$rs0[$row]['ip']}</td><td class=\"css-description\"><input type=\"text\" value=\"{$rs0[$row]['description']}\" name=\"IPNR-ID-{$rs0[$row]['ipnr_id']}\"></td>";
		}
		else
		{
			echo "<td class='css-empty-ip'>$empty_char</td><td class='css-empty-description'>$empty_char</td>";
		}

		echo "<td class='bg-separator'>&nbsp;</td>";

		if(isset($rs1[$row]))
		{
			echo "<td class=\"css-ip\">{$rs1[$row]['ip']}</td><td class=\"css-description\"><input type=\"text\" value=\"{$rs1[$row]['description']}\" name=\"IPNR-ID-{$rs1[$row]['ipnr_id']}\"></td>";
		}
		else
		{
			echo "<td class='css-empty-ip'>$empty_char</td><td class='css-empty-description'>$empty_char</td>";
		}

		echo "<td class='bg-separator'>&nbsp;</td>";

		if(isset($rs2[$row]))
		{
			echo "<td class=\"css-ip\">{$rs2[$row]['ip']}</td><td class=\"css-description\"><input type=\"text\" value=\"{$rs2[$row]['description']}\" name=\"IPNR-ID-{$rs2[$row]['ipnr_id']}\"></td>";
		}
		else
		{
			echo "<td class='css-empty-ip'>$empty_char</td><td class='css-empty-description'>$empty_char</td>";
		}

		echo "<td class='bg-separator'>&nbsp;</td>";

		if(isset($rs3[$row]))
		{
			echo "<td class=\"css-ip\">{$rs3[$row]['ip']}</td><td class=\"css-description\"><input type=\"text\" value=\"{$rs3[$row]['description']}\" name=\"IPNR-ID-{$rs3[$row]['ipnr_id']}\"></td>";
		}
		else
		{
			echo "<td class='css-empty-ip'>$empty_char</td><td class='css-empty-description'>$empty_char</td>";
		}

		echo "</tr>";
	}

	?>

	<tr>
		<td class="css-submit-row" align="center" colspan="<?= $colspan ?>"><input type="submit" name="submit" value="Aggiorna le descrizioni!"></td>
	</tr>
	</tbody>
</table>
</form>
</body>
</html>