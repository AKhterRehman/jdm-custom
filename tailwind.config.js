import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Lexend', ...defaultTheme.fontFamily.sans],
                display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                lux: ['"Bodoni Moda"', 'Didot', 'Georgia', 'serif'],
                label: ['Jost', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: {
                    DEFAULT: '#0b0b0d',
                    900: '#0b0b0d',
                    800: '#141417',
                    700: '#1c1c20',
                    600: '#26262b',
                },
                charcoal: {
                    DEFAULT: '#1a1a1d',
                    900: '#101012',
                    800: '#17171a',
                    700: '#202024',
                    600: '#2b2b30',
                },
                gold: {
                    200: '#ecdcb8',
                    300: '#e0c993',
                    400: '#d1b370',
                    500: '#c0a062',
                    600: '#9a7b3f',
                    700: '#7a6030',
                },
                silver: {
                    300: '#d4d7dc',
                    400: '#b4b8bf',
                    500: '#8f949c',
                },
            },
        },
    },

    plugins: [forms],
};
