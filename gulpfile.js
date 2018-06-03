'use strict';

let gulp        = require('gulp');
let jshint      = require('gulp-jshint');
let clean       = require('gulp-clean');
let concat      = require('gulp-concat');
let babel       = require('gulp-babel');
let uglify      = require('gulp-uglify');
let htmlmin     = require('gulp-htmlmin');
let imagemin    = require('gulp-imagemin');
let sass        = require('gulp-sass');
let cleanCSS    = require('gulp-clean-css');
let livereload  = require('gulp-livereload');
let runSequence = require('run-sequence');
let pump        = require('pump');
let sourcemaps  = require('gulp-sourcemaps');

livereload({start: true});

gulp.task('clean', function (cb) {
    pump([
            gulp.src('public/'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-public-css', function (cb) {
    pump([
            gulp.src('public/css/*'),
            clean()
        ],
        cb
    );
});

gulp.task('clean-assets-css', function (cb) {
    pump([
            gulp.src('assets/css/*'),
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
            jshint({esversion: '6'}),
            jshint.reporter('default')
        ],
        cb
    );
});

gulp.task('compress', function (cb) {
    pump([
            gulp.src('assets/js/*.js'),
            //sourcemaps.init(),
            //concat('scripts.js'),
            babel({presets: ['env'], plugins: ['transform-runtime']}),
            uglify(),
            //sourcemaps.write('../maps'),
            //concat('all.min.js'),
            gulp.dest('public/js'),
            livereload()
        ],
        cb
    );
});

gulp.task('compress-includes', function (cb) {
    pump([
            gulp.src('assets/js/includes/*.js'),
            //sourcemaps.init(),
            concat('main.js'),
            babel({presets: ['env'], plugins: ['transform-runtime']}),
            uglify(),
            //sourcemaps.write('../maps'),
            concat('main.min.js'),
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
            gulp.src('assets/sass/*.scss'),
            sass.sync().on('error', sass.logError),
            gulp.dest('assets/css'),
            gulp.src(['assets/css/*.css']),
            cleanCSS(),
            gulp.dest('public/css'),
            livereload()
        ],
        cb
    );
});

gulp.task('watch', function () {
    livereload.listen();
    //connect.listen();

    gulp.watch('assets/views/*.html', ['htmlmin']);
    gulp.watch('assets/views/**/*.html', ['htmlmin']);
    gulp.watch('assets/images/**/*', ['imagemin']);
    gulp.watch('assets/js/*.js', ['compress']);
    gulp.watch('assets/js/includes/*.js', ['compress-includes']);
    gulp.watch('assets/sass/*.scss', ['sass', 'htmlmin']);
    gulp.watch('assets/sass/**/*.scss', ['sass', 'htmlmin']);
    gulp.watch('assets/sass/beauty/**/*.scss', ['sass', 'htmlmin']);
});

gulp.task('default', function (cb) {
    return runSequence('clean', ['lint', 'compress', 'compress-includes', 'htmlmin', 'imagemin', 'sass', 'watch'], cb)
});