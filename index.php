<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
</head>

<body>
  <ul>
    <script>
      $(document).ready(function () {
        setInterval(function () {
          updateCars();
        }, 500);

        function updateCars() {
          $.ajax({
            url: 'display_cars.php',
            type: 'POST',
            success: function (show_cars) {
              if (!show_cars.error) {
                $("#show-cars").html(show_cars);
              }
            }
          });
        }

        $('#search').keyup(function () {
          var search = $('#search').val();
          $.ajax({
            url: 'search.php',
            data: {
              search: search
            },
            type: 'POST',
            success: function (data) {
              if (!data.error) {
                $('#result').html(data);
              }
            }
          });
        });

        // This code add cars to database table cars       
        $(document).on("submit", "#add-car-form", function (evt){
          evt.preventDefault();
          var postData = $(this).serialize();
          var url = $(this).attr('action');
          $.post(url, postData, function (php_table_data) {
            $("#car-result").html(php_table_data);
            $("#add-car-form")[0].reset();
          });
        });
      }); 
    </script>
  </ul>
  <div id="container" class="col-xs-6 col-xs-offset-3">
    <div class="row">
      <h2>Search Our Database</h2>
      <input class='form-control' type="text" name='search' id='search' placeholder='Search our inventory'>
      <br>
      <br>
      <h2 class="bg-success" id="result">
      </h2>
    </div>
    <div class="row">
      <form method="post" id="add-car-form" class="col-x-6" action="add_cars.php">
        <div class="form-group">
          <label for="car-name">Add a Car</label>
          <input type="text" name="car_name" class="form-control" required>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="add car">
        </div>
      </form>
    </div>
    <div class="row">
      <div class="col-xs-6">
        <table class="table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
            </tr>
          </thead>
          <tbody id="show-cars"></tbody>
        </table>
      </div>
      <div class="col-xs-6">
        <div id="action-container">
        </div>
      </div>
    </div>
  </div>
</body>
</html>