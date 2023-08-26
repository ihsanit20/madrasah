const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                "noto-sans-bengali": '"Noto Sans Bengali", "Scheherazade New"',
                "noto-serif-bengali": '"Noto Serif Bengali", "Scheherazade New"',
            },
            animation: {
                "marquee-40": 'marquee 40s linear infinite',
                "marquee-20": 'marquee 20s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': { transform: 'translateX(100%)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
            colors: {
                'brand': {
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b',
                    950: '#022c22',
                },
            },
        },
    },

    plugins: [
        typography,
        forms
    ],
};