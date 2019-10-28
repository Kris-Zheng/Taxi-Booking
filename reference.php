<HTML> 
  <head> 
    <title></title> 
  </head> 
  <body>
  </body> 

<?php 	                
                        $referenceNo = $_POST['bookingNo'];
			//If reference number is provided update the status of the reference number
			$DBConnect = @mysqli_connect("cmslamp14.aut.ac.nz", "srm7150","zth970204", "srm7150")
			Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
			mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

                        $SQLstring = "SELECT COUNT(*) FROM Booking where Booking_Number ='".$referenceNo."'";
			$queryResult = @mysqli_query($DBConnect, $SQLstring)
			Or die ("<p>Unable to query the Booking table.</p>"."<p>Error code ".
			mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
			$row = mysqli_fetch_row($queryResult);
			if($row[0] > 0)
			{
				$SQLstring = "UPDATE Booking SET Booking_Status='assigned' where Booking_Number=".$referenceNo;
				$queryResult = @mysqli_query($DBConnect, $SQLstring)
				Or die ("<p>Unable to update the Booking table.</p>"."<p>Error code ".
				mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
				echo "Reference number: <b>" . $referenceNo . "</b> has been assigned";
			}
			else
			{
				echo "Please provide valid reference number<br><br>";
				exit();
			} 		
?>
</HTML>