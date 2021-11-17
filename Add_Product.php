<?php
	require('requirelogin.php');
	include_once("connection.php");
	function bind_Category_List($conn) {
		$sqlstring = "SELECT cat_id, cat_name from category";
		$result = pg_query($conn, $sqlstring);
		echo "<SELECT name='CategoryList' class='form-control'>
			<option value='0'>Choose category</option>";
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
				echo "<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
			}
		echo "</select>";	
		}

		function bind_Shop_List($conn) {
			$sqlstring = "SELECT shop_id, shop_name from public.store";
			$result = pg_query($conn, $sqlstring);
			echo "<SELECT name='StoreList' class='form-control'>
				<option value='0'>Choose store</option>";
				while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
					echo "<option value='".$row['shop_id']."'>".$row['shop_name']."</option>";
				}
			echo "</select>";	
			}

		if(isset($_POST["btnAdd"]))
		{
			$id = $_POST["txtID"];
			$id = htmlspecialchars(pg_escape_string($conn, $id));
		    $proname = $_POST["txtName"];
			$proname = htmlspecialchars(pg_escape_string($conn, $proname));
		    $short = $_POST["txtShort"];
			$short = htmlspecialchars(pg_escape_string($conn, $short));
		    $detail = $_POST['txtDetail'];
			$detail = htmlspecialchars(pg_escape_string($conn, $detail));
		    $price = $_POST['txtPrice'];
			$price = htmlspecialchars(pg_escape_string($conn, $price));
		    $qty = $_POST['txtQty'];
			$qty = htmlspecialchars(pg_escape_string($conn, $qty));
	    	$pic = $_FILES['txtImage'];
		    $category = $_POST['CategoryList'];
			$category = htmlspecialchars(pg_escape_string($conn, $category));
			$shop = $_POST['StoreList'];
			$shop = htmlspecialchars(pg_escape_string($conn, $shop));
		    $err = "";

			if(trim($id)==""){
				$err .="<li>Enter product ID, please</li>";
			}
			if(trim($proname)==""){
			   $err .="<li>Enter product name, please</li>";
		    }
		    if($category=="0"){
			   $err .="<li>Choose product category, please</li>";
		    }
			if($shop=="0"){
				$err .="<li>Choose shop, please</li>";
			 }
		    if(!is_numeric($price)){
			   $err .="<li>Product price must be number, please</li>";
		    }
		    if(!is_numeric($qty)){
			   $err .="<li>Product quantiy must be number, please</li>";
		    }
		    if($err !=""){
			   echo "<ul>$err</ul>";
		   }
			
			else
			{
				if($pic['type']=="image/jpg" || $pic['type']=="image/jpeg" || $pic['type']=="image/png"|| $pic['type']=="image/gif")
				{
					if ($pic['size'] <= 614400)
					{
						$sq = "SELECT * FROM public.product WHERE product_id='$id' OR pro_name='$proname'";
						$result = pg_query($conn, $sq);
						
						if(pg_num_rows($result)==0)
						{
							copy($pic['tmp_name'], "product_image/".$pic['name']);
							$filePic = $pic['name'];
							$sqlstring = "INSERT INTO product(
								product_id, product_Name, price, smalldesc, detaildesc, prodate, pro_qty, pro_image, cat_id, shop_id)
								VALUES ('$id', '$proname', '$price', '$short', '$detail', '".date('Y-m-d H:i:s')."', '$qty', '$filePic', '$category,'$shop')";
							pg_query($conn, $sqlstring);
							echo '<meta http-equiv="refresh" content="0;URL=index.php?page=product"/>';
						}
						else
						{
							echo "<script>alert('Duplicate product ID')</script>";
						}

					}
					else
					{
						echo "<script>alert('Size of the image too big')</script>";
						
					}

				}
				else{
					echo "<script>alert('Image format is not correct')</script>";
				}
			}
	}
?>
<div class="container">
	<h2>Adding new Product</h2>

	 	<form id="frmProduct" name="frmProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal" role="form">
				<div class="form-group">
					<label for="txtTen" class="col-sm-2 control-label">Product ID(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtID" id="txtID" class="form-control" placeholder="Product ID" value=''/>
							</div>
				</div> 
				<div class="form-group">
                <label for="txtTen" class="col-sm-2 control-label">Product Name(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtName" id="txtName" class="form-control" placeholder="Product Name" value=''/>
							</div>
                </div>   
                <div class="form-group">   
                    <label for="" class="col-sm-2 control-label">Product category(*):  </label>
							<div class="col-sm-10">
							      <?php bind_Category_List($conn);  ?>
							</div>
                </div>
				<div class="form-group">   
                    <label for="" class="col-sm-2 control-label">Shop(*):  </label>
							<div class="col-sm-10">
							      <?php bind_Shop_List($conn);  ?>
							</div>
                </div>  
                          
                <div class="form-group">  
                    <label for="lblGia" class="col-sm-2 control-label">Price(*):  </label>
							<div class="col-sm-10">
							      <input type="text" name="txtPrice" id="txtPrice" class="form-control" placeholder="Price" value=''/>
							</div>
                 </div>     
                
                            
                <div class="form-group">  
        	        <label for="lblDetail" class="col-sm-2 control-label">Detail description(*):  </label>
							<div class="col-sm-10">
							      <textarea name="txtDetail" rows="4" class="ckeditor"></textarea>
              					  <script language="javascript">
                                        CKEDITOR.replace( 'txtDetail',
                                        {
                                            skin : 'kama',
                                            extraPlugins : 'uicolor',
                                            uiColor: '#eeeeee',
                                            toolbar : [ ['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
                                                ['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
                                                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                                                ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
                                                ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
                                                ['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
                                                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
                                                ['Link','Unlink','Anchor', 'NumberedList','BulletedList','-','Outdent','Indent'],
                                                ['Image','Flash','Table','Rule','Smiley','SpecialChar'],
                                                ['Style','FontFormat','FontName','FontSize'],
                                                ['TextColor','BGColor'],[ 'UIColor' ] ]
                                        });
										
                                    </script> 
                                  
							</div>
                </div>
                            
            	<div class="form-group">  
                    <label for="lblSoLuong" class="col-sm-2 control-label">Quantity(*):  </label>
							<div class="col-sm-10">
							      <input type="number" name="txtQty" id="txtQty" class="form-control" placeholder="Quantity" value=""/>
							</div>
                </div>
 
				<div class="form-group">  
	                <label for="sphinhanh" class="col-sm-2 control-label">Image(*):  </label>
							<div class="col-sm-10">
							      <input type="file" name="txtImage" id="txtImage" class="form-control" value=""/>
							</div>
                </div>
                        
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						      <input type="submit"  class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new"/>
                              <input type="button" class="btn btn-primary" name="btnIgnore"  id="btnIgnore" value="Ignore" onclick="window.location='?page=product_management'" />
                              	
						</div>
				</div>
			</form>
</div>