<div class="container-fluid"  style="display: none;" id="admin_reserve_div">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Reserve section</h4>
                            </div>
                            <div class="content">
                            	<form method="post" action="#" onSubmit="return reserve_book();" class="form-horizontal">
										<div class="form-group">
											<label for="reserve_id" class="col-sm-2 control-label">Reserve ID</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="reserve_id" placeholder="Reserve ID">
											</div>
										</div>
										<div class="form-group">
											<label for="reserve_b_id" class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<button class="btn btn-primary" value="reserve">Borrow from reservation</button></button>
											</div>
										</div>
								</form>


							</div>
						</div>
					</div>
				</div>
</div>
<script type="text/javascript">
	function reserve_book(){
		var reserve_id = $("#reserve_id").val();
		$.getJSON("http://localhost/library/core/ajax/borrow_from_reserve.php",{reserve_id:reserve_id_id}, function (data) {
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