<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<?php
    if (!isset($_GET['pdid']) || $_GET['pdid'] == NULL) {
     echo "<script>window.location = '404.php'</script>";
} else {
    $id = $_GET['pdid'];
}
?>
 <div class="main">
    <div class="content">
    	<div class="section group">
			<?php
			$get_product_details = $pd->get_details($id);
			if ($get_product_details) {
				while ($result_details = $get_product_details->fetch_assoc()) {	
			?>
				<div class="cont-desc span_1_of_2">				
					<div class="grid images_3_of_2">
						<img src="admin/uploads/<?php echo $result_details['image'] ?>" alt="" />
					</div>
				<div class="desc span_3_of_2">

					<h2><?php echo $result_details['productName']?></h2>
					<p><?php echo $fm->textShorten($result_details['product_desc'], 200) ?></p>			
					<div class="price">
						<p>Price: <span><?php echo $result_details['price']." "."VND" ?></span></p>
						<p>Category:  <span><?php echo $result_details['catName']?></span></p>
						<p>Brand: <span><?php echo $result_details['brandName']?></span></p>
					</div>
				<div class="add-cart">
					<form action="cart.php" method="post">
						<input type="number" class="buyfield" name="" value="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					</form>				
				</div>
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	    </div>
				
	</div>
	<?php
				}
			}
	?>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
				      <li><a href="productbycat.php">Mobile Phones</a></li>
				   
    				</ul>
    	
 				</div>
 		</div>
 	</div>

<?php
include 'inc/footer.php';
?>