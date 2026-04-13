/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
        colors: {
        'dark-choco': '#443025',
        'aloewood': '#7F5836',
        'milk-tea': '#AA7F66',
        'sakura': '#EC9C9D',
        'misty-rose': '#F2CF2A', // Pastikan hex ini sesuai dengan gambarmu
        }
    }
    },
    plugins: [
        require("flowbite/plugin"),
    ],
}

