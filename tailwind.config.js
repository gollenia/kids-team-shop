module.exports = {
  purge: [
    './templates/**/*.twig',
    './resources/css/*.css'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors:{

        "primary": {
          contrast: "var(--primary-contrast)",
          transparent: "var(--primary-transparent)",
          contrastsoft: "var(--primary-soft-contrast)",
          lighter: "var(--primary-lighter)",
          DEFAULT: "var(--primary)",
          darker: "var(--primary-darker)",
        },
        "primary-light": {
          contrast: "var(--primary-light-contrast)",
          transparent: "var(--primary-light-transparent)",
          contrastsoft: "var(--primary-light-soft-contrast)",
          lighter: "var(--primary-light-lighter)",
          DEFAULT: "var(--primary-light)",
          darker: "var(--primary-light-darker)",
        },
        "primary-dark": {
          contrast: "var(--primary-dark-contrast)",
          transparent: "var(--primary-dark-transparent)",
          contrastsoft: "var(--primary-dark-soft-contrast)",
          lighter: "var(--primary-dark-lighter)",
          DEFAULT: "var(--primary-dark)",
          darker: "var(--primary-dark-darker)",
        },
        "darkgray": {
          contrast: "var(--darkgray-contrast)",
          transparent: "var(--darkgray-transparent)",
          contrastsoft: "var(--darkgray-soft-contrast)",
          lighter: "var(--darkgray-lighter)",
          DEFAULT: "var(--darkgray)",
          darker: "var(--darkgray-darker)",
        },
        "lightgray": {
          contrast: "var(--lightgray-contrast)",
          transparent: "var(--lightgray-transparent)",
          contrastsoft: "var(--lightgray-soft-contrast)",
          lighter: "var(--lightgray-lighter)",
          DEFAULT: "var(--lightgray)",
          darker: "var(--lightgray-darker)",
        },
        "mediumgray": {
          contrast: "var(--mediumgray-contrast)",
          transparent: "var(--mediumgray-transparent)",
          contrastsoft: "var(--mediumgray-soft-contrast)",
          lighter: "var(--mediumgray-lighter)",
          DEFAULT: "var(--mediumgray)",
          darker: "var(--mediumgray-darker)",
        }
      },
      fontFamily: {
        display: ['"Exo 2"', 'sans-serif'],
        body: ['"Exo 2"', 'sans-serif'],
        script: ['"Gochi Hand"', 'sans-serif'],
      }
    }
  },
  
  variants: {
    borderRadius: ['responsive', 'last', 'first', 'hover', 'focus'],
  },
  plugins: [],
}
