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
				<td style="padding: 0px 10px 0 10px"><a href="position.php?new">New Position</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="position.php?view">View Positions</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="../index.php">Back</a></td>
			</tr>
		</table>
		<?php 
			if(isset($_GET['new']))
			{
		?>
				<br>
				<table border="1">
					<form method="post" action="">
						<tr>
							<td colspan="2"><center><b>New Position</b></center></td>
						</tr>
						<tr>
							<td><b>Position: </b></td>
							<td style="padding: 0px 30px 0 30px"><input type="text" name="position" required></td>
						</tr>
						<tr>
							<td colspan="2"><input style="width: 100%" type="submit" name="submit" value="SAVE"></td>
						</tr>
					</form>
				</table>
		<?php 
			}
			else if(isset($_GET['view']))
			{
		?>
				<br>
				<table border="1">
					<tr>
						<td style="padding: 0 15px 0 15px"><center>#</center></td>
						<td style="padding: 0 40px 0 40px"><b><center>Name</center></b></td>
						<td style="padding: 0 60px 0 60px"> </td>
					</tr>
					<tr>
						<?php 
							$stmt = "SELECT * FROM positions";
							$result = $conn->query($stmt);
							$num_rows = 0;
							if($result->num_rows > 0)
							{
								while($row = $result->fetch_assoc())
								{
									$num_rows++;
									$pos_id = $row['id'];
									$pos_name = $row['pos_name'];
						?>
									<td><center><?php echo $num_rows; ?></center></td>
									<td><a href="position.php?action=update&id=<?php echo $pos_id; ?>"><?php echo $pos_name; ?></td>
									<td><center><a href="position.php?action=delete&id=<?php echo $pos_id; ?>">DELETE</a></center></td>
									</tr>
						<?php 
								}
							} 
						?>
					
				</table>
		<?php 
			}
		?>
	</body>
</html>
<?php
if(isset($_POST['submit']))
{
	$position = $_POST['position'];

	$search = "SELECT pos_name FROM positions WHERE pos_name ='$position'";
	$r = $conn->query($search);
	
	if($r->num_rows > 0)
	{
		echo "Position ". $position . " already saved.";
	}
	else
	{
		$stmt = "INSERT INTO positions (pos_name) VALUES ('$position')";
		if($conn->query($stmt) === TRUE)
		{
			echo "Position successfully saved";
		}
	}	
}
$action = isset($_GET['action']) ? $_GET['action'] : NULL;

	if($action == "update")
	{
		$clicked_id = $_GET['id'];
		$value = "SELECT * FROM positions WHERE id='$clicked_id'";
		$r = $conn->query($value);
		
		if($r->num_rows > 0)
		{
			while($row = $r->fetch_assoc())
			{
				$pos_name = $row['pos_name'];
			}
		}
?>
	<br>
	<table border="1">
		<form method="post" action="../crud/pos_update.php?id=<?php echo $clicked_id; ?>">
			<tr>
				<td colspan="2"><center><b>Update Position</b></center></td>
			</tr>
			<tr>
				<td><b>Position: </b></td>
				<td style="padding: 0px 30px 0 30px"><input type="text" value="<?php echo $pos_name; ?>" name="position" required></td>
			</tr>
			<tr>
				<td colspan="2"><input style="width: 100%" type="submit" name="edit" value="SAVE"></td>
			</tr>
		</form>
	</table>
<?php	
}
else if($action == "delete"){
	$clicked_id = $_GET['id'];
	
	$stmt = "DELETE FROM positions WHERE id='$clicked_id'";
	if($conn->query($stmt) === TRUE)
	{
		echo "<br>Successfully deleted";
	}
	$conn->close();
}

?>