/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/templates/**/*.php",
        "./public/resources/**/*.{vue,js}"
    ],
    theme: {
        extend: {
            container: {
                center: true,
              },
        },
    },
    plugins: [],
}

