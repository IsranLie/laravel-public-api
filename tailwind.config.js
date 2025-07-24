export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                figtree: ['"Figtree"', "sans-serif"],
            },
            colors: {
                // #e21212
                "custom-red-50": "#fff1f1",
                "custom-red-100": "#ffdfdf",
                "custom-red-200": "#ffc5c5",
                "custom-red-300": "#ff9d9d",
                "custom-red-400": "#ff6565",
                "custom-red-500": "#fe3535",
                "custom-red-600": "#e21212",
                "custom-red-700": "#c70e0e",
                "custom-red-800": "#a41010",
                "custom-red-900": "#881414",
                "custom-red-950": "#4a0505",
            },
        },
    },
    plugins: [],
};
