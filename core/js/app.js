
$( document ).ready(function() {
	"use strict";
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


var globalContent = $("#main_wrapper").html();
        var image_src = $('.sidebar').data('image');
        
        if(image_src !== undefined){
            var sidebar_container = '<div class="sidebar-background" style="background-image: url(' + image_src + ') "/>'
            $('.sidebar').append(sidebar_container);
        } 
			$("#universal_search_field").keyup(function() {
			  var text = $(this).val();
				if(text.length > 0){
					$.getJSON("http://localhost/library/core/ajax/get_inline_search.php",{q:text}, function (data) {
						$("#main_wrapper").html("");
						var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">';
						if(data.ISBN){
							var content = "";
							for(var i=0; i < data.ISBN.length; i++){
								content = content + generate_div_from_search_result(data.ISBN[i]);
							}
							str = str + '<div class="panel panel-default" style="clearfix:none;">'+
									  '<div class="panel-heading">By ISBN</div>'+
									  '<div class="panel-body">' + content + '</div>'+
									'</div>';
						}
						if(data.title){
							var content = "";
							for(var i=0; i < data.title.length; i++){
								content = content + generate_div_from_search_result(data.title[i]);
							}
							str = str + '<div class="panel panel-default" style="clearfix:none;">'+
									  '<div class="panel-heading">By title</div>'+
									  '<div class="panel-body">' + content + '</div>'+
									'</div>';
						}
						if(data.category){
							var content = "";
							for(var i=0; i < data.category.length; i++){
								content = content + generate_div_from_search_result(data.category[i]);
							}
							str = str + '<div class="panel panel-default" style="clearfix:none;">'+
									  '<div class="panel-heading">By category</div>'+
									  '<div class="panel-body">' + content + '</div>'+
									'</div>';
						}
						if(data.publisher){
							var content = "";
							for(var i=0; i < data.publisher.length; i++){
								content = content + generate_div_from_search_result(data.publisher[i]);
							}
							str = str + '<div class="panel panel-default" style="clearfix:none;">'+
									  '<div class="panel-heading">By publisher</div>'+
									  '<div class="panel-body">' + content + '</div>'+
									'</div>';
						}
					
						$("#main_wrapper").html(str + '</div></div></div></div>');
					});
				}
				else{
					$("#main_wrapper").html(globalContent);
				}
			});
		});
function generate_div_from_search_result(data){
			var str = '<div class="thumbnail" style="width:156px; float:left; margin-right: 16px;" onClick="loadModule(\'show_book_detail:' + data.ISBN + '\')"><img src="data:image/jpeg;base64,' + data.thumbnail + '" style="width:128px; height:128px;"><div class="caption"><h3>' + data.title + '</h3><p>By ' + data.publisher + ' in ' + data.category + '</p></div></div>';
			return str;
		}
