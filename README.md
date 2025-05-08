# Employee Tracking System

The **Employee Tracking System** is a web-based application designed to manage field employees who perform on-site tasks, ensuring they are present at the correct locations for their assignments. This system streamlines attendance tracking, scheduling, and vacation requests, providing a user-friendly interface for both employees and administrators to enhance workforce management.


## Features

- **Attendance Management**: Employees can check in and out with geolocation and photo verification.
- **Schedule Management**: View and manage work schedules.
- **Vacation Requests**: Submit, approve, or reject vacation requests.
- **Role-Based Access Control**: Secure access with roles like Admin, Verificator, and Employee.
- **Attendance Overview and Trends**: Visualize attendance data with charts.
- **Dark Mode Support**: Enhanced user experience with light and dark themes.


## Requirements

- **PHP**: ^8.2
- **Composer**: Dependency manager for PHP
- **Laravel Framework**: ^11.x
- **Database**: MySQL or SQLite
- **Node.js**: For managing frontend assets (optional)


## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/employee-tracking-system.git
   cd employee-tracking-system
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set up the environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   - Configure the `.env` file with your database credentials.

4. **Run migrations**:
   ```bash
   php artisan migrate
   ```
   - You could also run the seeder (optional).
       ```bash
       php artisan db:seed
       ```

5. **Start the development server**:
   ```bash
   php artisan serve
   ```

6. **Start the frontend development server**:
   ```bash
   npm run dev
   ```

7. **Access the application** at [http://localhost:8000](http://localhost:8000).


## Usage

### Employee Features

- **Check-In/Check-Out**: Employees can check in and out with photo and location verification based on assigned schedule.
- **View Attendance History**: Employees can view their attendance records.
- **View Vacation Requests History**: Employees can view their vacation request records.
- **Submit Vacation Requests**: Employees can request vacations and track their status.

### Verificator Features

- **Approve/Reject vacation requests**: Handle vacation requests verifications.
- **Approve/Reject attendances**: Handle attendance verifications.
- **View Attendance Trends**: Analyze attendance data with visual charts.
  
### Admin Features

- **Manage Users**: Add, update, or delete user accounts.
- **Manage Employee Schedules**: Add, update, or delete employee schedules.
- **Approve/Reject vacation requests**: Handle vacation requests verifications.
- **Approve/Reject attendances**: Handle attendance verifications.
- **View Attendance Trends**: Analyze attendance data with visual charts.


## Testing

- Run the test suite using Pest:
   ```bash
   php artisan test
   ```
