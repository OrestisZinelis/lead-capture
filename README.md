# Lead Capture Modal Project

## Project Overview

This project is designed to capture leads through a modal interface and manage them using a table with inline edit support. Changes to the leads are synchronized with Mailchimp to ensure seamless integration with email marketing campaigns.


📷

![Screenshot 2025-02-14 at 2 38 45 PM](https://github.com/user-attachments/assets/a1a49aaa-d912-46f3-8f16-a452081aba79)

![Screenshot 2025-02-14 at 2 36 58 PM](https://github.com/user-attachments/assets/b76b662d-f84d-4273-8fac-80d89fbb10ab)

https://github.com/user-attachments/assets/429c6c39-4eaf-45c3-9f51-26ef7a500ca9



## Tech Stack

The following technologies were used in the development of this project:

-   Vue 3 (with TypeScript support)
-   TailwindCSS
-   Vite
-   Laravel 11
-   spatie/laravel-newsletter
-   drewm/mailchimp-api

## Environment Setup

To run this project, you will need to set up your environment variables. Create a `.env` file in the root of your project and update it with your MongoDB and Mailchimp credentials.

For MongoDB:

-   `DB_CONNECTION`
-   `DB_HOST`
-   `DB_PORT`
-   `DB_DATABASE`
-   `DB_USERNAME`
-   `DB_PASSWORD`

For Mailchimp:

-   `NEWSLETTER_API_KEY`
-   `NEWSLETTER_LIST_ID`

## How to Use

-   Navigate to the root URL `/` to display the Subscribe Modal. A button is also provided to open/close the modal.

-   The `/management` URL displays the Leads Management Table with inline editing support.

## Running the Project

Install dependencies

`npm install` or `yarn`

To run the project with asset compilation:

`npm run dev` or `yarn dev`

To start the Laravel development server:

`php artisan serve`

Or to run both the asset compilation and the Laravel server with a single command

`npm run start` or `yarn start`

## Future Enhancements

For a real-world application, the following enhancements could be considered:

-   Implementing a robust table component like Vue Table (from tanstack) with pagination.
-   Adding infinite scroll functionality.
-   Creating an action toolbar with features such as search, sort, bulk actions, and filters.
-   Integrating a UI library (e.g., naive-ui) for improved components like toast notifications, modals, buttons, selects, and theming support.
-   Including confirmation dialogs for critical actions, such as deletions.
