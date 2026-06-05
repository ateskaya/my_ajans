import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                enterprise: {
                    bg: '#020617',
                    surface: '#09090b',
                    elevated: '#0f172a',
                    muted: '#18181b',
                    border: '#27272a',
                    'border-light': '#3f3f46',
                },
                accent: {
                    DEFAULT: '#22d3ee',
                    bright: '#06b6d4',
                    neon: '#38bdf8',
                    glow: '#0ea5e9',
                    muted: '#164e63',
                },
            },
            boxShadow: {
                'accent-glow': '0 0 20px rgba(34, 211, 238, 0.25)',
                'accent-glow-lg': '0 0 40px rgba(34, 211, 238, 0.35)',
            },
            backgroundImage: {
                'enterprise-gradient':
                    'linear-gradient(135deg, #020617 0%, #09090b 50%, #0f172a 100%)',
                'accent-gradient':
                    'linear-gradient(135deg, #06b6d4 0%, #22d3ee 50%, #38bdf8 100%)',
            },
        },
    },

    plugins: [forms],
};
