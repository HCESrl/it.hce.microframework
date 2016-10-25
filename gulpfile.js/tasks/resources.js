var gulp = require('gulp');

gulp.task('copy-audio', function () {
  gulp.src("resources/audio/**")
    .pipe(gulp.dest('public/audio'))
    .pipe(gulp.dest('static/audio'));
});

gulp.task('copy-fonts', function () {
  gulp.src("resources/fonts/**")
    .pipe(gulp.dest('public/fonts'))
    .pipe(gulp.dest('static/fonts'));
});

gulp.task('copy-video', function () {
  gulp.src("resources/video/**")
    .pipe(gulp.dest('public/video'))
    .pipe(gulp.dest('static/video'));
});