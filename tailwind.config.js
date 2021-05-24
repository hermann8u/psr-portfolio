const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './templates/**/*.twig',
        './assets/**/*.js',
    ],
    darkMode: false,
    theme: {
        container: {
            center: true,
            padding: '1.5rem',
        },
        extend: {
            colors: {
                'gray-800-trans': 'rgba(45, 55, 72, 0.8)'
            },
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans]
            },
        }
    },
    variants: {
        extend: {},
    },
}
