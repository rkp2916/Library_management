<div class="container-fluid"  style="display: none;" id="admin_borrow_div">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Borrow section</h4>
                            </div>
                            <div class="content">
                            	<form method="post" action="#" onSubmit="return borrow_book();" class="form-horizontal">
										<div class="form-group">
											<label for="borrow_book_id" class="col-sm-2 control-label">Book ID</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="borrow_book_id" placeholder="Book ID">
											</div>
										</div>
										<div class="form-group">
											<label for="borrow_reader_id" class="col-sm-2 control-label">Reader ID</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="borrow_reader_id" placeholder="Reader ID">
											</div>
										</div>
										<div class="form-group">
											<label for="borrow_lib_id" class="col-sm-2 control-label">Branch</label>
											<div class="col-sm-10">
											  <select class="form-control" id="borrow_lib_id">
											  <?php
												  echo $admin->get_branches_combobox();
												  ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="borrow_b_id" class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<button class="btn btn-primary" value="Borrow">Borrow</button></button>
											</div>
										</div>
								</form>


							</div>
						</div>
					</div>
				</div>
</div>
<script type="text/javascript">
	function borrow_book(){
		var reader_id = $("#borrow_reader_id").val();
		var lib_id = $("#borrow_lib_id").val();
		var book_id = $("#borrow_book_id").val();
		$.getJSON("http://localhost/library/core/ajax/borrow_book.php",{reader_id:reader_id, lib_id:lib_id, book_id:book_id}, function (data) {
			if(data.error){
				alert(data.error);
			}
			else{
				alert("Book successfully borrowed");
			}
		});
		return false;
	}
</script>