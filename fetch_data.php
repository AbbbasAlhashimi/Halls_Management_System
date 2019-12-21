
<?php


include('database_connection.php');

$method = $_SERVER['REQUEST_METHOD'];


  $hall_id = isset($_POST['hall_id']) ? $_POST['hall_id'] : '';
  $hall_name = isset($_POST['hall_name']) ? $_POST['hall_name'] : '';
  $hall_department = isset($_POST['hall_department']) ? $_POST['hall_department'] : '';
  $hall_floor = isset($_POST['hall_floor']) ? $_POST['hall_floor'] : '';
  $capacity = isset($_POST['capacity']) ? $_POST['capacity'] : '';
  
  //Defining records indexes
   if($method == 'GET'   &&
    isset($_POST['hall_id']) &&
    isset($_POST['hall_name']) &&
    isset($_POST['hall_department']) &&
    isset($_POST['hall_floor']) &&
    isset($_POST['capacity']) )
//if($method == 'GET' )
{
  $data = array(
  ':hall_name'   => "%" . $_GET[$hall_name] . "%",
  ':hall_department'     => "%" . $_GET[$hall_department] . "%",
  ':hall_floor'    => "%" . $_GET[$hall_floor] . "%",
  ':capacity'    => "%" . $_GET[$capacity] . "%"
  );


//I think hall name should be like hall_name
       $query = "SELECT * FROM tbl_halls WHERE hall_name LIKE:"
       .$id."AND id LIKE:"
       .$hall_name."AND hall_department LIKE:"
       .$hall_department."AND hall_floor LIKE:"
       .$hall_floor."AND capacity LIKE:"
       .$capacity." ORDER BY BY hotel_id DESC";


       $statement = $connect->prepare($query);
       $statement->execute($data);
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
          $output = array( 
           'hall_id'    => $row['hall_id'],  
           'hall_name'   => $row['hall_name'],
           'hall_department'    => $row['hall_department'],
           'hall_floor'   => $row['hall_floor'],
           'capacity'   => $row['capacity']
          );
       }
       header("Content-Type: application/json");
       echo json_encode($output);
       
    }

if($method == "POST")
{
 $data = array(
  ':id'  => $_POST["id"],
  ':hall_name'  => $_POST["hall_name"],
  ':hall_department'    => $_POST["hall_department"],
  ':hall_floor'   => $_POST["hall_floor"],
  ':capacity'   => $_POST["capacity"]

  
 );

 $query = "INSERT INTO tbl_halls (hall_id,hall_name, hall_department, hall_floor,capacity) VALUES ("
 .$hall_id.","
 .$hall_name.","
 .$hall_department.","
 .$hall_floor.","
 .$capacity."
)";
 $statement = $connect->prepare($query);
 $statement->execute($data);

}


if($method == 'PUT')
{
 parse_str(file_get_contents("php://input"), $_PUT);
 $data = array(
  ':hall_id' => $_PUT['hall_id'],
  ':hall_name' => $_PUT['hall_name'],
  ':hall_department'   => $_PUT['hall_department'],
  ':hall_floor'  => $_PUT['hall_floor'],
  ':capacity'  => $_PUT['capacity']
 );

 $query = "
 UPDATE tbl_halls 
 SET hall_id = :hall_id, 
 SET hall_name = :hall_name, 
 hall_department = :hall_department, 
 hall_floor = :hall_floor,
 capacity = :capacity,
 WHERE hall_id = :hall_id
 ";
 $statement = $connect->prepare($query);
 $statement->execute($data);

}

if($method == "DELETE")
{
 parse_str(file_get_contents("php://input"), $_DELETE);
 $query = "DELETE FROM hotels_list WHERE hall_id = '".$_DELETE["hall_id"]."'";
 $statement = $connect->prepare($query);
 $statement->execute();
}

?>
