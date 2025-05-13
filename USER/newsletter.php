<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = htmlspecialchars(trim($_POST["email"] ?? ''));

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $file = fopen("subscribers.csv", "a");
        fputcsv($file, [$name, $email, date("Y-m-d H:i:s")]);
        fclose($file);
        header("Location: index.php?status=success#newsletter");
        exit();
    } else {
        header("Location: index.php?status=error#newsletter");
        exit();
    }
}
?>
