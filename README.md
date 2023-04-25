## Leaderboard

This is an API to manage user scores and provide a leaderboard. The API is built using Laravel and uses MySQL for data storage, Redis for caching and Nginx as the web server. It is dockerized for easy deployment.

## Requirements
- **Docker**
- **Docker Compose**


## Installation

1. Clone the repository:

`git clone https://github.com/saeedmzr/leaderboard.git`

2. Copy the .env.example file to .env:

`cp .env.example .env`

3. Modify the .env file with your desired environment variables.
4. Build and start the containers using Docker Compose:

`docker-compose up -d --build`

This will create and start the containers in the background.

5. Run migrations and seeders:

`docker-compose exec php php artisan migrate --seed`

6. Open your browser and navigate to `http://localhost:{APP_PORT}` to access the API.


## Endpoints


### Authentication
 All endpoints require authentication using Sanctum.

- **POST `/auth/login`: Login using email and password.**
- **GET `/auth/get`: Get authenticated user details.**
- **POST `/auth/logout`: Logout the authenticated user.**

### Scores
All endpoints require authentication using Sanctum.

- **POST `/score`: Store a score for the authenticated user.**
- **GET `/score/getTopList`: Get the top scores in the leaderboard.**
- **GET `/score/around`: Get the scores around the authenticated user.**
## Redis-based leaderboard functionality
This project uses Redis as the data store for the leaderboard functionality. Redis is a highly performant in-memory data store that allows for fast read and write operations. In this case, Redis is used to store the scores of users and their associated ranks.
For the reading endpoints that retrieve scores and rankings, the application does not connect to MySQL, which is the main database used for the project. Instead, the data is retrieved directly from Redis. This approach provides a significant speed improvement, as Redis is optimized for fast read operations.
As a result, the leaderboard functionality of this project can handle a high volume of requests with very low response times. For example, retrieving the top 100 rankings can be accomplished in 19-25 milliseconds, which is extremely fast.
