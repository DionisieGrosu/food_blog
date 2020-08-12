const {src, dest, parallel, series, watch} = require('gulp');
const sass = require('gulp-sass');
const cleancss = require('gulp-clean-css');
const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();
const uglify = require('gulp-uglify-es').default;
const autoprefixer = require('gulp-autoprefixer');
const imagemin = require('gulp-imagemin');
const newer = require('gulp-newer');
// const rsync = require('gulp-rsync');
const del = require('del');


const imageswatch = 'jpg,jpeg,png,webp,svg';
const fileswatch = 'html,htm,txt,json,md,woff2';


function styles() {
    return src('public/admin/sass/main.sass')
        .pipe(eval('sass')())
        .pipe(concat('public.min.css'))
        .pipe(autoprefixer({
            overrideBrowserslist: ['last 15 versions', '> 1%', 'ie 8', 'ie 7', "android >= 4"],
            grid: true
        }))
        .pipe(cleancss({level: {1: {specialComments: 0}}, /* format: 'beautify' */}))
        .pipe(dest('public/admin/css'))
        .pipe(browserSync.stream())
}

function scripts() {
    return src(
        // 'public/admin/libs/jquery/dist/jquery.js',
        // 'public/admin/libs/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
        // // 'public/admin/js/libs.js',
        // 'public/admin/libs/jquery/dist/jquery.js',
        // 'public/admin/libs/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
        'public/admin/js/index.js'
    )
        .pipe(concat('public.min.js'))
        .pipe(uglify())
        .pipe(dest('public/admin/js'))
        .pipe(browserSync.stream())
}

function libsJS() {
    return src([
        // 'public/admin/libs/jquery/dist/jquery.js',
        // 'public/admin/libs/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
        // 'public/admin/js/libs.js',
        'public/admin/libs/jquery/dist/jquery.js',
        'public/admin/libs/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
        // 'public/admin/libs/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.js',
        // 'public/admin/libs/slick-1.8.1/slick/slick.js'
    ])
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(dest('public/admin/js'))
}

function browsersync() {
    browserSync.init({
        server: {baseDir: ['public/admin/', 'public/users/']},
        index: 'foods.html',
        notify: false,
        online: true
    })
}


function images() {
    return src('public/admin/images/src/**/*')
        .pipe(newer('public/admin/images/dist/'))
        .pipe(imagemin())
        .pipe(dest('public/admin/images/dist/'))
}

function cleanimg() {
    return del('public/admin/images/dist/**/*', {force: true})
}

function startwatch() {
    watch('public/admin/sass/**/*.sass', styles);
    watch('public/admin/images/src/**/*.{' + imageswatch + '}', images);
    watch('public/**/*.{' + fileswatch + '}').on('change', browserSync.reload);
    watch('public/admin/js/**/*.js').on('change', scripts);
}


exports.browsersync = browsersync;
exports.assets = series(cleanimg, styles, scripts, images);
exports.styles = styles;
exports.scripts = scripts;
exports.images = images;
exports.cleanimg = cleanimg;
exports.default = parallel(images, libsJS, styles, scripts, browsersync, startwatch);