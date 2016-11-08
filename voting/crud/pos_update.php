<?php
include '../db_connection/connect.php';
?>

<html>
	<body>
	<center>
		<table border="1">
			<tr>
				<td colspan="3"><b><center>Main Menu</center></b></td>
			</tr>
			<tr>
				<td style="padding: 0px 10px 0 10px"><a href="../pages/position.php?new">New Position</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="../pages/position.php?view">View Positions</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="../index.php">Back</a></td>
			</tr>
		</table>
	</body>
</html>
<?php 
if(isset($_GET['id']))
{
	$clicked_id = $_GET['id'];
	
	$position = $_POST['position'];
		
	$check = "SELECT * FROM positions WHERE pos_name='$position'";
	$result = $conn->query($check);
	if($result->num_rows > 0)
	{
		echo "<br>Position is already registered";
	}
	else
	{
		$stmt = "UPDATE positions SET pos_name ='$position' WHERE id='$clicked_id'";
		if($conn->query($stmt) === TRUE)
		{
			echo "<br>Position has been updated";
		}
	}
	$conn->close();
}
?>