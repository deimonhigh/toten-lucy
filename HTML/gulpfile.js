const args = returnArgs(process.argv.slice(2));

// Aqui nós carregamos o gulp e os plugins através da funçao `require` do nodejs
const gulp        = require('gulp'),
      clean       = require('del'),
      cleanCSS    = require('gulp-clean-css'),
      connect     = require('gulp-connect'),
      fileinclude = require('gulp-file-include'),
      htmlmin     = require('gulp-htmlmin'),
      include     = require("gulp-include"),
      plumber     = require('gulp-plumber'),
      rename      = require('gulp-rename'),
      sass        = require('gulp-sass'),
      sourcemaps  = require('gulp-sourcemaps'),
      compressor  = require('gulp-uglify'),
      decomment   = require('gulp-decomment');

// Error handler
const onError = function (err) {
  console.log(err);
  this.emit('end');
};

// Definimos FALSE se nao houver programaçao depois
const whitespace = true;
/**
 * Definimos por linha de comando se a pasta DIST irá ser deletada
 * @type {boolean}
 * @param --del {true|false}
 */
const del = hasKey('del') ? returnKey('del') : true;

/**
 * Definimos por linha de comando qual será a pasta DIST
 * @type {string}
 * @param --dist {path}
 */
const baseDist = hasKey('dist') ? returnKey('dist') : './dist/';
const baseSrc = './src/';

// Definimos o diretorio dos arquivos que serao verificados na pasta SRC
const filesSrc = {
  js: baseSrc + 'assets/js/functions.js',
  angular: [baseSrc + 'angular/**/*Module.js', baseSrc + 'angular/app.js'],
  indexJS: baseSrc + 'assets/index.js',
  imgs: baseSrc + 'assets/imgs/**/*',
  scss: baseSrc + 'assets/css/**/*.scss',
  fonts: [baseSrc + '**/*/*.eot', baseSrc + '**/*/*.woff2', baseSrc + '**/*/*.woff', baseSrc + '**/*/*.ttf', '!' + baseSrc + 'assets/images/'],
  fontsModules: ['node_modules/**/*/*.eot', 'node_modules/**/*/*.woff2', 'node_modules/**/*/*.woff', 'node_modules/**/*/*.ttf'],
  html: baseSrc + 'views/**/*.html',
  index: baseSrc + 'index.html'
};

// Definimos o diretorio dos arquivos na pasta DIST
const dist = {
  indexJS: baseDist + 'assets/',
  js: baseDist + 'assets/js/',
  imgs: baseDist + 'assets/imgs/',
  angular: baseDist + 'assets/angular/',
  css: baseDist + 'assets/css/',
  fonts: baseDist + 'assets/fonts/',
  html: baseDist + 'views/',
  index: baseDist,
  mapJS: '/map/',
  mapJSAngular: '/map/',
  mapCSS: '/map/'
};

//region Server
const portNumber = 5555;
gulp.task('connect', function () {
  connect.server({
                   port: portNumber,
                   root: baseDist,
                   livereload: true
                 });
});
//endregion

//region Commom tasks
gulp.task('clean:dist', function () {
  return JSON.parse(del) ? clean(baseDist, {force: true}) : gulp.src('/');
});

gulp.task('js', function () {
  return gulp.src(filesSrc.js)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(include())
             .pipe(rename({
                            basename: 'scripts',
                            suffix: '.min'
                          }))
             .pipe(sourcemaps.write(dist.mapJS))
             .pipe(gulp.dest(dist.js))
             .pipe(connect.reload());
});

gulp.task('angular', function () {
  return gulp.src(filesSrc.angular)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(include())
             .pipe(rename({
                            suffix: '.min'
                          }))
             .pipe(sourcemaps.write(dist.mapJSAngular))
             .pipe(gulp.dest(dist.angular))
             .pipe(connect.reload());
});

gulp.task('html', function () {
  return gulp.src(filesSrc.html)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(fileinclude())
             .pipe(htmlmin({
                             "collapseWhitespace": whitespace,
                             "removeComments": true,
                             "removeRedundantAttributes": true,
                             "conservativeCollapse": true

                           }))
             .pipe(gulp.dest(dist.html))
             .pipe(connect.reload());
});

gulp.task('index', function () {
  return gulp.src(filesSrc.index)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(fileinclude())
             .pipe(htmlmin({
                             "collapseWhitespace": whitespace,
                             "removeComments": true,
                             "removeRedundantAttributes": true,
                             "conservativeCollapse": true

                           }))
             .pipe(gulp.dest(dist.index))
             .pipe(connect.reload());
});

gulp.task('imgs', function () {
  return gulp.src(filesSrc.imgs)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(gulp.dest(dist.imgs))
             .pipe(connect.reload());
});

gulp.task('indexJS', function () {
  return gulp.src(filesSrc.indexJS)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(decomment({trim: true}))
             .pipe(compressor())
             .pipe(gulp.dest(dist.indexJS))
             .pipe(connect.reload());
});

