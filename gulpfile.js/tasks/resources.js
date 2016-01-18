var gulp = require('gulp');

gulp.task('copy-audio', function () {
    gulp.src("resources/audio/**")
        .pipe(gulp.dest('public/audio'));
});

gulp.task('copy-fonts', function () {
    gulp.src("resources/fonts/**")
        .pipe(gulp.dest('public/fonts'));
});

gulp.task('copy-video', function () {
    gulp.src("resources/video/**")
        .pipe(gulp.dest('public/video'));
});