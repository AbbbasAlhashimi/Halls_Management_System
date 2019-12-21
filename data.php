<?php
include("database_connection.php");

$method = $_SERVER["REQUEST_METHOD"];

header("Content-Type: application/json");

$data = [];

if ($method == "GET") {

    $query = "SELECT * FROM tbl_halls ";

    if (!empty($_GET)) {
        foreach($_GET as $key => $value) {
            if (strlen($value) > 0) {
                $data[$key] = "%{$value}%";
            }
        }
    }

    if (sizeof($data) > 0) {
        $query .= "WHERE ";
        $keys = array_keys($data);
    }


    if (isset($data["hall_id"])) {
        $query .= "hall_id LIKE :hall_id ";
    }

    if (isset($data["hall_name"])) {
        if (sizeof($data) > 1 && $keys[0] != "hall_name") {
            $query .= "AND ";
        }
        $query .= "hall_name LIKE :hall_name ";
    }

    if (isset($data["hall_department"])) {
        if (sizeof($data) > 1 && $keys[0] != "hall_department") {
            $query .= "AND ";
        }

        $query .= "hall_department LIKE :hall_department ";
    }

    if (isset($data["hall_floor"])) {
        if (sizeof($data) > 1 && $keys[0] != "hall_floor") {
            $query .= "AND ";
        }

        $query .= "hall_floor LIKE :hall_floor ";
    }

    if (isset($data["capacity"])) {
        if (sizeof($data) > 1 && $keys[0] != "capacity") {
            $query .= "AND ";
        }

        $query .= "capacity LIKE :capacity ";
    }

    $statement = $pdo->prepare($query);
    $statement->execute($data);

    echo json_encode($statement->fetchAll(PDO::FETCH_CLASS));
}

if ($method == "POST") {
    $data = [];
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            if (strlen($value) > 0) {
                $data[$key] = "{$value}";
            }
        }
    }

    $query = "INSERT INTO tbl_halls VALUES(:hall_id, :hall_name, :hall_department, :hall_floor, :capacity)";
    $statement = $pdo->prepare($query);
    $statement->execute($data);

    $query = "SELECT * FROM tbl_halls WHERE hall_id = :hall_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["hall_id"=>$data["hall_id"]]);

    echo json_encode($statement->fetch(PDO::FETCH_ASSOC));
}

if ($method == "PUT") {
    parse_str(file_get_contents("php://input"), $vars);

    $data = [];
    if (!empty($vars)) {
        foreach($vars as $key => $value) {
            if (strlen($value) > 0) {
                $data[$key] = "{$value}";
            }
        }
    }

    $query = "UPDATE tbl_halls SET 
                hall_id = :hall_id,
                hall_name = :hall_name,
                hall_department = :hall_department,
                hall_floor = :hall_floor,
                capacity = :capacity
                WHERE id = :id";

    $statement = $pdo->prepare($query);
    $statement->execute($data);

    $query = "SELECT * FROM tbl_halls WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(["id"=>$data["id"]]);

    echo json_encode($statement->fetch(PDO::FETCH_ASSOC));
}

if ($method == "DELETE") {
    parse_str(file_get_contents("php://input"), $vars);

    
    $data = [];
    if (!empty($vars)) {
        foreach($vars as $key => $value) {
            if (strlen($value) > 0) {
                $data[$key] = "{$value}";
            }
        }
    }
    
    $query = "DELETE FROM tbl_halls WHERE id = :id";
    
    $statement = $pdo->prepare($query);
    $statement->execute(["id" => $data["id"]]);
    echo json_encode($data);
}