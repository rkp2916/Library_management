<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Dashboard</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<?php
	error_reporting(E_ERROR);
	include("../core/modules/admin_class.php");
	$admin = new Admin();
	if(isset($_POST['hidden'])){
		if($_POST['hidden'] == "add_category"){
			print_r($admin->add_category($_POST['category_title']));
		} else if($_POST['hidden'] == "add_publisher"){
			$params = array(
				'publisher_id' => 0,
				'name' => $_POST['publisher_name'],
				'website' => $_POST['publisher_website'],
				'email' => $_POST['publisher_email'],
				'address_street_number' => $_POST['publisher_address_street_number'],
				'address_street_name' => $_POST['publisher_address_street_name'],
				'address_city' => $_POST['publisher_address_city'],
				'address_state' => $_POST['publisher_address_state'],
				'address_country' => $_POST['publisher_address_country'],
				'address_zip' => $_POST['publisher_address_zip']
			);
			print_r($admin->add_publisher($params));
		} else if($_POST['hidden'] == "add_book_detail"){
			echo("<pre>" . print_r($_POST) . "</pre>");
			$params = array(
				'ISBN' => $_POST['book_isbn'],
				'title' => $_POST['book_title'],
				'description' => $_POST['book_description'],
				'thumbnail' => addslashes(file_get_contents($_FILES['book_thumbnail']['tmp_name'])),
				'edition' => $_POST['book_edition'],
				'publication_date' => strtotime($_POST['book_date']),
				'category_id' => $_POST['category_id'],
				'publisher_id' => $_POST['publisher_id']
			);
			print_r($admin->add_book_detail($params, $_POST['add_author_id_0'], $_POST['add_author_id_1'], $_POST['add_author_id_2'], $_POST['add_author_id_3'], $_POST['add_author_id_4']));
		} else if($_POST['hidden'] == "add_author"){
			//author_id, name, thumbnail, email, website, country
			$params = array(
				'author_id' => 0,
				'name' => $_POST['author_name'],
				'thumbnail' => addslashes(file_get_contents($_FILES['author_thumbnail']['tmp_name'])),
				'email' => $_POST['author_email'],
				'website' => $_POST['author_website'],
				'country' => $_POST['author_country']
			);
			print_r($admin->add_author($params));
		} else if($_POST['hidden'] == "add_reader"){
			//reader_id, name, email, thumbnail, ph_no, address_street_number, address_street_name, address_city, address_state, address_country, address_zip
			/*print_r($_FILES);
			$target_file = "../../uploads/" . basename($_FILES["reader_thumbnail"]["name"]);
			if (move_uploaded_file($_FILES["reader_thumbnail"]["tmp_name"], $target_file)) {
				
			}*/
			echo(print_r($_FILES));
				$params = array(
					'reader_id' => 0,
					'name' => $_POST['reader_name'],
					'email' => $_POST['reader_email'],
					'thumbnail' => addslashes(file_get_contents($_FILES['reader_thumbnail']['tmp_name'])),
					'ph_no' => $_POST['reader_ph_no'],
					'address_street_number' => $_POST['reader_address_street_number'],
					'address_street_name' => $_POST['reader_address_street_name'],
					'address_city' => $_POST['reader_address_city'],
					'address_state' => $_POST['reader_address_state'],
					'address_country' => $_POST['reader_address_country'],
					'address_zip' => $_POST['reader_address_zip']
				);
				print_r($admin->add_reader($params));
		} else if($_POST['hidden'] == "add_branch"){
			$params = array(
				'lib_id' => 0,
				'name' => $_POST['branch_name'],
				'city' => $_POST['branch_city']
			);
			print_r($admin->add_branch($params));
		} else if($_POST['hidden'] == "add_book_qty"){
			$isbn = $_POST['add_book_isbn'];
			$qty = $_POST['add_book_qty'];
			$admin->add_book_qty($isbn, $qty);
		}
	}
?>
<script>
$(document).ready(function(){

    var counter = 1;

    $("#add_author_button").click(function () {

	if(counter>=5){
            alert("Only 5 authors allowded");
            return false;
	}else{
		$('#add_author_id_'+counter).show();
	}

	counter++;
     });

     $("#remove_author_button").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }

	counter--;

        $('#add_author_id_'+counter).hide();

     });

  });
	</script>
</head>

<body>
<fieldset>
	<legend>Add category</legend>
	
	<form method="post" action="#">
		<input type="text" name="category_title" placeholder="title" />
		<input type="hidden" name="hidden" value="add_category" />
		<input type="submit" value="Add" />
	</form>
