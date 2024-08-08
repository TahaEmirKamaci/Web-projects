<?php ob_start();

	require("ilkel_site_giris\ilkel_site.html");
	
	if($_COOKIE["Username"] == "admin" && $_COOKIE["Password"] == md5("123"))
		header("Location: welcome.php");
	
	$islem="";
	if(isset($_GET["islem"])) {
		
		$islem = $_GET["islem"];	
		if($islem == "login"){
			$baglan = mysqli_connect("localhost", "root", "", "site_kayit");
			//mysqli_set_charset($baglan, "utf8");
			
			$username = $_POST["username"];
			$password = $_POST["password"];
			
			$query_sql = "select * from kayit where username ='$username'";
			
			$query_result = mysqli_num_rows(mysqli_query($baglan, $query_sql));
			if($query_result < 1) {
				
				$insert_sql = "insert into kayit(username, password) values('$username', md5('$password'))";
				mysqli_query($baglan, $insert_sql);

				mysqli_close($baglan);
				
				setcookie('Username',$username,time()+100);
				setcookie('Password',md5($password),time()+100);
				
				header("Location: welcome.php");
			}
		}
	}
	
ob_end_flush();



	$baglanti = mysqli_connect("localhost", "root","", "site_kayit");
	mysqli_set_charset($baglanti,"utf8");
	
	$query_sql = "select username, password from kayit where username = 'admin' and
	password = '123'";
		
	$query_result = mysqli_query($baglanti, $query_sql);
	
	if (!$query_result){
		
		$islem="";
		if(isset($_GET["islem"])) {
			echo "here";
			$islem = $_GET["islem"];
		
			if($islem == "login") {
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				echo "Username: " .$_POST["username"]."<br/>";
				echo "Password: " .$_POST["password"]."<br/>";
				
				$insert_sql = "insert into kayit(username, password) values($username, $password)";
				mysqli_query($baglanti,$insert_sql);

				setcookie('Username',$username,time()+100);
				setcookie('Password',md5($password),time()+100);	

				//header("Location: welcome.php");
			}	
		}
	}
	
	mysqli_close($baglanti);
	
	$islem="";
	
	if(isset($_GET["islem"])) {
		
		$islem = $_GET["islem"];
		
		if($islem == "login") {
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			echo "Username: " .$_POST["username"]."<br/>";
			echo "Password: " .$_POST["password"]."<br/>";
			
			setcookie('Username',$username,time()+100);
			setcookie('Password',md5($password),time()+100);	

			header("Location: welcome.php");
		}
	}
	?>