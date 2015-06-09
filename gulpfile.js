var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

// Paths – Admin
var admin_scss = 'assets/admin/scss/*';
var admin_css = 'assets/admin/';

// Paths - Public
var public_scss = 'assets/public/scss/*';
var public_css = 'assets/public/css/';
var public_js_source = [
	'assets/public/js/source/social-curator-grid.js'
]
var public_js_compiled = 'assets/public/js/';


/**
* ------------------------------------------------------------------------
* Admin Tasks
* ------------------------------------------------------------------------
*/

// Styles
gulp.task('admin_styles', function(){
	return gulp.src(admin_scss)
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(autoprefix('last 15 version'))
		.pipe(gulp.dest(admin_css))
		.pipe(livereload())
		.pipe(notify('Social Curator Grid admin styles compiled & compressed.'));
});



/**
* ------------------------------------------------------------------------
* Public Tasks
* ------------------------------------------------------------------------
*/

// Styles
gulp.task('public_styles', function(){
	return gulp.src(public_scss)
		.pipe(sass({ outputStyle: 'compressed' }))
		.pipe(autoprefix('last 15 version'))
		.pipe(gulp.dest(public_css))
		.pipe(livereload())
		.pipe(notify('Social Curator Grid public styles compiled & compressed.'));
});

// JS
gulp.task('public_js', function(){
	return gulp.src(public_js_source)
		.pipe(concat('social-curator-grid.min.js'))
		.pipe(gulp.dest(public_js_compiled))
		.pipe(uglify())
		.pipe(gulp.dest(public_js_compiled))
});


/**
* Watch Task
*/
gulp.task('watch', function(){
	livereload.listen(8000);
	gulp.watch(admin_scss, ['admin_styles']);
	gulp.watch(public_scss, ['public_styles']);
	gulp.watch(public_js_source, ['public_js']);
});


/**
* Default
*/
gulp.task('default', [
	'admin_styles', 
	'public_styles', 
	'public_js',
	'watch'
]);