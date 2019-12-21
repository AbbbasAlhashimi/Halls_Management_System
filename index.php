<!DOCTYPE html>
<html lang="en">

<head>
  <title>Halls Management System</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
  <style>
    .hide {
      display: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <br />
    <div class="table-responsive">
      <h3 align="center">Halls Management System</h3><br />
      <div id="grid_table"></div>
    </div>
  </div>
  <script>
    $('#grid_table').jsGrid({

      width: "80%",
      height: "500px",
      align: "center",
      filtering: true,
      inserting: true,
      editing: true,
      sorting: true,
      paging: true,
      autoload: true,
      pageSize: 10,
      pageButtonCount: 5,
      deleteConfirm: "Do you really want to delete this row?",

      controller: {
        loadData: function (filter) {
          return $.ajax({
            type: "GET",
            url: "data.php",
            data: filter
          });
        },
        insertItem: function (item) {//Inserting  records
          return $.ajax({
            type: "POST",
            url: "data.php",
            data: item
          });
        },
        //End of function
        updateItem: function (item) {//updating records
          return $.ajax({
            type: "PUT",
            url: "data.php",
            data: item
          });
        },//End of function
        deleteItem: function (item) {//Deleting records
          return $.ajax({
            type: "DELETE",
            url: "data.php",
            data: item
          });
        },
      },

      //Form fields
      fields: [ 
          {
            name: "id",
             type: "hidden",
             css: 'hide'
            },
        {
          name: "hall_id",
          type: "text",
          width: 50,
          validate: "required"
        },
        {
          name: "hall_name",
          type: "text",
          width: 50,
          validate: "required"
        },
        {
          name: "hall_department",
          type: "text",
          width: 50,
          validate: "required"
        },

        {
          name: "hall_floor",
          type: "text",
          width: 50,
          validate: "required"
        },
        {
          name: "capacity",
          type: "text",
          width: 50,
          validate: "required"
        },
        {
          type: "control"
        }
      ]

    });//End of function

  </script>

</body>

</html>