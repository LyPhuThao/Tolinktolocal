<?php 
require_once 'Includes/autoloader.php';
			
	//if (isset($_POST['submit'])){
		// process tokens
	/*	$sessToken = $_SESSION['token'] ?? 1;
		$postToken = $_POST['token'] ?? 2;
	// invalidate token stored in session
		//unset($_SESSION['token']);
		if ($sessToken != $postToken) {
			$_SESSION['message'] = 'ERROR: token mismatch';
			} else {
				$_SESSION['message'] = 'SUCCESS: form processed';

		//if (isset($_FILES['image'])) {	*/	
			
	if (filter_has_var(INPUT_POST, 'submit')) {
		$required = array('image[]','area', 'district', 'address', 'transaction', 'price',
			'contact_time', 'phone', 'cusname', 'email', 'description');
		//$val = new Validator($required);
		$val->isFullURL('image[]');
		$val->isInt('area',null,500);
		$val->checkTextLength('district', 1, 20);
		$val->checkTextLength('address', 5, 20);
		$val->isBool('transaction');
		$val->isInt('price');
		$val->checkTextLength('contact_time', 5, 10);
		$val->isInt('phone', 10, 10);
		$val->checkTextLength ('cusname', 2, 20);
		$val->removeTags('cusname');
		$val->isEmail('email');
		$val->checkTextLength('description', 10, 150);
				//$val->useEntities('description');
		$val->removeTags('description');
		$errors = $val->_errors;
				// nếu qua khâu validate và filter mà dữ liệu nhập không có vấn đề gì -> upload và chèn dữ lệu vào database.

			if(empty($errors)) 
				{	
					try 
						{ 	//$con = new Dbh;
							//$conn = $con->connect();
							
							//$q = mysqli_stmt_init($conn);

							//$loader = new Upload('C:/xampp/htdocs/workspace/IMAGE');
							$loader -> upload('image');
							$names = $loader->getFileNames();											
								if ($names){ 	require ('connectmysql.php');
										for($i=0;$i<count($names);$i++)	{					
												$query = "INSERT INTO product_declared(id,img,area,dist,road,trans_type,price,contact_time, phone, fname, email, Descript, date)";
												$query.= "VALUES";
												$query.= "(' ',?,?,?,?,?,?,?,?,?,?,?,NOW())";	
												
												$q = mysqli_stmt_init($conn);
												mysqli_stmt_prepare($q, $query);
// use prepared statement to insure that only text is inserted
// bind fields to SQL Statement
										//mysqli_stmt_bind_param($q,'sssssssssss',$names,$area,$dist,$road,$transact,$price,$contacttime,$phone,$name,$email,$descript);
												mysqli_stmt_bind_param($q,'sssssssssss',$names, $_POST['area'],$_POST['district'], $_POST['road'], $_POST['transaction'], $_POST['price'], $_POST['contact_time'],
                                       			 $_POST['phone'], $_POST['cusname'],$_POST['email'],$_POST['description']);
// execute query
												$execute = mysqli_stmt_execute($q);
											}
												if (mysqli_stmt_affected_rows($q) >0) {			
// Good
												header ("location: thankyou.html"); 
				
												}									
												else {echo " No data inserted!";}
												$result = $loader -> getMessages();	
					
				echo '<pre>';
				print_r($names);
				echo '</pre>'; 			
									}
								}
													
	
										  catch (Throwable $t) 
								 	{
										echo $t -> getMessage ();
									}
					}
			
				}
			
			echo '<pre>';
				print_r($_FILES);
				print_r($val->_filterArgs);
				print_r($val->_errors);				
				echo '</pre>'; 
//$this-> messages[] = $result;
				
				//$up = $loader -> checkFile($_FILES) -> checkSize($_FILES) ->checkType -> moveFile ($_FILES);
				// $loader -> movefile ($file);
				//trang 248: thử với hai kiểu chạy có false và không có false ở cuối $loader ->upload
	//$loader -> upload ('image', $max,['application/pdf'], false); */
			
				
	/* By changing the value of $max (remember to change that of the form html) and passing it as the second argument to
upload(), you affect both MAX_FILE_SIZE in the form’s hidden field and the
maximum value stored inside the class. */
?>
