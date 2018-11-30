module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
	 pkg: grunt.file.readJSON('package.json'),

	 /**
	  * Sass tasks
	  */
	  sass: {
		dist: {
		  options: {
			 style: 'compressed'
		  },
		  files: {
			 './style.css' : 'style.scss'
		  } 
		}  
	  },

		/**
	  * Autoprefixer
	  */
	  postcss: {
		options: {
		  map: {
			 inline: false 
		  },
		  processors: [
			 require('autoprefixer')({browsers: ['last 2 versions']})
		  ]
		},
		// prefix all css files in the project root
		dist: {
		  src: './*.css'
		}  
	  },

	  /**
		 * Watch task
		 */
		 watch: {
			grunt: {
				files: ['Gruntfile.js'],
				options: {
					reload: true
				}
			},
			css: {
				files: ['./**/*.scss'],
				tasks: ['sass', 'postcss']
			} 
		 }

	 
  });

  // Load the plugin that provides the "uglify" task.
  
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-postcss');
  // Default task(s).

  grunt.registerTask('default',['watch']);

};