# 🎬 Movie Review Hub - AWS Cloud Project

## Project Overview
A fully functional movie review web application deployed on AWS cloud infrastructure using EC2, RDS, S3, and VPC services.

## Architecture
- **Compute**: AWS EC2 (t2.micro) running Apache + PHP
- **Database**: AWS RDS MySQL
- **Storage**: AWS S3 for image uploads
- **Networking**: Custom VPC with public/private subnets
- **Security**: IAM roles and Security Groups

## Features
- Add movie reviews with ratings (1-10)
- Upload movie posters to S3
- Display reviews in responsive grid layout
- Delete reviews
- All data persisted in RDS database

## Technologies Used
- PHP 8.x
- MySQL 8.x
- HTML5/CSS3
- JavaScript (AJAX)
- AWS CLI

## Setup Instructions
1. Clone this repository
2. Update `config.php` with your RDS credentials
3. Upload to EC2 instance
4. Configure S3 bucket policy
5. Attach IAM role to EC2

## AWS Services
| Service | Purpose |
|---------|---------|
| EC2 | Web server hosting |
| RDS | MySQL database |
| S3 | Image storage |
| VPC | Network isolation |
| IAM | Security permissions |

## Reference
https://youtu.be/gKsByHd794M

## Author
CC Group Project

## License
Educational Purpose Only
