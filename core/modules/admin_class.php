<?php
	
	error_reporting(E_ERROR);
	include("db.php");
	include("configurations.php");

	class Admin extends Database{
		
		private $db;
		private $error = false;
		private $error_msg;
		private $sql;
		
		function get_sql(){
			return $this->sql;
		}
		
		public function getErrorDetails(){
			if($this->error){
				$params = array(
					"error" => $this->error_msg
				);
			}
			return $params;
		}
		
		function __construct() {
			$this->db = new Database();
			$this->db->connect();
	  	}
		
		function add_category($title){
			$params = array(
				'category_id' => 0,
				'title' => $title
			);
			if(!$this->db->insert("categories", $params)){
				$this->error = true;
				$this->error_msg = "Error while adding category to database <br>" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_publisher($params){
			if(!$this->db->insert("publisher", $params)){
				$this->error = true;
				$this->error_msg = "Error while adding publisher to database <br>" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_book_detail($params, $add_author_id_0, $add_author_id_1, $add_author_id_2, $add_author_id_3, $add_author_id_4){
			if(!$this->db->insert("book_info", $params)){
				/*$n = count($add_author_id);
				for($i=0; $i < $n; $i++){
					
				}*/
				$this->error = true;
				$this->error_msg = "Error while adding book to database <br>" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				
				if($add_author_id_0!=0){
					$params1 = array(
						'ISBN' => $params['ISBN'],
						'author_id' => $add_author_id_0
					);
					$this->db->insert("book_author", $params1);
				}
				if($add_author_id_1!=0){
					$params1 = array(
						'ISBN' => $params['ISBN'],
						'author_id' => $add_author_id_1
					);
					$this->db->insert("book_author", $params1);
				}
				if($add_author_id_2!=0){
					$params1 = array(
						'ISBN' => $params['ISBN'],
						'author_id' => $add_author_id_2
					);
					$this->db->insert("book_author", $params1);
				}
				if($add_author_id_3!=0){
					$params1 = array(
						'ISBN' => $params['ISBN'],
						'author_id' => $add_author_id_3
					);
					$this->db->insert("book_author", $params1);
				}
				if($add_author_id_4!=0){
					$params1 = array(
						'ISBN' => $params['ISBN'],
						'author_id' => $add_author_id_4
					);
					$this->db->insert("book_author", $params1);
				}
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_author($params){
			if(!$this->db->insert("authors", $params)){
				$this->error = true;
				$this->error_msg = "Error while adding author to database <br>" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_reader($params){
			if(!$this->db->insert("readers", $params)){
				$this->error = true;
				$res = $this->db->getResult();
				$this->error_msg = "Error while adding author to database" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_branch($params){
			if(!$this->db->insert("branches", $params)){
				$this->error = true;
				$this->error_msg = "Error while adding branch to database <br>" . $this->db->getSql();
				return $this->getErrorDetails();
			}
			else{
				$result = $this->db->getResult();
				
				return $result[0];
			}
			$this->sql = $this->db->getSql();
		}
		
		function add_book_qty($isbn, $qty){
			//book_id, ISBN, lib_id, status
			$lib_id = array();
			$book_qty = array();
			foreach($qty as $key => $value)
			{
				$lib_id[] = $key;
				$book_qty[] = $value;
			}
			$n = count($lib_id);
			for($i = 0; $i < $n; $i++){
				$current_lib_id = $lib_id[$i];
				$current_qty = $book_qty[$i];
				$params = array(
					'book_id' => 0,
					'ISBN' => $isbn,
					'lib_id' => $current_lib_id,
					'status' => 1
				);
				for($k = 0; $k < $current_qty; $k++){
					$this->db->sql("INSERT INTO `books` (`book_id`, `ISBN`, `lib_id`, `status`) VALUES (0, $isbn, $current_lib_id, 1)");
				}
			}
		}
		
		function get_categories(){
			$query = "SELECT * FROM categories ORDER BY title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['category_id'] . '">' . $res[$i]['title'] . '</option>';
			}
			return $data;
		}
		
		
		function get_publishers(){
			$query = "SELECT publisher_id, name FROM publisher ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['publisher_id'] . '">' . $res[$i]['name'] . '</option>';
			}
			return $data;
		}
		
		
		function get_book_isbn(){
			$query = "SELECT title, ISBN FROM book_info ORDER BY title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['ISBN'] . '">' . $res[$i]['title'] . '</option>';
			}
			return $data;
		}
		
		
		function get_authors(){
			$query = "SELECT author_id, name FROM authors ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['author_id'] . '">' . $res[$i]['name'] . '</option>';
			}
			return $data;
		}
		
		
		
		function get_branches_only_id(){
			$query = "SELECT lib_id, name FROM branches ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<tr><td>' . $res[$i]['name'] . '</td><td>
				<input type="text" class="form-control" name="add_book_qty[' . $res[$i]['lib_id'] .']" /></td></tr>';
			}
			return $data;
		}
		
		function get_branches_combobox(){
			$query = "SELECT lib_id, name FROM branches ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['lib_id'] . '">' . $res[$i]['name'] . '</option>';
			}
			return $data;
		}
		
		function get_branches(){
			$query = "SELECT * FROM branches ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function book_borrow($book_id, $reader_id, $lib_id){
			
			/*$query = "SELECT book_id FROM books WHERE status=1 AND lib_id=" . $this->lib_id . " AND ISBN=" . $ISBN;
			$this->db->sql($query);
			$res = $this->db->getResult();
			
			if(count($res) > 0){
				$book_id = $res[0]['book_id'];
				$params = array(
					'borrow_id' => 0,
					'book_id' => $book_id,
					'reader_id' => $this->reader_id,
					'lib_id' => $this->lib_id,
					'bdatetime' => time(),
					'rdatetime' => 0,
					'is_due' => 0,
					'is_authorize' => 0
				);
				if(!$this->db->insert("borrowed", $params)){
					return array("error" => "Error while borrowing book", "error_code" => 2);
				}
				$this->db->sql("UPDATE books SET status=3 WHERE book_id=" . $book_id);
				return array();
			}
			else{
				return array("error" => "No books available for borrow", "error_code" => 1);
			}*/
			
			$query = "SELECT count(*) AS borrowCount FROM borrowed WHERE reader_id=" . $reader_id . " AND rdatetime=0";
				$this->db->sql($query);
				$res = $this->db->getResult();
				if($res[0]['borrowCount'] < 10){
					$query = "SELECT status FROM books WHERE book_id=" . $book_id;
					$this->db->sql($query);
					$res = $this->db->getResult();
					if($res[0]['status'] == 1){
						$params = array(
							'borrow_id' => 0,
							'book_id' => $book_id,
							'reader_id' => $reader_id,
							'lib_id' => $lib_id,
							'bdatetime' => time(),
							'rdatetime' => 0,
							'is_due' => 0,
							'is_authorize' => 0
						);
						if(!$this->db->insert("borrowed", $params)){
							return array("error" => "Error while borrowing book", "error_code" => 2);
						}
						else{
							$this->db->sql("UPDATE books SET status=3 WHERE book_id=" . $book_id);
							return array();
						}
					}
					else{
						return array("error" => "This book is not available", "error_code" => 2);
					}
				}
				else{
					return array("error" => "Maximum 10 borrows are allowded", "error_code" => 2);
				}
		}
		
		function borrow_from_reserve($reserve_id){
			$query = 'SELECT book_id, reader_id, lib_id reserve_time FROM reserve WHERE reserve_id=' . $reserve_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$book_id = $res[0]['book_id'];
			$lib_id = $res[0]['lib_id'];
			$reader_id = $res[0]['reader_id'];
			$reserve_time = $res[0]['reserve_time'];
			$reserve_date = date('Y-m-d', $reserve_time);
			$reserve_date_midnight_timestamp = strtotime($reserve_date);
			$due_date_6_pm_timestamp = intval($reserve_date_midnight_timestamp) + (18*60*60);
			$cur_timestamp = time();
			if($cur_timestamp < $due_date_6_pm_timestamp){
				$query = "SELECT count(*) AS borrowCount FROM borrowed WHERE reader_id=" . $reader_id . " AND rdatetime=0";
				$this->db->sql($query);
				$res = $this->db->getResult();
				if($res[0]['borrowCount'] < 10){
					$params = array(
						'borrow_id' => 0,
						'book_id' => $book_id,
						'reader_id' => $reader_id,
						'lib_id' => $lib_id,
						'bdatetime' => time(),
						'rdatetime' => 0,
						'is_due' => 0,
						'is_authorize' => 0
					);
					if(!$this->db->insert("borrowed", $params)){
						return array("error" => "Error while borrowing book", "error_code" => 2);
					}
					else{
						$this->db->sql("UPDATE books SET status=3 WHERE book_id=" . $book_id);
						$this->db->delete("reserve","reserve_id=" . $reserve_id);
						return array();
					}
				}
				else{
					$this->db->delete("reserve","reserve_id=" . $reserve_id);
					return array("error" => "Maximum 10 borrows are allowded", "error_code" => 2);
				}
			}
			else{
				$this->db->delete("reserve","reserve_id=" . $reserve_id);
				return array("error" => "Borrowing cannot be possible after 6PM of " . $reserve_date, "error_code" => 1);
			}
		}
		
		function get_top_10_borrowed($lib_id){
			$query = 'select book_info.ISBN, book_info.title, count(*) times from book_info, borrowed, books where borrowed.book_id = books.book_id and book_info.ISBN = books.ISBN and borrowed.lib_id = ' . $lib_id . ' group by book_info.ISBN order by times DESC limit 10';
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_top_10_frequent_borrower($lib_id){
			$query = 'select readers.reader_id, readers.name, count(*) as total_books from readers, borrowed where readers.reader_id = borrowed.reader_id and borrowed.lib_id = '. $lib_id . ' group by readers.reader_id order by total_books DESC limit 10';
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		function avg_fine_paid($reader_id){
			$query = 'SELECT bdatetime, rdatetime FROM borrowed WHERE is_due=1';
			$this->db->sql($query);
			$res = $this->db->getResult();
			$total = 0;
			$result = array();
			for($i=0; $i < count($res); $i++){
				$diff = $res[$i]['rdatetime'] - $res[$i]['bdatetime'];
				$days = diff / (60*60*24);
				$due_days = $days-20;
				if($due_days >0){
					$total  =$total + $due_days*0.2;
				}
			}
			$result['fine'] = $total;
			return $result;
		}
		
		function book_return($book_id, $reader_id){
			$return_date = time();
			$query = "SELECT bdatetime, borrow_id FROM borrowed WHERE rdatetime=0 AND book_id=" . $book_id . " AND reader_id=" . $reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$borrow_date = $res[0]['bdatetime'];
			$borrow_id = $res[0]['borrow_id'];
			$days = round($return_date - $borrow_date)/(60*60*24);
			if($this->db->sql("UPDATE borrowed SET rdatetime=" . $return_date . " WHERE borrow_id=" . $borrow_id)){
				if($days > 20){
					$this->db->sql("UPDATE borrowed SET is_due=1 WHERE borrow_id=" . $borrow_id);
				}
				$this->db->sql("UPDATE books SET status=1 WHERE book_id=" . $book_id);
			}
			else{
				return array("error" => "Error while returning book", "error_code" => 2);
			}
		}
	}
?>