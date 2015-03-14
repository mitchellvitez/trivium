<?php if (isset($_GET['help']) or !isset($_GET['key'])) { ?>
    <h1>Trivium API</h1>
    <h2>Serving up trivia questions about the University of Michigan since 2015</h2>
    <p><a href="//vitez.me/trivium">Website</a></p>
    <p><a href="//github.com/mitchellvitez/trivium">Github</a></p>
    <p>For help, please first read the README.md on Github. If you are still having issues, contact <a href="mailto:mvitez@umich.edu">mvitez@umich.edu</a></p>
    <p>To request an API key email that address. You must call the API using <code>vitez.me/trivium?key=API_KEY</code> or it will display this message</p>
<?php
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
