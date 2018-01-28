var gulp        = require('gulp');
var jshint      = require('gulp-jshint');
var clean       = require('gulp-clean');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglify');
var htmlmin     = require('gulp-htmlmin');
var sass        = require('gulp-sass');
var cleanCSS    = require('gulp-clean-css');
var livereload  = require('gulp-livereload');
var runSequence = require('run-sequence');
var pump        = require('pump');

/* Utils */
//var es     = require('event-stream');
//var rename = require('gulp-rename');

gulp.task('clean', function () {
    return gulp.src('public/').pipe(clean());
});

gulp.task('lint', function (cb) {
    pump([
            gulp.src('assets/js/**/*.js'),
            jshint(),
            jshint.reporter('default')
        ],
        cb
    );
});

gulp.task('compress', function (cb) {
    pump([
            gulp.src('assets/js/**/*.js'),
            concat('scripts.js'),
            uglify(),
            concat('all.min.js'),
            gulp.dest('public/js'),
            livereload()
        ],
        cb
    );
});

gulp.task('htmlmin', function (cb) {
    pump([
            gulp.src('assets/views/**/*.html'),
            htmlmin({collapseWhitespace: true}),
            gulp.dest('public/views'),
            livereload()
        ],
        cb
    );
});

gulp.task('sass', function (cb) {
    pump([
            gulp.src('assets/sass/**/*.scss'),
            sass().on('error', sass.logError),
            gulp.dest('assets/css')
        ],
        cb
    );
});

gulp.task('cssmin', function (cb) {
    pump([
            gulp.src(['assets/css/**/*.css']),
            cleanCSS(),
            concat('styles.css'),
            gulp.dest('public/css'),
            livereload()
        ],
        cb
    );
});

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('assets/views/*.html', ['htmlmin']);
    gulp.watch('assets/views/**/*.html', ['htmlmin']);
    gulp.watch('assets/js/**/*.js', ['compress']);
    gulp.watch('assets/sass/**/*.scss', ['sass']);
    gulp.watch('assets/css/**/*.css', ['cssmin']);
});

gulp.task('default', function (cb) {
    return runSequence('clean', ['lint', 'compress', 'htmlmin', 'sass', 'cssmin', 'watch'], cb)
});
