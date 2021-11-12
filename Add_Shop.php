     <!-- Bootstrap --> 
     <link rel="stylesheet" type="text/css" href="style.css"/>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	    
	<?php
        include_once("connection.php");
		if(isset($_POST["btnAdd"]))
		{
			$id = $_POST["txtID"];
			$name = $_POST["txtName"];
            $address = $_POST["txtAddress"];
			$phone = $_POST["txtPhone"];
            $email = $_POST["txtEmail"];
			$err="";
			if($id==""){
				$err .="<li>Enter Shop ID, please</li>";
			}
			else if($name==""){
				$err .="<li>Enter Shop Name, please</li>";
			}
            else if($address==""){
				$err .="<li>Enter Shop Address, please</li>";
			}
			else if($phone==""){
				$err .="<li>Enter Shop Phone, please</li>";
			}
            else if($email==""){
				$err .="<li>Enter Shop Email, please</li>";
			}
			if($err!="")
			{
				echo "<ul>$err</ul>";
			}
			else{
                $id = htmlspecialchars(pg_real_escape_string($conn, $id));
				$name = htmlspecialchars(pg_real_escape_string($conn, $name));
                $id = htmlspecialchars(pg_real_escape_string($conn, $address));
				$name = htmlspecialchars(pg_real_escape_string($conn, $phone));
                $id = htmlspecialchars(pg_real_escape_string($conn, $email));
				$sq = "SELECT * from shop where shop_id='$id' or cat_name='$name'";
				$result = pg_query($conn,$sq);
				if(pg_num_rows($result)==0)
				{
					pg_query($conn, "INSERT INTO shop (cat_id, cat_name, address, phone, email	) VALUES ('$id','$name','$address','$phone','$email)");
					echo '<meta http-equiv="refresh" content="0;URL=?page=shop_management" />';
				}
				else
				{
					echo "<li>Duplicate Shop ID or Name</li>";
				}
			}
		}
	?>

<div class="container">
	<h2>Adding Shop</h2>
			 	<form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
				 <div class="form-group">
						    <label for="txtTen" class="col-sm-2 control-label">Shop ID(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtID" id="txtID" class="form-control" placeholder="Category ID" value='<?php echo isset($_POST["txtID"])?($_POST["txtID"]):"";?>'>
							</div>
					</div>	
				 <div class="form-group">
						    <label for="txtTen" class="col-sm-2 control-label">Shop Name(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Cateogry Name" value='<?php echo isset($_POST["txtName"])?($_POST["txtName"]):"";?>'>
							</div>
					</div>
                    <div class="form-group">
						    <label for="txtTen" class="col-sm-2 control-label">Address(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Shop Address" value='<?php echo isset($_POST["txtName"])?($_POST["txtName"]):"";?>'>
							</div>
					</div>
                    <div class="form-group">
						    <label for="txtTen" class="col-sm-2 control-label">Phone(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Shop Phone" value='<?php echo isset($_POST["txtName"])?($_POST["txtName"]):"";?>'>
							</div>
					</div>
                    <div class="form-group">
						    <label for="txtTen" class="col-sm-2 control-label">Email(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Shop Email" value='<?php echo isset($_POST["txtName"])?($_POST["txtName"]):"";?>'>
							</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						      <input type="submit"  class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new"/>
                              <input type="button" class="btn btn-primary" name="btnIgnore"  id="btnIgnore" value="Ignore" onclick="window.location='?page=category_management'" />
                              	
						</div>
					</div>
				</form>
	</div>