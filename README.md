# News API with Laravel and Vue JS #

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Requirements

1. Apache
2. MySQL database
3. Node JS

### Set up Laravel project

Clone the project and navigate to the project root directory
```
cd ~/full/path/to/news
```

Here we assume that our `Apache` and `MySQL` server are running.

---

Copy `.env.example` file to `.env`
```
cp .env.example .env
```

Install dependencies
```
composer install

php artisan key:generate

npm install && npm run dev
```

Then, we have to migrate our migration files to create our tables and seed default data for `user` and `categories`
(in `database/migrations` and `database/seeds`)

Don't forget to create new database named `news_app`, we will use it as our database in this project as mentioned in our `.env` file (`DB_DATABASE=news_app`).
```
php artisan migrate && php artisan db:seed
```
It will creates a default user for us, `Admin`. Use this credential for managing `categories` data from api.
```
Admin -> John Doe
username: admin@gmail.com
password: john123
```

##### Install Laravel Passport
Run command below to install passport
```
php artisan passport:install --uuids
```
It will generates 2 clients for us
```
Personal access client created successfully.
Client ID: 95a8e86c-d6bd-47bd-9869-f192fa2a5c67
Client secret: bo72cMzHsoXcIU5sTIYIZzD0qlfSa6VYJf8J5KYk
Password grant client created successfully.
Client ID: 95a8e86c-deda-4010-9c94-9289acd404f6
Client secret: 6UzPDESm8pQ4o474cKh6MPFLLBK0LgfiB3rLjjSu
```
And then, update our `.env` file with the generated Personal Access Client ID and Secret.
```
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
```

##### Create Symlink for Storage Public Folder
```
php artisan storage:link
```

##### Run Our Project
Run command below to serve our project locally, we are going to use `port 8080`
```
php artisan serve --port=8080
```
Now we can access our project with url http://localhost:8080



## Testing Our API
To test our API, click button bellow : 

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/f3aad0d72d0be88279c1?action=collection%2Fimport#?env%5BNewsApp%5D=W3sia2V5IjoiYmFzZVVSTCIsInZhbHVlIjoiaHR0cDovL2xvY2FsaG9zdDo4MDAwIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJ0b2tlbiIsInZhbHVlIjoiIiwiZW5hYmxlZCI6dHJ1ZX1d)

##### or

If it's failed to run from the link above, you can import it manually via `Import From Link` tab in Import window :
```
Collection link :

https://www.getpostman.com/collections/f3aad0d72d0be88279c1
```

You can import the Postman Environment file in the project directory (`NewsApp.postman_environment.json`).

- - -
