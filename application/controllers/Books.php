<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {
    private $image = FALSE;

	public function index(){

		$data=$this->fetch_books();
        $this->load->view('book-list',['book_data'=> $data]);
    }
	/* add book form load */
    public function add(){

        $this->load->model('query', 'getData');
        $categories = $this->getData->get_categories();
        $this->load->view('book-add',['categories'=> $categories]);
    }
	/* to add book details & form validation */
    public function add_books(){
       
        $this->load->library('form_validation');
        $this->image_validate('cover_picture');
        $this->format_validate();
        $this->form_validation->set_rules('book_name', 'Book Name', 'required'); 
        $this->form_validation->set_rules('author_email', 'Email', 'required|valid_email'); 
        $this->form_validation->set_rules('website', 'Website', 'required'); 
        $this->form_validation->set_rules('category[]', 'Category', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required'); 
        $this->form_validation->set_rules('isbn', 'ISBN Number', 'required'); 
        $this->form_validation->set_rules('price', 'Price', 'required|numeric'); 
        $this->form_validation->set_rules('type', 'Book type', 'required'); 
        $this->form_validation->set_rules('customRadioInline1', 'Rating', 'required'); 
        $this->form_validation->set_rules('review', 'Review', 'required');  

        if ($this->form_validation->run() === true && is_bool($this->image) === true) 
		{
        $data['book_name']=$this->input->post('book_name');
        $data['author_email']=$this->input->post('author_email');
        $data['website']=$this->input->post('website');
        $data['cover_picture']=$this->upload->data('file_name');
        $data['category']=$this->input->post('category');
        $data['date']=$this->input->post('date');
        $data['isbn']=$this->input->post('isbn');
        $data['price']=$this->input->post('price');
        $data['type']=$this->input->post('type');
        if($this->input->post('paperback') != 1){
            $data['paperback']=0;
        }else{ $data['paperback']=$this->input->post('paperback');}
        if($this->input->post('hardback') != 1){
            $data['hardback']= 0;
        }else{$data['hardback']=$this->input->post('hardback');}
        if($this->input->post('ebook') != 1){
            $data['ebook']= 0;
        }else{$data['ebook']=$this->input->post('ebook');}
        if($this->input->post('stock') != 1){
            $data['stock']= 0;
        }else{$data['stock']=$this->input->post('stock');}
        
        $data['customRadioInline1']=$this->input->post('customRadioInline1');
        $data['review']=$this->input->post('review');

        $this->load->model('query', 'insert');	
 
			if ($this->insert->addbook($data)) {
			   $this->session->set_flashdata('message', ' Book added Successfully');
               $this->session->set_flashdata('status', 'success');
               return redirect('books');
			}else{
				$this->session->set_flashdata('message', 'Failed to add book');
                $this->session->set_flashdata('status', 'danger');
                $this->add(); 
			}
            
        }else{
            if ($this->image === TRUE) 
                {
                    $data = array('image_metadata' => $this->upload->data());
                    unlink($data['image_metadata']['full_path']);$data['image_metadata'] = NULL; 
                }
             $this->add(); 
        }
    }

	/* validate image type & size  */
    public function image_validate($name){
        if (!empty($_FILES[$name]['name']))
        {
            $upload_dir = './assets';
                if (!is_dir($upload_dir)) {
                     mkdir($upload_dir);
                } 

                $config['upload_path'] = $upload_dir;
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);

            if( ! $this->upload->do_upload($name)){
                $image_error = strip_tags($this->upload->display_errors());
               
                $this->form_validation->set_rules($name, 'Cover Picture', 'required',
                array('required' => $image_error));
            }else{
                $this->image = TRUE;  
            }
            
        }else{
            $this->form_validation->set_rules($name, 'Cover Picture', 'required',);
            
        }
    }

	/* validate format to check any 1  is selected */
    public function format_validate(){

        $data['paperback']=$this->input->post('paperback');
        $data['hardback']=$this->input->post('hardback');
        $data['ebook']=$this->input->post('ebook');
        if(($data['paperback'] || $data['hardback'] || $data['ebook'] ) != 1){
            $this->form_validation->set_rules('format', 'Format', 'required');  
        }
    }

	/* get book details */
	public function fetch_books(){
		$this->load->model('query','getData');
		$books = $this->getData->get_books();
		$data   =   array();
		$c = array();
		foreach ($books as $row):
			$format=array();
			$a = new stdClass();	
			$a->id=$row->book_id;
			$a->book_name=$row->book_name;
			$a->cover_picture=$row->cover_picture;
			$a->price=$row->price;

			if($row->type == 1){
				$a->type='Magazine';
			}elseif($row->type == 2){
				$a->type='Novel';
			}else{
				$a->type='Textbook';
			}

			if($row->is_paperback == 1){
				array_push($format,'Paperback');
			}

			if($row->is_hardback == 1){
				array_push($format,'Hardback');
			}

			if($row->is_ebook == 1){
				array_push($format,'ebook');
			}
			
			$a->format=$li=implode(', ',$format);
			if($row->in_stock == 1){
				$a->in_stock="Available";
				$a->in_stock_status="success";
			}else{
				$a->in_stock="Out Of Stock";
				$a->in_stock_status="danger";
			}

			$category = $this->getData->book_category($row->book_id);

			foreach ($category as $cat):
				array_push($c,$cat->category);
				$List = implode(', ', $c);
				$a->cat=$List;
				
			endforeach;
			    
			array_push($data,$a); 
			$c=array();

		endforeach; 
 
		return $data; 
		
	}

	/* selected books category */
	public function  book_category($id)
	{
		$this->load->model('query', 'getData');
		$cate = $this->getData->get_categories();
		$SelCategory = $this->getData->book_category($id);

		$categories   =   array();
		foreach($cate as $row):
			$a = new stdClass();
			$a->cat_id = $row->cat_id;
			$a->category = $row->category;
			foreach ($SelCategory as $cat):
				if($row->cat_id === $cat->cat_id)
				{
					$a->selected='selected';
				}else{
					$a->selected='';
				}
			endforeach;
			array_push($categories,$a);
		endforeach;
		
		return $categories; 
		
	}

	/* edit book details, to get details & update it */
	public function edit($book_id){
       
        $this->load->library('form_validation');
		$this->format_validate();
		
		if (!empty($_FILES['cover_picture']['name']))
        {
		$this->image_validate('cover_picture');
		}
		
        $this->form_validation->set_rules('book_name', 'Book Name', 'required'); 
        $this->form_validation->set_rules('author_email', 'Email', 'required'); 
        $this->form_validation->set_rules('website', 'Website', 'required'); 
        $this->form_validation->set_rules('category[]', 'Category', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required'); 
        $this->form_validation->set_rules('isbn', 'ISBN Number', 'required'); 
        $this->form_validation->set_rules('price', 'Price', 'required'); 
        $this->form_validation->set_rules('type', 'Book type', 'required'); 
        $this->form_validation->set_rules('customRadioInline1', 'Rating', 'required'); 
        $this->form_validation->set_rules('review', 'Review', 'required');  

        if ($this->form_validation->run() === true && is_bool($this->image) === true) 
		{
        $data['book_name']=$this->input->post('book_name');
        $data['author_email']=$this->input->post('author_email');
		$data['website']=$this->input->post('website');
		if (!empty($_FILES['cover_picture']['name']))
        {
		$data['cover_picture']=$this->upload->data('file_name');
		unlink('assets/'.$this->input->post('cover_picture_old').'');
		}else{
		$data['cover_picture']=$this->input->post('cover_picture_old');
		}
		$data['category']=$this->input->post('category');
        $data['date']=$this->input->post('date');
        $data['isbn']=$this->input->post('isbn');
        $data['price']=$this->input->post('price');
        $data['type']=$this->input->post('type');
        if($this->input->post('paperback') != 1){
            $data['paperback']=0;
        }else{ $data['paperback']=$this->input->post('paperback');}
        if($this->input->post('hardback') != 1){
            $data['hardback']= 0;
        }else{$data['hardback']=$this->input->post('hardback');}
        if($this->input->post('ebook') != 1){
            $data['ebook']= 0;
        }else{$data['ebook']=$this->input->post('ebook');}
        if($this->input->post('stock') != 1){
            $data['stock']= 0;
        }else{$data['stock']=$this->input->post('stock');}
        
        $data['customRadioInline1']=$this->input->post('customRadioInline1');
        $data['review']=$this->input->post('review');

        $this->load->model('query', 'edit');	
 
			if ($this->edit->edit_book($book_id,$data)) {
			   $this->session->set_flashdata('message', ' Book updated Successfully');
			   $this->session->set_flashdata('status', 'success');
			   echo "<pre>";
			   print_r( $data);
			   echo"</pre>"; 
               return redirect('books');
			}else{
				$this->session->set_flashdata('message', 'Failed to update book');
                $this->session->set_flashdata('status', 'danger');
                $this->edit(); 
			}
            
        }else{
            if ($this->image === TRUE) 
                {
                    $data = array('image_metadata' => $this->upload->data());
                    unlink($data['image_metadata']['full_path']);$data['image_metadata'] = NULL; 
				}
				
				$this->load->model('query', 'getData');
				$book_info = $this->getData->get_book_info($book_id);
				
				$categories = $this->book_category($book_id);
				$this->load->view('edit_book',['categories'=> $categories,'book_info'=>$book_info]);
        }
	}
	
    /* delete book details */
	public function delete($id){
		
		$this->load->model('query', 'delete');
		$book_info = $this->delete->delete_book_info($id);
		
		unlink('assets/'.$book_info->cover_picture.'');

	}
}
