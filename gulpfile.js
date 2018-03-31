var gulp        = require('gulp');
var jshint      = require('gulp-jshint');
var clean       = require('gulp-clean');
var concat      = require('gulp-concat');
var uglify      = require('gulp-uglify');
var htmlmin     = require('gulp-htmlmin');
var imagemin    = require('gulp-imagemin');
var sass        = require('gulp-sass');
var cleanCSS    = require('gulp-clean-css');
var livereload  = require('gulp-livereload');
var runSequence = require('run-sequence');
var pump        = require('pump');

/* Utils */
//var es     = require('event-stream');
//var rename = require('gulp-rename');

gulp.task('clean', function (cb) {
    pump([
            gulp.src('public/'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-css', function (cb) {
    pump([
            gulp.src('public/css/*'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-images', function (cb) {
    pump([
            gulp.src('public/images/*'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-js', function (cb) {
    pump([
            gulp.src('public/js/*'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-views', function (cb) {
    pump([
            gulp.src('public/views/*'),
            clean()
        ],
        cb
    );
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

gulp.task('imagemin', function (cb) {
    pump([
            gulp.src('assets/images/**/*'),
            imagemin(),
            gulp.dest('public/images'),
            livereload()
        ],
        cb
    );
});

gulp.task('sass', function (cb) {
    pump([
            gulp.src('assets/sass/styles.scss'),
            sass().on('error', sass.logError),
            gulp.dest('assets/css')
        ],
        cb
    );
});

gulp.task('cssmin', function (cb) {
    pump([
            gulp.src(['assets/css/styles.css']),
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
    gulp.watch('assets/views/*.html', ['htmlmin'/*,'clean-views'*/]);
    gulp.watch('assets/views/**/*.html', ['htmlmin'/*,'clean-views'*/]);
    gulp.watch('assets/images/**/*', ['imagemin'/*,'clean-image'*/]);
    gulp.watch('assets/js/**/*.js', ['compress'/*,'clean-js'*/]);
    gulp.watch('assets/sass/**/*.scss', ['sass']);
    gulp.watch('assets/css/**/*.css', ['cssmin'/*,'clean-css'*/]);
});

gulp.task('default', function (cb) {
    return runSequence('clean', ['lint', 'compress', 'htmlmin', 'imagemin', 'sass', 'cssmin', 'watch'], cb)
});