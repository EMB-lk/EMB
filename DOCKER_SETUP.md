# Docker Setup Guide for EMB.LK

This guide will help you run the EMB.LK Business Directory Platform using Docker and Docker Compose.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 2.0 or higher)

### Installing Docker

#### On Ubuntu/Debian:
```bash
# Update package index
sudo apt-get update

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Add your user to the docker group
sudo usermod -aG docker $USER

# Install Docker Compose
sudo apt-get install docker-compose-plugin
```

#### On macOS:
Download and install [Docker Desktop for Mac](https://www.docker.com/products/docker-desktop)

#### On Windows:
Download and install [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop)

## Project Structure

The Docker setup includes the following services:

1. **app** - PHP 8.2-FPM container running the Laravel application
2. **webserver** - Nginx web server
3. **db** - MySQL 8.0 database server

## Files Created

- `Dockerfile` - Defines the PHP application container
- `docker-compose.yml` - Orchestrates all services
- `docker/nginx/conf.d/default.conf` - Nginx configuration
- `.dockerignore` - Files to exclude from Docker build
- `.env` - Environment variables (configured for Docker)

## Quick Start

### 1. Build and Start Containers

```bash
# Build and start all containers in detached mode
docker compose up -d --build
```

This command will:
- Build the PHP application image
- Download MySQL and Nginx images
- Create and start all containers
- Install Composer dependencies
- Install NPM dependencies and build assets

### 2. Generate Application Key

```bash
docker compose exec app php artisan key:generate
```

### 3. Run Database Migrations and Seeders

```bash
docker compose exec app php artisan migrate --seed
```

This will create:
- All database tables
- 10 business categories
- 3 subscription plans (Free, Monthly Premium, Yearly Premium)

### 4. Set Proper Permissions

```bash
docker compose exec app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
```

### 5. Access the Application

Open your browser and navigate to:
```
http://localhost:8000
```

## Docker Commands Reference

### Start Containers
```bash
docker compose up -d
```

### Stop Containers
```bash
docker compose down
```

### View Logs
```bash
# All services
docker compose logs -f

# Specific service
docker compose logs -f app
docker compose logs -f webserver
docker compose logs -f db
```

### Execute Commands in Container
```bash
# Run artisan commands
docker compose exec app php artisan [command]

# Access container shell
docker compose exec app bash

# Run Composer commands
docker compose exec app composer [command]

# Run NPM commands
docker compose exec app npm [command]
```

### Rebuild Containers
```bash
# Rebuild and restart
docker compose up -d --build

# Rebuild specific service
docker compose up -d --build app
```

### Stop and Remove Everything
```bash
# Stop and remove containers, networks
docker compose down

# Also remove volumes (WARNING: This deletes the database!)
docker compose down -v
```

## Database Access

### From Host Machine
- **Host**: localhost
- **Port**: 3306
- **Database**: emb_directory
- **Username**: emb_user
- **Password**: emb_password

### From Application Container
- **Host**: db
- **Port**: 3306
- **Database**: emb_directory
- **Username**: emb_user
- **Password**: emb_password

### Connect via MySQL Client
```bash
mysql -h 127.0.0.1 -P 3306 -u emb_user -p emb_directory
# Password: emb_password
```

### Or use Docker exec
```bash
docker compose exec db mysql -u emb_user -p emb_directory
# Password: emb_password
```

## Development Workflow

### Making Code Changes

Since the project directory is mounted as a volume, any changes you make to the code will be immediately reflected in the container.

### Recompiling Assets
```bash
# Development build with watch
docker compose exec app npm run dev

# Production build
docker compose exec app npm run build
```

### Running Migrations
```bash
# Run new migrations
docker compose exec app php artisan migrate

# Rollback last migration
docker compose exec app php artisan migrate:rollback

# Fresh migration with seed
docker compose exec app php artisan migrate:fresh --seed
```

### Clearing Cache
```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

## Troubleshooting

### Container Won't Start
```bash
# Check container status
docker compose ps

# View logs for errors
docker compose logs
```

### Permission Issues
```bash
# Fix storage and cache permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### Database Connection Issues
```bash
# Check if database is running
docker compose ps db

# Check database logs
docker compose logs db

# Verify .env database settings
cat .env | grep DB_
```

### Reset Everything
```bash
# Stop and remove all containers and volumes
docker compose down -v

# Rebuild from scratch
docker compose up -d --build

# Re-run migrations
docker compose exec app php artisan migrate --seed
```

## Production Considerations

Before deploying to production:

1. Update `.env` file:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Generate a secure `APP_KEY`
   - Use strong database credentials

2. Update `Dockerfile`:
   - Remove `--no-dev` flag only if you need dev dependencies
   - Consider multi-stage builds for smaller images

3. Configure SSL/TLS:
   - Add SSL certificates
   - Update Nginx configuration for HTTPS
   - Configure port 443

4. Set up proper backups:
   - Regular database backups
   - Volume backups for uploaded files

5. Configure proper logging and monitoring

## Support

For issues related to Docker setup, please check:
- Docker documentation: https://docs.docker.com/
- Laravel documentation: https://laravel.com/docs

For project-specific issues, refer to the main README.md file.
