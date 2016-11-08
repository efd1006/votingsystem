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
				<td style="padding: 0px 10px 0 10px"><a href="candidates.php?new">New Candidate</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="candidates.php?view">View Candidates</a></td>
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
							<td style="padding: 0px 55px 0 55px"><center><b>Name</b></center></td>
							<td><input type="text" name="name" required></td>
						</tr>
						<tr>
							<td><center><b>Position</b></center></td>
							<td>
								<select name="position" required style="width: 100%">
								<?php 
									$stmt = "SELECT * FROM positions";
									$result = $conn->query($stmt);
									if($result->num_rows > 0)
									{
										while($row = $result->fetch_assoc())
										{
											$pos_id = $row['id'];
											$pos_name = $row['pos_name'];
								?>
									<option value="<?php echo $pos_id; ?>"><?php echo $pos_name; ?></option>
								<?php 
										}
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input style="width: 100%" type="submit" name="submit" value="SAVE"></td>	
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
						<td colspan="2"><center><b>Candidate List</b></center></td>
					</tr>
					<tr>
						<td style="padding: 0px 55px 0 55px"><center><b>Name</b></center></td>
						<td style="padding: 0px 50px 0 50px"><center><b>Position</b></center></td>
					</tr>
					<tr>
						<?php 
							$stmt = "SELECT * FROM candidates";
							$result = $conn->query($stmt);
							if($result->num_rows > 0)
							{
								while($row = $result->fetch_assoc())
								{
									$candidate_name = $row['candidate_name'];
									$pos_id = $row['pos_id'];
									
									$query = "SELECT * FROM positions WHERE id='$pos_id'";
									$res = $conn->query($query);
									if($res->num_rows > 0)
									{
										while($row = $res->fetch_assoc())
										{
											$pos_name = $row['pos_name'];
						?>
							<td><center><?php echo $candidate_name; ?></center></td>
							<td><center><?php echo $pos_name; ?></center></td>
						</tr>
						<?php 
										}
									}
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
	$name = $_POST['name'];
	$position_id = $_POST['position'];
	
	$check = "SELECT * FROM candidates WHERE candidate_name = '$name'";
	$r = $conn->query($check);
	if($r->num_rows > 0)
	{
		echo "<br>Candidate has been already registered.";
	}
	else
	{
		$stmt = "INSERT INTO candidates (candidate_name, pos_id) VALUES ('$name','$position_id')";
		if($conn->query($stmt) === TRUE)
		{
			echo "Candidate has been registered.";
		}
	}
}
?>