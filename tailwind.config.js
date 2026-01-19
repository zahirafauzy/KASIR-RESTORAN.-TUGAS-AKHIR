import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
module.exports = {
content: [
'./resources/views/**/*.blade.php',
'./resources/js/**/*.js',
'./node_modules/flowbite/**/*.js'
],
theme: {
extend: {},
},
plugins: [require('flowbite/plugin')],
};
