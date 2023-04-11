/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["content/**/*.md", "layouts/**/*.html"],
  theme: {
    extend: {
      colors: {
        'beige': {
          light: '#f5eadd',
          DEFAULT: '#f3e5d5',
          dark: '#dacebf',
        },
        'mint': {
          light: '#91d0cc',
          DEFAULT: '#91d0cc',
          dark: '#91d0cc',
        },
        'primary': {
          light: '#5e4741',
          DEFAULT: '#361a12',
          dark: '#2b140e',
        },
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    // require("daisyui"),
  ],
}
