<?php

include_once 'config.php';
$_GET['value'] = isset($_GET['value']) ? $_GET['value']: "";
$sql = "";
$search = isset($_GET['installsearch']) ? $_GET['installsearch'] : "";
if (strlen(trim($search)) == 0){
  $_GET['installsearch'] = null;
}

switch ($_GET['value']){
    case "room":
        $sql = "SELECT * FROM `room` ". (isset($_GET['installsearch']) ? "WHERE room_name LIKE ?" : "") ." order by room_name ASC";
        $stmt = $conn->prepare($sql);
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $search = "%".$search."%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt ->get_result();
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;
    case "office":
        $sql = "SELECT * FROM `offices` ". (isset($_GET['installsearch']) ? "
       where office_name LIKE ?" : "") ." order by office_name ASC";
       $stmt = $conn->prepare($sql);
       $stmt = $conn->prepare($sql);
       if(isset($_GET['installsearch'])){
        $search = "%".$search."%";
           $stmt->bind_param("s", $search);
           $stmt->execute();
           $result = $stmt ->get_result(); 
       }
       else{
           $result = mysqli_query($conn, $sql);
       }
        break;
    case "building":
        $sql = "SELECT * FROM `buildings` ". (isset($_GET['installsearch']) ? "
        WHERE building_name LIKE ?" : "") ."order BY building_name ASC";
        $stmt = $conn->prepare($sql);
        if(isset($_GET['installsearch'])){
            $search = "%".$search."%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt ->get_result(); 
        }
        else{
            $result = mysqli_query($conn, $sql);
        }
        break;

    default:
  // Fetch data from buildings table
$query = "SELECT * FROM buildings";
$result = mysqli_query($conn, $query);

    $stmt = $conn->prepare($sql);
if(isset($_GET['installsearch'])){
    $search = "%".$search."%";
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt ->get_result();
}
else{
    $result = mysqli_query($conn, $sql);
}
break;

}
while($row = $result->fetch_assoc()){
    $cardClass = 'primary';
    $entityType = $row['entity_type'];
    $entityId = $row[$entityType. '_id'];
    $cardTitle = $row[$entityType. '_name'];
    $cardText = '';

    // switch ($row['entity_type']) {
    //     case 'Building':
    //       $cardText .= "Building: {$row['building_name']}<br>";
    //       $entityId = $row['building_id'];
    //       $cardTitle = $row['building_name'];
    //       break;
    //     case 'Office':
    //       $cardText .= "Office: {$row['office_name']}<br>";
    //       if ($row['building_name']) {
    //         $cardText .= "Building: {$row['building_name']}<br>";
    //       }
    //       $entityId = $row['office_id'];
    //       $cardTitle = $row['office_name'];
    //       break;
    //     case 'Room':
    //       $cardText .= "Room: {$row['room_name']}<br>";
    //       if ($row['office_name']) {
    //         $cardText .= "Office: {$row['office_name']}<br>";
    //       }
    //       if ($row['building_name']) {
    //         $cardText .= "Building: {$row['building_name']}<br>";
    //       }
    //       $entityId = $row['room_id'];
    //       $cardTitle = $row['room_name'];
    //       break;
    //   }

    echo "
    <div class=\"col-md-4\">
      <div class=\"card mb-4 card-{$cardClass}\">
        <div class=\"card-body\">
          <h5 class=\"card-title\">{$cardTitle}</h5>
          <p class=\"card-text\">{$cardText}</p>
          " . ($_SESSION['admin'] == 1 ? "
          <div class=\"d-flex justify-content-end\">
            " . ($row['entity_type'] == 'building' ? "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editBuildingModal\" data-building-id=\"{$row['building_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-building-id=\"{$row['building_id']}\">Delete</button>
            " : "") . "
            " . ($row['entity_type'] == 'office' ? "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editOfficeModal\" data-office-id=\"{$row['office_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-office-id=\"{$row['office_id']}\">Delete</button>
            " : "") . "
            " . ($row['entity_type'] == 'room' ? "
            <button type=\"button\" class=\"btn btn-secondary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#editRoomModal\" data-room-id=\"{$row['room_id']}\">Edit</button>
            <button type=\"button\" class=\"btn btn-danger\" data-room-id=\"{$row['room_id']}\">Delete</button>
            " : "") . "
          </div>
          " : "") . "
        </div>
      </div>
    </div>
  ";
    


}