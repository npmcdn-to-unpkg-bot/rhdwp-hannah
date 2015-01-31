module.exports = function(grunt) {

  grunt.initConfig({
    jshint : {
      all : ['Gruntfile.js', 'js/*.js', '!js/**/*modernizr*.js', '!js/**/*.min.js', '!js/vendor/**/*.js']
    },
    watch : {
      js : {
        files: ['js/**/*.js'],
        tasks : ['jshint'],
        options : {
          livereload : true
        }
      },
      php : {
        files : ['**/*.php'],
        options : {
          livereload : true
        }
      },
      css : {
        files : ['**/*.css'],
        options : {
          livereload : true
        }
      }
    },
    modernizr : {
      dist : {
        'devFile' : 'js/vendor/modernizr/modernizr-dev.js',
        'outputFile' : 'js/vendor/modernizr/modernizr-custom.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-modernizr');

  grunt.registerTask('default', ['jshint']);
};