</fieldset>
<fieldset>
	<legend>Add new book detail</legend>
	<table>
	<form method="post" action="#"  enctype="multipart/form-data">
		<tr><td><input type="text" name="book_isbn" placeholder="ISBN" /></td></tr>
		<tr><td><input type="text" name="book_title" placeholder="title" /></td></tr>
		<tr><td><textarea name="book_description" placeholder="Description"></textarea></td></tr>
		<tr><td><input type="file" name="book_thumbnail" id="book_thumbnail" value="Attach thumbnail" /></td></tr>
		<tr><td><input type="text" name="book_edition" placeholder="edition" /></td></tr>
		<tr><td><input type="date" name="book_date" placeholder="date" /></td></tr>
		<tr><td>
		<select name="publisher_id">
			<?php echo $admin->get_publishers(); ?>
		</select>
		</td></tr>
		<tr><td>
		<select name="category_id">
			<?php echo $admin->get_categories(); ?>
		</select>
		</td></tr>
		<input type="hidden" name="hidden" value="add_book_detail" />
		<tr><td>
			<div id="add_author_div">
				<div>
					<select name="add_author_id_0" id="add_author_id_0">
						<option value="0">Choose author</option>
						<?php echo $admin->get_authors(); ?>
					</select>
					<select name="add_author_id_1" id="add_author_id_1" style="display: none">
						<option value="0">Choose author</option>
						<?php echo $admin->get_authors(); ?>
					</select>
					<select name="add_author_id_2" id="add_author_id_2" style="display: none">
						<option value="0">Choose author</option>
						<?php echo $admin->get_authors(); ?>
					</select>
					<select name="add_author_id_3" id="add_author_id_3" style="display: none">
						<option value="0">Choose author</option>
						<?php echo $admin->get_authors(); ?>
					</select>
					<select name="add_author_id_4" id="add_author_id_4" style="display: none">
						<option value="0">Choose author</option>
						<?php echo $admin->get_authors(); ?>
					</select>
				</div>
				
			</div>
			<input type='button' value='Add author' id='add_author_button'>
			<!--<input type='button' value='Remove last' id='remove_author_button'>-->
		</td></tr>
		<tr><td><input type="submit" value="Add" /></td></tr>
		</table>
	</form>
</fieldset>
<fieldset>
	<legend>Add author</legend>
	<form method="post" action="#"  enctype="multipart/form-data">
		<input type="text" name="author_name" placeholder="Name" />
		<input type="file" name="author_thumbnail" id="author_thumbnail" value="Attach thumbnail" />
		<input type="email" name="author_email" placeholder="email" />
		<input type="url" name="author_website" placeholder="website" />
		<input type="text" name="author_country" placeholder="Country" />
		<input type="hidden" name="hidden" value="add_author" />
		<input type="submit" value="Add" />
	</form>
</fieldset>

<fieldset>
	<legend>Add qty to existing books</legend>
	<form method="post" action="#">
		<table>
			<?php
			echo("<tr><td>Book title</td><td><select name='add_book_isbn'>" . $admin->get_book_isbn() . "</select></td></tr>");
			echo $admin->get_branches_only_id();
		?>
		<input type="hidden" name="hidden" value="add_book_qty" />
		<tr><td></td><td><input type="submit" value="Add" /></td></tr>
		</table>
	</form>
</fieldset>

<fieldset>
	<legend>Add publisher</legend>
	<form method="post" action="#">
		<input type="text" name="publisher_name" placeholder="Name" />
		<input type="url" name="publisher_website" placeholder="website" />
		<input type="email" name="publisher_email" placeholder="email" />
		<input type="text" name="publisher_address_street_number" placeholder="street no" />
		<input type="text" name="publisher_address_street_name" placeholder="street name" />
		<input type="text" name="publisher_address_city" placeholder="city" />
		<input type="text" name="publisher_address_state" placeholder="state" />
		<input type="text" name="publisher_address_zip" placeholder="zip" />
		<input type="text" name="publisher_address_country" placeholder="country" />
		<input type="hidden" name="hidden" value="add_publisher" />
		<input type="submit" value="Add" />
	</form>
</fieldset>


<fieldset>
	<legend>Add reader</legend>
	<!--reader_id, name, email, thumbnail, ph_no, address_street_number, address_street_name, address_city, address_state, address_country, address_zip-->
	<form method="post" action="#" enctype="multipart/form-data">
		<input type="text" name="reader_name" placeholder="Name" />
		<input type="email" name="reader_email" placeholder="email" />
		<input type="file" name="reader_thumbnail" id="reader_thumbnail" value="Attach thumbnail" />
		<input type="text" name="reader_ph_no" placeholder="Phone number" />
		<input type="text" name="reader_address_street_number" placeholder="street no" />
		<input type="text" name="reader_address_street_name" placeholder="street name" />
		<input type="text" name="reader_address_city" placeholder="city" />
		<input type="text" name="reader_address_state" placeholder="state" />
		<input type="text" name="reader_address_zip" placeholder="zip" />
		<input type="text" name="reader_address_country" placeholder="country" />
		<input type="hidden" name="hidden" value="add_reader" />
		<input type="submit" value="Add" />
	</form>
</fieldset>

<fieldset>
	<legend>Add library branch</legend>
	<form method="post" action="#">
		<input type="text" name="branch_name" placeholder="Name" />
		<input type="text" name="branch_city" placeholder="City" />
		<input type="hidden" name="hidden" value="add_branch" />
		<input type="submit" value="Add" />
	</form>
</fieldset>
</body>
</html>