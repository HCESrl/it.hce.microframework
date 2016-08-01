var
    gulp = require('gulp'),
    gm = require('gulp-gm'),
    config = require('../../config/environment.json');

gulp.task('build-images', function () {
    var resolutions = config.imagesResolutions;
    var quality = config.imagesQuality;

    var scalableImages = config.scalableImages;
    var componentsNames = Object.getOwnPropertyNames(scalableImages);

    Object.keys(scalableImages).forEach(function (imgSet, index) {
        imgSet = scalableImages[imgSet];
        imgSet.resolutions.forEach(function (resolution) {
            ///Remember to install: apt-get install graphicsmagick
            //For API doc: http://aheckmann.github.io/gm/docs.html
            gulp.src(['resources/images/scalable/' + componentsNames[index] + '/*.png', 'resources/images/scalable/' + componentsNames[index] + '/*.jpg'])
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
                    return 'public/images/components/' + resolution + '/' + componentsNames[index] + '/';
                }));
        });
    });
});