-- Movie Review Hub Database Schema
-- Run this on your RDS MySQL database

-- Create database (if not exists)
CREATE DATABASE IF NOT EXISTS app_db;
USE app_db;

-- Create movie_reviews table
CREATE TABLE IF NOT EXISTS movie_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    review TEXT NOT NULL,
    image_url VARCHAR(500) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO movie_reviews (title, year, rating, review, image_url) VALUES 
('Inception', 2010, 9.5, 'A mind-bending masterpiece that explores dreams within dreams. Christopher Nolan at his best!', ''),
('The Dark Knight', 2008, 10, 'Heath Ledger\'s Joker is legendary. A perfect superhero film that transcends the genre.', ''),
('Interstellar', 2014, 9.0, 'Beautiful, emotional, and scientifically fascinating space epic about love and survival.', ''),
('Parasite', 2019, 9.5, 'A brilliant social satire that keeps you guessing until the very end. Well-deserved Oscar winner.', ''),
('Spirited Away', 2001, 9.0, 'A magical journey into a world of spirits and wonder. Miyazaki at his finest.', '');

-- Verify table structure
DESCRIBE movie_reviews;

-- Show all records
SELECT * FROM movie_reviews;