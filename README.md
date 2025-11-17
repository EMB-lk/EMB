# EMB.LK - Embilipitiya Business Directory Platform

A hyper-local web application for businesses in the Embilipitiya area to create public profiles and connect with the local community.

## Project Overview

**EMB.LK** is a freemium business directory platform that allows local businesses in Embilipitiya to:
- Create free business profiles with automatic subdomain assignment (e.g., `your-business.emb.lk`)
- Manage their online presence with essential business information
- Get discovered through a powerful global search function
- Upgrade to premium plans for advanced features

## Business Model

### Free Tier - "Basic Profile"
- **Cost**: Free
- **Features**:
  - Automatic subdomain assignment (*.emb.lk)
  - Publicly accessible business profile
  - Basic information (name, address, contact, description)
  - Access to pre-designed templates based on business category
  - Up to 5 photo uploads

### Premium Tier - "Professional Plan"
- **Cost**: LKR 1,500/month or LKR 15,000/year
- **Features**:
  - All features from Free Tier
  - Custom domain mapping (e.g., your-business.com)
  - Up to 50 photo uploads
  - Detailed analytics
  - Priority support

## Tech Stack

- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Authentication**: Laravel Breeze
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL

## Features Implemented

### Core Features
✅ User authentication and registration
✅ Business profile creation and management (CRUD)
✅ Automatic subdomain generation
✅ Category-based business classification
✅ Global search functionality
✅ Business profile views with analytics
✅ Free and premium subscription plans
✅ View counting

### Database Structure
- **Users**: Business owners
- **Businesses**: Business profiles
- **Categories**: Business categories (10 pre-defined)
- **Plans**: Subscription plans (Free, Monthly, Yearly)
- **Subscriptions**: Active subscriptions for businesses
- **Custom Domains**: Premium feature for custom domain mapping

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd EMB
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment configuration**
```bash
cp .env.example .env
```

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Configure database**
Edit `.env` file and set your database credentials:
```
DB_DATABASE=emb_directory
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

This will create all necessary tables and populate:
- 10 business categories
- 3 subscription plans (Free, Monthly Premium, Yearly Premium)

8. **Build frontend assets**
```bash
npm run build
```

9. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the platform.

## Default Categories

The platform comes with 10 pre-configured business categories:
1. Restaurants & Cafes
2. Retail & Shopping
3. Health & Medical
4. Education & Training
5. Professional Services
6. Automotive
7. Home & Garden
8. Beauty & Wellness
9. Technology & Electronics
10. Entertainment & Events

## Subscription Plans

### 1. Basic Profile (Free)
- Price: Free
- Subdomain: Included
- Photos: 5 max
- Custom Domain: No
- Analytics: No
- Support: Standard

### 2. Professional Monthly
- Price: LKR 1,500/month
- Subdomain: Included
- Photos: 50 max
- Custom Domain: Yes
- Analytics: Yes
- Support: Priority

### 3. Professional Yearly
- Price: LKR 15,000/year (2 months free)
- Subdomain: Included
- Photos: 50 max
- Custom Domain: Yes
- Analytics: Yes
- Support: Priority

## User Flow

### For Business Owners
1. Register an account
2. Create a business profile
3. Automatically get a free plan with subdomain
4. Fill in business details (name, category, contact info, etc.)
5. Profile becomes publicly accessible
6. Optionally upgrade to premium for advanced features

### For Public Users
1. Visit the home page
2. Browse businesses by category or search
3. View detailed business profiles
4. Access business contact information
5. Visit business subdomains directly

## Routes

### Public Routes
- `GET /` - Home page with featured businesses
- `GET /search` - Search results page
- `GET /business/{slug}` - Public business profile

### Authenticated Routes
- `GET /dashboard` - User dashboard
- `GET /business` - List user's businesses
- `GET /business/create` - Create new business
- `POST /business` - Store new business
- `GET /business/{business}/edit` - Edit business
- `PUT /business/{business}` - Update business
- `DELETE /business/{business}` - Delete business

## Features Roadmap

### Implemented ✅
- [x] User authentication system
- [x] Business CRUD operations
- [x] Category management
- [x] Subscription plans
- [x] Global search
- [x] View analytics
- [x] Automatic subdomain generation

### Pending 🚧
- [ ] Subdomain routing middleware
- [ ] Custom domain verification and mapping
- [ ] Photo upload functionality
- [ ] Advanced analytics dashboard
- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] Business verification system
- [ ] Category-specific templates
- [ ] Map integration for location
- [ ] Review and rating system

## Development Notes

### Subdomain Implementation
The platform generates automatic subdomains for each business (e.g., `abc-motors.emb.lk`). For production:
1. Configure wildcard DNS for *.emb.lk
2. Set up web server to handle subdomain routing
3. Implement subdomain middleware to detect and route requests

### Custom Domain Implementation
For premium users with custom domains:
1. Domain verification via DNS TXT record
2. Configure domain mapping in web server
3. SSL certificate management for custom domains

## Security Considerations

- All business updates require authentication
- Policy-based authorization ensures users can only edit their own businesses
- Input validation on all forms
- CSRF protection enabled
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade template escaping

## Target Area

**Embilipitiya** - A town in Sri Lanka, serving as the primary target market for this hyperlocal directory platform.

## License

This project is open-source software.

## Support

For support and questions, please open an issue in the repository.

---

Built with ❤️ for the Embilipitiya business community
