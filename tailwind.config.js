module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.ts.php',
    './node_modules/flowbite/**/*.js'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
