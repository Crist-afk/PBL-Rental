/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      colors: {
        'dark-chocolate': '#443025',
        'sakura': '#EC9C9D',
        'misty-rose': '#FFE4E1',
        'aloewood': '#8B5A2B',
        'milk-tea': '#D2B48C',
      }
    },
  },
  plugins: [
      require('flowbite/plugin')
  ],
}
