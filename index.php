<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Reviews - CC Group Project</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        
        .add-movie-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        
        .add-movie-btn:hover {
            transform: translateY(-2px);
        }
        
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        
        .movie-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .movie-poster {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .movie-poster img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }
        
        .movie-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .movie-year {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .movie-rating {
            display: inline-block;
            background: #ffc107;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            margin-bottom: 12px;
        }
        
        .movie-review {
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .delete-btn:hover {
            opacity: 0.8;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
        }
        
        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .modal-content input[type="file"] {
            padding: 8px;
        }
        
        .submit-btn {
            background: #667eea;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        
        .cancel-btn {
            background: #6c757d;
        }
        
        @media (max-width: 768px) {
            .movie-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Movie Review Hub</h1>
        <p class="subtitle">Share your thoughts about movies you've watched</p>
        
        <button class="add-movie-btn" onclick="openModal()">+ Add Movie Review</button>
        
        <div class="movie-grid">
            <?php
            include 'config.php';
            
            if ($conn->connect_error) {
                echo "<p>Database connection failed: " . $conn->connect_error . "</p>";
            } else {
                $result = $conn->query("SELECT * FROM movie_reviews ORDER BY id DESC");
                
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='movie-card'>";
                        
                        if (!empty($row['image_url'])) {
                            echo "<div class='movie-poster'>";
                            echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['title']) . "'>";
                            echo "</div>";
                        }
                        
                        echo "<div class='movie-title'>" . htmlspecialchars($row['title']) . "</div>";
                        echo "<div class='movie-year'>📅 Year: " . $row['year'] . "</div>";
                        echo "<div class='movie-rating'>⭐ Rating: " . $row['rating'] . "/10</div>";
                        echo "<div class='movie-review'>" . nl2br(htmlspecialchars($row['review'])) . "</div>";
                        echo "<button class='delete-btn' onclick='deleteMovie(" . $row['id'] . ")'>Delete Review</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='text-align:center; grid-column:1/-1;'>No movie reviews yet. Add your first review!</p>";
                }
                $conn->close();
            }
            ?>
        </div>
    </div>
    
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <h2>Add Movie Review</h2>
            <form id="movieForm" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Movie Title" required>
                <input type="number" name="year" placeholder="Release Year" required>
                <input type="number" name="rating" placeholder="Rating (1-10)" min="1" max="10" step="0.1" required>
                <textarea name="review" rows="4" placeholder="Your review..." required></textarea>
                <input type="file" name="movie_poster" accept="image/*">
                <button type="submit" class="submit-btn">Submit Review</button>
                <button type="button" class="submit-btn cancel-btn" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('movieModal').style.display = 'block';
            document.getElementById('movieForm').reset();
        }
        
        function closeModal() {
            document.getElementById('movieModal').style.display = 'none';
        }
        
        document.getElementById('movieForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            const response = await fetch('add_review.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            if (result.success) {
                closeModal();
                location.reload();
            } else {
                alert('Error: ' + result.error);
            }
        });
        
        async function deleteMovie(id) {
            if (confirm('Are you sure you want to delete this review?')) {
                const response = await fetch('add_review.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id: id, delete: true})
                });
                
                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + result.error);
                }
            }
        }
        
        window.onclick = function(event) {
            if (event.target == document.getElementById('movieModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>