function borrow_book(ISBN){
	$("#borrow_book_btn").addClass("disabled").html("Borrowing");
	$.getJSON("http://localhost/library/core/ajax/borrow_book.php",{ISBN:ISBN}, function (data) {
		if(data.error){
			$("#borrow_book_btn").addClass("disabled").html("Can't borrow");
			alert(data.error);
		}
		else{
			$("#borrow_book_btn").addClass("disabled").html("Borrowed");
		}
	});
	
}
function reserve_book(ISBN){
	$("#reserve_book_btn").addClass("disabled").html("Reserving");
	$.getJSON("http://localhost/library/core/ajax/reserve_book.php",{ISBN:ISBN}, function (data) {
		if(data.error){
			$("#reserve_book_btn").addClass("disabled").html("Can't reserve");
			alert(data.error);
		}
		else{
			$("#reserve_book_btn").addClass("disabled").html("Reserveed");
		}
	});
	
}			  
function loadModule(task){
	if(task == 'list_category'){
		$.getJSON("http://localhost/library/core/ajax/get_categories.php",{}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + '<button class="btn btn-primary" style="margin-right:16px;" type="button" onClick="loadModule(\'show_category:' + data[i].category_id + '\')">' + data[i].title + ' <span class="badge">' + data[i].countNo + '</span></button>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task == 'list_authors'){
		$.getJSON("http://localhost/library/core/ajax/get_authors.php",{}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + '<button class="btn btn-primary" style="margin-right:16px;" type="button" onClick="loadModule(\'show_author:' + data[i].author_id + '\')">' + data[i].title + ' <span class="badge">' + data[i].countNo + '</span></button>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task == 'list_publishers'){
		$.getJSON("http://localhost/library/core/ajax/get_publishers.php",{}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + '<button class="btn btn-primary" style="margin-right:16px;" type="button" onClick="loadModule(\'show_publisher:' + data[i].publisher_id + '\')">' + data[i].title + ' <span class="badge">' + data[i].countNo + '</span></button>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task.indexOf('show_category') !== -1){
		var data = task.split(":");
		var id = data[1];
		$.getJSON("http://localhost/library/core/ajax/get_specific_category.php",{id:id}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + generate_div_from_search_result(data[i]);
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task.indexOf('show_author') !== -1){
		var data = task.split(":");
		var id = data[1];
		$.getJSON("http://localhost/library/core/ajax/get_specific_author.php",{id:id}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + generate_div_from_search_result(data[i]);
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task.indexOf('show_publisher') !== -1){
		var data = task.split(":");
		var id = data[1];
		$.getJSON("http://localhost/library/core/ajax/get_specific_publisher.php",{id:id}, function (data) {
			var content = "";
			for(var i=0; i < data.length; i++){
				content = content + generate_div_from_search_result(data[i]);
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task.indexOf('show_book_detail') !== -1){
		var data = task.split(":");
		var id = data[1];
		$.getJSON("http://localhost/library/core/ajax/show_book_detail.php",{ISBN:id}, function (data) {
			var content = '<div class="header"><h2>' + data.book_title + '</h2></div>';
			content = content + '<div class="content"><table><tr><td><image src="data:image/jpeg;base64,' + data.book_thumbnail + '" style="width:200px; height:300px; margin-right:16px;" /></td>';
			content = content + '<td style="vertical-align:top;"><p>' + data.book_description + '</p><p>Published by ' + data.publisher_name + ' in ' + data.category_title + ' on ' + data.book_publish_date + '</p><p> Authors: ';
			for(var i=0; i < data.authors.length; i++){
				content = content + data.authors[i].name + ",";	
			}
			/*if(data.current_borrow_count < 10){
				content = content + '<br><button id="borrow_book_btn" onCLick="borrow_book(\'' + id + '\');" class="btn btn-primary" >Borrow</button>';
			}*/
			if(data.current_reserve_count < 10){
				content = content + '  <button id="reserve_book_btn" onCLick="reserve_book(\'' + id + '\');" class="btn btn-primary" >Reserve</button>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</p></td></div></div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task == 'list_borrows'){
		$.getJSON("http://localhost/library/core/ajax/get_borrow_list.php",{}, function (data) {
			var content = '<div class="header"><h2>Borrowed books</h2></div><div class="content">';
			for(var i=0; i < data.length ; i++){
				var date = new Date(data[i].bdatetime * 1000),
				datevalues = [
				   date.getFullYear(),
				   date.getMonth()+1,
				   date.getDate(),
				   date.getHours(),
				   date.getMinutes(),
				   date.getSeconds(),
				];
				var last_date = (parseInt(data[i].bdatetime) + (20*24*60*60))*1000;
				var cur_date = new Date().getTime();
				var days_due = Math.round((last_date - cur_date) / (1000*60*60*24));
				if(days_due < 0){
					days_due = 0;
				}
				var fine_str = '';
				if(data[i].fine){
					fine_str = '<br><strong>Fine: </strong>$' + data[i].fine;
				}
				content = content + '<div class="panel panel-default"><div class="panel-heading"><h3>' + data[i].title + '</h3></div><div class="panel-body"><table style="width:100%;"><tr><td style="width: 128px;vertical-align: top;"><img src="data:image/jpeg;base64,' + data[i].thumbnail + '" style="width:128px; height:128px;"></td><td style="vertical-align: top;padding-left: 16px;"><p><strong>ISBN: </strong>' + data[i].ISBN + '<br><strong>Borrowed date: </strong>' + datevalues[1] + "/" + datevalues[2] + "/" + datevalues[0] + fine_str +'</p></td><td style="float:right;text-align:center;"><div style="width:128px; height:128px; background:#EAEAEA; border:1px solid #CCC;border-radius: 16px;"><span style="font-size:90px; text-align:center;">' + days_due + '</span></div><div>days due</div></td></tr></table></div></div>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task == 'list_reserves'){
		$.getJSON("http://localhost/library/core/ajax/get_reserve_list.php",{}, function (data) {
			var content = '<div class="header"><h2>Reserved books</h2></div><div class="content">';
			for(var i=0; i < data.length ; i++){
				var date = new Date(data[i].reserve_time * 1000),
				datevalues = [
				   date.getFullYear(),
				   date.getMonth()+1,
				   date.getDate(),
				   date.getHours(),
				   date.getMinutes(),
				   date.getSeconds(),
				];
				
				content = content + '<div class="panel panel-default"><div class="panel-heading"><h3>' + data[i].title + '</h3></div><div class="panel-body"><table style="width:100%;"><tr><td style="width: 128px;vertical-align: top;"><img src="data:image/jpeg;base64,' + data[i].thumbnail + '" style="width:128px; height:128px;"></td><td style="vertical-align: top;padding-left: 16px;"><p><strong>ISBN: </strong>' + data[i].ISBN + '<br><strong>Reserved date: </strong>' + datevalues[1] + "/" + datevalues[2] + "/" + datevalues[0] + '</p></td><td style="float:right;text-align:center;"><div style="width:128px; height:128px; background:#EAEAEA; border:1px solid #CCC;border-radius: 16px;"><span style="font-size:90px; text-align:center;">' + data[i].due + '</span></div><div>hours due</div></td></tr></table></div></div>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;">' + content + '</div></div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
}
function show_sql1(){
	var lib_id = $("#sql1_select").val();
	$.getJSON("http://localhost/library/core/ajax/get_top_10_frequent_borrower.php",{lib_id:lib_id}, function (data) {
			var content = "<tr><th>Reader</th><th>Total books borrowed</th></tr>";
			for(var i=0; i < data.length; i++){
				content = content + '<tr><td><a href="#" onCLick="loadAdminModule(\'show_reader:' + data[i].reader_id+ '\')">' + data[i].name + '</a></td><td>' + data[i].total_books + '</td></tr>';
			}
			var str = '<table class="table table-striped" style="width:auto;">' + content + '</table>';
			$("#sql1_div").html(str);
		});
}
function show_sql2(){
	var lib_id = $("#sql2_select").val();
	$.getJSON("http://localhost/library/core/ajax/get_top_10_borrowed.php",{lib_id:lib_id}, function (data) {
			var content = "<tr><th>Reader</th><th>Total books borrowed</th></tr>";
			for(var i=0; i < data.length; i++){
				content = content + '<tr><td><a href="#" onCLick="loadModule(\'show_book_detail:' + data[i].ISBN+ '\')">' + data[i].title + '</a></td><td>' + data[i].times + '</td></tr>';
			}
			var str = '<table class="table table-striped" style="width:auto;">' + content + '</table>';
			$("#sql2_div").html(str);
		});
}
function show_sql3(){
	var reader_id = $("#sql3_select").val();
	$.getJSON("http://localhost/library/core/ajax/avg_fine_paid.php",{reader_id:reader_id}, function (data) {
			$("#sql3_div").html("Avg fine for this reader is $" + data.fine);
		});
}
function loadAdminModule(task){
	if(task == 'show_add_data'){
		$("#default_wrapper").hide();
		$("#admin_add_data_div").show();
	}
	else if(task == 'show_branches'){
		$("#default_wrapper").hide();
		$.getJSON("http://localhost/library/core/ajax/get_branches.php",{}, function (data) {
			var content = "<tr><th>Branch name</th><th>Location</th></tr>";
			for(var i=0; i < data.length; i++){
				content = content + '<tr><td>' + data[i].name + '</td><td>' + data[i].city + '</td></tr>';
			}
			var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;"><div class="header"><h4 class="title">Branches</h4></div><table class="table table-striped">' + content + '</table></div></div></div></div>';
			$("#main_wrapper").html(str);
		});
	}
	else if(task == 'show_trending'){
		$("#default_wrapper").hide();
		
		var content = '<div><ul class="nav nav-tabs" role="tablist"><li role="presentation" class="active"><a href="#sql1" aria-controls="sql1" role="tab" data-toggle="tab">Get top 10 frequent borrower</a></li><li role="presentation"><a href="#sql2" aria-controls="sql2" role="tab" data-toggle="tab">Get top 10 borrowed</a></li><li role="presentation"><a href="#sql3" aria-controls="sql3" role="tab" data-toggle="tab">Avg fine paid by reader</a></li></ul><div class="tab-content"><div role="tabpanel" class="tab-pane active" id="sql1"><select id="sql1_select" class="form-control">' + global_branch_option + '</select><br><button class="btn btn-primary" onCLick="show_sql1();">Show</button><br><div id="sql1_div"></div></div><div role="tabpanel" class="tab-pane" id="sql2"><select id="sql2_select" class="form-control">' + global_branch_option + '</select><br><button class="btn btn-primary" onCLick="show_sql2();">Show</button><br><div id="sql2_div"></div></div><div role="tabpanel" class="tab-pane" id="sql3"><input id="sql3_input" class="form-control" placeholder="Enter reader id"><br><button class="btn btn-primary" onCLick="show_sql3();">Show</button><br><div id="sql3_div"></div></div></div>';
		var str = '<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="card" style="padding:16px;"><div class="header"><h4 class="title">Trending</h4></div>' + content + '</div></div></div></div>';
			$("#main_wrapper").html(str);
	}
	else if(task == 'show_make_borrow'){
		$("#default_wrapper").hide();
		$("#admin_borrow_div").show();
	}
	else if(task == 'show_take_return'){
		$("#default_wrapper").hide();
		$("#admin_return_div").show();
	}
	else if(task == 'show_borrow_from_reserve'){
		$("#default_wrapper").hide();
		$("#admin_reserve_div").show();
	}
	
	return false;
}