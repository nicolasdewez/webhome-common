var gulp = require('gulp'),
    tasks = require('gulp-load-plugins')(),
    concat = require('gulp-concat'),
    rimraf = require('rimraf'),
    srcPath = 'Resources/public/',
    jsPath = srcPath + 'scripts/',
    jsFile = jsPath + '*',
    distPath = jsPath + 'dist/';

gulp.task('clean', function(callback) {
    rimraf.sync(distJsPath);

    callback();
});

gulp.task('js', function() {
    gulp.src([jsFile])
        .pipe(concat('common.js'))
        .pipe(tasks.plumber('common.js'))
        .pipe(gulp.dest(distPath));
});

gulp.task('livereload', function() {
    tasks.livereload.listen();

    gulp.watch(jsPath + '**/*.js', ['js']);
});

gulp.task('default', ['clean', 'js', 'livereload']);
