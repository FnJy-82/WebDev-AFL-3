/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php'
  ],
  theme: {
    extend: {
        fontFamily: {
            // This adds back your custom font from the old setup
            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif']
        }
    },
  },
  plugins: [
    require('@tailwindcss/forms'), // You already have this in your package.json
  ],
}
