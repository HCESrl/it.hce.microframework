var
    gulp = require('gulp'),
    gm = require('gulp-gm'),
    config = require('../../config/environment.json');

gulp.task('build-images', function () {
    var resolutions = config.imagesResolutions;
    var quality = config.imagesQuality;

    resolutions.forEach(function (resolution) {
        //Remember to install: apt-get install graphicsmagick
        //For API doc: http://aheckmann.github.io/gm/docs.html
        gulp.src(['resources/images/scalable/**/*.png', 'resources/images/scalable/**/*.jpg'])
            .pipe(gm(function (gmfile) {
                if (config.dev) {
                    return gmfile.fill("#ffffff")
                        .fontSize(resolution / 20)
                        .drawText(resolution / 20, 0, resolution.toString().replace(/(.)/g, "$1\n"), 'East')
                        .quality(quality)
                        .resize(resolution);
                }
                return gmfile.quality(quality)
                    .resize(resolution);
            }))
            .pipe(gulp.dest(function (file) {
                var pathArray = file.path.replace(file.base, '').split('/');
                var type = pathArray[0];
                file.path = file.path.replace(type + '/', '');

                return 'public/images/' + type + '/' + resolution + '/';
            }));
    });

    gulp.src(['resources/images/scalable/**/*.png', 'resources/images/scalable/**/*.jpg'], {
            base: 'resources/images/scalable/'
        })
        .pipe(gulp.dest('public/images'));

    gulp.src(['resources/images/static/**/*.png', 'resources/images/static/**/*.jpg'], {
            base: 'resources/images/static/'
        })
        .pipe(gulp.dest('public/images'));
});