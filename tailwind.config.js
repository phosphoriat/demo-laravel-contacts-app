/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/js/src/pages/**/*.vue",
    "./resources/js/src/components/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

