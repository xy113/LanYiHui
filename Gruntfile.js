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
                        'js/jquery.common.js',
                        'js/jquery.confirm.js',
                        'js/jquery.marquee.js',
                        'js/DSXValidate.js',
                        'js/DSXUtil.js',
                        'js/DSXDialog.js',
                        'js/DSXUI.js',
                        'js/boot.js',
                    ]
                }
            }
        }
    });

    // 加载提供"uglify"任务的插件
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // 默认任务
    grunt.registerTask('default', ['uglify:release']);
}
