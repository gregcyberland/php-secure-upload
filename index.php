<?php
error_reporting(0);
$accounts = array(
    array("id" => 0, "username" => "parent", "password" => "parent"),
    array("id" => 1, "username" => "student", "password" => "student"),
    array("id" => 2, "username" => "teacher", "password" => "teacher")
);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validLogin = false;
    foreach ($accounts as $account) {
        if ($_POST["username"] === $account["username"] && $_POST["password"] === $account["password"]) {
            $validLogin = true;
            $_SESSION["user"] = $account["id"]; // Set the current user's ID in session
            break;
        }
    }
    
    if ($validLogin) {
        $_SESSION["loggedin"] = true;
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    echo "<h1>" . ucfirst($accounts[$_SESSION["user"]]['username']) . "</h1>";

    include 'helper/uploadHelper.php';
    uploadFile();
    echo '<p><a href="logout.php">Logout</a></p>';
    echo '<p><a href="list.php">View</a></p>';
} else {
    echo '<h2>Login</h2>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>';
}
?>