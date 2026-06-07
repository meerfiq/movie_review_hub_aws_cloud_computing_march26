# Movie Review Hub - Complete Project Documentation

## Project Information
- **Project Name**: Movie Review Hub
- **Course**: AWS Cloud Computing
- **Group**: CC Group Project
- **Date**: 2026

## AWS Services Used

### 1. EC2 (Compute)
- **Instance Type**: t2.micro (Free Tier)
- **AMI**: Amazon Linux 2023
- **Role**: Web server hosting PHP application
- **Configuration**: Apache + PHP 8.x

### 2. RDS (Database)
- **Engine**: MySQL 8.0
- **Instance Class**: db.t3.micro
- **Storage**: 20GB GP2
- **Database Name**: app_db
- **Table**: movie_reviews

### 3. S3 (Storage)
- **Bucket Name**: cc-project-bucket-26
- **Use**: Store movie poster images
- **Access**: Public read via bucket policy
- **Folder Structure**: /movie-posters/

### 4. VPC (Networking)
- **CIDR**: 10.0.0.0/16
- **Subnets**: 2 Public, 2 Private
- **Internet Gateway**: For public access
- **NAT Gateway**: For private subnet internet access

### 5. IAM (Security)
- **Role Name**: cc_group_project-ec2-s3-role
- **Permissions**: S3 read/write access
- **Attached To**: EC2 instance

### 6. Security Groups
- **web-sg**: HTTP (80), SSH (22)
- **db-sg**: MySQL (3306) from web-sg only

## Application Features

1. **Create Reviews**
   - Movie title, year, rating (1-10)
   - Written review
   - Optional image upload

2. **Read Reviews**
   - Display all reviews in grid layout
   - Show images from S3
   - Sort by newest first

3. **Delete Reviews**
   - One-click deletion
   - Confirmation dialog

4. **Image Upload**
   - Upload to S3 bucket
   - Automatic URL generation
   - Display in review cards

## File Structure
/var/www/html/
├── config.php # Database credentials
├── index.php # Main application
├── add_review.php # API endpoint
└── upload_test.html # Test interface


## Deployment Steps

1. Launch EC2 instance with Amazon Linux 2023
2. Install Apache and PHP
3. Create RDS MySQL database
4. Create S3 bucket with public read policy
5. Create IAM role and attach to EC2
6. Upload application files
7. Configure database connection
8. Test application

## Testing URLs

- Main App: `http://[EC2-PUBLIC-IP]/index.php`
- Database Check: `http://[EC2-PUBLIC-IP]/check_db.php`
- Test Upload: `http://[EC2-PUBLIC-IP]/upload_test.html`

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Database connection fails | Check RDS endpoint in config.php |
| Images not uploading | Verify IAM role attached to EC2 |
| Images not displaying | Check S3 bucket policy |
| 403 Forbidden | Run: sudo chmod -R 755 /var/www/html |
| Blank page | Check Apache error log |

## Cost Considerations

All services used are within AWS Free Tier limits:
- EC2 t2.micro: 750 hours/month free
- RDS db.t3.micro: 750 hours/month free
- S3: 5GB standard storage free
- Data transfer: 15GB out free

## Cleanup Instructions

To avoid charges after project completion:
1. Terminate EC2 instance
2. Delete RDS database
3. Empty and delete S3 bucket
4. Delete IAM role
5. Delete VPC

## References

- AWS Documentation
- PHP Manual
- MySQL Documentation

## Appendix: API Endpoints

### POST /add_review.php
**Form Data**:
- title (string, required)
- year (integer, required)
- rating (float, required)
- review (text, required)
- movie_poster (file, optional)

**Response**:
```json
{"success": true}