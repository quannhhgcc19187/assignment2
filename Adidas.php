<?php
include_once("connection.php");
?>

    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product">
                        <h2 class="section-title">Animals</h2>
                        <div class="product-carousel">

                        <!--Load san pham tu DB -->
                           <?php
						  // 	include_once("database.php")
		  				   	$result = mysqli_query($conn, "SELECT * FROM product WHERE Cat_ID='C001'" );
			
			                if (!$result) { //add this check.
                                die('Invalid query: ' . mysqli_error($conn));
                            }
		
			            
			                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				            ?>
				            <!--Một sản phẩm -->
                            <div class="single-product">
                                <div class="product-f-image">
                                    <img src="product-imgs/<?php echo $row['Pro_image']?>" width="150" height="150"><a href="?page=quanly_chitietsanpham&ma=<?php echo  $row['Product_ID']?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                </div>
                                
                                <h2><a href="?page=quanly_chitietsanpham&ma=<?php echo  $row['Product_ID']?>"><?php echo $row['Product_Name']?></a></h2>
                                
                                <div class="product-carousel-price">
                                    <ins><?php echo  $row['Price']?></ins>
                                </div> 
                            </div>
                <?php
				}
				?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>