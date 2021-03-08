module.exports = {
  purge: [
    './templates/**/*.twig',
    './resources/css/*.css',
    './public/css/*.css',
    '../../plugins/bibleverse/syntax.php'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
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
        }
      },
      fontFamily: {
        display: ['"Exo 2"', 'sans-serif'],
        body: ['"Exo 2"', 'sans-serif'],
        script: ['"Gochi Hand"', 'sans-serif'],
      },
      
    }
  },
  
  variants: {
    extend: {
      borderRadius: ['responsive', 'last', 'first', 'hover', 'focus'],
      backgroundColor: ['checked'],
      borderColor: ['checked']
    }
  },
  plugins: [],
}
