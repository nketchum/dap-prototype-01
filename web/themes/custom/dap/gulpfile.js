'use strict';

var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-cssmin');
var importer = require('node-sass-globbing');
var livereload = require('gulp-livereload')
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var stripCssComments = require('gulp-strip-css-comments');

var sass_config = {
  importer: importer,
  includePaths: [
    'node_modules/breakpoint-sass/stylesheets/',
    'node_modules/singularitygs/stylesheets/',
    'node_modules/modularscale-sass/stylesheets',
    'node_modules/compass-mixins/lib/'
  ]
};

// Compiles sass
gulp.task('sass', function () {
  return gulp.src('./scss/**/*.scss')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass(sass_config).on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 version']
    }))
    .pipe(stripCssComments({preserve: false}))
    // .pipe(cssmin())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./css'));
});

// Type "gulp" in the cli to watch
gulp.task('default', function(){
  livereload.listen();
    gulp.watch('./scss/**/*.scss', ['sass']);
    gulp.watch(['./css/style.css'], function (files){
      livereload.changed(files)
    });
});
