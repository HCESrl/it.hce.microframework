//GULPFILE
var
    gulp = require('gulp'),
    requireDir = require('require-dir');

requireDir('./tasks');

gulp.task('default', [
    'build-svg-css',
    'build-images',
    'copy-audio',
    'copy-fonts',
    'copy-video'
]);