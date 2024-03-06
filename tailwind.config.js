/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: 'jit', // activates Just-in-Time mode
  prefix: 'tw-', // adds 'tw-' prefix to the classes
  content: [
      './**/*.php',
      './src/**/*.{vue,js,ts,jsx,tsx}'
  ], // update this path if needed, include *.php
  media: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}