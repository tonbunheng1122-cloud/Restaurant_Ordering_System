# FastBite - Restaurant Ordering System

A modern, full-featured restaurant ordering system built with Laravel 12, featuring user dashboards, menu management, reservations, order tracking, and comprehensive admin panel.

## 🚀 Features

- **User Authentication**: Secure login system with role-based access (Admin/User)
- **Dashboard Analytics**: Real-time statistics, sales charts, and performance metrics
- **Menu Management**: Complete product catalog with categories and pricing
- **Order System**: Seamless food ordering with cart functionality
- **Reservation System**: Table reservation management
- **Admin Panel**: Full administrative control over products, users, and reports
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **Real-time Updates**: Live dashboard with Chart.js visualizations

## 📋 Requirements

- **PHP**: ^8.2 or higher
- **Composer**: Latest version
- **Node.js**: ^16.0 or higher
- **NPM**: Latest version
- **MySQL**: ^5.7 or higher (or MariaDB)
- **Redis**: For caching and sessions (optional but recommended)

## 🛠️ Installation

Follow these steps to set up the project on your local machine:

### 1. Clone or Download the Repository

```bash
git clone <repository-url>
cd Restaurant_Ordering_System
```

### 2. Install PHP Dependencies

```bash
composer install
```

This will install all required PHP packages including Laravel framework and dependencies.

### 3. Install Node.js Dependencies

```bash
npm install
```

This installs frontend dependencies including:
- Tailwind CSS for styling
- Alpine.js for interactivity
- Chart.js for data visualization
- Vite for asset compilation

### 4. Environment Configuration

Copy the environment example file:

```bash
cp .env.example .env
```

Edit the `.env` file with your local configuration:

```env
APP_NAME="FastBite"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fastbite_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cache & Sessions (Database recommended for production)
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Redis (optional but recommended)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

This generates a unique application key for encryption.

### 6. Database Setup

Create a MySQL database and run migrations:

```bash
php artisan migrate
```

When prompted, type `yes` to create the database tables.

### 7. Seed Default Admin User

```bash
php artisan db:seed --class=AdminSeeder
```

This creates a default admin user:
- **Username**: `admin`
- **Password**: `admin123`
- **Role**: Admin

⚠️ **Important**: Change the default password after first login!

### 8. Create Storage Link

```bash
php artisan storage:link
```

This creates a symbolic link for file uploads (product images, etc.).

### 9. Build Frontend Assets

```bash
npm run build
```

This compiles and optimizes CSS and JavaScript assets.

## 🚀 Running the Application

### Development Mode

For development, run these commands in separate terminals:

#### Terminal 1: Start Laravel Server
```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

#### Terminal 2: Start Vite Dev Server
```bash
npm run dev
```

This enables hot module replacement for frontend changes.

#### Terminal 3: Start Queue Worker (Redis)
```bash
php artisan queue:work --tries=3 --timeout=90 --sleep=3
```

This processes background jobs using Redis queues.

### Production Mode

For production deployment:

```bash
# Build optimized assets
npm run build

# Start the server
php artisan serve --host=0.0.0.0 --port=8000

# Start queue worker in background
php artisan queue:work --tries=3 --timeout=90 --sleep=3 --daemon
```

## 💾 Redis Data Storage

Your application is configured to use Redis for high-performance data storage:

### Current Redis Configuration ✅

- **Cache Store**: Redis (faster than database/file caching)
- **Session Driver**: Redis (persistent sessions across server restarts)
- **Queue Connection**: Redis (reliable background job processing)

### Redis Usage Examples

#### 1. Cache Data
```php
// Store data in Redis cache
Cache::put('popular_dishes', $dishes, 3600); // 1 hour
Cache::put('user_orders_' . $userId, $orders, 1800); // 30 minutes

// Retrieve cached data
$popularDishes = Cache::get('popular_dishes', []);
$userOrders = Cache::get('user_orders_' . $userId, collect());
```

#### 2. Session Management
```php
// Store user preferences in session
session(['user_theme' => 'dark', 'language' => 'en']);
session(['cart_items' => $cartData]);

// Retrieve session data
$theme = session('user_theme', 'light');
$cart = session('cart_items', []);
```

#### 3. Background Jobs (Queues)
```php
// Dispatch job to Redis queue
dispatch(new ProcessOrder($order));
dispatch(new SendOrderNotification($order))->delay(now()->addMinutes(5));

// In a controller
public function placeOrder(Request $request)
{
    $order = Order::create($request->validated());
    
    // Send to background processing
    ProcessOrder::dispatch($order);
    SendOrderNotification::dispatch($order)->delay(10);
    
    return response()->json(['message' => 'Order placed successfully']);
}
```

#### 4. Real-time Features
```php
// Store temporary data
Redis::set('active_users', $userCount);
Redis::setex('order_lock_' . $orderId, 300, 'processing'); // 5 minutes

// Get data
$activeUsers = Redis::get('active_users');
$isProcessing = Redis::exists('order_lock_' . $orderId);
```

### Redis Performance Benefits

- **⚡ Faster Response Times**: Data retrieval in microseconds vs milliseconds
- **🔄 Persistent Sessions**: User sessions survive server restarts
- **📊 Real-time Analytics**: Store live dashboard data
- **🔄 Background Processing**: Handle heavy tasks without blocking UI
- **📈 Scalability**: Handle more concurrent users
- **💾 Memory Efficient**: Optimized data structures

### Redis Commands

```bash
# Clear all cache
php artisan cache:clear

# Clear specific cache tags
Cache::tags(['orders'])->flush();

# Monitor Redis (if you have redis-cli)
redis-cli -h your-redis-host -p your-redis-port -a your-password monitor

# Check Redis info
redis-cli -h your-redis-host -p your-redis-port -a your-password info
```

