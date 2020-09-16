<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Book Listing</title>
    <style>
      .container {
        max-width: 1100px;
        margin: 80px auto;
        padding: 50px;
        box-shadow: 0px 0px 8px 1px #c1c1c1;
        border-radius: 8px;
        position: relative;
      }
      .table .thead-light th {
        color: white;
        background-color: #007bff;
        border-color: white;
      }
      .thead-light {
        text-align: center;
      }
      tr {
        text-align: center;
      }
      .badge-success {
        padding: 5px 20px !important;
      }
      .badge-danger {
        padding: 5px 10px !important;
      }
      .fa-pencil,
      .fa-trash {
        font-size: 20px;
        margin-right: 10px;
      }
      .fa-plus {
        margin-right: 10px;
      }
      .add-book {
        float: right;
        margin-bottom: 10px;
      }
      .table td, .table th {
        vertical-align: middle;
      }
    </style>
  </head>
  <body>
    <div class="container">

					<!-- snippet for success/falure error message -->
			<?php $error = $this->session->flashdata("message");
			 $status = $this->session->flashdata("status");?>
				  <?php if($error){ ?>
  					<div class="alert alert-<?php echo $status ? $status : 'warning' ?> alert-dismissible" role="alert">
  						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  						<?php echo $error?>
  					</div>
			    <?php } ?>
				<!-- end of erroe message snippet -->
				
      <div class="add-book">
        <a  class="btn btn-primary" href="<?php echo site_url('books/add') ?>">
        <i class="fa fa-plus" aria-hidden="true"></i>Book</a>
      </div>
      <table class="table table-bordered table-striped">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Cover Picture</th>
            <th scope="col">Book Name</th>
            <th scope="col">Categories</th>
            <th scope="col">Price (&#8377)</th>
            <th scope="col">Type</th>
            <th scope="col">Format</th>
            <th scope="col">In Stock</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
				<?php $i=1; ?>
				<?php if(count($book_data)): ?>
					<?php foreach($book_data as $book): ?>
          <tr id="<?php echo $book->id; ?>">
            <th scope="row"><?php echo $i; ?></th>
            <td><img src="assets/<?php echo $book->cover_picture; ?>"height='70' alt="Default Image"></td>
            <td><?php echo $book->book_name; ?></td>
            <td><?php echo $book->cat; ?></td>
            <td><?php echo $book->price; ?></td>
            <td><?php echo $book->type; ?></td>
            <td><?php echo $book->format; ?></td>
            <td><span class="badge badge-pill badge-<?php echo $book->in_stock_status; ?>"><?php echo $book->in_stock; ?></span> </td>
            <td>
						<a  style="color:black;" href="<?php echo site_url('books/edit/'.$book->id.'');?>" >
              <i
                class="fa fa-pencil"
                aria-hidden="true"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Edit"
              ></i></a>
							<a  style="color:black;" class="remove" >
              <i
                class="fa fa-trash"
                aria-hidden="true"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Delete"
              ></i></a>
            </td>
          </tr>
					<?php $i++; ?>
					<?php endforeach; ?>
					<?php endif; ?>

       </tbody>
      </table>
    </div>
		
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script>
      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
		<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");


        if(confirm('Are you sure to remove this record ?'))
        {
            $.ajax({
               url: 'books/delete/'+id,
               type: 'DELETE',
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
                    alert("Record removed successfully");  
               }
            });
        }
    });


</script>
  </body>
</html>
