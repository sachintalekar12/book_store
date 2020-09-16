<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Model {

    public function get_categories()
    {
        $this->db->from('book_store.categories');
        $row= $this->db->get();
        return $row->result();
    }


    public function addbook($book)
    {
        $data['book_name']=$book['book_name'];
		$data['author_email'] =$book['author_email'];
		$data['website']=$book['website'];
        $data['cover_picture']=$book['cover_picture'];
        $data['dt_publish']= date("Y-m-d", strtotime($book['date'])); 
        $data['review']=$book['review'];
        $data['isbn_number']=$book['isbn'];
        $data['price']=$book['price'];
        $data['type']=$book['type'];
        $data['rating']=$book['customRadioInline1'];
        $data['is_paperback']=$book['paperback'];
        $data['is_hardback']=$book['hardback'];
        $data['is_ebook']=$book['ebook'];
        $data['in_stock']=$book['stock'];
        $data['dt_modified']=date('Y-m-d H:i:s');
      
        $this->db->insert('book_store.books',$data);

        $book_id=$this->db->insert_id();
        $categories=$book['category'];
        $result = array();
        foreach($categories as $category){
           $result[]=array(
               'book_id' => $book_id,
               'cat_id' => $category
           );
        }
        return $this->db->insert_batch('book_categories', $result);

    }


	public function get_books()
	{
		$this->db->select(['books.book_id','books.book_name','books.cover_picture','books.price','books.type','books.is_paperback','books.is_hardback','books.is_ebook','books.in_stock']);
		$this->db->from('books');
		$row= $this->db->get();
		return $row->result();
	}


	public function book_category($id)
	{
		$this->db->select(['categories.cat_id','categories.category']);
		$this->db->from('categories');
		$this->db->where('book_categories.book_id', $id);
		$this->db->join('book_categories','book_categories.cat_id = categories.cat_id');
		$row = $this->db->get();
		return $row->result();
	}

	public function edit_book($id,$book)
	{ 
        $data['book_name']=$book['book_name'];
		$data['author_email'] =$book['author_email'];
		$data['website']=$book['website'];
        $data['cover_picture']=$book['cover_picture'];
        $data['dt_publish']= date("Y-m-d", strtotime($book['date'])); 
        $data['review']=$book['review'];
        $data['isbn_number']=$book['isbn'];
        $data['price']=$book['price'];
        $data['type']=$book['type'];
        $data['rating']=$book['customRadioInline1'];
        $data['is_paperback']=$book['paperback'];
        $data['is_hardback']=$book['hardback'];
        $data['is_ebook']=$book['ebook'];
        $data['in_stock']=$book['stock'];
        $data['dt_modified']=date('Y-m-d H:i:s');

        $this->db->where('book_id',$id);
		$this->db->update('books',$data);

		$this->db->where('book_id', $id);
		$this->db->delete('book_categories');

        $categories=$book['category'];
        $result = array();
        foreach($categories as $category){
           $result[]=array(
               'book_id' => $id,
               'cat_id' => $category
           );
        }
		
        $this->db->insert_batch('book_categories', $result);

		return true;  
	}

	public function get_book_info($id)
	{
		$this->db->where('book_id',$id);
		$get_data = $this->db->get('books');

		return $get_data->row();
	}

	public function delete_book_info($id)
	{
	

		$this->db->select(['books.cover_picture']);
		$this->db->where('book_id',$id);
		$cover = $this->db->get('books');


		$tables = array('books', 'book_categories');
		$this->db->where('book_id',$id);
		$this->db->delete($tables);

		return $cover->first_row();


		  
	}
} 
?>
