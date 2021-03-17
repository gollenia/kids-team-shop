const colors = require('tailwindcss/colors');

module.exports = {
  purge: [
    './templates/**/*.twig',
    './resources/vue/**/*.vue',
    './public/css/*.css',
    '../../plugins/bibleverse/syntax.php',
    './resources/css/*.css'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
      colors: {
        "primary": {
          contrast: "var(--primary-contrast)",
          transparent: "var(--primary-transparent)",
          contrastsoft: "var(--primary-soft-contrast)",
          lighter: "var(--primary-lighter)",
          DEFAULT: "var(--primary)",
          darker: "var(--primary-darker)",
        },
        "secondary": {
          contrast: "var(--secondary-contrast)",
          transparent: "var(--secondary-transparent)",
          contrastsoft: "var(--secondary-soft-contrast)",
          lighter: "var(--secondary-lighter)",
          DEFAULT: "var(--secondary)",
          darker: "var(--secondary-darker)",
        },
        transparent: 'transparent',
        current: 'currentColor',
        black: colors.black,
        white: colors.white,
        gray: colors.trueGray,
        blue: colors.blue,
        red: colors.rose,
        yellow: colors.amber,
        green: colors.green,
      },
      fontFamily: {
        display: ['"Exo 2"', 'sans-serif'],
        body: ['"Exo 2"', 'sans-serif'],
        script: ['"Gochi Hand"', 'sans-serif'],
      },
  },
  
  variants: {

      borderRadius: ['responsive', 'last', 'first', 'hover', 'focus'],
    
  },
  plugins: [],
  corePlugins: {
   gradientColorStops: false,
   divideOpacity: false,
   divideColor: false,
   divide: false,
   ringWidth: false,
   ringColor: false,
   ringOpacity: false,
   ringOffsetWidth: false,
   ringOffsetColor: false
  }
}
