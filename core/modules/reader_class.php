<?php
	
	error_reporting(E_ERROR);
	session_start();
	include("db.php");
	include("configurations.php");
	error_reporting(E_ERROR);

	class Reader extends Database{
		
		private $db;
		private $error = false;
		private $error_msg;
		private $sql;
		private $lib_id;
		private $reader_id;
		
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
			$this->lib_id = $_SESSION['lib_id'];
			$this->reader_id = $_SESSION['reader_id'];
	  	}
		
		function get_search_by_ISBN($q){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND bi.ISBN='" . $q . "' ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function get_search_by_title($q){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND LOWER(bi.title) LIKE LOWER('%" . $q . "%') ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = str_replace($q, "<strong>" . $q . "</strong>", $res[$i]['title']);
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function get_search_by_category($q){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND LOWER(c.title) LIKE LOWER('%" . $q . "%') ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = str_replace($q, "<strong>" . $q . "</strong>", $res[$i]['category']);
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function get_search_by_publisher($q){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND LOWER(p.name) LIKE LOWER('%" . $q . "%') ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = str_replace($q, "<strong>" . $q . "</strong>", $res[$i]['publisher']);
				$data[] = $result;
			}
			return $data;
		}
		
		
		
		
		function reserve_book($ISBN){
			/*reserve_id,
			book_id,
			reader_id,
			lib_id,
			reserve_time*/
			$query = "SELECT book_id FROM books WHERE status=1 AND lib_id=" . $this->lib_id . " AND ISBN=" . $ISBN;
			$this->db->sql($query);
			$res = $this->db->getResult();
			
			if(count($res) > 0){
				$book_id = $res[0]['book_id'];
				$params = array(
					'reserve_id' => 0,
					'book_id' => $book_id,
					'reader_id' => $this->reader_id,
					'lib_id' => $this->lib_id,
					'reserve_time' => time()
				);
				if(!$this->db->insert("reserve", $params)){
					return array("error" => "Error while reserving book", "error_code" => 2);
				}
				$this->db->sql("UPDATE books SET status=2 WHERE book_id=" . $book_id);
				return array();
			}
			else{
				return array("error" => "No books available for reserve", "error_code" => 1);
			}
		}
		
		function get_current_borrowed(){
			$query = "SELECT br.borrow_id FROM borrowed br, books bk WHERE br.lib_id=" . $lib_id . " AND br.reader_id=" . $reader_id . " AND bk.book_id=br.book_id and bk.status=3";
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_all_details(){
			$data = array();
			$query = "SELECT name FROM branches WHERE lib_id=" . $this->lib_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data['branch_name'] = $res[0]['name'];
			$query = "SELECT * FROM readers WHERE reader_id=" . $this->reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data['reader_name'] = $res[0]['name'];
			$data['reader_thumbnail'] = "data:image/jpeg;base64," . $res[0]['thumbnail'];
			return $data;
		}
		
		function check_reader_exists($reader_id){
			$query = "SELECT * FROM readers WHERE reader_id=" . $reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			if(count($res) == 1){
				return true;
			}else{
				return false;
			}
		}
		function get_branches_only_id(){
			$query = "SELECT lib_id, name FROM branches ORDER BY name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = "";
			for($i=0;$i<count($res);$i++){
				$data .= '<option value="' . $res[$i]['lib_id'] . '">' . $res[$i]['name'] . '</option>';
			}
			return $data;
		}
		
		function get_top_10_borrow_from_branch(){
			/*$query = 'select book_info.ISBN, book_info.title, book_info.thumbnail, count(*) AS countNo
						from book_info, borrowed, books
						where borrowed.book_id = books.book_id and
								book_info.ISBN = books.ISBN and
								borrowed.lib_id = ' . $this->lib_id . '
						group by book_info.ISBN  LIMIT 10';*/
			$query = 'select book_info.ISBN, book_info.title, book_info.thumbnail, count(*) AS countNo
from book_info, borrowed, books
where borrowed.book_id = books.book_id and
		book_info.ISBN = books.ISBN and
        borrowed.lib_id = ' . $this->lib_id . '
group by book_info.ISBN
order by countNo desc
limit 10';
			$this->db->sql($query);
			$res = $this->db->getResult();
								//echo "<pre>" . print_r($res) . "</pre>";
			return $res;
		}
		
		function get_top_10_borrow(){
			$query = 'select book_info.ISBN, book_info.title, book_info.thumbnail, count(*) AS count
						from book_info, borrowed, books
						where borrowed.book_id = books.book_id and
								book_info.ISBN = books.ISBN
						group by book_info.ISBN  LIMIT 10';
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_categories(){
			$query = 'select c.category_id, c.title, count(*) AS countNo FROM categories c, book_info b WHERE b.category_id=c.category_id GROUP BY b.category_id ORDER BY c.title ASC';
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_authors(){
			$query = "SELECT a.author_id, a.name AS title, count(*) AS countNo FROM authors a, book_author b WHERE a.author_id=b.author_id GROUP BY b.author_id ORDER BY a.name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_publishers(){
			$query = "SELECT p.publisher_id, p.name AS title, count(*) AS countNo FROM publisher p, book_info b WHERE p.publisher_id=b.publisher_id GROUP BY p.publisher_id ORDER BY p.name ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			return $res;
		}
		
		function get_specific_category($id){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND bi.category_id='" . $id . "' ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function get_specific_author($id){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p, book_author ba WHERE bi.publisher_id=p.publisher_id AND ba.ISBN=bi.ISBN AND bi.category_id=c.category_id AND ba.author_id='" . $id . "' ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function get_specific_publisher($id){
			$query = "SELECT bi.ISBN, bi.title, bi.thumbnail, c.title AS 'category', p.name AS 'publisher'  FROM book_info bi, categories c, publisher p WHERE bi.publisher_id=p.publisher_id AND bi.category_id=c.category_id AND bi.publisher_id='" . $id . "' ORDER BY bi.title ASC";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['category'] = $res[$i]['category'];
				$result['publisher'] = $res[$i]['publisher'];
				$data[] = $result;
			}
			return $data;
		}
		
		function show_book_detail($id){
			$query = "SELECT bi.title, bi.description, bi.thumbnail, bi.edition, bi.publication_date, c.category_id, c.title AS category_title, p.publisher_id, p.name AS publisher_name  FROM book_info bi, publisher p, categories c WHERE bi.category_id=c.category_id AND bi.publisher_id=p.publisher_id AND bi.ISBN=" . $id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			$data['book_title'] = $res[0]['title'];
			$data['book_description'] = $res[0]['description'];
			$data['book_thumbnail'] = base64_encode($res[0]['thumbnail']);
			$data['book_edition'] = $res[0]['edition'];
			$data['book_publish_date'] = date('m/d/Y',$res[0]['publication_date']);
			$data['category_id'] = $res[0]['category_id'];
			$data['category_title'] = $res[0]['category_title'];
			$data['publisher_id'] = $res[0]['publisher_id'];
			$data['publisher_name'] = $res[0]['publisher_name'];
			
			$query = "SELECT a.author_id, a.name FROM book_author ba, authors a WHERE ba.author_id=a.author_id AND ba.ISBN=" . $id;
			$this->db->sql($query);
			$data['authors'] = $this->db->getResult();
			
			$query = "SELECT count(*) AS borrowCount FROM borrowed WHERE reader_id=" . $this->reader_id . " AND rdatetime=0";
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data['current_borrow_count'] = $res[0]['borrowCount'];
			
			$query = "SELECT count(*) AS reserveCount FROM reserve WHERE reader_id=" . $this->reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data['current_reserve_count'] = $res[0]['reserveCount'];
			return $data;
		}
		
		function get_borrow_list(){
			$query = "SELECT br.borrow_id, bi.title, bi.thumbnail, bi.ISBN, br.bdatetime FROM borrowed br, book_info bi, books b WHERE br.book_id=b.book_id AND b.ISBN=bi.ISBN AND br.rdatetime=0 AND br.reader_id=" . $this->reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['borrow_id'] = $res[$i]['borrow_id'];
				$result['bdatetime'] = $res[$i]['bdatetime'];
				$diff = time() - $res[$i]['bdatetime'];
				if($diff > (20*24*60*60)){
					$days = $diff / (24*60*60);
					$result['fine'] = $days * 0.20;
				}
				$data[] = $result;
			}
			return $data;
		}
		
		function get_reserve_list(){
			$query = "SELECT r.reserve_id, bi.title, bi.thumbnail, bi.ISBN, r.reserve_time FROM reserve r, book_info bi, books b WHERE r.book_id=b.book_id AND b.ISBN=bi.ISBN AND r.reader_id=" . $this->reader_id;
			$this->db->sql($query);
			$res = $this->db->getResult();
			$data = array();
			for($i=0;$i<count($res);$i++){	
				$result = array();
				$result['ISBN'] = $res[$i]['ISBN'];
				$result['title'] = $res[$i]['title'];
				$result['thumbnail'] = base64_encode($res[$i]['thumbnail']);
				$result['reserve_id'] = $res[$i]['reserve_id'];
				$result['reserve_time'] = $res[$i]['reserve_time'];
				
				$reserve_time = $res[$i]['reserve_time'];
				$reserve_date = date('Y-m-d', $reserve_time);
				$reserve_date_midnight_timestamp = strtotime($reserve_date);
				$due_date_6_pm_timestamp = intval($reserve_date_midnight_timestamp) + (18*60*60);
				if(time() < $due_date_6_pm_timestamp){
					$due = round(($due_date_6_pm_timestamp - time()) / (60*60));
					if($due == 0){
						$result['due'] = "<1";
					}else{
						$result['due'] = $due;
					}
				}else{
					$result['due'] = 0;
				}
				$data[] = $result;
			}
			return $data;
		}
		
		
	}
?>