<?php if (isset($_GET['help']) or !isset($_GET['key'])) {
    include_once("message.php");
    exit();
}

    include_once("getConnection.php");

    function sanitize($str, $conn) {
        return $conn->real_escape_string(stripslashes(htmlspecialchars($str)));
    }

    function apiKeyIsValid($key) {
        $conn = getConnection();
        $key = sanitize($key, $conn);

        $query = "SELECT * FROM vitezme_trivium.api_keys WHERE `key` = '$key' LIMIT 1";

        $result = false;
        if (!$result = mysqli_query($conn, $query)) {
            return false;
        }
        if ($result->num_rows == 0) {
            return false;
        }
        
        return true;
    }

    function echoData($limit) {
        $conn = getConnection();
        $query = "SELECT * FROM vitezme_trivium.questions ORDER BY RAND() LIMIT $limit ";

        $result = false;

        if(!$result = mysqli_query($conn, $query)) {
            exit('{"error":"query failure"}');
        }

        $data = array();
        while($row = $result->fetch_assoc()) {
            if ($row['type'] != 'image') {
                unset($row['image_url']);
            }
            if ($row['type'] == 'number') {
                unset($row['wrong1']);
                unset($row['wrong2']);
                unset($row['wrong3']);
            }
            $data[] = $row;
        }

        echo json_encode($data);
    }
    
    $api_key = sanitize($_GET['key'], getConnection());
    if (!apiKeyIsValid($api_key)) {
        exit('{"error":"invalid key"}');
    }

    $limit = 1;
    if (!empty($_GET['limit'])) {
        $limit = sanitize($_GET['limit'], getConnection());
        if (!is_numeric($limit)) {
            exit('{"error":"bad limit"}');
        }
    }
    
    echoData($limit);
?>