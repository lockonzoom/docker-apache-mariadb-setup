<?php
// Path to display folders
$path = './'; // Change to your desired path

// Check if the path exists
if (is_dir($path)) {
    // Read all files and folders in the path
    $folders = scandir($path);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder List</title>
    <!-- Link to Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a { 
            text-decoration: none; 
            color: #333;
            min-height: 100px;
        }

        .btn-light {
            background-color: transparent !important;
            border:none !important;
        }

        .btn-light:hover {
            background-color: #eeeeeef7 !important;
            border:none !important;
        }
    </style>
</head>
<body>
    <div class="row m-0 p-3 my-5">
    <div class="alert alert-secondary"><p class="mb-0">Folder List in: <span class="text-primary"><?php echo $path; ?></span></p></div>
        <div class="row m-0 p-3 my-5">
            <?php
            foreach ($folders as $folder) {
                // Skip . and ..
                if ($folder === '.' || $folder === '..') {
                    continue;
                }

                // Check if it's a folder
                $fullPath = $path . DIRECTORY_SEPARATOR . $folder;
                if (is_dir($fullPath) && $folder != 'img') {
                    // Display folder as a link
                    echo "<div class='col-lg-1 col-md-2 col-sm-4'><a href='$folder' class=' btn btn-light'>
                    <img src=\"./img/folder-icon-macos.webp\" class=\"w-100\" />
                    <p class=\"text-center\">$folder</p>
                    </a>
                    </div>";
                }
            }
            ?>
        </div>
    </div>
    <!-- Bootstrap 5 Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    echo "Path not found";
}
?>