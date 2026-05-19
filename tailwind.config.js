export default {
    content: [
        './resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/js/**/*.js',
    ],

    safelist: [
        'bg-blue-600',
        'bg-yellow-500',
        'bg-green-600',
        'bg-purple-600',
        'bg-red-600',
        'bg-indigo-600',
        'hover:bg-green-700',
        'hover:bg-purple-700',
        'hover:bg-indigo-700',
        'text-green-600',
        'text-red-500',
        'text-yellow-500',
    ],

    theme: {
        extend: {},
    },

    plugins: [],
};