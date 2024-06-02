# API platform

API is built by Ainis Šitkauskas IKGfm-22 using Symfony 7.0, providing a protyte for handling user feedback report sending and goal setting functionalities.

## Installation

To set up the project locally, follow these steps:
1. **Install dependencies:**
   ```bash
   composer install
   ```
   ```bash
   npm install
   ```
2. **Set up the environment variables:**
   Modify the `.env` file with you configuration.

3. **Run the database migrations:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
4. **Start the server:**
   ```bash
   symfony serve

## Commands for feedback report

**Send users feedback**
   - **Description:** Sends users energy feedback reports
   - **Usage:**
     ```bash
     php bin/console app:send-user-feedback
     ```

## Commands for user goal setting

1. **Updates user goals**
   - **Description:** Updates users goals based on previuos day consumptions'
   - **Usage:**
     ```bash
     php bin/console app:update-user-goals
     ```

2. **Clear user goals**
   - **Description:** Clears user goals on status 'waiting'
   - **Usage:**
     ```bash
     php bin/console app:clear-user-goals
     ```
## Endpoints for goal setting functionality on mobile app

1. **Get user Goal**
   - **Method:** `GET`
   - **Path:** `/user-goals/{userId}`
   - **Description:** Retrieve last selected user goal.
   - **Example Request:**
     ```bash
     curl -X GET http://localhost:8000/user-goals/1
     ```

2. **Generate User Goals**
   - **Method:** `POST`
   - **Path:** `/user-goals/generate`
   - **Description:** Generates user new goals.
   - **Example Request:**
     ```bash
     curl -X POST http://localhost:8000/user-goals/generate -d '{"user_id":1}'
     ```

3. **Confirm User Goal**
   - **Method:** `POST`
   - **Path:** `/user-goals/confirm`
   - **Description:** Confirms user selected goal.
   - **Example Request:**
     ```bash
     curl -X POST http://localhost:8000/user-goals/confirm -d '{"user_id":1, "percentage":5}'
     ```
