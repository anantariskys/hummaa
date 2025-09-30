import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-main-bg',
        'bg-main-bg/40',
        'bg-main-bg/50',
        'bg-main-bg/90',
        'bg-white',
        'border-main-bg',
        'text-main-bg',
        'bg-green-100',
        'border-green-500',
        'text-gray-800',
        'bg-red-100',
        'border-red-500',
        'text-red-800',
        'border-ujian-gray-200'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'main-bg': '#2C7A7B', // Main background
                'card-diff-bg': '#bbd4d5',
                'sidebar-active': '#d5e4e5',
                'main-blue-button': '#1976d2', // Main Button
                'ujian-green-border': '#2C7A7B', // Border jawaban terpilih
                'sblack':'#232323',
                'orange':'#F485A4',
                'ujian-gray': {
                    100: '#F3F4F6', 
                    200: '#E5E7EB', 
                    500: '#6B7280', 
                    700: '#374151', 
                }
              }
        },
    },

    plugins: [forms],
};