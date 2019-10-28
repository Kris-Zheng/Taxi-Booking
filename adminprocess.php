<HTML> 
  <head> 
    <title></title> 
  </head> 
  <body>
  </body> 

<?php 	                
			//If reference number is provided update the status of the reference number
			$DBConnect = @mysqli_connect("cmslamp14.aut.ac.nz", "srm7150", "zth970204", "srm7150")
			Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
			mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
	               		 
		
			ListBookings();

	function ListBookings()
	{
		//Build the where clause since it requires date formating
		$TodayDate = date('Y-n-j');
		$StartTime = date('H:i:s');
		$EndTime = date('H:i:s',strtotime('+120 minute'));
		$dateClause = " AND Pickup_Date = '$TodayDate' AND Pickup_Time < '$EndTime' AND Pickup_Time > '$StartTime'"; 
		$TableName = "Booking";
		$DBConnect = @mysqli_connect("cmslamp14.aut.ac.nz", "srm7150", "zth970204", "srm7150")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		$SQLstring = "SELECT Booking_Number,Passenger_Name,Passenger_Phone,Unit_Number,Street_Number,
				Street_Name,Suburb,Destination_Suburb,Pickup_Date,Pickup_Time 
				FROM Booking  WHERE Booking_Status = 'unassigned'".$dateClause;
		//echo $SQLstring; 
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to query the $TableName table.</p>"."<p>Error code ".
		mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		$row = mysqli_fetch_row($queryResult);
		//Check if there are any bookings 
		if(count($row) > 0)
		{
			echo "<table width='100%' border='1'>";
			echo "<th>Reference #</th><th>Passenger name</th><th>Passenger contact phone</th><th>Pick-up address</th>
			<th>Destination suburb</th><th>Pick-up time</th>";
			while ($row) 
			{	 
			
				echo "<tr><td>{$row[0]}</td>"; 
				echo "<td>{$row[1]}</td>"; 
				echo "<td>{$row[2]}</td>";
			       
				if(empty($row[3]))
					$address = $row[4]." ".$row[5].",".$row[6];
				else
					$address = $row[3]."/".$row[4]." ".$row[5].",".$row[6];
				echo "<td>$address</td>";
				echo "<td>{$row[7]}</td>";
				$dt = $row[8].":".$row[9];
				$dt = date_create_from_format('Y-n-j:H:i:s',$dt);
				$dt = date_format($dt,'d M H:i');
				echo "<td> $dt </td></tr>"; 
				$row = mysqli_fetch_row($queryResult);
			}
			echo "</table><br/><br/>";		
		}
		else
		{
			echo "There are no pickups within 2 hours from now.<br><br>";
		}
		mysqli_close($DBConnect);
	}
?>

</HTML>