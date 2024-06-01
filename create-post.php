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

        <!-- Posts -->
        <div class="posts create-posts-container" style="margin-top: 7rem;">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Photo</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Slides</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Note</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <!-- PHOTO => -->
                    <form>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="photo-heading" name="photo-heading" placeholder="name@example.com">
                            <label for="photo-heading">Heading</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="photo-content" placeholder="write your content" id="photo-content" style="height: 100px"></textarea>
                            <label for="photo-content">Content</label>
                        </div>
                        <!-- <label for="photo-file" class="form-label">Upload</label> -->
                        <input name="photo-file" class="form-control form-control-lg my-3" id="photo-file" type="file" />
                        <button type="submit" class="my-3 w-100 btn btn-primary">Submit</button>
                    </form>
                    <!-- PHOTO END -->
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <!-- SLIDES => -->
                    <form id="slides-form">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="slide-heading" name="slide-heading" placeholder="name@example.com">
                            <label for="slide-heading">Heading</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="slide-content" placeholder="write your content" id="slide-content" style="height: 100px"></textarea>
                            <label for="slide-content">Content</label>
                        </div>
                        <input name="name=" filefield[]" multiple="multiple" class="form-control form-control-lg my-3" id="slide-file" type="file" />
                        <button type="submit" class="my-3 w-100 btn btn-primary">Submit</button>
                    </form>
                    <!-- SLIDES END -->
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <!-- NOTE => -->
                    <form>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="note-heading" name="note-heading" placeholder="name@example.com">
                            <label for="note-heading">Heading</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="note-content" placeholder="write your content" id="note-content" style="height: 100px"></textarea>
                            <label for="note-content">Content</label>
                        </div>
                        <button type="submit" class="my-3 w-100 btn btn-primary">Submit</button>
                    </form>
                    <!-- NOTE END -->
                </div>
            </div>
        </div>
        <!-- Posts end -->

        <div class="space space-2" style="width: 18rem;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>