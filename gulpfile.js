var gulp        = require('gulp');
var jshint      = require('gulp-jshint');
var clean       = require('gulp-clean');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglify');
var es          = require('event-stream');
var htmlmin     = require('gulp-htmlmin');
var sass        = require('gulp-sass');
var cleanCSS    = require('gulp-clean-css');
var livereload  = require('gulp-livereload');
var runSequence = require('run-sequence');
var rename      = require('gulp-rename');

gulp.task('clean', function ()
{
    return gulp.src('public/')
        .pipe(clean());
});

gulp.task('jshint', function ()
{
    return gulp.src('assets/js/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('uglify', function ()
{
    return es.merge([
        gulp.src(['assets/js/**/*.js']).pipe(concat('scripts.js')).pipe(uglify())
    ])
        .pipe(concat('all.min.js'))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload());
});

gulp.task('htmlmin', function ()
{
    return gulp.src('assets/views/**/*.html')
        .pipe(htmlmin({collapseWhitespace: true}))
        .pipe(gulp.dest('public/views'))
        .pipe(livereload());
});

gulp.task('sass', function ()
{
    return gulp.src('assets/sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('cssmin', function ()
{
    return gulp.src(['assets/css/**/*.css'])
        .pipe(cleanCSS())
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload());
});

gulp.task('watch', function ()
{
    livereload.listen();
    gulp.watch('assets/views/*.html', ['htmlmin']);
    gulp.watch('assets/views/**/*.html', ['htmlmin']);
    gulp.watch('assets/js/**/*.js', ['uglify']);
    gulp.watch('assets/sass/**/*.scss', ['sass']);
    gulp.watch('assets/css/**/*.css', ['cssmin']);
});

gulp.task('default', function (cb)
{
    return runSequence('clean', ['jshint', 'uglify', 'htmlmin', 'sass', 'cssmin', 'watch'], cb)
});
