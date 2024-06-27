# Restaurant Management System

## Table of Contents
1. [Project Overview](#project-overview)
2. [Features](#features)
3. [Technologies Used](#technologies-used)
4. [Installation](#installation)
5. [Usage](#usage)
6. [Postman Documentation](#postman-documentation)
7. [Screenshots](#screenshots)
8. [Contributing](#contributing)
9. [Contributors](#contributors)
10. [License](#license)
11. [Contact](#contact)

## Project Overview

The Restaurant Management System is a comprehensive solution for managing restaurant operations efficiently. It allows for table management, reservations management, order management, , review management, and provides an admin dashboard to streamline the workflow of restaurant staff and improve customer satisfaction.

## Features

- **Table Reservation**: Book tables in advance.
- **Order Management**: Take and track orders easily.
- **Review Management**: Give reviews to the service of the restaurant.
- **Admin Dashboard**: Access detailed views and controls for managing the restaurant.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript.
- **Backend**: [php/SQL]
- **Database**: [MySQL]
- **Framework**: Laravel
- **Version Control**: Git

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/restaurant-management-system.git
    ```
2. Install needed packages:
    ```bash
    composer install
    ```
3. Copy the .env file:
    ```bash
    cp .env.example .env
    ```
4. Generate the application key:
    ```bash
    php artisan key:generate
    ```
5. Set up the database and the seeder:
    ```bash
    php artisan migrate --seed
    ```
6. Install the Spatie package. Follow the steps on the [official site](https://spatie.be/docs/laravel-permission/v6/introduction).
7. Install dependencies:
    ```bash
    npm install  # or yarn install
    ```
8. Run the application:
    ```bash
    php artisan serve
    npm run dev
    ```

## Usage

1. **Login**: Use the provided admin credentials to log in.
2. **Dashboard**: Access the admin dashboard to view the summary of operations.
3. **Manage Tables**: View and manage table reservations.
4. **Order Processing**: Create and track orders.
5. **Menu Customization**: Update the menu as needed.
6. **Billing**: Generate and manage bills.
7. **Review Management**: Manage customer reviews.

## Postman Documentation

- [Postman Documentation](https://documenter.getpostman.com/view/34501481/2sA3XPEP5E#e5758aa8-82a4-4a31-9f74-70f1c1356d3a)

## Screenshots

![image](https://github.com/samerabbas77/Restaurant_Focal/assets/166222783/24c6ff62-7abc-4ab8-b6c1-40a408cd5c8c)
![image](https://github.com/samerabbas77/Restaurant_Focal/assets/166222783/4f43a294-5666-485e-9048-e3f1025dc82b)
![image](https://github.com/samerabbas77/Restaurant_Focal/assets/166222783/8f55e21a-8b85-442d-8e04-f174eb3d9754)
![image](https://github.com/samerabbas77/Restaurant_Focal/assets/166222783/dbdef951-fe7e-4d0a-bf38-ad7b817215ad)
![image](https://github.com/samerabbas77/Restaurant_Focal/assets/166222783/1d1494db-6fe5-4912-a023-fabe30e7dbc4)




## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

## Contributors

- samerabbas77    [https://github.com/samerabbas77]
- HussainQursh77  [https://github.com/HussainQursh77]
- SafaaNahhas     [https://github.com/SafaaNahhas]
- FaezaAldarweesh [https://github.com/FaezaAldarweesh]
- ayaalaji        [https://github.com/ayaalaji]
- hamza123        [hamzaissa022000@gmail.com] 

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

- **Author**: [samer Abbas]
- **Email**: [samer23abbas@gmail.com]
- **GitHub**: [(https://github.com/samerabbas77)]

---

This version of the README includes the new contributor and updates the Technologies Used section to include Laravel.
