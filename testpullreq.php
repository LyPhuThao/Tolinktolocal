<?php
	// Connect to the db.
/*require('connectmysql.php');
	//Define some global variables
if (isset($_POST['submit']))*/
	{
$out= " ";
$file = $_FILES['image'];
$fileName = $file['name'];
$tmpName = $file ['tmp_name'];
$fileType = $file['type'];
define ('UPLOADPATH', 'IMAGE/');
$target = UPLOADPATH.$fileName;
		//create variables to later regulate the file type to be uploaded

// To display on the screen whether there is anything uploaded into array
if(isset($_FILES['image'])){
	
			$out = "Temp Name: $tmpName <br>";
			echo '<pre>';
			var_dump($_POST);
			var_dump($_FILES);
			echo '</pre>';
}

//Enable error reporting.

	error_reporting(E_ALL);
	ini_set("display_errors", 1);
// main codes for uploading:*/

		// only accept values from same site via post
	//if (isset($_POST['submit']))
	//{
		// Check the file type
					$fileExt = explode ('.', $fileName);
					$fileActualExt = strtolower(end($fileExt));
					$allowed = array ('jpg','jpeg', 'png', 'pdf');
													
		try {
				$errors = array(); // Initialize an error array.
	//require('connectmysql2.php'); // Connect to the db.
	// check picture
				$full_picture = filter_var($fileName, FILTER_SANITIZE_URL);
					if ((empty($full_picture)) || (strlen($full_picture) > 45)){
// optional
						$full_picture = NULL;
						}
// check area
				$area = filter_var($_POST['area'], FILTER_SANITIZE_STRING);
					if (empty($area)){
						$error[] = 'You forgot to enter the area (m2).';
						}	
//Check district
				//$dist= filter_var($_POST['district'], FILTER_SANITIZE_STRING);
					if (empty($dist)){
						$error[] = 'You forgot to enter the district.';
						} 
// Check address
						
					$road = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
					if (empty($road)){
						$error[] = 'You forgot to enter the location.';
						}	
// Check for transaction type
				$transact = filter_var($_POST['transaction'], FILTER_SANITIZE_STRING);
					if (empty($transact)|| ($transact == '- Select -')) {
						$error[] = 'You forgot to enter the location.';
						}
// Check price
					$price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
					if (empty($price)){
						$error[] = 'You forgot to enter the price. (VND)';
						}	
// Check time
					$contacttime = filter_var($_POST['contact_time'], FILTER_SANITIZE_STRING);
					if (empty($contacttime)){
						$error[] = 'You forgot to enter the contact time';
						}	
// Check phone
					$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
					if (empty($phone)){
						$error[] = 'You forgot to enter the phone number';
						}	
// Name
					$name = filter_var($_POST['cusname'], FILTER_SANITIZE_STRING);
					if (empty($cusname)){
						$error[] = 'You forgot to enter your name.';
						}		
// email
					$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
					if (empty($email)){
						$error[] = 'You forgot to enter your email.';
						}							
// description
					$descript = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
					if (empty($descript)){
						$error[] = 'Please provide some description of the real estate.';
						}	

					if (in_array($fileActualExt, $allowed)){
								if (empty($errors))
										{ 		
									
												if (move_uploaded_file($tmpName,$target)) {
												$query = "INSERT INTO product_declared(id,img,area,dist,road,trans_type,price,contact_time, phone, fname, email, Descript, date)";
												$query.= "VALUES";
												$query.= "(' ',?,?,?,?,?,?,?,?,?,?,?,NOW())";	
												$q = mysqli_stmt_init($conn);
												mysqli_stmt_prepare($q, $query);
	// use prepared statement to insure that only text is inserted
// bind fields to SQL Statement
												mysqli_stmt_bind_param($q,'sssssssssss',$full_picture,$area,$dist,$road,$transact,$price,$contacttime,$phone,$name,$email,$descript);
// execute query
												mysqli_stmt_execute($q);
												}
													if (mysqli_stmt_affected_rows($q) == 1) {			
// Good
													header ("location: thankyou.html"); 
						
													}
													
												
										
										}	
								
							else { // If it did not run OK.
// Message:
									$errorstring = 'System Error ';
									$errorstring .= 'The house could not be added due to a system error. ';
									$errorstring .= 'We apologize for any inconvenience.'; 
							}
					} 
					else {
								echo 'Your file have to be jpg,jpeg, png,pdf';}
// Debugging message:
// echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
			 // End of if ($r) IF.
			 //Clear the form data
				//$file= " ";
				//$fileName = " ";
				//$tmpName = " ";
				//$transact = " ";
						mysqli_close($conn); // Close the database connection.
						exit();
			}						
			catch(Exception $e) // We finally handle any problems here                
				{ // print "An Exception occurred. Message: " . $e->getMessage();
					print "The system is busy please try later";
				}
   
					catch(Error $e)
				{
     // print "An Error occurred. Message: " . $e->getMessage();
				print "The system is busy please try later";
				}
	}

	// Confirm success with the user (Headfist page 251 for more)
	echo '<p> Thanks for adding your information! </p>';
	// delete the tmpName to avoid disclosure of information
	@unlink ($tmpName);
	
  
   /* SO FAR IT WORKS, BUT FOR SOME FILES WITH LONG NAME, IT DOES NOT INSERT THE NAME INTO THE TABLE THOUGH PICTURE GAINED? 
   MAYBE BECAUSE THE LIMIT OF THE STRLEN ABOVE (45 characters) & VARCHAR OF THE TABLE CORRESPONDING COLUMN?- YES, IT IS THE CASE. ALSO, IT LOOKS LIKE THE BROWSER (GOOGLE ) ALSO LIMIT THE NAME LENGTH FOR FILE UPLOADING
   23/09/2019 */
   //CHECK TO SEE WHAT WILL APPEAR IF UPLOAD IS CLICKED WITHOUT ANY FILE ATTACHED
   // clear the form data P269 Headfirst
   // CÀI TGIAN THI HÀNH CODE--> ini_set(max_execution_time, "240") (TRANG 25 CUỐN WICKED COOL PHP)
   	
	 print_r($_FILES['image']);
   ?>
