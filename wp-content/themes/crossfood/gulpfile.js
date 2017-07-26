var gulp            = require('gulp');
//less-css
// var browserSync     = require('browser-sync');
var less            = require('gulp-less');
var cssmin          = require('gulp-minify-css');
var autoprefixer    = require('gulp-autoprefixer');
var rename          = require('gulp-rename');

var uglify          = require('gulp-uglify');
var concat          = require('gulp-concat');

var copy            = require('gulp-contrib-copy');

//images
var imagemin        = require('gulp-imagemin');
var cache           = require('gulp-cache');

//cleaning
var clear           = require('del');
var cache           = require('gulp-cache');

//Sequence
var runSequence = require('run-sequence');
 var gulpsync = require('gulp-sync')(gulp);





// path
var PUBLIC_DIR = '../';
var path = {
    scripts :  'src/js/**/*.js' ,
    less    :  'src/less/style.less' ,
    css     :  'src/css/',
};



gulp.task('less', function(){
    return gulp.src(path.less)
        .pipe(less()) // используем gulp-less
        .pipe(autoprefixer({
            browsers:
                [
                    'Chrome > 20',
                    'Firefox > 20',
                    'Safari > 8',
                    'iOS > 7',
                    'ie > 8'
                ]
        }))
        .pipe(cssmin())
        .pipe(gulp.dest(path.css))
        // .pipe(rename('style.css'))
        // .pipe(gulp.dest(PUBLIC_DIR))
});


// gulp.task('scripts', function(){
//     return gulp.src(['!src/js/index.min.js', path.scripts])
//         .pipe(concat('index.min.js'))
//         .pipe(uglify())
//         .pipe(gulp.dest(PUBLIC_DIR +'src/js/'))
//         .pipe(gulp.dest('src/js/'))
// });


gulp.task('clean:cache', function(done){
    return cache.clearAll(done);
});



// Watchers
gulp.task('default',gulpsync.sync([
            'clean:cache',
            'less',
            // 'scripts',
         ]
    )
);


gulp.task('build',gulpsync.sync([
            'clean:cache',
            'less',
            // 'scripts',
         ]
    )
);

