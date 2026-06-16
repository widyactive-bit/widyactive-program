/**
 * Tailwind CSS configuration for Widyactive project.
 * Includes a dark glassmorphism palette and custom font settings.
 */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/**/*.ts',
    './resources/**/*.jsx',
    './resources/**/*.tsx',
    './resources/**/*.css',
    './resources/**/*.php',
    './resources/**/*.html',
    './resources/**/*.scss',
    './resources/**/*.sass',
    './resources/**/*.less',
    './resources/**/*.ts',
    './resources/**/*.svelte',
    './resources/**/*.twig',
    './resources/**/*.md',
    './resources/**/*.mdx',
    './resources/**/*.astro',
    './resources/**/*.liquid',
    './resources/**/*.pug',
    './resources/**/*.ejs',
    './resources/**/*.hbs',
    './resources/**/*.haml',
    './resources/**/*.jade'
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0d1117', // dark background
        accent: '#1f6feb', // vibrant accent
        glass: 'rgba(255,255,255,0.12)',
        'glass-border': 'rgba(255,255,255,0.1)',
      },
      fontFamily: {
        sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif']
      },
      backdropBlur: {
        xs: '4px'
      }
    }
  },
  plugins: [],
};
