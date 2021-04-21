
<?php
if (isset($super)){
if(isset($_SESSION["logetin"])){ // den her spørger om vi har en session der er aktiv der heder $_SESSION["logetin"] og hvis vi har det kan vi se nedenstående 
	
					
						 ?>
						 <!-- de neste 4 linier er en form med en logud knap --><h3></h3>
					 
				
					<input name="logout" type="submit" value="log out" />
                    <input name="Add_Employee" type="submit" value="Add_Employee" />
				
					
					
						<?php
						
} // $_SESSION["logetin"] slutter 
else{ // else her spørger om hvad den skal gøre hvis vi ikke har en aktiv $_SESSION["logetin"]
if(isset($_POST["login"])) // den her spørger om der er tryket på den knap der har navnet login som er vores login knap 
 {
				// de næste to variabler er vores brugernanvn og pass som vi skriver i den form som er længere nede på arket
				// de er md5 krypteret hvilket man skal huske når man sætter dem ind i databasen for de krypterer det du skriver i login felterne
				// til andre tegn som så skal passe med dem du har i din database 
					$login = md5($_POST["user"]);
					$pass =  md5($_POST["pass"]);					
	

				// den sql der er på linge 48 går ud og tæller hvor mange gange brugeren findes i databasen 
			$sql = "SELECT *, (SELECT count(username) FROM ab_employeeadmin WHERE username = '$login' and pass = '$pass') as antal FROM ab_employeeadmin"; // finder ud af om brugeren er i databasen  
					$result = mysql_query ($sql) or die (mysql_error());    
				
				while ($row = mysql_fetch_assoc ($result))// følgende skal ske 1 gang per celle du har i din database
				{
					$antal = $row["antal"] ; // laver en variabel der fortæller hvor mange gange en bruger optræder i databasen 
					
				}
					if($antal == 1){ // spørg om brugeren optræder 1 gang 
						
				
						// hvis brugeren optræder 1 gang sætter den en $_SESSION["logetin"] 
						$_SESSION["logetin"] = $login ;
						header("location:" . $_SERVER['HTTP_REFERER']); // redirecter siden tilbage til sig selv 
						
				}else{ // det her under sker hvis man taster forkert brugernavn eller password
							
								?>
							brugernavn eller password er forkert <br/>
				
				<input name="user" type="text" value=""/>
				<input name="pass" type="password" value="" />
				<input name="login" type="submit" value="login" />
				
								<?php }
 }else{ // det her under skal ske hvis man ikke har gjort noget på siden endnu, altså være det første man ser 
							
							

				?>
		
				<input name="user" type="text" value=""/>
				<input name="pass" type="password" value="" />
				<input name="login" type="submit" value="login" />
			
				<?php
				}
				
				 }
				
					
					

}

?>