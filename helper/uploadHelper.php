<?php
function uploadFile() {
    echo "<h2>Upload a File</h2>";
    echo '<form action="" method="post" enctype="multipart/form-data">
            Select File:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="submit">
        </form>';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
        $targetDir = getUploadDirectory(); // Get upload directory based on user's role
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (optional)
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($fileType != "pdf" && $fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
            echo "Sorry, only PDF, JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

function getUploadDirectory() {
    if (isset($_SESSION["user"])) {
        switch ($_SESSION["user"]) {
            case 0: // Parent
                return "uploads/parent/";
                break;
            case 1: // Student
                return "uploads/student/";
                break;
            case 2: // Teacher
                return "uploads/teacher/";
                break;
            default:
                return "uploads/";
        }
    } else {
        return "upload/";
    }
}
?>