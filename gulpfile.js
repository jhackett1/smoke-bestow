var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

var sassDir = "./sass/";
var cssDir = "./css/";


// Compile sass
gulp.task('sass', function(){
  gulp.src(sassDir+"**/*.sass")
    .pipe(sass({}))
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(gulp.dest(cssDir))
})

// MAIN WATCH TASK
gulp.task('default', ['sass'], function() {
  // When a sass or js file is changed, compile it
  gulp.watch(sassDir+"**/*.sass", ['sass']);
});
