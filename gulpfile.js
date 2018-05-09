var gulp = require('gulp');

gulp.task('default', function() {
  // place code for your default task here
     gulp.src('./*.php').pipe(gulp.dest('../GULP/'));
     gulp.src('./top/**/*').pipe(gulp.dest('../GULP/top/'));
     gulp.src('./pages/**/*').pipe(gulp.dest('../GULP/pages/'));
});
