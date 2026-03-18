<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darquest</title>
</head>
<body>
<p>Allo</p>
<?php
if (isset($_SESSION["id"]))
    {
        $id = $_SESSION["id"];
        echo "<p>$id</p>";
    }
?>

</body>
</html>