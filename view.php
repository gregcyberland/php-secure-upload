<?php
session_start();
if (isset($_SESSION["loggedin"])) {
    // Define upload directory based on the user's role
    $uploadDir = getUploadDirectory();

    // Construct the file path
    $file = $uploadDir . $_GET['file'];

    // Check if the file exists
    if (file_exists($file)) {
        $filename = $_GET['file'];

        $type = explode('.', $_GET['file']);

        if ($type[1] === 'pdf') {
            $contentTyp = 'application/pdf';
        } else {
            $contentTyp = 'image/png';
        }

        // Header content type
        header('Content-type: ' . $contentTyp);

        header('Content-Disposition: inline; filename="' . $filename . '"');

        // Read the file
        @readfile($file);
    } else {

        //only show files if teacher is login
        if($_SESSION["user"] == 2){

        $student = "uploads/student/";
        $parent = "uploads/parent/";

        // Construct the file path
        $fileStudent = $student . $_GET['file']; 
        $fileParent = $parent . $_GET['file']; 

        if (file_exists($fileStudent)) {
            $filename = $_GET['file'];

            $type = explode('.', $_GET['file']);
    
            if ($type[1] === 'pdf') {
                $contentTyp = 'application/pdf';
            } else {
                $contentTyp = 'image/png';
            }

            // Header content type
            header('Content-type: ' . $contentTyp);

            header('Content-Disposition: inline; filename="' . $filename . '"');
    
            // Read the file
            @readfile($fileStudent);
        }else{
            $filename = $_GET['file'];

            $type = explode('.', $_GET['file']);
    
            if ($type[1] === 'pdf') {
                $contentTyp = 'application/pdf';
            } else {
                $contentTyp = 'image/png';
            }

            // Header content type
            header('Content-type: ' . $contentTyp);

            header('Content-Disposition: inline; filename="' . $filename . '"');
    
            // Read the file
            @readfile($fileParent);
        }

        }else{
             echo "File not found.";
        }
    }
} else {
    header("Location: index.php");
}

function getUploadDirectory()
{
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

?>
