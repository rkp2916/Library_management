<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<?php
	include("../core/meta.php");
	include("../core/modules/admin_class.php");
	$admin = new Admin();
	$data = array();
	if(isset($_POST['hidden'])){
		if($_POST['hidden'] == "add_category"){
			$admin->add_category($_POST['category_title']);
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
			$admin->add_publisher($params);
		} else if($_POST['hidden'] == "add_book_detail"){
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
			$admin->add_book_detail($params, $_POST['add_author_id_0'], $_POST['add_author_id_1'], $_POST['add_author_id_2'], $_POST['add_author_id_3'], $_POST['add_author_id_4']);
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
			$admin->add_author($params);
		} else if($_POST['hidden'] == "add_reader"){
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
					'address_zip' => $_POST['reader_address_zip'],
					'lib_id' => $_POST['reader_branch']
				);
			$admin->add_reader($params);
		} else if($_POST['hidden'] == "add_branch"){
			$params = array(
				'lib_id' => 0,
				'name' => $_POST['branch_name'],
				'city' => $_POST['branch_city']
			);
			$admin->add_branch($params);
		} else if($_POST['hidden'] == "add_book_qty"){
			$isbn = $_POST['add_book_isbn'];
			$qty = $_POST['add_book_qty'];
			$admin->add_book_qty($isbn, $qty);
		}
	}
	
	?>
	<script type="text/javascript">
		var global_branch_option = '<?php echo $admin->get_branches_combobox(); ?>';
	</script>
<title>Library management system</title>

    <!-- Animation library for notifications   -->
    <link href="http://localhost/library/core/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="http://localhost/library/core/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="http://localhost/library/core/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="http://localhost/library/core/css/pe-icon-7-stroke.css" rel="stylesheet" />
	<?php
	//$data = $reader->get_all_details();
	?>
	<script type="text/javascript" src="http://localhost/library/core/js/app.js"></script>
<style type="text/css">
	.main-card-thumbnail{
		width: 198px;
		height: 198px;
		border-radius: 16px;
		background: rgba(255,255,255,0.5);
	}
	.main-card-thumbnail:hover{
		box-shadow: 5px 5px 90px #999;
		cursor: pointer;
	}
	.main-card-thumbnail img{
		width: 128px;
		height: 128px;
	}
</style>
</head>
<body>
	

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="http://localhost/library/core/img/sidebar-4.jpg">


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://localhost/library/pages/admin.php" class="simple-text">
                    Admin
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="#" onClick="return loadAdminModule('show_add_data');">
                        <i class="pe-7s-graph"></i>
                        <p>Add data</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadAdminModule('show_branches');">
                        <i class="pe-7s-user"></i>
                        <p>Branches</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadAdminModule('show_trending');">
                        <i class="pe-7s-note2"></i>
                        <p>Trending</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadAdminModule('show_make_borrow');">
                        <i class="pe-7s-note2"></i>
                        <p>Make borrow</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadAdminModule('show_take_return');">
                        <i class="pe-7s-note2"></i>
                        <p>Take return</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadAdminModule('show_borrow_from_reserve');">
                        <i class="pe-7s-note2"></i>
                        <p>Approved reserve</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel" style="background: url(http://localhost/library/core/img/bg.png); background-size: cover; background-position: center;">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left" style="margin-top: 10px;">
                        <li>
                        <form class="navbar-form navbar-left" style="padding-left: 0px;">
							<div class="form-group">
							  <input type="text" class="form-control" placeholder="Enter book title, category, publisher or ISBN" id="universal_search_field" style="height: 34px;
																padding: 6px 12px;
																font-size: 14px;
																line-height: 1.42857143;
																color: #555;
																background-color: #fff;
																background-image: none;
																border: 1px solid #ccc;
																border-radius: 4px;
																width: 512px;" />
							</div>
							
                           <a href="">
                                <i class="fa fa-search"></i>
                            </a>
						  </form>
                        	
                        </li>
                  
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               Account
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" id="main_wrapper">
            <div class="container-fluid" id="default_wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <!--<div class="card">
                            <div class="header">
                                <h4 class="title">Top 10 most borrow in <?php echo $data['branch_name']; ?></h4>
                            </div>-->
                            <div class="content">
								<center>
								<table>
									<tr>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_add_data');">
											  <img src="http://localhost/library/core/img/add.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Add data</h4>
											  </div>
											</div>
										</td>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_branches');">
											  <img src="http://localhost/library/core/img/info.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Branches</h4>
											  </div>
											</div>
										</td>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_trending');">
											  <img src="http://localhost/library/core/img/trending.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Trending</h4>
											  </div>
											</div>
										</td>
									</tr>
									
									
									<tr>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_make_borrow');">
											  <img src="http://localhost/library/core/img/borrow.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Make borrow</h4>
											  </div>
											</div>
										</td>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_take_return');">
											  <img src="http://localhost/library/core/img/return.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Take return</h4>
											  </div>
											</div>
										</td>
										<td style="padding: 16px;">
											<div class="thumbnail main-card-thumbnail" onClick="return loadAdminModule('show_borrow_from_reserve');">
											  <img src="http://localhost/library/core/img/reserve.png">
											  <div class="caption" style="padding: none; width: 100%; text-align: center;margin-top: -16px;">
												<h4>Pickup</h4>
											  </div>
											</div>
										</td>
									</tr>
								</table>
								</center>
                            </div>
                        <!--</div>-->
                    </div>


                </div>
            </div>
			<?php
			 include('admin_add_data.php');
			include('admin_borrow_div.php');
			include('return_book_div.php');
			include('admin_reserve_div.php');
			?>
        </div>



    </div>
</div>


</body>


	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="http://localhost/library/core/js/bootstrap-checkbox-radio-switch.js"></script>


</html>
