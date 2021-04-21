<?php if (isset($super)){ ?>
     <form action="" method="post">
    <table class="edit" width="300" border="0">
  <tr>
    <td width="100">Name :</td>
    <td width="200"><input name="EmployeeName" type="text" value=""/>
			<form id="ed_buttens" action="" method="post">

            </form>
		</td>
  </tr>
  <tr>
    <td>Job Title:</td>
    <td><input name="JobTitle" type="text" value=""/></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input name="Phone" type="text" value=""/></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td><input name="Email" type="text" value=""/></td>
  </tr>
  <tr>
    <td>Skype:</td>
    <td><input name="Skype" type="text" value=""/></td>
    </tr>
</table>
<a href="index.php?neste=nu"><input name="nexst_step" type="submit" value="nexst_step" /></a>
</form>
<?php } 

?>