gulp.task('fonts', function () {
  const sourceFonts = filesSrc.fonts.concat(filesSrc.fontsModules);
  return gulp.src(sourceFonts)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(rename({dirname: ""}))
             .pipe(gulp.dest(dist.fonts))
             .pipe(connect.reload());
});

gulp.task('sass', function () {
  return gulp.src(filesSrc.scss)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(sass({
                          outputStyle: 'compressed'
                        }))
             .pipe(rename('style.min.css'))
             .pipe(sourcemaps.write(dist.mapCSS))
             .pipe(gulp.dest(dist.css))
             .pipe(connect.reload());
});
//endregion

//region Prod tasks
gulp.task('compressJS', function () {
  return gulp.src(filesSrc.js)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(include())
             .pipe(decomment({trim: true}))
             .pipe(compressor())
             .pipe(rename({
                            basename: 'scripts',
                            suffix: '.min'
                          }))
             .pipe(sourcemaps.write(dist.mapJS))
             .pipe(gulp.dest(dist.js))
             .pipe(connect.reload());
});

gulp.task('compressAngular', function () {
  return gulp.src(filesSrc.angular)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(decomment({trim: true}))
             .pipe(compressor())
             .pipe(rename({
                            suffix: '.min'
                          }))
             .pipe(sourcemaps.write(dist.mapJSAngular))
             .pipe(gulp.dest(dist.angular))
             .pipe(connect.reload());
});

gulp.task('cleanCSS', function () {
  return gulp.src(filesSrc.scss)
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(sass({
                          outputStyle: 'compressed'
                        }))
             .pipe(cleanCSS({
                              debug: true,
                              level: {
                                2: {all: true}
                              }
                            }))
             .pipe(rename('style.min.css'))
             .pipe(sourcemaps.write(dist.mapCSS))
             .pipe(gulp.dest(dist.css));
});
//endregion

//region Type Task
const choiceslabel = ['SASS => s', 'Fonts => f', 'JS => j', 'HTML => h', 'Index => x', 'Angular => g', 'Abrir no navegador => a', 'Fim => q'];

function message() {
  console.log('-----------------------------');
  console.log('\n');
  console.log('Digite a task que deseja recomeçar:');
  console.log(choiceslabel);
  console.log('\n');
  console.log('-----------------------------')
}

gulp.task('type', function () {
  const readline = require('readline');
  const exec = require('child_process').exec;

  const rl = readline.createInterface({
                                        input: process.stdin,
                                        output: process.stdout,
                                        terminal: true
                                      });

  const choices = ['s', 'f', 'j', 'h', 'x', 'g', 'a', 'q'];
  const tasks = ['sass', 'fonts', 'js', 'html', 'index', 'angular'];
  message();

  rl.on('line', function (line) {
    const index = choices.indexOf(line);
    if (index > -1) {
      if (index == (choices.length - 1)) {
        process.exit();
      } else if (index == (choices.length - 2)) {
        console.log("\nAbrindo em http://localhost:" + portNumber + '/\n');
        exec('start chrome "http://localhost:"' + portNumber + '/');
      } else {
        console.log('Iniciando task: ', tasks[index]);

        console.log(gulp.task(tasks[index])());

        gulp.task(tasks[index])();

      }
    } else {
      console.log('Comando inválido');
    }
  })
});
//endregion                k

gulp.task('watch', function () {
  gulp.watch(baseSrc + 'assets/js/*.js', gulp.parallel('js'));
  gulp.watch(filesSrc.html, gulp.parallel('html', 'index'));
  gulp.watch(baseSrc + 'assets/css/**/*.scss', gulp.parallel('sass'));
  gulp.watch(baseSrc + 'angular/**/*.js', gulp.parallel('angular'));
  gulp.watch(filesSrc.imgs, gulp.parallel('imgs'));
  gulp.watch([filesSrc.index], gulp.parallel('index'));
});

// Tarefa padrao quando executado o comando GULP
//region Task Default
gulp.task('default',
          gulp.series(
            'clean:dist',
            gulp.parallel(
              'fonts',
              'html',
              'index',
              'imgs',
              'sass',
              'js',
              'angular'
            ),
            gulp.parallel(
              'watch',
              'connect',
              'type'
            )
          )
);
//endregion

//region Build Prod
gulp.task('buildProd',
          gulp.series(
            'clean:dist',
            gulp.parallel(
              'fonts',
              'imgs',
              'html',
              'index',
              'compressJS',
              'compressAngular',
              'cleanCSS'
            )
          )
);
//endregion

//region Utils
function returnArgs(args) {
  console.log(args);
  return args.filter(function (obj) {
    return obj.toString().indexOf('=') > -1;
  }).map(function (arg) {
    var temp = arg.split('=');
    var send = {};
    var key = temp[0].replace('--', '');
    send[key] = temp[1];
    return send;
  });
}

function returnKey(key) {
  return args.find(function (row) {
    return !!row[key];
  })[key];
}

function hasKey(key) {
  return args.filter(function (row) {
      return !!row[key];
    }).length > 0;
}
//endregion