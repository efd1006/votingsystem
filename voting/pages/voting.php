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
				<td style="padding: 0px 20px 0 20px"><a href="voting.php?vote">Vote</a></td>
				<td style="padding: 0px 30px 0 30px"><a href="voting.php?view">View Votes</a></td>
				<td style="padding: 0px 10px 0 10px"><a href="../index.php">Back</a></td>
			</tr>
		</table>
		<?php 
			if(isset($_GET['vote']))
			{
		?>
				<br>
				<table border="1">
					<form method="post" action="">
						<tr>
							<td style="padding: 0px 20px 0 10px">Voter Name</td>
							<td><input type="text" name="voter_name" required></td>
						</tr>
						<tr>
							<td style="padding: 0px 20px 0 10px">Candidate</td>
							<td>
								<select name="candidate" required style="width: 100%">
									<?php 
										$stmt = "SELECT * FROM candidates";
										$result = $conn->query($stmt);
										if($result->num_rows >0)
										{
											while($row = $result->fetch_assoc())
											{
												$candidate_id = $row['id'];
												$candidate_name = $row['candidate_name'];
												$pos_id = $row['pos_id'];
												
												$q = "SELECT * FROM positions WHERE id='$pos_id'";
												$resu = $conn->query($q);
												if($resu->num_rows >0)
												{
													while($row = $resu->fetch_assoc())
													{
														$pos_name = $row['pos_name'];
													}
												}
									?>
										<option value="<?php echo $candidate_id; ?>"><?php echo $candidate_name ." - ". $pos_name ; ?></option>
									<?php 
											}
										}
									?>
								</select>
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
						<td style="padding: 0px 25px 0 25px"><center><b>Candidate</b></center></td>
						<td><center><b>Position</b></center></td>
						<td><center><b>No of votes</b></center></td>
					</tr>
					<tr>
						<?php 
							$stmt = "SELECT * FROM candidates";
							$result = $conn->query($stmt);
							if($result->num_rows > 0)
							{
								while($row = $result->fetch_assoc())
								{
									$candidate_id = $row['id'];
									$candidate_name = $row['candidate_name'];
									$pos_id = $row['pos_id'];
									
									$count_vote= "SELECT candidate_id FROM votes WHERE candidate_id = '$candidate_id'";
									$r = $conn->query($count_vote);
									$vote_count = $r->num_rows;
									
									$position_query = "SELECT * FROM positions WHERE id='$pos_id'";
									$res = $conn->query($position_query);
									if($res->num_rows > 0)
									{
										while($row = $res->fetch_assoc())
										{
											$pos_name = $row['pos_name'];
						?>
							<td><center><?php echo $candidate_name; ?></center></td>
							<td><center><?php echo $pos_name; ?></center></td>
							<td><center><?php echo $vote_count; ?></center></td>
							</tr>
						<?php 
										}
									}
								}
							}
						?>
		<?php 
			}
		?>
		
	</body>
</html>

<?php 
if(isset($_POST['submit']))
{
	$voter_name = $_POST['voter_name'];
	$candidate_id = $_POST['candidate'];
	
	$check = "SELECT * FROM votes WHERE voter_name='$voter_name'";
	$result = $conn->query($check);
	if($result->num_rows >0)
	{
		echo "<br>".$voter_name." has already voted.";
	}
	else
	{
		$stmt = "INSERT INTO votes (voter_name, candidate_id) VALUES ('$voter_name','$candidate_id')";
		if($conn->query($stmt) === TRUE)
		{
			echo "<br>Vote has been saved.";
		}
	}
}
?>