### Redis Data Types for Your App

1. **Strings**: User sessions, cache keys, counters
2. **Hashes**: User profiles, order details, settings
3. **Lists**: Recent orders, activity feeds, queues
4. **Sets**: Unique visitors, favorite items, tags
5. **Sorted Sets**: Leaderboards, rankings, priorities

### Example: Real-time Order Tracking

```php
// Store order status in Redis
Redis::hset('order:' . $orderId, 'status', 'preparing');
Redis::hset('order:' . $orderId, 'updated_at', now());

// Get order status
$status = Redis::hget('order:' . $orderId, 'status');
$updated = Redis::hget('order:' . $orderId, 'updated_at');

// Real-time dashboard
$activeOrders = Redis::keys('order:*');
$totalPreparing = Redis::hlen('order:preparing');
```

## 📁 Project Structure

```
Restaurant_Ordering_System/
├── app/                    # Laravel application code
│   ├── Http/Controllers/   # Controllers
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── database/              # Database migrations and seeders
│   ├── migrations/        # Database schema
│   └── seeders/          # Database seeders
├── public/                # Public assets
├── resources/             # Views and frontend assets
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/                # Route definitions
├── storage/               # File storage
├── tests/                 # Test files
├── vendor/                # Composer dependencies
├── .env                   # Environment configuration
├── composer.json          # PHP dependencies
├── package.json           # Node dependencies
└── vite.config.js         # Vite configuration
```

## 🔧 Available Commands

### Laravel Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed
php artisan db:seed --class=AdminSeeder

# Create storage link
php artisan storage:link

# Run tests
php artisan test
```

### NPM Commands

```bash
# Development build
npm run dev

# Production build
npm run build

# Install dependencies
npm install
```

## 🌐 Usage

### Admin Access
1. Visit `http://localhost:8000/login`
2. Login with admin credentials
3. Access admin dashboard at `/dashboards`

### User Access
1. Visit `http://localhost:8000`
2. Register or login as a regular user
3. Access user dashboard and place orders

## � Configuration

### Telegram Bot Setup

The system includes built-in Telegram notifications for orders, stock alerts, and status updates. To set up Telegram alerts:

#### 1. Create a Telegram Bot
1. Open Telegram and search for `@BotFather`
2. Send `/newbot` command
3. Follow the prompts to create your bot
4. Save the **Bot Token** (format: `123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11`)

#### 2. Get Your Chat ID
1. Send a message to your bot
2. Visit: `https://api.telegram.org/bot<YourBOTToken>/getUpdates`
3. Find your chat ID in the response (usually a negative number for private chats)

#### 3. Configure Environment Variables
Update your `.env` file with the Telegram credentials:

```env
# Telegram Bot Configuration
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_CHAT_ID=your_chat_id_here
```

#### 4. Test the Configuration
Run this command to test your Telegram setup:

```bash
php artisan tinker
```

Then in tinker, run:
```php
Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
    'chat_id' => env('TELEGRAM_CHAT_ID'),
    'text' => '🔔 FastBite Telegram Alert Test - Configuration Successful!',
    'parse_mode' => 'Markdown'
]);
```

### Current Telegram Notifications

The system currently sends Telegram alerts for:

- ✅ **New Orders**: When customers place orders
- ✅ **Order Status Changes**: When order status is updated
- ✅ **Stock Alerts**: When products are running low
- ✅ **Order Cancellations**: When orders are cancelled

### Extending Telegram Alerts

To add Telegram notifications to other parts of the system (reservations, user registrations, etc.), you can:

1. **Add the sendTelegram method** to other controllers
2. **Import required classes**:
```php
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
```

3. **Use the existing sendTelegram method** from MenuController or create a trait

Example implementation:
```php
private function sendTelegram(string $message): void
{
    $botToken = Setting::get('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');
    $chatId   = Setting::get('telegram_chat_id')   ?? env('TELEGRAM_CHAT_ID');

    if (!$botToken || !$chatId) {
        Log::warning('Telegram not configured — skipping alert.');
        return;
    }

    try {
        $response = Http::timeout(5)->post(
            "https://api.telegram.org/bot{$botToken}/sendMessage",
            [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => 'Markdown',
            ]
        );

        if (!$response->successful()) {
            Log::warning('Telegram send failed: ' . $response->body());
        }
    } catch (\Exception $e) {
        Log::warning('Telegram exception: ' . $e->getMessage());
    }
}
```

### Admin Settings Integration (Optional)

To manage Telegram settings through the admin panel, you can add a "Notifications" tab to the settings page with fields for:
- Telegram Bot Token
- Telegram Chat ID
- Enable/Disable specific notification types

### Troubleshooting Telegram

1. **Bot not responding**: Check if the bot token is correct
2. **Messages not sending**: Verify the chat ID and ensure you've messaged the bot first
3. **Network issues**: Check firewall settings and internet connectivity
4. **Rate limits**: Telegram has rate limits; avoid sending too many messages quickly

### Example Telegram Messages

The system sends formatted messages like:

```
🆕 *NEW ORDER RECEIVED*
━━━━━━━━━━━━━━━━━━━━
👤 Customer: John Doe
📱 Phone: +1234567890
📍 Address: 123 Main St
━━━━━━━━━━━━━━━━━━━━
🍕 *Order Items:*
• Pizza Margherita - $15.99
• Coke - $2.99
━━━━━━━━━━━━━━━━━━━━
💰 *Total: $18.98*
📊 Status: Pending
🕐 Ordered at: 2024-01-15 14:30:00
```

This provides comprehensive setup instructions for Telegram alerts in your FastBite restaurant ordering system.


### Redis Run 
php artisan tinker 