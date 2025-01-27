/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./**/*.html.twig"],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                inter: ["Inter", "sans-serif"],
            },
        },
    },
    plugins: [],
}
