module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        shell: {
            composer: {
                command: 'composer update'
            }
        },
        clean: {
            post_build: [
                'build/'
            ],
            pre_compress: [
                'build/releases'
            ]
        },
        copy: {
            build: {
                options: {
                    mode: true
                },
                src: [
                    '**',
                    '!node_modules/**',
                    '!build',
                    '!build/**',
                    '!releases',
                    '!releases/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!.gitmodules',
                    '!.gitattributes',
                    '!composer.lock'
                ],
                dest: 'build/<%= pkg.name %>/'
            }
        },
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: 'releases/<%= pkg.name %>-<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'build/',
                src: [
                    '**/*',
                    '!build/*'
                ]
            }
        },
        replace: {
            plugin_file: {
				src: [ 'wp-phpinfo.php' ],
				overwrite: true,
				replacements: [{
					from: /Version:\s*(.*)/,
					to: "Version: <%= pkg.version %>"
				}, {
					from: /define\(\s*'PHINFO_VER',\s*'(.*)'\s*\);/,
					to: "define( 'PHINFO_VER', '<%= pkg.version %>' );"
				}]
			}
        }

    });

    //load modules
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-text-replace' );
	grunt.loadNpmTasks( 'grunt-shell');

    // Tasks
    grunt.registerTask( 'version_number', [ 'replace:plugin_file' ] );
	grunt.registerTask( 'build', [  'shell:composer', 'copy', 'compress' ] );
	grunt.registerTask( 'just_build', [  'copy', 'compress' ] );

};