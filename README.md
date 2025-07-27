<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Laravel Using Public API

### 🔥LarApi

Simple website to use public api on laravel

> give a star if you like it, cheers

#### Features

-   Create, Update, Delete, Search, and Filter
-   Pagination
-   Preloader
-   Bookmark Post (local storage)
-   Theme Switch (Dark/Light)

#### Menus

-   Home
-   Post Lists
-   Post Detail
-   Post Create/Update
-   User Lists
-   User Profile
-   User Create/Update

### Setup Instructions

To get a local copy of the code, clone it using git:

```
git clone https://github.com/IsranLie/laravel-public-api.git
cd laravel-public-api
```

Install composer depedencies:

```
composer install
```

Copy .env file:

```
cp .env.example .env
```

App key:

```
php artisan key:generate
```

Install node depedecies:

```
npm install
```

Inside the package.json file there is a starting script (concurrently) written to run `npm run dev & php artisan` serve simultaneously so you can simply run the following command:

```
npm run start
```

The website will run on the laravel server `http://127.0.0.1:8000/`

### Technologies Used

-   [Laravel v10.x](https://laravel.com/): free and open-source PHP-based web framework for building web applications.
-   [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript): often abbreviated as JS, is a programming language and core technology of the World Wide Web, alongside HTML and CSS.
-   [Tailwind CSS v3.x](https://tailwindcss.com/): a utility-first CSS framework that provides a set of predefined CSS classes.
-   [Remix Icons](https://remixicon.com/): open-source neutral-style system symbols elaborately crafted for designers and developers.
-   [JSONPlaceholder API](https://jsonplaceholder.typicode.com/): free fake and reliable API for testing and prototyping.
-   [Lorem Picsum](https://picsum.photos/): image url for testing.

### Browser Support

This project designed with the latest web browsers in mind. Recommended that you use the latest version of one of the following browsers.

-   Apple Safari
-   Google Chrome
-   Microsoft Edge
-   Mozilla Firefox

### Screen Capture

##### Desktop View:

<img width="1300" height="1460" alt="screencapture-127-0-0-1-8000-2025-07-26-17_01_58" src="https://github.com/user-attachments/assets/9be76373-b245-4a5c-b167-c89a06cb6299" />

##### Mobile View:

<img width="313" height="594" alt="image" src="https://github.com/user-attachments/assets/3d596e75-b2f7-42b1-8917-3f5aec8e47c4" />

##### Demo Video

https://github.com/user-attachments/assets/f02c4f9e-c849-486a-bc3d-3ac261a1d850
