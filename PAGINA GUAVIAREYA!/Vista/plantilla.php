<!DOCTYPE html>
<html lang="en">

<head>
    <title>GuaviareYa!</title>
    <?php
    include('include_style_plantilla.php');
    include('google_analytics.php');
    ?>
</head>

<body>
    <?php
    // Incluye la sección solicitada
    $seccionFile = $seccion . ".php";
    if (file_exists("../Vista/" . $seccionFile)) {
        include("../Vista/" . $seccionFile);
    } else {
        include("../Vista/404.php");
    }
    ?>
</body>

</html>
