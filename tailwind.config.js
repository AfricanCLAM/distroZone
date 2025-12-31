import tailwindcss from '@tailwindcss/vite'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Work Sans"', 'sans-serif'],
            },
        },
    },

    plugins: ["@tailwindcss/postcss", tailwindcss()],
}; 1
