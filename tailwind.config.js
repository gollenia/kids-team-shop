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
        "red": {
          contrast: "var(--red-contrast)",
          transparent: "var(--red-transparent)",
          contrastsoft: "var(--red-soft-contrast)",
          lighter: "var(--red-lighter)",
          DEFAULT: "var(--red)",
          darker: "var(--red-darker)",
        },
        "green": {
          contrast: "var(--green-contrast)",
          transparent: "var(--green-transparent)",
          contrastsoft: "var(--green-soft-contrast)",
          lighter: "var(--green-lighter)",
          DEFAULT: "var(--green)",
          darker: "var(--green-darker)",
        },
        "blue": {
          contrast: "var(--blue-contrast)",
          transparent: "var(--blue-transparent)",
          contrastsoft: "var(--blue-soft-contrast)",
          lighter: "var(--blue-lighter)",
          DEFAULT: "var(--blue)",
          darker: "var(--blue-darker)",
        },
        "orange": {
          contrast: "var(--orange-contrast)",
          transparent: "var(--orange-transparent)",
          contrastsoft: "var(--orange-soft-contrast)",
          lighter: "var(--orange-lighter)",
          DEFAULT: "var(--orange)",
          darker: "var(--orange-darker)",
        },
        "purple": {
          contrast: "var(--purple-contrast)",
          transparent: "var(--purple-transparent)",
          contrastsoft: "var(--purple-soft-contrast)",
          lighter: "var(--purple-lighter)",
          DEFAULT: "var(--purple)",
          darker: "var(--purple-darker)",
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
        "gray": {
          contrast: "var(--gray-contrast)",
          transparent: "var(--gray-transparent)",
          contrastsoft: "var(--gray-soft-contrast)",
          lighter: "var(--gray-lighter)",
          DEFAULT: "var(--gray)",
          darker: "var(--gray-darker)",
        }
      },
      fontFamily: {
        display: ['"Exo 2"', 'sans-serif'],
        body: ['"Exo 2"', 'sans-serif'],
        script: ['"Gochi Hand"', 'sans-serif'],
      },
      borderRadius: {
        'none': '0',
         'sm': '5px',
         DEFAULT: '0.25rem',
         DEFAULT: '10px',
         'md': '20px',
         'lg': '50px',
         'full': '9999px',
         'large': '12px',
      }
    }
  },
  
  variants: {
    borderRadius: ['responsive', 'last', 'first', 'hover', 'focus'],
  },
  plugins: [],
}
