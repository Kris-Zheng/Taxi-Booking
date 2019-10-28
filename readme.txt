//create Database if not exist
CREATE TABLE `Booking` (
	`Booking_Number` INT(10) NOT NULL AUTO_INCREMENT,
	`Passenger_Name` VARCHAR(30) NOT NULL,
	`Passenger_Phone` VARCHAR(15) NOT NULL,
	`Unit_Number` VARCHAR(10) NULL DEFAULT NULL,
	`Street_Number` VARCHAR(10) NOT NULL,
	`Street_Name` VARCHAR(50) NOT NULL,
	`Suburb` VARCHAR(50) NOT NULL,
	`Destination_Suburb` VARCHAR(50) NOT NULL,
	`Pickup_Date` DATE NOT NULL,
	`Pickup_Time` TIME NOT NULL,
	`Booking_DT` DATETIME NOT NULL,
	`Booking_status` VARCHAR(30) NOT NULL,
	PRIMARY KEY (`Booking_Number`)
)

1.Go to booking.html to create taxi booking request, the booking information will dispaly on the same page and save into database automaticlly. 
  Please use the code above to create the database if it not exists.
2.Click the link to go to admin.html. if you click on 'List All', it will display all booking requests within 2 hours from the pick_up time.
  Then you can change booking status from "unassign" to "assign" by 'submit' button.


1.xhr.js
2.Style.css
3.reference.php
4.reference.js
5.readme.txt
6.download.jpg
7.bookingprocess.php
8.booking.js
9.booking.html
10.adminprocess.php
11.admin.js
12.admin.html