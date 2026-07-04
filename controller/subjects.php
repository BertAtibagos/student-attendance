<?php
    session_start();
    require('../config/conn-config.php');

    if (!isset($_SESSION['STUDENT']['ID'], $_SESSION['STUDENT']['LVLID'], $_SESSION['STUDENT']['YRID'],$_SESSION['STUDENT']['PRDID'])) {
        http_response_code(401);
        echo json_encode(["error" => "Missing session data"]);
        exit;
    }

    $USERID = $_SESSION['STUDENT']['ID'];
    $LVLID  = $_SESSION['STUDENT']['LVLID'];
    $YRID   = $_SESSION['STUDENT']['YRID'];
    $PRDID  = $_SESSION['STUDENT']['PRDID'];

    if (!ctype_digit((string)$USERID) || !ctype_digit((string)$LVLID) || !ctype_digit((string)$YRID) || !ctype_digit((string)$PRDID)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid session data"]);
        exit;
    }

    $USERID = (int)$USERID;
    $LVLID  = (int)$LVLID;
    $YRID   = (int)$YRID;
    $PRDID  = (int)$PRDID;


    $qry_get_subj_list = "SELECT `schl_enr_as`.`SchlAcadSubj_ID` AS `schl_acad_subj_id`
                          FROM `schoolstudent` `schl_stud`
                          LEFT JOIN `schoolenrollmentregistration` `schl_enr_reg`
                            ON `schl_stud`.`SchlEnrollRegColl_ID` = `schl_enr_reg`.`SchlEnrollRegSms_ID`
                          LEFT JOIN `schoolenrollmentregistrationstudentinformation` `schl_enr_reg_stud_info`
                            ON `schl_enr_reg`.`SchlEnrollRegSms_ID` = `schl_enr_reg_stud_info`.`SchlEnrollReg_ID`
                          LEFT JOIN `schoolenrollmentassessment` `schl_enr_as`
                            ON `schl_enr_reg`.`SchlStud_ID` = `schl_enr_as`.`SchlStud_ID`
                          WHERE `schl_stud`.`SchlStudSms_ID` = ?
                            AND `schl_enr_as`.`SchlAcadLvl_ID` = ?
                            AND `schl_enr_as`.`SchlAcadYr_ID` = ?
                            AND `schl_enr_as`.`SchlAcadPrd_ID` = ?
                            AND `schl_enr_reg`.`SchlAcadLvl_ID` = ?";

    $stmt = $dbConn->prepare($qry_get_subj_list);
    $stmt->bind_param("iiiii", $USERID, $LVLID, $YRID, $PRDID, $LVLID);
    $stmt->execute();
    $subj_rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $raw_ids = array_column($subj_rows, 'schl_acad_subj_id');
    $subj_ids = [];
    foreach ($raw_ids as $id) {
        foreach (explode(',', $id) as $single_id) {
            $subj_ids[] = (int) trim($single_id);
        }
    }
    $subj_ids = array_unique($subj_ids);

    if (empty($subj_ids)) {
        $fetch = [];
    } else {

    $placeholders = implode(',', array_fill(0, count($subj_ids), '?'));
    $types = str_repeat('i', count($subj_ids));

    $qry = "SELECT `schl_enr_subj_off`.`SchlEnrollSubjOffSms_ID` AS `subj_id`,
                `schl_acad_subj`.`SchlAcadSubj_CODE` AS `subj_code`,
                `schl_acad_subj`.`SchlAcadSubj_desc` AS `subj_desc`
            FROM schoolenrollmentsubjectoffered schl_enr_subj_off
            LEFT JOIN schoolacademicsubject schl_acad_subj
                ON schl_enr_subj_off.SchlAcadSubj_ID = schl_acad_subj.SchlAcadSubjSms_ID
            LEFT JOIN schooltadi studrec
                ON schl_enr_subj_off.SchlEnrollSubjOffSms_ID = studrec.schlenrollsubjoff_id
                AND DATE(studrec.schltadi_date) = CURDATE()
            WHERE
                schl_enr_subj_off.SchlEnrollSubjOffSms_ID IN ($placeholders)
            GROUP BY schl_enr_subj_off.SchlEnrollSubjOffSms_ID";

    $stmt = $dbConn->prepare($qry);
    $stmt->bind_param($types, ...$subj_ids);
    $stmt->execute();
    $fetch = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    }
    $dbConn->close();
    echo json_encode($fetch);

?>