<div class="container-fluid"  style="display: none;" id="admin_return_div">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Return section</h4>
                            </div>
                            <div class="content">
                            	<form method="post" action="#" onSubmit="return return_book();" class="form-horizontal">
										<div class="form-group">
											<label for="return_book_id" class="col-sm-2 control-label">Book ID</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="return_book_id" placeholder="Book ID">
											</div>
										</div>
										<div class="form-group">
											<label for="return_reader_id" class="col-sm-2 control-label">Reader ID</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="return_reader_id" placeholder="Reader ID">
											</div>
										</div>
										<div class="form-group">
											<label for="return_b_id" class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<button class="btn btn-primary" value="return">return</button></button>
											</div>
										</div>
								</form>


							</div>
						</div>
					</div>
				</div>
</div>
<script type="text/javascript">
	function return_book(){
		var reader_id = $("#return_reader_id").val();
		var book_id = $("#return_book_id").val();
		$.getJSON("http://localhost/library/core/ajax/return_book.php",{reader_id:reader_id,  book_id:book_id}, function (data) {
			if(data.error){
				alert(data.error);
			}
			else{
				alert("Book successfully returned");
			}
		});
		return false;
	}
</script>