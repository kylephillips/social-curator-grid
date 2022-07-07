var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');
var minifycss = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

// Paths – Admin
var admin_scss = 'assets/admin/scss/*';
var admin_css = 'assets/admin/';

// Paths - Public
var public_scss = 'assets/public/scss/*';
var public_css = 'assets/public/css/';
var public_js_source = [
	'assets/public/js/source/imagesloaded.pkgd.js',
	'assets/public/js/source/social-curator-grid.js'
]
var public_js_compiled = 'assets/public/js/';


/**
* ------------------------------------------------------------------------
* Admin Tasks
* ------------------------------------------------------------------------
*/

// Styles
var admin_styles = function(){
	return gulp.src(admin_scss)
		.pipe(sass({sourceComments: 'map', sourceMap: 'sass', style: 'compact'}))
		.pipe(autoprefix('last 5 version'))
		.pipe(minifycss({keepBreaks: false}))
		.pipe(gulp.dest(admin_css))
		.pipe(livereload())
		.pipe(notify('Social Curator Grid admin styles compiled & compressed.'));
}


/**
* ------------------------------------------------------------------------
* Public Tasks
* ------------------------------------------------------------------------
*/

// Styles
var public_styles = function(){
	return gulp.src(public_scss)
		.pipe(sass({sourceComments: 'map', sourceMap: 'sass', style: 'compact'}))
		.pipe(autoprefix('last 5 version'))
		.pipe(minifycss({keepBreaks: false}))
		.pipe(gulp.dest(public_css))
		.pipe(livereload())
		.pipe(notify('Social Curator Grid public styles compiled & compressed.'));
}

/**
* Concatenate and minify scripts
*/
var public_js = function(){
	return gulp.src(public_js_source)
		.pipe(concat('social-curator-grid.min.js'))
		//.pipe(uglify())
		.pipe(gulp.dest(public_js_compiled));
};

/**
* Watch Task
*/
gulp.task('watch', function(){
	livereload.listen();
	
	gulp.watch(admin_scss, gulp.series(admin_styles));
	gulp.watch(public_scss, gulp.series(public_styles));
	gulp.watch(public_js_source, gulp.series(public_js));

});


/**
* Default
*/
gulp.task('default', gulp.series(admin_styles, public_styles, public_js, 'watch'));