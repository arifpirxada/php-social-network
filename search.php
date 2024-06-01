<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - ChitKit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
    <?php require "partials/navbar.php" ?>

    <div class="container main-container d-flex gap-5 justify-content-center">
        <?php require "partials/sidebar.php" ?>

        <!-- Posts -->
        <div class="posts" style="margin-top: 7rem;">
            <div class="d-flex justify-content-center my-2">
                <form class="form-inline d-flex gap-2">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div class="container posts-container mt-4">

                <div class="post-item">
                    <div class="card mb-3">

                        <div class="d-flex p-3 mb-0">
                            <div class="d-flex align-items-center" style="width: 70%;">
                                <img width="60" height="60" class="rounded-circle" src="img/users/user-2.jpg" alt="">
                                <span class="mx-3">
                                    <a href="#" style="text-decoration: none;" class="card-text text-black fw-bold m-0">Jerry</a>
                                    <p class="card-text text-secondary m-0">Life is better with...</p>
                                </span>
                            </div>
                            <p class="card-text text-body-secondary">3 jan, 2024</p>

                        </div>
                        <img class="mt-3" src="img/posts/coding.png" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Just Learned This Mind-Blowing Productivity Hack!</h5>
                            <p class="card-text">⏰ Feeling overwhelmed? You won't believe this simple trick that's
                                boosted my focus!
                                #productivitytips #timemanagement.</p>
                        </div>
                        <div class="post-actions d-flex justify-content-around my-4">
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/like-icon.png" alt="">Like</button>
                            <button class="bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/share-icon.png" alt="">Share</button>
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/comment-icon.png" alt="">Comment</button>
                        </div>
                    </div>
                </div>

                <div class="post-item">
                    <div class="card mb-3">

                        <div class="d-flex p-3 mb-0">
                            <div class="d-flex align-items-center" style="width: 70%;">
                                <img width="60" height="60" class="rounded-circle" src="img/users/user-1.jpg" alt="">
                                <span class="mx-3">
                                    <a href="#" style="text-decoration: none;" class="card-text text-black fw-bold m-0">Jerry</a>
                                    <p class="card-text text-secondary m-0">Exploring the world...</p>
                                </span>
                            </div>
                            <p class="card-text text-body-secondary">3 jan, 2024</p>

                        </div>
                        <img class="mt-3" src="img/posts/editing.jpg" alt="...">
                        <div class="post-actions d-flex justify-content-around my-4">
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/like-icon.png" alt="">Like</button>
                            <button class="bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/share-icon.png" alt="">Share</button>
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/comment-icon.png" alt="">Comment</button>
                        </div>
                    </div>
                </div>

                <div class="post-item">
                    <div class="card mb-3">

                        <div class="d-flex p-3 mb-0">
                            <div class="d-flex align-items-center" style="width: 70%;">
                                <img width="60" height="60" class="rounded-circle" src="img/users/user-4.jpg" alt="">
                                <span class="mx-3">
                                    <a href="#" style="text-decoration: none;" class="card-text text-black fw-bold m-0">Walter</a>
                                    <p class="card-text text-secondary m-0">Full of rand...</p>
                                </span>
                            </div>
                            <p class="card-text text-body-secondary">3 jan, 2024</p>

                        </div>
                        <img class="mt-3" src="img/posts/man.jpg" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">This Mind-Blowing Productivity Hack!</h5>
                            <p class="card-text">boosted my focus! Lorem ipsum dolor sit amet. #productivitytips
                                #timemanagement.</p>
                        </div>
                        <div class="post-actions d-flex justify-content-around my-4">
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/like-icon.png" alt="">Like</button>
                            <button class="bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/share-icon.png" alt="">Share</button>
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/comment-icon.png" alt="">Comment</button>
                        </div>
                    </div>
                </div>


                <div class="post-item">
                    <div class="card mb-3">

                        <div class="d-flex p-3 mb-0">
                            <div class="d-flex align-items-center" style="width: 70%;">
                                <img width="60" height="60" class="rounded-circle" src="img/users/user-4.jpg" alt="">
                                <span class="mx-3">
                                    <a href="#" style="text-decoration: none;" class="card-text text-black fw-bold m-0">Jerry</a>
                                    <p class="card-text text-secondary m-0">Full of rand...</p>
                                </span>
                            </div>
                            <p class="card-text text-body-secondary">3 jan, 2024</p>

                        </div>
                        <div class="card-body">
                            <h5 class="card-title">What do you think?</h5>
                            <p class="card-text">Simple trick that's Lorem ipsum dolor sit amet consectetur, adipisicing
                                elit.!
                                #productivitytips #timemanagement.</p>
                        </div>
                        <div class="post-actions d-flex justify-content-around my-4">
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/like-icon.png" alt="">Like</button>
                            <button class="bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/share-icon.png" alt="">Share</button>
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/comment-icon.png" alt="">Comment</button>
                        </div>
                    </div>
                </div>


                <div class="post-item">
                    <div class="card mb-3">

                        <div class="d-flex p-3 mb-0">
                            <div class="d-flex align-items-center" style="width: 70%;">
                                <img width="60" height="60" class="rounded-circle" src="img/users/user-3.jpg" alt="">
                                <span class="mx-3">
                                    <a href="#" style="text-decoration: none;" class="card-text text-black fw-bold m-0">Justine</a>
                                    <p class="card-text text-secondary m-0">Not all who wander...</p>
                                </span>
                            </div>
                            <p class="card-text text-body-secondary">7 feb, 2024</p>

                        </div>
                        <img class="mt-3" src="img/posts/dog.jpg" alt="...">
                        <div class="post-actions d-flex justify-content-around my-4">
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/like-icon.png" alt="">Like</button>
                            <button class="bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/share-icon.png" alt="">Share</button>
                            <button class="mx-1 bg-transparent border-0"><img width="30" height="30" class="mx-2" src="img/icons/comment-icon.png" alt="">Comment</button>
                        </div>
                    </div>
                </div>



            </div>

        </div>
        <!-- Posts end -->
        <div class="space space-2" style="width: 18rem;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>