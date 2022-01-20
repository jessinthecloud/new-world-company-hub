const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                '1/4': '25%',
                '1/3': '33%',
                '1/2': '50%',
                '2/3': '66%',
                '3/4': '75%',
            },
            minWidth: {
                '1/4': '25%',
                '1/3': '33%',
                '1/2': '50%',
                '2/3': '66%',
                '3/4': '75%',
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                common: {
                    50:  '#eeeeed',
                    100: '#e5e5e3',
                    200: '#dcdcda',
                    300: '#cbcbc8',
                    400: '#b9b9b5',
                    500: '#A8A8A3', //'#575750',
                    600: '#989892',
                    700: '#777771',
                    800: '#444440',
                    900: '#222220',
                },
                uncommon: {
                    50:  '#bdeeb4',
                    100: '#a7e99b',
                    200: '#91e382',
                    300: '#7bde69',
                    400: '#4fd337',
                    500: '#39A825', //'#57A848',
                    600: '#2e861e',
                    700: '#226516',
                    800: '#17430f',
                    900: '#0b2207',
                },
                rare: {
                    50:  '#afdded',
                    100: '#94d2e8',
                    200: '#79c6e2',
                    300: '#5ebbdc',
                    400: '#2da3cd',
                    500: '#217897',
                    600: '#1a6079',
                    700: '#14485b',
                    800: '#0a242d',
                    900: '#07181e',
                },
                epic: {
                    50:  '#efb7ee',
                    100: '#ea9fe8',
                    200: '#e587e3',
                    300: '#df6fdd',
                    400: '#d53fd2',
                    500: '#B227AF', // '#B257B0',
                    600: '#a030a0', 
                    700: '#8e2a8e',
                    800: '#471547',
                    900: '#240b24',
                },
                legendary: {
                    50:  '#ffe5c3',
                    100: '#ffdcaf',
                    200: '#ffd49b',
                    300: '#ffcb87',
                    400: '#ffb95f',
                    500: '#FFA837',
                    600: '#ff9b18',
                    700: '#d97b00',
                    800: '#9b5800',
                    900: '#3e2300',
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
