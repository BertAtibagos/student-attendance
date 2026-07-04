<?php
    session_start();

    $_SESSION['STUDENT'] = [
        'ACCESS_RIGHTS' => "2,1,ACADEMICS,,fa-solid fa-book-open,PARENT,0;2,5,SCHEDULE,,,CHILD,1;2,11,FEES,,fa-solid fa-wallet,PARENT,0;2,12,TUITION FEE,,,CHILD,11;2,14,ENROLLMENT,,fa-regular fa-address-card,PARENT,0;2,15,ONLINE ENROLLMENT,,,CHILD,14;2,20,FORMS,,fa-solid fa-file-lines,PARENT,0;2,21,SURVEY,,,CHILD,20;7,26,TADI,,,CHILD,20;9,3,GRADES,,,CHILD,1",
        'CATEGORY' => "STUDENT",
        'CRSEID' => 19,
        'DEPID' => 6,
        'ID' => 957,
        'IDNO' => 22-00341,
        'INFO' => "BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY - 3RD YEAR, 2ND SEM, 2025-2026, BSIT 3B",
        'LVLID' => 2,
        'PRDID' => 6,
        'SECID' => 2311,
        'YRID' => 19,
        'YRLVLID' => 8
        ];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee Attendance</title>
    <!-- <link rel="stylesheet" href="css.css?t=<?php echo time(); ?>"> -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
</head>
<body>
    <div id="root"></div>
    <script>
        window.__SESSION__ = <?php echo json_encode($_SESSION["STUDENT"]); ?>;
    </script>
    <script type="module" src="app.js?t=<?php echo time(); ?>"></script>
</body>
</html>