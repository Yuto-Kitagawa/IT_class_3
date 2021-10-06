/* strict mode */
'use strict';

/*-------------------------------------------------
 - include node_modules
--------------------------------------------------*/
const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const autoprefixer = require('gulp-autoprefixer');
const pug = require('gulp-pug');
// const webpack = require('webpack');
// const webpackStream = require('webpack-stream');
// const webpackConfig = require('./webpack.config');

const { series,task,src,dest,watch } = gulp;

/*-------------------------------------------------
 - input/output dir path
--------------------------------------------------*/
const cssSrcPath = './src/scss';
const cssDestPath = './css';
const jsSrcPath = './src/js';
const jsDestPath = './js';
const pugSrcPath = './src/pug';
const pugDestPath = './';

/*-------------------------------------------------
 - tasks
--------------------------------------------------*/

task('sass',(done)=>{
    src(cssSrcPath + '/*.scss' )
        .pipe(plumber({
            errorHandler: notify.onError('Error: <%= error.message %>')
        }))
        .pipe(sass({
            outputStyle:'expanded',
            compass : true
            }).on('error',sass.logError))
        .pipe(sourcemaps.write())
        .pipe(autoprefixer())
        .pipe(dest(cssDestPath));
    done();
    
});

task('js',(done)=>{
    src(jsSrcPath + '/*.js' )
    .pipe(plumber({
        errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    // .pipe(webpackStream(webpackConfig,webpack))
    .pipe(dest(jsDestPath));
    done();
});

task('pug',(done)=>{
    //src(['pugSrcPath' + '/*.pug' , '!' + pugSrcPath + '/_*.pug'])
    src([`${pugSrcPath}/*.pug` , `!${pugSrcPath}/_*.pug`])
    .pipe(plumber({
        errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(pug({
        pretty: true
    }))
    .pipe(dest(pugDestPath));
    done();
});

task('watch',(done)=>{
//es5 or es6 
//    watch(cssSrcPath+'/*.scss',task('sass'));
    watch(`${cssSrcPath}/*.scss`,task('sass'));
//    watch(jsSrcPath+'/*.js',task('js'));
    watch(`${jsSrcPath}/*.js`,task('js'));
//    watch(pugSrcPath+'/*.pug',task('pug'));
    watch(`${pugSrcPath}/*.pug`,task('pug'));
   done();
});

task('default',series('sass','js','pug'));

