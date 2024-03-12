const gulp = require('gulp');
const fancylog = require('fancy-log');
const browserSync = require('browser-sync');
const server = browserSync.create();
const minify = require('gulp-minify');
const dev_url = 'http://glt.local/';
const chokidar = require('chokidar');

/**
 * Define all source paths
 */
var paths = {
  styles: {
    src: './assets/*.scss',
    dest: './build',
  },
  script: {
    src: './assets/*.js',
    dest: './build',
  },
  scripts: {
    src: './assets/scripts/*.js',
    dest: './build/js',
  },
  theFold: {
    src: './assets/scripts/thefold/*.js',
    inc: './assets/scripts/thefold/src/*.js',
  },
  themeMain: {
    styles: {
      src: './themes/theme-main/assets/*.scss',
      dest: './themes/theme-main/build',
    },
    scripts: {
      src: './themes/theme-main/assets/scripts/*.js',
      dest: './themes/theme-main/build/js',
    },
  },
};

/**
 * Webpack compilation: http://webpack.js.org, https://github.com/shama/webpack-stream#usage-with-gulp-watch
 *
 * build_js()
 */
function build_js() {
  const compiler = require('webpack');
  const webpackStream = require('webpack-stream');

  return gulp
    .src(paths.script.src)
    .pipe(
      webpackStream(
        {
          config: require('./webpack.config.js'),
        },
        compiler
      )
    )
    .pipe(gulp.dest(paths.script.dest));
}

/**
 * SASS-CSS compilation: https://www.npmjs.com/package/gulp-sass
 *
 * build_css()
 */
function build_css() {
  const sass = require('gulp-sass')(require('sass'));
  const postcss = require('gulp-postcss');
  const sourcemaps = require('gulp-sourcemaps');
  const autoprefixer = require('autoprefixer');
  const cssnano = require('cssnano');

  const plugins = [autoprefixer(), cssnano()];

  return gulp
    .src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(
      sass().on('error', sass.logError)
    )
    .pipe(postcss(plugins))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.styles.dest));
}

/**
 * Watch task: Webpack + SASS
 *
 * $ gulp watch
 */
gulp.task('watch', function () {
  // Modify "dev_url" constant and uncomment "server.init()" to use browser sync
  server.init({
    proxy: dev_url,
  });

  gulp.watch([paths.script.src, paths.scripts.src, paths.theFold.src, paths.theFold.inc], build_js);
  gulp.watch([paths.styles.src, './assets/scss/*.scss'], build_css);
  gulp.watch([paths.themeMain.styles.src], build_theme_main_css);
  gulp.watch([paths.themeMain.scripts.src], build_theme_main_js);
});

function build_theme_main_css() {
  const sass = require('gulp-sass')(require('sass'));
  const postcss = require('gulp-postcss');
  const sourcemaps = require('gulp-sourcemaps');
  const autoprefixer = require('autoprefixer');
  const cssnano = require('cssnano');

  const plugins = [autoprefixer(), cssnano()];

  return gulp
    .src(paths.themeMain.styles.src)
    .pipe(sourcemaps.init())
    .pipe(
      sass().on('error', sass.logError)
    )
    .pipe(postcss(plugins))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.themeMain.styles.dest));
}

function build_theme_main_js() {
  const compiler = require('webpack');
  const webpackStream = require('webpack-stream');

  return gulp
    .src(paths.themeMain.scripts.src)
    .pipe(webpackStream({
      config: require('./webpack.config.js'),
    }, compiler))
    .pipe(gulp.dest(paths.themeMain.scripts.dest));
}
