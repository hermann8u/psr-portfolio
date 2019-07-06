const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        container: {
            center: true,
            padding: '1.5rem',
        },
        fontFamily: {
            'sans': ['Montserrat', ...defaultTheme.fontFamily.sans]
        },
        extend: {
            colors: {
                'gray-800-trans': 'rgba(45, 55, 72, 0.8)'
            }
        }
    }
}
