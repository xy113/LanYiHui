module.exports = function(grunt){

    // 项目配置
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! common.js created_at:<%= grunt.template.today("yyyy-mm-dd") %> */\n'//添加banner
            },
            release: {//任务四：合并压缩a.js和b.js
                files: {
                    'public/js/common.js': [
                        'resources/assets/js/jquery.common.js',
                        'resources/assets/js/jquery.confirm.js',
                        'resources/assets/js/jquery.marquee.js',
                        'resources/assets/js/DSXValidate.js',
                        'resources/assets/js/DSXUtil.js',
                        'resources/assets/js/DSXDialog.js',
                        'resources/assets/js/DistrictSelector.js',
                        'resources/assets/js/DSXUI.js',
                        'resources/assets/js/boot.js',
                    ]
                }
            }
        },
        babel: {
            options: {
                sourceMap: false,
                presets: ['babel-preset-latest']
            },
            dist: {
                files: {
                    'resources/assets/test/app.js': 'resources/assets/test/index.js'
                }
            }
        }
    });

    require( "load-grunt-tasks" )( grunt );
    // 加载提供"uglify"任务的插件
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // 默认任务
    grunt.registerTask('default', ['uglify:release', 'babel']);
    //grunt.registerTask('babel', ['babel']);
};
