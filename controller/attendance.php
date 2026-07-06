<?php
session_start();
require('../config/conn-config.php');

    if(!isset($_SESSION['STUDENT']['ID'],$_POST['subjectId'])){
        http_response_code(401);
        echo json_encode(["error" => "Missing session data"]);
        exit;
    }

    $USERID = $_SESSION['STUDENT']['ID'];
    $SUBJID = $_POST['subjectId'];

    if (!ctype_digit((string)$USERID) || !ctype_digit((string)$SUBJID)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid session data"]);
        exit;
    }

    $filter = " AND log_hist.SchlEnrollSubjOff_ID = ?";
    $value = [(int)$USERID, (int)$SUBJID];
    $bind = "ii";

    if (isset($_POST['dateStart']) && isset($_POST['dateEnd'])) {
        $filter .= " AND DATE(log_hist.SchlClsLogHis_DATETIME) BETWEEN ? AND ?";
        $value[] = $_POST['dateStart'];
        $value[] = $_POST['dateEnd'];
        $bind .= "ss";
    }
    
    $qry = "SELECT
                `SchlClsLogHis_ID` AS id,
                DATE(log_hist.SchlClsLogHis_DATETIME) AS log_date,
                log_hist.SchlUserRF_ID,
                MIN(log_hist.SchlClsLogHis_DATETIME) AS first_login,
                MAX(log_hist.SchlClsLogHis_DATETIME) AS last_login
            FROM schoolclassloghistory AS log_hist
            WHERE `SchlEmp_ID` = ?
            $filter
            GROUP BY
                DATE(log_hist.SchlClsLogHis_DATETIME),
                log_hist.SchlUserRF_ID
            ORDER BY log_date DESC";

    $stmt = $dbConn->prepare($qry);

    if (!$stmt) {
        echo json_encode(["error" => $dbConn->error]);
        exit;
    }

    $stmt->bind_param($bind, ...$value);
    $stmt->execute();
    $result = $stmt->get_result();
    $fetch = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $dbConn->close();

    echo json_encode($fetch);
?>