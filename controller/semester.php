<?php
    session_start();
    require('../config/conn-config.php');

    if (!isset($_SESSION['STUDENT']['ID'], $_SESSION['STUDENT']['LVLID'], $_SESSION['STUDENT']['YRID'])) {
        http_response_code(401);
        echo json_encode(["error" => "Missing session data"]);
        exit;
    }

    $lvlid = $_SESSION['STUDENT']['LVLID'];
    $yrid = $_SESSION['STUDENT']['YRID'];

    if (!ctype_digit((string)$lvlid) || !ctype_digit((string)$yrid)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid session data"]);
        exit;
    }

    $lvlid  = (int)$lvlid;
    $yrid   = (int)$yrid;
    $active = 1;

    $qry = "SELECT DISTINCT
                schl_acad_prd.SchlAcadPrdSms_ID AS prdId,
                schl_acad_prd.SchlAcadPrd_NAME AS prdName
            FROM schoolacademicyearperiod AS schl_acad_yr_prd
            LEFT JOIN schoolacademicperiod AS schl_acad_prd
                ON schl_acad_yr_prd.SchlAcadPrd_ID = schl_acad_prd.SchlAcadPrdSms_ID
            WHERE schl_acad_yr_prd.SchlAcadLvl_ID = ?
            AND schl_acad_yr_prd.SchlAcadYr_ID = ?
            AND schl_acad_yr_prd.SchlAcadYrPrd_ISACTIVE = ?";

    $stmt = $dbConn->prepare($qry);

    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "Query preparation failed"]);
        exit;
    }

    $stmt->bind_param("iii", $lvlid, $yrid, $active);
    $stmt->execute();
    $fetch = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $dbConn->close();
    
    echo json_encode($fetch);
?>