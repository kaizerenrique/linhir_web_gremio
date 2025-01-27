import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'malachite': '#49df62',
                'deep_fir' : '#052e0e',

                'pink_salmon' : '#ff9aad',
                'maroon_oak' : '#4c0311',

                'turquoise': '#2bd6be',
                'deep_teal' : '#042f2d',
                
                'lavender_pink' : '#eeb3d6',
                'toledo' : '#461129',
            },
        },
    },

    plugins: [forms, typography],
};
