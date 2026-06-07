<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include 'config.php';

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['error'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Handle DELETE
$input = file_get_contents('php://input');
if ($input) {
    $data = json_decode($input, true);
    if (isset($data['delete']) && isset($data['id'])) {
        $id = intval($data['id']);
        if ($conn->query("DELETE FROM movie_reviews WHERE id = $id")) {
            $response['success'] = true;
        } else {
            $response['error'] = $conn->error;
        }
        echo json_encode($response);
        $conn->close();
        exit;
    }
}

// Handle INSERT
$title = trim($_POST['title'] ?? '');
$year = intval($_POST['year'] ?? 0);
$rating = floatval($_POST['rating'] ?? 0);
$review = trim($_POST['review'] ?? '');

if (empty($title)) {
    $response['error'] = 'Title is required';
    echo json_encode($response);
    exit;
}

$title_safe = $conn->real_escape_string($title);
$review_safe = $conn->real_escape_string($review);
$image_url = '';

// Upload to S3
if (isset($_FILES['movie_poster']) && $_FILES['movie_poster']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['movie_poster']['tmp_name'];
    $extension = strtolower(pathinfo($_FILES['movie_poster']['name'], PATHINFO_EXTENSION));
    $new_filename = time() . '_' . uniqid() . '.' . $extension;
    $bucket = 'cc-project-bucket-26'; // Update with your bucket name
    
    $cmd = "aws s3 cp " . escapeshellarg($file_tmp) . " s3://$bucket/movie-posters/$new_filename 2>&1";
    exec($cmd, $output, $return_code);
    
    if ($return_code === 0) {
        $image_url = "https://$bucket.s3.amazonaws.com/movie-posters/$new_filename";
    }
}

$sql = "INSERT INTO movie_reviews (title, year, rating, review, image_url) 
        VALUES ('$title_safe', $year, $rating, '$review_safe', '$image_url')";

if ($conn->query($sql)) {
    $response['success'] = true;
} else {
    $response['error'] = $conn->error;
}

$conn->close();
echo json_encode($response);
?>