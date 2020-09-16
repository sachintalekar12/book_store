<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <title>Add Book</title>
    <style>
    .container {
    max-width: 700px;
    margin: 80px auto;
    padding: 50px;
    box-shadow: 0px 0px 8px 1px #c1c1c1;
    border-radius: 8px;
    position: relative;
    }
    .dropdown {
    display: block !important;
    width: 100% !important;
    }
    .btn-light {
    color: #212529;
    background-color: white;
    border-color: #ced4da;
    }
    .custom-control {
    display: inline-block !important;
    }
    .toggle-off {
    white-space: nowrap;
    }
    .form-group {
    margin-bottom: 1.3rem;
    }
    .custom-control {
    margin-right: 15px;
    }
    .header {
    position: absolute;
    width: 100%;
    height: 70px;
    background-color: #007bff!important;
    top: 0;
    left: 0;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    }
    .main {
    padding-top: 50px;
    }
    .header h1 {
    text-align: center;
    color: white;
    padding: 10px 0px;
    }
    .btn-success:not(:disabled):not(.disabled).active, .btn-success:not(:disabled):not(.disabled):active, .show>.btn-success.dropdown-toggle {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    }
    .btn-info, .btn-success,  .btn-success:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    }
    .center-align {
    text-align: center;
    }
    /*  */

    input[type="file"] {
    display: none;
    }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="header">
          <h1>Edit Book</h1>
        </div>
        <div class="main">
    <?php echo form_open_multipart('books/edit/'.$book_info->book_id.'')  ?>
        <div class="form-group">
          <label for="bookName">Book Name</label>
          <?php echo form_input(['name'=> 'book_name','value'=> $book_info->book_name,'class'=> 'form-control','id'=> 'bookName','placeholder'=> 'Enter Book Name']) ?>
          <?php  echo form_error('book_name', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
          <label for="authorEmail">Author Email</label>
              <?php echo form_input(['name'=> 'author_email','value'=> $book_info->author_email, 'class'=> 'form-control', 'id'=> 'authorEmail', 'placeholder'=> 'Enter Author Email'])  ?>
          <?php  echo form_error('author_email', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
          <label for="website">Website</label>
          <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">https://www.</span>
          </div>
          <?php echo form_input(['name'=> 'website','value'=> $book_info->website, 'class'=> 'form-control', 'id'=> 'website', 'placeholder'=> ' Enter Website']) ?>
          </div>
          <?php  echo form_error('website', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
          <label style="display: block " class="my-1 mr-2" for="inlineFormCustomSelectPref">Cover Picture</label>
          <label  class="btn btn-primary"> Upload
					<?php echo form_upload(['name'=> 'cover_picture']) ?></label>
          <?php  echo form_error('cover_picture', '<div class="text-danger">','</div>') ?>
        </div>
				<?php echo form_hidden('cover_picture_old',$book_info->cover_picture) ?>
        <div class="form-group">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Categories (multi-select)</label>
          <select class="selectpicker" id="category" name="category[]"  multiple data-live-search="true">
            <?php if(count($categories)): ?>
						<?php foreach($categories as $row ):?>
							<option value="<?php echo $row->cat_id; ?>"<?php echo $row->selected ; ?> ><?php echo $row->category;  ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
          <?php  echo form_error('category[]', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Date Of Publication</label>
          <?php  echo form_input(['name'=>'date', 'id'=> 'datepicker', 'value'=> $book_info->dt_publish, 'width'=> '100%']) ?>
          <?php  echo form_error('date', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group"></div>
        <div class="form-row">
          <div class="col">
            <div class="form-group">
              <label for="website">ISBN Number</label>
              <?php echo form_input(['name'=> 'isbn','class'=> 'form-control','value'=> $book_info->isbn_number, 'id'=> 'website', 'placeholder'=> 'Enter ISBN Number']) ?>
              <?php  echo form_error('isbn', '<div class="text-danger">','</div>') ?>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label for="website">Price</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">&#8377</span>
                </div>
                <?php echo form_input(['name'=>'price','value'=> $book_info->price,'class'=> 'form-control','aria-label'=> 'Amount (to the nearest dollar)'])  ?>
              </div>
              <?php  echo form_error('price', '<div class="text-danger">','</div>') ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Type</label>
          <select name="type"  class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option disabled selected>Choose...</option>
						<?php if($book_info->type == 1) { ?>
            <option value="1" selected>Magazine</option>
            <option value="2">Novel</option>
            <option value="3">Textbook</option>
						<?php }elseif($book_info->type == 2){ ?>
						<option value="1">Magazine</option>
            <option value="2" selected>Novel</option>
            <option value="3">Textbook</option>
						<?php }elseif($book_info->type == 3){ ?>
						<option value="1">Magazine</option>
            <option value="2">Novel</option>
            <option value="3" selected>Textbook</option>
						<?php }?>
          </select>
          <?php  echo form_error('type', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group ">
          <label style="display: block" class="my-1 mr-2" for="inlineFormCustomSelectPref">Format</label>
          <div class="custom-control custom-checkbox">
            <?php echo form_checkbox(['name'=> 'paperback','value'=>'1','checked'=>$book_info->is_paperback==1 ? true : '','class'=> 'custom-control-input','id'=> 'customCheck1']) ?>
            <label class="custom-control-label" for="customCheck1">Paperback</label>
          </div>
          <div class="custom-control custom-checkbox">
            <?php echo form_checkbox(['name'=> 'hardback','value'=>'1','checked'=>$book_info->is_hardback==1 ? true : '','class'=> 'custom-control-input','id'=> 'customCheck2']) ?>
            <label class="custom-control-label" for="customCheck2">Hardback</label>
          </div>
          <div class="custom-control custom-checkbox">
            <?php echo form_checkbox(['name'=> 'ebook','value'=>'1','checked'=>$book_info->is_ebook==1 ? true : '','class'=> 'custom-control-input','id'=> 'customCheck3']) ?>
            <label class="custom-control-label" for="customCheck3">ebook</label>
          </div>
          <?php  echo form_error('format', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group ">
          <label style="display: block" class="my-1 mr-2" for="inlineFormCustomSelectPref">In Stock</label>
          <?php echo form_checkbox(['name'=> 'stock', 'value'=>'1','checked'=>$book_info->in_stock==1 ? true : '', 'data-toggle'=> 'toggle', 'data-on'=> 'Available','data-off'=>'Out Of Stock','data-onstyle'=> 'success','data-offstyle'=> 'danger', 'data-height'=>'30']) ?>
        </div>
        <div class="form-group">
          <label style="display: block" class="my-1 mr-2" for="inlineFormCustomSelectPref">Rating</label>
          <div class="custom-control custom-radio custom-control-inline">
					  <?php echo form_radio(['id'=>'customRadioInline1','name'=>'customRadioInline1','checked'=>$book_info->rating == 1 ? true : '','value'=>'1','class'=>'custom-control-input'])?>
            <label class="custom-control-label" for="customRadioInline1">1</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
					 <?php echo form_radio(['id'=>'customRadioInline2','name'=>'customRadioInline1','checked'=>$book_info->rating == 2 ? true : '','value'=>'2','class'=>'custom-control-input'])?>
            <label class="custom-control-label" for="customRadioInline2">2</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
					<?php echo form_radio(['id'=>'customRadioInline3','name'=>'customRadioInline1','checked'=>$book_info->rating == 3 ? true : '','value'=>'3','class'=>'custom-control-input'])?>
            <label class="custom-control-label" for="customRadioInline3">3</labl>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
					<?php echo form_radio(['id'=>'customRadioInline4','name'=>'customRadioInline1','checked'=>$book_info->rating == 4 ? true : '','value'=>'4','class'=>'custom-control-input'])?>
            <label class="custom-control-label" for="customRadioInline4">4</labl>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
					<?php echo form_radio(['id'=>'customRadioInline5','name'=>'customRadioInline1','checked'=>$book_info->rating == 5 ? true : '','value'=>'5','class'=>'custom-control-input'])?>
            <label class="custom-control-label" for="customRadioInline5">5</labl>
          </div>
          <?php  echo form_error('customRadioInline1', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
          <label for="comment">Review</label>
          <?php echo form_textarea(['name'=> 'review', 'value'=>  $book_info->review ,'class'=> 'form-control', 'rows'=> '5', 'id'=>'comment']) ?>
          <?php  echo form_error('review', '<div class="text-danger">','</div>') ?>
        </div>
        <div class="form-group">
        <div class="center-align">
          <button type="submit" class="btn btn-primary">Update</button>
          <a  class="btn btn-danger" href="<?php echo site_url('books') ?>">Cancel</a>
        </div>
      </div>
      <?php echo form_close() ?>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
      $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
  </body>
</html>
