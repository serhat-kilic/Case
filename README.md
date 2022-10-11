## Requirements
<ul>
<li>requires a minimum PHP version of 8.1.</li>
<li>MySql 5.7. or MariaDb 10.</li>
</ul>

## Installation
<ul>
<li>composer update</li>
<li>php artisan migrate</li>
<li>php artisan db:seed</li>
</ul>


## Api Usage

### Users endpoints

| Method | URI           | Description                     |
|--------|---------------|---------------------------------|
| POST   | /api/register | Create a new user account       |
| POST   | /api/login    | Authenticate user               |
| POST   | /api/logout   | logout user                     |
| POST   | /api/refresh  | Set new jwt token               | 
| GET    | /api/me       | User informattion with jwtToken | 


### Employees endpoints

| Method | URI                       | Description            |
|--------|---------------------------|------------------------|
| POST   | /api/employees/create     | Add a new car          |
| GET    | /api/employees/list       | Get all cars           |
| GET    | /api/employees/get/:id    | Get a car by id        |
| GET    | /api/employees/search     | Search car             |
| GET    | /api/employees/cars       | Employee's Cars        |
| POST   | /api/employees/give-car   | Assign car to employee |
| DELETE | /api/employees/delete/:id | Delete a car           |
| PUT    | /api/employees/edit/:id   | Edit car             |


### Cars endpoints

| Method | URI                  | Description            |
|--------|----------------------|------------------------|
| POST   | /api/cars/create     | Add a new car          |
| GET    | /api/cars/list       | Get all cars           |
| GET    | /api/cars/get/:id    | Get car by id          |
| DELETE | /api/cars/delete/:id | Delete a car           |
| PUT    | /api/cars/edit/:id   | Edit car               |


## Postman Collection
Click to reach the <a href="https://www.postman.com/collections/2c2e2c8d57652cfaac8b">Postman Collection</a>
