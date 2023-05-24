<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function connect_to_db()
{
    return mysqli_connect('localhost', 'root', '', 'InstaCloneDB');
}

function does_value_exist($conn, $table, $column, $value)
{
    $query = "SELECT * FROM `$table` WHERE `$column` = '$value'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function upload_image_file_to_dir($file, $target_dir, $directory_name)
{
    $image_name = $file['name'];
    $image_tmp_name = $file['tmp_name'];

    $new_image_filename = uniqid() . '_' . $image_name;
    $image_upload_path = $target_dir . $new_image_filename;

    $relative_image_path = '/Emuel_Vassallo_4.2D/instagram-clone/uploads/' . $directory_name . '/' . $new_image_filename;

    if ($directory_name === 'profile-pictures') {
        $_SESSION['user_profile_picture_path'] = $relative_image_path;
    }

    if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
        return $relative_image_path;
    }

    return false;
}

function create_user($conn, $email, $phone_number, $full_name, $username, $hashed_password, $display_name, $bio)
{
    $pfp_file = $_FILES['profile_picture_picker'];
    $target_dir = dirname(dirname(dirname(__DIR__))) . '/Emuel_Vassallo_4.2D/instagram-clone/uploads/profile-pictures/';
    $directory_name = 'profile-pictures';

    $query_callback = function ($profile_picture_path) use ($conn, $username, $full_name, $email, $phone_number, $hashed_password, $display_name, $bio) {
        $username = mysqli_real_escape_string($conn, strtolower($username));
        $profile_picture_path = mysqli_real_escape_string($conn, $profile_picture_path);
        $display_name = mysqli_real_escape_string($conn, $display_name);
        $bio = mysqli_real_escape_string($conn, $bio);

        $query = "INSERT INTO `users_table` 
             (`username`, `full_name`, `email`, `phone_number`, `password`, `profile_picture_path`, `display_name`, `bio`) 
             VALUES ('$username', '$full_name', '$email', '$phone_number', '$hashed_password', '$profile_picture_path', '$display_name', '$bio');";

        return mysqli_query($conn, $query);
    };

    return process_file_and_execute_query($conn, $pfp_file, $target_dir, $directory_name, $query_callback);
}

function get_user_by_credentials($conn, $username, $password)
{
    $query = "SELECT * 
              FROM `users_table` 
              WHERE `username` = '$username' 
                OR `email` = '$username' 
                OR `phone_number` = '$username'";

    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];

    if (password_verify($password, $hashed_password) || $password === $hashed_password) {
        return $row;
    }

    return false;
}

function update_user_profile($conn, $user_id, $display_name, $profile_picture_path, $bio)
{
    $display_name = mysqli_real_escape_string($conn, $display_name);
    $bio = mysqli_real_escape_string($conn, $bio);

    $query = "UPDATE `users_table` SET 
              `profile_picture_path` = '$profile_picture_path',
              `display_name` = '$display_name',
              `bio` = '$bio'
              WHERE `id` = '$user_id'";

    return mysqli_query($conn, $query);
}

function add_post($conn, $user_id, $caption)
{
    $new_post_file = $_FILES['new_post_image_picker'];
    $target_dir = dirname(dirname(dirname(__DIR__))) . '/Emuel_Vassallo_4.2D/instagram-clone/uploads/posts/';
    $directory_name = 'posts';

    $query_callback = function ($new_new_post_image_picker_path) use ($conn, $user_id, $caption) {
        $created_at = date('Y-m-d H:i:s');
        $user_id = mysqli_real_escape_string($conn, $user_id);
        $caption = mysqli_real_escape_string($conn, $caption);

        $query = "INSERT INTO `posts_table` (`user_id`, `image_dir`, `caption`, `created_at`) 
                  VALUES ('$user_id', '$new_new_post_image_picker_path', '$caption', '$created_at')";

        return mysqli_query($conn, $query);
    };

    return process_file_and_execute_query($conn, $new_post_file, $target_dir, $directory_name, $query_callback);
}

function process_file_and_execute_query($conn, $file, $target_dir, $directory_name, $query_callback)
{
    if (empty($file['name'])) {
        return false;
    }

    $new_image_path = upload_image_file_to_dir($file, $target_dir, $directory_name);

    if (!$new_image_path) {
        return false;
    }

    return $query_callback(mysqli_real_escape_string($conn, $new_image_path));
}

function get_all_posts($conn)
{
    $query = "SELECT p.*, u.username, u.display_name, u.profile_picture_path
              FROM `posts_table` AS p
              JOIN `users_table` AS u ON p.user_id = u.id
              ORDER BY p.created_at DESC;
              ";

    $result = mysqli_query($conn, $query);

    $posts = array();

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }

    return $posts;
}

function get_user_post_count($conn, $user_id)
{
    $query = "SELECT COUNT(*) AS post_count FROM posts_table WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result)['post_count'];
    return $row;
}


?>