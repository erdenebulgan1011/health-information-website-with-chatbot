# HealthVR - Health Information Website with Chatbot Source Code

A comprehensive web application that provides health information services integrated with multiple AI-powered chatbots to assist users in finding relevant health resources and guidance.

## 🏥 Overview

HealthVR is a Laravel-based health information platform that combines reliable health content delivery with multiple AI chatbot integrations. Users can browse health information, get personalized recommendations, and interact with various AI-powered assistants including OpenAI GPT, DeepSeek, and Hugging Face models for health-related queries.

## 🏥 The main goal is to create a reliable, accessible, and user-friendly healthcare platform in Mongolian. The platform will include
1. Public discussion forum
2. Chatbot interaction interface
3. Personal health record keeping
4 AI-powered health advice
4. VR content display
5. Event calendar
6. Hospital and pharmacy map display
7. Health test system
   
## ✨ Features

- **Multi-AI Chatbot Integration**: Support for OpenAI GPT-4, DeepSeek Reasoner, and Hugging Face models
- **Comprehensive Health Database**: Extensive collection of health information and resources  
- **User-Friendly Interface**: Modern, responsive design built with Tailwind CSS
- **Advanced Search Functionality**: AI-powered search capabilities for health topics
- **User Management**: Authentication and user profile management
- **Content Management**: Admin panel for managing health content
- **Email Notifications**: Integrated email system for user communications
- **Mobile Responsive**: Optimized for all device types
- **VR Ready**: Built with VR compatibility in mind (HealthVR)

## 🛠️ Technology Stack

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL/PostgreSQL (configurable)
- **Build Tools**: Vite for asset compilation
- **Package Management**: Composer (PHP) & NPM (JavaScript)
- **Testing**: PHPUnit for backend testing

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- NPM or Yarn
- MySQL or PostgreSQL
- Git

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd healthinfo
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Environment Setup

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Configuration

Create a MySQL database and edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthinfo
DB_USERNAME=root
DB_PASSWORD=
```

### 6. AI Services Setup

Configure your AI service API keys in the `.env` file:

```env
# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-4.1-mini

# DeepSeek Configuration  
DEEPSEEK_API_KEY=your_deepseek_api_key_here
DEEPSEEK_MODEL=deepseek-reasoner

# Hugging Face Configuration
HUGGINGFACE_API_TOKEN=your_huggingface_token_here
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 7. Seed Database (Optional)

```bash
php artisan db:seed
```

### 9. Build Assets

```bash
npm run build
# or for development
npm run dev
```

## 🏃‍♂️ Running the Application

### Development Server

```bash
# Start Laravel development server
php artisan serve

# In another terminal, start Vite dev server for hot reloading
npm run dev
```

The application will be available at `http://127.0.0.1:8000`

### Production Deployment

```bash
# Build production assets
npm run build

# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Project Structure

```
healthinfo/
├── app/                    # Laravel application logic
│   ├── Http/Controllers/   # HTTP controllers
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic services
├── bootstrap/             # Laravel bootstrap files
├── config/               # Configuration files
├── database/             # Database migrations and seeders
│   ├── migrations/       # Database migrations
│   └── seeders/         # Database seeders
├── public/              # Public web assets
├── resources/           # Views, CSS, JS, and language files
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── views/          # Blade templates
├── routes/             # Route definitions
├── storage/            # Generated files, logs, cache
├── tests/              # Automated tests
└── vendor/             # Composer dependencies
```

## 🤖 AI Chatbot Implementation

### Multiple AI Integrations

The HealthVR system integrates with multiple AI services:

1. **OpenAI Integration**
   - Model: GPT-4.1-mini
   - Used for: Complex health consultations and detailed explanations
   - Endpoint: OpenAI API

2. **DeepSeek Integration**
   - Model: DeepSeek Reasoner
   - Used for: Medical reasoning and diagnostic assistance
   - Endpoint: https://api.deepseek.com/v1/chat/completions

3. **Hugging Face Integration**
   - Various models available
   - Used for: Specialized health NLP tasks
   - Custom model fine-tuning capabilities

### Architecture

The chatbot system is implemented using:

- **Multi-AI Service Integration**: Seamless switching between different AI providers
- **Knowledge Base**: Structured health information database
- **Response Engine**: Laravel-based logic for generating appropriate responses
- **Real-time Communication**: WebSocket or AJAX-based chat interface
- **Health API**: Dedicated health information API endpoint

### Key Components

1. **Chat Controller** (`app/Http/Controllers/ChatController.php`)
   - Handles chat requests and responses
   - Integrates with AI services
   - Manages conversation history

2. **Health Knowledge Service** (`app/Services/HealthKnowledgeService.php`)
   - Processes health-related queries
   - Retrieves relevant information from database
   - Formats responses for chatbot

3. **Frontend Chat Interface** (`resources/js/chat.js`)
   - Real-time chat UI
   - Message handling and display
   - User interaction management

### Configuration

Configure chatbot and AI services in your `.env` file:

```env
# Application Settings
APP_NAME=HealthVR
APP_URL=http://127.0.0.1:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthinfo
DB_USERNAME=root
DB_PASSWORD=

# AI Services Configuration
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4.1-mini

DEEPSEEK_API_KEY=your_deepseek_api_key
DEEPSEEK_MODEL=deepseek-reasoner
DEEPSEEK_API_ENDPOINT=https://api.deepseek.com/v1/chat/completions

HUGGINGFACE_API_TOKEN=your_huggingface_token

# Health API Endpoint
HEALTH_API_URL=http://127.0.0.1:8000/health

# Email Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="HealthInfo System"

# Session and Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 🗄️ Database Schema

### Key Tables

- `users` - User authentication and profiles
- `health_articles` - Health information content
- `categories` - Content categorization
- `chat_conversations` - Chat history
- `chat_messages` - Individual chat messages

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 📊 Performance Optimization

- **Caching**: Laravel cache for frequently accessed data
- **Database Indexing**: Optimized database queries
- **Asset Optimization**: Minified CSS/JS for production
- **Image Optimization**: Compressed images for faster loading

## 🔒 Security Features

- CSRF Protection
- Input Validation and Sanitization
- Authentication and Authorization
- SQL Injection Prevention
- XSS Protection

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](../../issues) page
2. Create a new issue with detailed information
3. Contact the development team

## 🙏 Acknowledgments

- Laravel Framework team
- Tailwind CSS team
- Health information content providers
- Open source community contributors

---

**Note**: This application is for informational purposes only and should not replace professional medical advice. Always consult with healthcare professionals for medical concerns.
