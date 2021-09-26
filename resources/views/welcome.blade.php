<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
</head>
<body>
  
<div class="container">
    <h1 class="text-center">Laravel Ajax Crud</h1>
    <br/>

      <div class="container">
        <div id="msg"></div>
        <form id="createProduct" class="createProduct">
          <input type="hidden" name="id" id="id">
        <input type="text" id="name" name="name" class="form-control">
        <br/>
        <input type="text" id="des" name="des" class="form-control">
        <br>

          <button class="btn btn-info btn-create" value="Submit"> Submit</button>
         <button class="btn btn-info submit-update" value="Submit" style="display: none"> update</button>
      </form>


      </div>


    <br/>
    <div class="deleteMsg"></div>
  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    
    </tr>
  </thead>
  <tbody id="newProduct">
    
 
  </tbody>
</table>          
</div>










<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      function alldata(){
        $.ajax({
          url: 'alldata',
          dataType:'json',
          type:'get',
          success:function(res){
            var data = '';
            var sl = 1;
            $.each(res, function(key,value){
              data = data + "<tr>"
              data = data + "<td>"+value.id+"</td>"
              data = data + "<td>"+value.name+"</td>"
              data = data + "<td>"+value.des+"</td>"
              data = data + "<td>"
              data = data + " <a href='#' class='btn btn-info btn-edit'  onclick='editData("+value.id+")'>Edit</a>"
              data = data + " <a href='#' class='btn btn-danger btn-delete' onclick='deleteData("+value.id+")' >delete</a>"
              data = data + "<td>"
              data = data + "</tr>"
            })
            $('tbody').html(data);
          }
        });
      }
      alldata();

      // function addData(){
      //    let formData = $('#createProduct').serialize();
      //    console.log(formData);
      //   $.ajax({

      //   })
      // }
      function deleteData(id){
        console.log(id);
        
          swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
             $.ajax({
               url:"/product/delete/"+id,
                type:"get",
                dataType:"json",
                success:function(res){
                  console.log(res);
                   alldata();
                }
             });
            } else {
              swal("Your imaginary file is safe!");
            }
          });
             

      }

       $('.btn-create').on('click', function(e){
          e.preventDefault();
          let formData = $('#createProduct').serialize();
          $.ajax({
            url:"/product/store",
            type:"post",
            data:formData,
            dataType:"json",
            success:function(res){
              alldata();
              $('#createProduct').trigger('reset');
              Swal.fire({
                toast:true,
                position:'top-end',
                icon: 'success!',
                text: 'Data Added Successfully',
                timer:1500,
           
             
            })
            }
          })
       });

        function editData(id){
          $.ajax({
            url:"/product/edit/"+id,
            type:"get",
            dataType:"json",
            success:function(res){
              $('.btn-create').hide();
              $('.submit-update').show();
              $('#name').val(res.name);
               $('#des').val(res.des);
                $('#id').val(res.id);
            }
          })
        }

         $('.submit-update').on('click', function(e){
          e.preventDefault();
          let id = $('#id').val();
          let formData = $('#createProduct').serialize();
          $.ajax({
            url:"/product/update",
            type:"post",
            data:formData,
            dataType:"json",
            success:function(res){
              alldata();
              $('#createProduct').trigger('reset');
               $('.btn-create').show();
              $('.submit-update').hide();
              console.log('data update success');
            }
          })
       });

       
        
       
  </script>
</body>
</html>
