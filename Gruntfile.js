module.exports = function(grunt) {

	var npmDependencies = require('./package.json').devDependencies;
	var hasSass = npmDependencies['grunt-contrib-sass'] !== undefined;
	var hasStylus = npmDependencies['grunt-contrib-stylus'] !== undefined;

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
		stylus : {
			files: ['stylus/**/*.styl'],
			tasks : (hasStylus) ? ['stylus:dev'] : null
		},
		sass : {
			files : ['scss/**/*.scss'],
			tasks : (hasSass) ? ['sass:dev'] : null
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
	},
	
	// Stylus dev and production build tasks
	stylus : {
		production : {
			files : [
				{
					src : ['**/*.styl', '!**/_*.styl'],
					cwd : 'stylus',
					dest : 'css',
					ext: '.css',
					expand : true
				}
			],
			options : {
				compress : true
			}
		},
		dev : {
			files : [
				{
					src : ['**/*.styl', '!**/_*.styl'],
					cwd : 'stylus',
					dest : 'css',
					ext: '.css',
					expand : true
				}
			],
			options : {
				compress : false
			}
		},
	},
	
	// Sass dev and production build tasks
	sass : {
		production : {
			files : [
				{
					src : ['**/*.scss', '!**/_*.scss'],
					cwd : 'scss',
					dest : 'css',
					ext : '.css',
					expand : true
				}
			],
			options : {
				style : 'compressed'
			}
		},
		dev : {
			files : [
				{
					src : ['**/*.scss', '!**/_*.scss'],
					cwd : 'scss',
					dest : 'css',
					ext : '.css',
					expand : true
				}
			],
			options : {
				style : 'expanded'
			}
		}
	},
});
	
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-modernizr');
	
	grunt.registerTask('default', ['jshint']);
};
