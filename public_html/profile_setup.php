<?php
session_start();
require_once '../core/utility_functions.php';

if (empty($_SERVER['HTTP_REFERER']) || !isset($_SESSION['registration_complete']) || !$_SESSION['registration_complete']) {
    $base_url = get_base_url();
    header('Location: ' . $base_url . 'register.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Setup Profile</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script type="module" src="scripts/validate-profile-setup.js" defer></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <?php include('partials/header.php'); ?>
        <main class="page-login d-flex flex-column w-100 h-100 align-items-center justify-content-center">
            <form id="setup-profile-form" autocomplete="off" novalidate="novalidate" class="bg-white w-100"
                method="POST" enctype="multipart/form-data"
                action="execute_core_file.php?filename=process_profile_setup.php">
                <div class="card edit-profile-card w-100">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <div class="d-flex align-items-center w-100">
                            <h5 class="text-center m-0 p-0 text-nowrap">Finish Profile Setup</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="display-name" class="form-label">Profile Picture</label>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <img src="https://res.cloudinary.com/dp4vwqhol/image/upload/v1687030814/momento/images/default-pfp_cv6ra7.jpg"
                                        class="profile-picture-picker-image img-fluid rounded-circle"
                                        id="profile-picture-picker-image" alt="profile picture" />
                                </div>
                                <div class="btn btn-light btn-rounded p-0">
                                    <label class="choose-profile-picture-label form-label mb-0 w-100 h-100 p-2"
                                        for="profile-picture-picker">Upload</label>
                                    <input type="file" name="profile_picture_picker" accept="image/*"
                                        class="form-control d-none" id="profile-picture-picker" autocomplete="off" />
                                </div>
                            </div>
                            <div id="errors-container_custom-profile-picture"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-profile-display-name" class="form-label">Display
                                Name</label>
                            <input type="text" class="form-control" id="edit-profile-display-name"
                                placeholder="<?php echo $_SESSION['full_name'] ?>"
                                value="<?php echo $_SESSION['full_name'] ?>" name="user_display_name">
                            <div id="errors-container_custom-display-name">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="profile-bio-textarea form-control" id="bio" name="bio" rows="
                                        3"
                                placeholder="Hi I'm <?php echo explode(' ', $_SESSION['full_name'])[0]; ?>!">Hi I'm <?php echo explode(' ', $_SESSION['full_name'])[0]; ?>!</textarea>
                            <div id="errors-container_custom-bio"></div>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <button type="submit" name="submit"
                                class="btn btn-primary fw-bold w-100 mb-1">Confirm</button>
                            <a class="col btn btn-link text-start text-nowrap text-center link-underline link-underline-opacity-0 fw-semibold"
                                href="register.php" role="button">Go back</a>
                        </div>
                    </div>
                </div>
                <div id="errors-container_custom-container"></div>
            </form>
        </main>
        <?php include('partials/footer.php'); ?>
    </div>

</html>