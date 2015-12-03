<?php  

//user_logs -- Insert users that logged into Facebook information into the logs table
if ($stmt = $mysqli->prepare("INSERT INTO $table2 (`user_mac`, `user_fb_id`, `ap_mac`, `user_browser`, `user_os`, `timestamp`) VALUES (?,?,?,?,?,?)")) {
    $stmt->bind_param("sssssi", $client_mac, $fb_id, $ap_mac, $user_browser, $user_os, $timestamp); 
    $stmt->execute();
    $stmt->close();
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

/* Información de usuarios */
if ($stmt = $mysqli->prepare("SELECT `user_mac` FROM $table WHERE $fb_user_id_string = ? ")) {
    $stmt->bind_param("s", $fb_id);
    $stmt->execute();
    $stmt->bind_result($test_mac);
    $stmt->fetch();
    $stmt->close();

    $fb_fullname_de = utf8_decode($fb_fullname);
    $fb_location_de = utf8_decode($fb_location);
    $fb_hometown_de = utf8_decode($fb_hometown);

    //New registry or registry update (user information) validation and process
    if (!isset($test_mac)) {
        
        //Insert new registry
        if ($stmt = $mysqli->prepare("INSERT INTO $table (`user_mac`, `user_fb_id`, `user_fb_email`, `user_fb_name`, `user_fb_birthday`, `user_fb_gender`, `user_fb_location`, `user_fb_hometown`, `user_lastlogin`, `user_firstlogin`) VALUES (?,?,?,?,?,?,?,?,?,?)")) {
            $fb_birthday = parse_birthday($fb_birthday);
            $stmt->bind_param("ssssisssii",$client_mac, $fb_id, $fb_email, $fb_fullname_de, $fb_birthday, $fb_gender, $fb_location_de, $fb_hometown_de, $timestamp, $timestamp);
            $stmt->execute();
            $stmt->close();
        } else {
            trigger_error($mysqli->error, E_USER_ERROR);
        }

    } else {
        
        //Update existant registry
        if ($stmt = $mysqli->prepare("UPDATE $table SET `user_mac`=?, `user_lastlogin`=?, `user_fb_location`=?, `user_fb_name`=?, `user_fb_email`=? WHERE $fb_user_id_string = ?")) {
            $stmt->bind_param("sissss",$client_mac,$timestamp, $fb_location_de, $fb_fullname_de, $fb_email, $fb_id);
            $stmt->execute();
            $stmt->close();
        } else {
            trigger_error($mysqli->error, E_USER_ERROR);
        }

    }

} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

$mysqli->close();