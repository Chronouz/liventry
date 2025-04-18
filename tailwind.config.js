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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto', 'sans-serif'], // Tambahan font Roboto
            },
            colors: {
                lightblue: '#AEEEEE',
                cream: '#FFF5E4',
                lightpink: '#FFD6E8',
                lavender: '#E6E6FA',
                neutralgray: '#F0F0F0',
                diaroBlue: '#2563EB',
                diaroDark: '#1E3A8A',
            },
        },
    },
    plugins: [forms],
};

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
    ],
    theme: {
      extend: {
        colors: {
          lightblue: '#AEEEEE',
          cream: '#FFF5E4',
          lightpink: '#FFD6E8',
          lavender: '#E6E6FA',
          neutralgray: '#F0F0F0',
          sidebarblue: '#2563EB',
          diaroBlue: '#2563EB',
          diaroDark: '#1E3A8A',
        },
        fontFamily: {
          roboto: ['Roboto', 'sans-serif'],
        }
      },
    },
    plugins: [],
  }