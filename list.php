<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Uploaded Files</title>
</head>
<body>
   <?php 
    session_start();
   if($_SESSION["user"] == 0){
    echo "<h2>Parent Page</h2>";
   }else if($_SESSION["user"] == 1){
    echo "<h2>Student Page</h2>";
   }else if($_SESSION["user"] == 2){
    echo "<h2>Teacher Page</h2>";
   }
   ?>
    <h3>List of Uploaded Files</h3>
    <a href="/index.php">back</a>
    <ul>
        <?php
        if (isset($_SESSION["loggedin"])) {

            if($_SESSION["user"] == 2){
                echo "<h3>Student File</h3>";
                echo displayFiles('uploads/student/');
                echo "<hr>";
                echo "<h3>Parent File</h3>";
                echo displayFiles('uploads/parent/');
            }else{
                echo displayFiles(getUploadDirectory());
            }


        } else {
            header("Location: index.php");
        }

        function getUploadDirectory() {
            if (isset($_SESSION["user"])) {
                switch ($_SESSION["user"]) {
                    case 0: // Parent
                        return 'uploads/parent/';
                        break;
                    case 1: // Student
                        return 'uploads/student/';
                        break;
                    case 2: // Teacher
                        return 'uploads/';
                        break;
                    default:
                        return 'uploads/';
                }
            } else {
                return 'uploads/';
            }
        }

        function scandirRecursive($dir) {
            $files = [];
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item !== '.' && $item !== '..') {
                    $path = $dir . '/' . $item;
                    if (is_dir($path)) {
                        $files = array_merge($files, scandirRecursive($path));
                    } else {
                        $files[] = $item;
                    }
                }
            }
            return $files;
        }

        function displayFiles($location){
            // Define upload directory based on the user's role
            $uploadDir = $location;

            // Get the list of files in the directory and subdirectories
            $files = scandirRecursive($uploadDir);

            // Display each file as a list item
            foreach ($files as $file) {
                $filePath = $uploadDir . $file;
                $fileType = pathinfo($filePath, PATHINFO_EXTENSION);

                echo "<li>";

                // Separate files uploaded by students and parents for teachers
                // if ($_SESSION["user"] == 2 && (strpos($uploadDir, 'uploads/parent/') !== false || strpos($uploadDir, 'uploads/student/') !== false)) {
                //     echo "<h3>" . ucfirst(basename($uploadDir)) . "</h3>";
                // }

                if ($fileType === 'png' || $fileType === 'jpeg' || $fileType === 'jpg') {
                    echo "<img src='/view.php?file={$file}' alt='{$file}' style='max-width: 500px; max-height: 300px;'>";
                } elseif ($fileType === 'pdf') {
                    echo "<embed src='/view.php?file={$file}' width='500' height='300' type='application/pdf'>";
                }

                echo "</li>";
            }
        }
        ?>
    </ul>
</body>
</html>
