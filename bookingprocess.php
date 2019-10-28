<HTML> 
  <head> 
    <title>Booking Page</title>
	<link rel="stylesheet" type="text/css" href="Cabsonline_Style.css"> 
  </head> 
<?php 
		//Get the passenger details from form
		$Passenger_Name = trim($_POST['pName']);
		$Passenger_Phone = trim($_POST['pPhone']);
		$Unit_No = trim($_POST['UnitNo']);
		$Street_No = trim($_POST['StreetNo']);
		$Street_Name = trim($_POST['StreetName']);
		$Suburb = trim($_POST['Suburb']);
		$Destination_Suburb = trim($_POST['Dsuburb']);
		$Pickup_Date = trim($_POST['pDate']);
		$Pickup_Time = trim($_POST['pTime']);

		//Check if any input is empty except for unit no
		if(empty($Passenger_Name) || empty($Passenger_Phone) || empty($Street_No) || empty($Street_Name)
			 || empty($Suburb) || empty($Destination_Suburb) || empty($Pickup_Date) || empty($Pickup_Time))
		{
			echo "Please provide details for all the fields";
			exit();
		}
		else
		{
			//Call a function to validate the date and time inputs
			DateTime($Pickup_Date,$Pickup_Time);
			//Call a function to validate the pickup time
			if(BookingTime($Pickup_Date,$Pickup_Time))
			{
				CreateBooking($Passenger_Name,$Passenger_Phone,$Unit_No,$Street_No,$Street_Name,$Suburb,$Destination_Suburb,$Pickup_Date,$Pickup_Time);
			}
			else
			{
				echo "Booking can not be maded before the current time.";
				exit();
			}
		}


	
	//This function takes Date and Time provided by customer and checks if the booking time is greater than 60mins from current time or not. And returns true if valid else false
	function BookingTime($Date,$Time)
	{
		//Concatenate the date and time provided
		$dt = $Date.":".$Time;
		//Create a date format using
		$Date = date_create_from_format('j/n/Y:H:i',$dt);
		//Compare the datetime provided with current time + 60mins

		if(date_format($Date,'Y/m/j:H:i') < date('Y/m/j:H:i',strtotime('+60 minute')))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	//This function takes Date and Time as input parameters which are entered by the customers, and validates if they are in correct format or not by checking against regular expression
	function DateTime($Pickup_Date,$Pickup_Time)
	{
		//checking date format as DD/MM/YYYY 
		$Date = "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/(20\d\d)$/";
		//checking time format as HH:MM 
		$Time = "/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
		
		$DateFlag = preg_match($Date,$Pickup_Date);
		$TimeFlag = preg_match($Time,$Pickup_Time);

		if($DateFlag != 1)
		{
			echo "Please enter the valid date in dd/mm/yyyy format";
			exit();
		}
		else
		{
			if($TimeFlag != 1)
			{
				echo "Please enter the valid time in HH:MM format";
				exit();
			}
		}
	}
	
	//This function takes all the parameters required for creating the booking and creates the book record.
	function CreateBooking($Passenger_Name,$Passenger_Phone,$Unit_No,$Street_No,$Street_Name,$Suburb,$Destination_Suburb,$Pickup_Date,$Pickup_Time)
	{
		$dtnow = date('Y-m-j H:i:s');
		$status = "unassigned";
		$Pickup_Date = date_create_from_format('j/n/Y',$Pickup_Date);
		$Pickup_Date = date_format($Pickup_Date,'Y-m-j');
		$DBConnect = @mysqli_connect("cmslamp14.aut.ac.nz", "srm7150","zth970204", "srm7150")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		
		$SQLstring = "INSERT INTO Booking values(null,'".$Passenger_Name."','".$Passenger_Phone."','".$Unit_No."','".$Street_No."','".$Street_Name."','".
				$Suburb."','".$Destination_Suburb."','".$Pickup_Date."','".$Pickup_Time."','".$dtnow."','".$status."')";
		//echo "<p>".$SQLstring."</p>";
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to insert data into booking table.</p>"."<p>Error code ".
		mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		
		$SQLstring = "SELECT MAX(Booking_Number) FROM Booking";		
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to insert data into booking table.</p>"."<p>Error code ".
		mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		$row = mysqli_fetch_row($queryResult);
		$Pickup_Date = date_create_from_format('Y-m-j',$Pickup_Date);
		$Pickup_Date = date_format($Pickup_Date,'j/m/Y');

		echo "<p>Thank you! Your booking reference number is ".$row[0].". You will be picked up in front of your provided address at ".$Pickup_Time." on ".$Pickup_Date.".</p>";
		echo "<br><br><a href=booking.html>Back</a>";
                echo "<br><br><a href=admin.html>Admin Page</a>";
		exit();
	}
?>
</HTML>