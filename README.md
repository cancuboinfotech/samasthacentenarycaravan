# Samastha Centenary Message Caravan Map Application

A Laravel-based real-time location tracking application for the Samastha Centenary Message Caravan, similar to "Where is my train" applications.

## Features

- 🗺️ Interactive map view with real-time caravan locations
- 📍 Location tracking with history
- 🚐 Multiple caravan support
- 📱 Responsive design
- 🔄 Auto-updating location data
- 📊 Location history and details

## Installation

1. **Install PHP dependencies:**
   ```bash
   composer install
   ```

2. **Install Node dependencies:**
   ```bash
   npm install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update `.env` file with your database credentials:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=samastha_caravan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Build frontend assets:**
   ```bash
   npm run build
   ```

7. **Start development server:**
   ```bash
   php artisan serve
   ```

   For development with hot reload:
   ```bash
   npm run dev
   ```

## Usage

### Web Interface

- **Map View:** `/` or `/map` - View all caravans on a map
- **Caravan Details:** `/map/{caravan_id}` - View specific caravan with route history
- **All Caravans:** `/caravans` - List all caravans

### API Endpoints

- `GET /api/locations` - Get all caravan locations
- `GET /api/caravans/{id}/location` - Get latest location for a caravan
- `GET /api/caravans/{id}/history` - Get location history for a caravan
- `POST /api/caravans/{id}/location` - Update caravan location

### Updating Location (API Example)

```bash
POST /api/caravans/1/location
Content-Type: application/json

{
    "latitude": 20.5937,
    "longitude": 78.9629,
    "address": "New Delhi",
    "city": "New Delhi",
    "state": "Delhi",
    "speed": 60.5,
    "heading": 45.0
}
```

## Database Structure

### Caravans Table
- id
- name
- vehicle_number
- description
- driver_name
- driver_phone
- is_active
- timestamps

### Caravan Locations Table
- id
- caravan_id
- latitude
- longitude
- address
- city
- state
- speed
- heading
- tracked_at
- timestamps

## Technologies Used

- Laravel 10
- Leaflet.js (OpenStreetMap)
- Tailwind CSS
- Vite
- MySQL

## License

MIT

# samasthacentenarycaravan
