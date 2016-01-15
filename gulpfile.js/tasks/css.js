var gulp        = require('gulp');
var gm          = require('gulp-gm');
var inlineSvg   = require("gulp-inline-svg");
var svgMin      = require('gulp-svgmin');

gulp.task('build-svg-css', function () {
    return gulp.src(['resources/svg/*.svg'])
        .pipe(svgMin())
        .pipe(inlineSvg({
            filename: '_iconsFactory.scss',
            template: 'resources/svg/template.mustache'
        }))
        .pipe(gulp.dest('public/css'));
});