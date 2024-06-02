<?php require "partials/helper.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Posts - ChitKit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
    <?php require "partials/navbar.php" ?>

    <div class="container main-container create-posts-main-container d-flex gap-5 justify-content-center">
        <?php require "partials/sidebar.php" ?>

        <?php
        // Upload a post =>

        $user_id = $_SESSION["user_id"];
        $type_err = false;
        $show_file_err = false;
        $size_err = false;
        $num_of_files_err = false;
        $result_err = false;
        $upload_success = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $help = new Helper();
            $heading = "";
            $content = "";
            if (isset($_POST["post-heading"])) {
                $heading = $help->test_input($_POST["post-heading"]);
            }
            if (isset($_POST["post-content"])) {
                $content = $help->test_input($_POST["post-content"]);
            }

            // Upload Files =>
            $file_paths_array = [];
            if (isset($_FILES["files"]) && !empty($_FILES["files"]["name"][0])) {
                $number_of_files = 0;
                // The below loop checks for erros for all files
                foreach ($_FILES["files"]["name"] as $key => $value) {
                    $file = $_FILES["files"];
                    $file_name = $file["name"][$key];
                    $file_tmp_name = $file["tmp_name"][$key];
                    $file_size = $file["size"][$key];
                    $file_err = $file["error"][$key];
                    $file_type = $file["type"][$key];

                    // Video types : mp4, mkv, mov, webm, avi
                    $allowed_file_types = array("jpeg", "jpg", "png", "mp4", "mkv", "mov", "webm", "avi");
                    $file_ex = explode(".", $file_name);
                    $file_ext = strtolower(end($file_ex));

                    if (!in_array($file_ext, $allowed_file_types)) {
                        $type_err = true;
                        break;
                    } elseif ($file_err != 0) {
                        $show_file_err = true;
                        break;
                    } elseif ($file_size > 524288000) {
                        // 524288000 : 500mb
                        $size_err = true;
                        break;
                    }
                    $number_of_files++;
                }

                if ($number_of_files > 10) {
                    $num_of_files_err = true;
                }

                /* If any error related to type, size or file error occured 
                in any of the files then the files will not be uploaded*/
                if (!$type_err && !$show_file_err && !$size_err && !$num_of_files_err) {

                    foreach ($_FILES["files"]["name"] as $key => $value) {
                        $file = $_FILES["files"];
                        $file_name = $file["name"][$key];
                        $file_tmp_name = $file["tmp_name"][$key];
                        $file_ex = explode(".", $file_name);
                        $file_ext = strtolower(end($file_ex));

                        $uniqueId = uniqid('', true);
                        $new_file_name = $user_id . "-" . $uniqueId . '.' . $file_ext;

                        $file_path = "uploads/posts/" . $new_file_name;
                        $move_file = move_uploaded_file($file_tmp_name, $file_path);
                        if (!$move_file) {
                            $show_file_err = true;
                        } else {
                            array_push($file_paths_array, $file_path);
                        }
                    }
                }
            }

            // Convert file path array into json to store in MySQL
            $file_paths_json = json_encode($file_paths_array);
            $sql = "INSERT INTO `posts`(`heading`, `content`, `file_json_array`, `user_id`) VALUES (?, ?, ?, ?)";
            // using stmt to escape quotation marks
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssi", $heading, $content, $file_paths_json, $user_id);

            if ($stmt->execute()) {
                $upload_success = true;
            } else {
                $result_err = true;
                /* ?> <div class="position-fixed" style="top: 32rem; z-index:300"><?php echo "MySQL Error: " . mysqli_error($con);?></div><?php */
            }
        }
        ?>

        <!-- Posts -->
        <div class="posts create-posts-container" style="margin-top: 7rem;">
            <!-- SLIDES => -->
            <form id="slides-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="post-heading" name="post-heading" placeholder="name@example.com">
                    <label for="post-heading">Heading</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" name="post-content" placeholder="write your content" id="post-content" style="height: 100px"></textarea>
                    <label for="post-content">Content</label>
                </div>
                <input name="files[]" multiple="multiple" accept="image/*, video/*" class="form-control form-control-lg my-3" id="slide-file" type="file" />
                <button type="submit" class="my-3 w-100 btn rounded-0 btn-primary">Post</button>
                <?php if ($type_err) { ?>
                    <div class="mt-3 alert text-center alert-warning" role="alert">Only jpeg, jpg, png, mp4, mkv, mov, webm & avi file types are allowed!</div>
                <?php } elseif ($show_file_err) { ?>
                    <div class="mt-3 alert text-center alert-warning" role="alert">An error occured while uploading your file!</div>
                <?php } elseif ($size_err) { ?>
                    <div class="mt-3 alert text-center alert-warning" role="alert">File should be less than 500mb!</div>
                <?php } elseif ($num_of_files_err) { ?>
                    <div class="mt-3 alert text-center alert-warning" role="alert">You can only upload 10 files.</div>
                <?php } elseif ($result_err) { ?>
                    <div class="mt-3 alert text-center alert-warning" role="alert">Internal server error!</div>
                <?php } elseif ($upload_success) { ?>
                    <div class="mt-3 alert text-center alert-success" role="alert">Your post has been uploaded successfully!</div>
                <?php } ?>
            </form>
            <!-- SLIDES END -->
        </div>
        <!-- Posts end -->

        <div class="space space-2" style="width: 18rem;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>