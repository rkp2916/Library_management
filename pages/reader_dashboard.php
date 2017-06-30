<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
	include("../core/meta.php");
	include("../core/modules/reader_class.php");
	if(!isset($_SESSION['reader_id'])){
		header('Location: home.php');
	}
	$reader = new Reader();
	$data = array();
	$data = $reader->get_all_details();
	?>
	<script type="text/javascript" src="http://localhost/library/core/js/app.js"></script>
</head>
<body>
	

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="http://localhost/library/core/img/sidebar-4.jpg">


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://localhost/library/pages/reader_dashboard.php" class="simple-text">
                    <?php echo $data['branch_name']; ?>
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="#" onClick="return loadModule('list_category');">
                        <i class="pe-7s-graph"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadModule('list_authors');">
                        <i class="pe-7s-user"></i>
                        <p>Authors</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadModule('list_publishers');">
                        <i class="pe-7s-note2"></i>
                        <p>Publishers</p>
                    </a>
                </li>
                <li style="border: 1px solid #ccc;"></li>
                <li>
                    <a href="#" onClick="return loadModule('list_borrows');">
                        <i class="pe-7s-note2"></i>
                        <p>Borrowed books</p>
                    </a>
                </li>
                <li>
                    <a href="#" onClick="return loadModule('list_reserves');">
                        <i class="pe-7s-note2"></i>
                        <p>Reserved books</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
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
                            <a href="http://localhost/library/pages/logout.php">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" id="main_wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Top 10 most borrow in <?php echo $data['branch_name']; ?></h4>
                            </div>
                            <div class="content"    style="overflow-x: scroll;
    overflow-y: hidden;">
								<?php
								$res = $reader->get_top_10_borrow_from_branch();
								//echo "<pre>" . print_r($res) . "</pre>";
								$n = count($res);
								for($i=0 ; $i<$n ; $i++){
									echo '<div class="thumbnail" style="width:156px;float:left; margin-right:16px;">
										  <img src="data:image/jpeg;base64,' . base64_encode($res[$i]['thumbnail']) . '" style="width:128px; height:128px;">
										  <div class="caption">
											<h3>' . $res[$i]['title'] . '</h3>
											<p>' . $res[$i]['countNo'] . ' times</p>
										  </div>
										</div>';
								}
								?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </div>
</div>


</body>


	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="http://localhost/library/core/js/bootstrap-checkbox-radio-switch.js"></script>


</html>
