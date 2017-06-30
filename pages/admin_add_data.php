			<div class="container-fluid" id="admin_add_data_div" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Add data</h4>
                            </div>
                            <div class="content">
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#book" aria-controls="book" role="tab" data-toggle="tab">Book</a></li>
									<li role="presentation"><a href="#qty" aria-controls="qty" role="tab" data-toggle="tab">Quantity to book</a></li>
									<li role="presentation"><a href="#author" aria-controls="author" role="tab" data-toggle="tab">Author</a></li>
									<li role="presentation"><a href="#publisher" aria-controls="publisher" role="tab" data-toggle="tab">Publisher</a></li>
									<li role="presentation"><a href="#category" aria-controls="category" role="tab" data-toggle="tab">Category</a></li>
									<li role="presentation"><a href="#reader" aria-controls="reader" role="tab" data-toggle="tab">Reader</a></li>
									<li role="presentation"><a href="#branch" aria-controls="branch" role="tab" data-toggle="tab">Branch</a></li>
								  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="book">
									<form method="post" action="#"  enctype="multipart/form-data"  class="form-horizontal">
										<div class="form-group">
											<label for="book_isbn" class="col-sm-2 control-label">ISBN</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="book_isbn" placeholder="ISBN"  name="book_isbn">
											</div>
										</div>
										<div class="form-group">
											<label for="book_title" class="col-sm-2 control-label">Title</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="book_title" placeholder="title"  name="book_title">
											</div>
										</div>
										<div class="form-group">
											<label for="book_description" class="col-sm-2 control-label">Description</label>
											<div class="col-sm-10">
											  <textarea  class="form-control" id="book_description" name="book_description" placeholder="Description"></textarea>
											</div>
										</div>
										<div class="form-group">
											<label for="book_thumbnail" class="col-sm-2 control-label">Thumbnail</label>
											<div class="col-sm-10">
											  <input type="file" class="form-control" id="book_thumbnail" placeholder="Attach thumbnail"  name="book_thumbnail">
											</div>
										</div>
										
										<div class="form-group">
											<label for="book_edition" class="col-sm-2 control-label">Edition</label>
											<div class="col-sm-10">
											  <input type="text" class="form-control" id="book_edition" placeholder="Edition"  name="book_edition">
											</div>
										</div>
										<div class="form-group">
											<label for="book_date" class="col-sm-2 control-label">Publication date</label>
											<div class="col-sm-10">
											  <input type="date" class="form-control" id="book_date" placeholder="Date"  name="book_date">
											</div>
										</div>
										
										<div class="form-group">
											<label for="publisher_id" class="col-sm-2 control-label">Publisher</label>
											<div class="col-sm-10">
												<select name="publisher_id"  class="form-control" id="publisher_id">
													<?php echo $admin->get_publishers(); ?>
												</select>
											</div>
										</div>
										
										
										<div class="form-group">
											<label for="category_id" class="col-sm-2 control-label">Category</label>
											<div class="col-sm-10">
												<select name="category_id"  class="form-control" id="category_id">
													<?php echo $admin->get_categories(); ?>
												</select>
											</div>
										</div>
										
										<input type="hidden" name="hidden" value="add_book_detail" />
										
											<div id="add_author_div"  class="form-group">
											<label for="" class="col-sm-2 control-label">Authors</label>
												<div class="col-sm-10">
													<select name="add_author_id_0" id="add_author_id_0"  class="form-control">
														<option value="0">Choose author</option>
														<?php echo $admin->get_authors(); ?>
													</select>
													<select name="add_author_id_1" id="add_author_id_1"  class="form-control" style="display: none">
														<option value="0">Choose author</option>
														<?php echo $admin->get_authors(); ?>
													</select>
													<select name="add_author_id_2" id="add_author_id_2"  class="form-control" style="display: none">
														<option value="0">Choose author</option>
														<?php echo $admin->get_authors(); ?>
													</select>
													<select name="add_author_id_3" id="add_author_id_3"  class="form-control" style="display: none">
														<option value="0">Choose author</option>
														<?php echo $admin->get_authors(); ?>
													</select>
													<select name="add_author_id_4" id="add_author_id_4"  class="form-control" style="display: none">
														<option value="0">Choose author</option>
														<?php echo $admin->get_authors(); ?>
													</select>
													<input type='button' value='Add author' id='add_author_button'  class="btn btn-default">
												</div>

											</div>
											<!--<input type='button' value='Remove last' id='remove_author_button'>-->
										<div id="add_author_div"  class="form-group">
											<label for="" class="col-sm-2 control-label"></label>
												<div class="col-sm-10">
										<input type="submit" value="Add" class="btn btn-primary" />
											</div></div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="qty">
									<form method="post" action="#"  class="form-horizontal">
										<table class="table table-hover" style="width: auto;">
											<?php
											echo("<tr><td>Book title</td><td><select name='add_book_isbn' class='form-control'>" . $admin->get_book_isbn() . "</select></td></tr>");
											echo $admin->get_branches_only_id();
										?>
										<input type="hidden" name="hidden" value="add_book_qty" />
										<tr><td></td><td><input type="submit" value="Add" class="btn btn-primary"/></td></tr>
										</table>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="author">
									<form method="post" action="#"  enctype="multipart/form-data" class="form-horizontal">
										<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" name="author_name" placeholder="Name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Profile photo</label><div class="col-sm-10"><input type="file" name="author_thumbnail" id="author_thumbnail" value="Attach thumbnail" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Email</label><div class="col-sm-10"><input type="email" name="author_email" placeholder="email" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Website</label><div class="col-sm-10"><input type="url" name="author_website" placeholder="website" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Country</label><div class="col-sm-10"><input type="text" name="author_country" placeholder="Country" class="form-control" /></div></div>
										<input type="hidden" name="hidden" value="add_author" />
										<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="submit" value="Add" class="btn btn-primary" /></div></div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="publisher">
								
									<form method="post" action="#" class="form-horizontal">
										<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" name="publisher_name" placeholder="Name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Website</label><div class="col-sm-10"><input type="url" name="publisher_website" placeholder="website" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Email</label><div class="col-sm-10"><input type="email" name="publisher_email" placeholder="email" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Street no</label><div class="col-sm-10"><input type="text" name="publisher_address_street_number" placeholder="street no" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Street name</label><div class="col-sm-10"><input type="text" name="publisher_address_street_name" placeholder="street name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">City</label><div class="col-sm-10"><input type="text" name="publisher_address_city" placeholder="city" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">State</label><div class="col-sm-10"><input type="text" name="publisher_address_state" placeholder="state" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Zip</label><div class="col-sm-10"><input type="text" name="publisher_address_zip" placeholder="zip" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Country</label><div class="col-sm-10"><input type="text" name="publisher_address_country" placeholder="country" class="form-control" /></div></div>
										<input type="hidden" name="hidden" value="add_publisher" />
										<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="submit" value="Add" class="btn btn-primary" /></div></div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="category">
									<form method="post" action="#" class="form-horizontal">
										<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" name="category_title" placeholder="title" class="form-control" /></div></div>
										<input type="hidden" name="hidden" value="add_category" />
										<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="submit" value="Add" class="btn btn-primary" /></div></div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="reader">
								
									<form method="post" action="#" enctype="multipart/form-data" class="from-horizontal">
										<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" name="reader_name" placeholder="Name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Email</label><div class="col-sm-10"><input type="email" name="reader_email" placeholder="email" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Profile photo</label><div class="col-sm-10"><input type="file" name="reader_thumbnail" id="reader_thumbnail" value="Attach thumbnail" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Phone number</label><div class="col-sm-10"><input type="text" name="reader_ph_no" placeholder="Phone number" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Street number</label><div class="col-sm-10"><input type="text" name="reader_address_street_number" placeholder="street no" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Street name</label><div class="col-sm-10"><input type="text" name="reader_address_street_name" placeholder="street name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">City</label><div class="col-sm-10"><input type="text" name="reader_address_city" placeholder="city" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">State</label><div class="col-sm-10"><input type="text" name="reader_address_state" placeholder="state" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Zipcode</label><div class="col-sm-10"><input type="text" name="reader_address_zip" placeholder="zip"  class="form-control"/></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Country</label><div class="col-sm-10"><input type="text" name="reader_address_country" placeholder="country" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">Library branch</label><div class="col-sm-10">
											<select name="reader_branch" class="form-control">
														<?php echo $admin->get_branches_combobox(); ?>
													</select>
											
										</div></div>
										<input type="hidden" name="hidden" value="add_reader" />
										<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="submit" value="Add" class="btn btn-primary" /></div></div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="branch">
									<form method="post" action="#" class="form-horizontal">
										<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" name="branch_name" placeholder="Name" class="form-control" /></div></div>
										<div class="form-group"><label class="col-sm-2 control-label">City</label><div class="col-sm-10"><input type="text" name="branch_city" placeholder="City" class="form-control" /></div></div>
										<input type="hidden" name="hidden" value="add_branch" />
										<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="submit" value="Add" class="btn btn-primary" /></div></div>
									</form>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div>