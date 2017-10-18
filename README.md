# authentica
*** Authentica v1.0 ***  

Tired of writing the code again and again for authenticating the user of your application? That too for each and every application you build?  
If yes, then you are landed at the right place.  <b>Authentica</b> allows you to reuse the library for authenticating user quickly and fetch the authenticated user's data when successfully authenticated.  

For more such applications & Help:-  
*******************************************  
* Github  :- https://github.com/suraj2334 *  
* Website :- http://suraj-mundalik.info   *   
*******************************************  

<b><h3>Features</h3></b>  
1. Login system supporting encrypted passwords  
2. Fetch the authenticated data if authentication is successful  
3. Support for MD5, SHA1 and PlainText password  


<b><h3>Supported Methods</h3></b>  
1. Authenticate(AUTHENTICATION_DETAILS)  

   This method takes authentication details in an associate array form. If authentication succeeds this method will return an associate array comprising of all the attributes in the table matching the user credentials. Read the following for more detailed view.  

2. getAuthenticationStatus()  

   Returns true if authentication was successful else false.  

<b><h3>How to?</h3></b>  

1. Include the <b>authentica.php</b> in your script  
2. Create a <b>Connection Identifier</b> using:  
   <i>$con = mysql_connect(HOST, USER, PASSWORD)</i>  
3. Create an Object of type <b>Authentica</b> with following parameters (in the specified order) to the constructor:  
   <ul>  
   	<li>Connection Identifier (From Step 2, $con)</li>  
   	<li>Database Name (Where your authentication table resides)</li>  
   	<li>Table Name (For example, <i>users</i> which holds user authentication details (Username, Password, etc..)</li>   
   </ul>  
4. Create an Associate Array of authentication details  
   $auth_data = array(	"Username" => "suraj",  
						"Password" => "suraj",  
						"PASSWORD_ENCRYPTED" => "md5"  
			     	  );  
   Where,  
   "Username" is the Column Name "suraj" is the value to be verified,  
   "Password" is the Column Name "suraj" is the value to be verified,  
   "PASSWORD_ENCRYPTED" specifies whether the Password is PlainText or encrpyted using either md5 or sha1  
   <b>Note: </b><i>PASSWORD_ENCRYPTED</i> must be specified blank if none of md5 or sha1 is used ("PASSWORD_ENCRYPTED" => "")  
5. Authenticate the user credentials by calling the <b>Authenticate()</b> method by passing the $auth_data as a parameter, created in Step 4  

6. If successful, the method will return the columns and its values specific to the given credentials in the form of an associate array or else empty on failure.  

<b><h1>Examples</h1></b>  

Database   : test  
Table 	   : users  

<table>  
	<thead>  
		<th>First_Name</th>  
		<th>Last_Name</th>  
		<th>Mobile</th>  
		<th>Username</th>  
		<th>Password</th>  
	</thead>  
	<tbody>  
		<tr>  
			<td>Mohan</td>  
			<td>Shinde</td>  
			<td>7896541230</td>  
			<td>mohan</td>  
			<td>e9206237def4b4ef46fd933ed0f5a08f</td>  
		</tr>  
		<tr>  
			<td>Suraj</td>  
			<td>Mundalik</td>  
			<td>9876543210</td>  
			<td>suraj</td>  
			<td>4dd49f4f84e4d6945e3bc6d14812004e</td>  
		</tr>  
		<tr>  
			<td>Tushar</td>  
			<td>Jachak</td>  
			<td>8796541230</td>  
			<td>tushar</td>  
			<td>df7c905d9ffebe7cda405cf1c82a3add</td>  
		</tr>  
	</tbody>  
</table>      

<b><h3>Authenticate User Credentials</h3></b>  
```  
<?php  
	require('authentica.php');  
	$con = @mysql_connect("localhost", "root", "");  
	$auth = new Authentica($con, "test", "users");  
	$auth_data = array(	"Username" => "suraj",  
						"Password" => "suraj",  
						"PASSWORD_ENCRYPTED" => "md5"  
			     	  );  
	$login_data = $auth->Authenticate($auth_data);  
	if(empty($login_data)){  
		echo "Login Failed.";  
	}  
	else{  
		echo "Login Successful.";  
	}  
?>    
```  
Above code will output <i>Login Successful.</i>, as Username = "suraj" & Password = "suraj" are valid entries in the users table. Note that we have stored the passwords using md5 so we have specified the PASSWORD_ENCRYPTED attribute as md5 in the $auth_data to encrypt the password "suraj" to md5 while verifying. Output will be:  
```  
Login Successful.  
```    

<b><h3>Authenticate User Credentials & Fetch the Data</h3></b>  
```  
<?php  
	require('authentica.php');  
	$con = @mysql_connect("localhost", "root", "");  
	$auth = new Authentica($con, "test", "users");  
	$auth_data = array(	"Username" => "suraj",  
						"Password" => "suraj",  
						"PASSWORD_ENCRYPTED" => "md5"  
			     	  );  
	$login_data = $auth->Authenticate($auth_data);    
	if(empty($login_data)){  
		echo "Login Failed";  
	}  
	else{  
		echo "Login Successful.<br><br>";  
		foreach($login_data as $attrib => $value){  
			echo $attrib." = ".$value."<br>";  
		}  
	}  
?>    
```  

Same as previous, just we are accessing the data returned by Authenticate() method. Output will be:  
```  
Login Successful.  
  
First_Name = Suraj  
Last_Name = Mundalik  
Mobile = 9876543210  
Username = suraj  
Password = 4dd49f4f84e4d6945e3bc6d14812004e  
```  

<b><h3>The $auth_status Property</h3></b>  
```  
<?php  
	require('authentica.php');  
	$con = @mysql_connect("localhost", "root", "");  
	$auth = new Authentica($con, "test", "users");  
	$auth_data = array("Username" => "spiderman",  
					"Password" => "marvels",  
					"PASSWORD_ENCRYPTED" => "md5"  
			       );  
	$login_data = $auth->Authenticate($auth_data);  
	if($auth->getAuthenticationStatus()){  
		echo "Login Successful.";  
	}
	else{
		echo "Login Failed";  
	}  
?>  
```  

You can simply check whether authentication is successful or not using the getAuthenticationStatus() method returns true on success else false. Here it will return false as there is no user with spiderman as Username and marvels as Password in the users table. So output will be:  
  
```  
Login Failed  
```  

<b><h3>Errors</h3></b>  
The library provides sufficient error handling for invalid parameters passed to its methods. If the method fails  it will return the error <b><i>Invalid or Empty ***.</b></i>  
Where *** can be:-  
1. CONNECTION_IDENTIFIER (If $con is not a valid connection identifier)  
2. DATABASE_NAME (If Database_Name parameter is empty or invalid)  
3. TABLE_NAME (If Table_Name parameter is empty or invalid)  

<b><h1>Do contact if there are any queries!</h1></b>  

