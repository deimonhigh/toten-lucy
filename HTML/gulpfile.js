// Aqui nós carregamos o gulp e os plugins através da funçao `require` do nodejs
var gulp        = require('gulp'),
    clean       = require('gulp-clean'),
    htmlmin     = require('gulp-htmlmin'),
    connect     = require('gulp-connect'),
    rename      = require('gulp-rename'),
    fileinclude = require('gulp-file-include'),
    sass        = require('gulp-sass'),
    cleanCSS    = require('gulp-clean-css'),
    sourcemaps  = require('gulp-sourcemaps'),
    plumber     = require('gulp-plumber'),
    include     = require("gulp-include"),
    compressor  = require('gulp-uglify');

// Error handler
var onError = function (err) {
  console.log(err);
  this.emit('end');
};

// Definimos FALSE se nao houver programaçao depois
var whitespace = true;

var baseDist = './dist/';
var baseSrc = './src/';

// Definimos o diretorio dos arquivos que serao verificados na pasta SRC
var filesSrc = {
  js: baseSrc + 'assets/js/functions.js',
  angular: [baseSrc + 'angular/**/*Module.js', baseSrc + 'angular/app.js'],
  indexJS: baseSrc + 'assets/index.js',
  imgs: baseSrc + 'assets/imgs/**/*',
  scss: baseSrc + 'assets/css/**/*.scss',
  fonts: [baseSrc + '**/*/*.eot', baseSrc + '**/*/*.woff2', baseSrc + '**/*/*.woff', baseSrc + '**/*/*.ttf', baseSrc + '**/*/*.svg', '!' + baseSrc + 'assets/images/'],
  html: baseSrc + 'views/**/*.html',
  index: baseSrc + 'index.html'
};

// Definimos o diretorio dos arquivos na pasta DIST
var dist = {
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

// LiveReload
var portNumber = 5555;
gulp.task('connect', function () {
  console.log('\nIniciando o servidor na porta ' + portNumber + '\n');
  connect.server({
                   port: portNumber,
                   root: baseDist,
                   livereload: true,
                   fallback: baseDist + 'index.html'
                 });
});

// Carregamos os arquivos JS
// E rodamos uma tarefa para concatenaçao
// Renomeamos o arquivo que sera minificado e logo depois o minificamos com o `jsmin`
// E pra terminar usamos o `gulp.dest` para colocar os arquivos concatenados e minificados na pasta dist/
gulp.task('js', function () {
  console.log('\nIniciando a task de inclusao e compressao do js\n');
  return gulp.src(filesSrc.js) // Arquivos que serao carregados, veja variável 'filesSrc.js' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(include())
             .pipe(rename({
                            basename: 'scripts',
                            suffix: '.min'
                          })) // Arquivo único de saída
             .pipe(sourcemaps.write(dist.mapJS)) // Cria os sourcemaps
             .pipe(gulp.dest(dist.js)) // pasta de destino do arquivo(s)
             .pipe(connect.reload()); // LiveReload
});

gulp.task('compressJS', function () {
  return gulp.src(filesSrc.js) // Arquivos que serao carregados, veja variável 'filesSrc.js' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(compressor())
             .pipe(gulp.dest(dist.js)) // pasta de destino do arquivo(s)
});

// Carregamos os arquivos do angular
// E rodamos uma tarefa para concatenaçao
// Renomeamos o arquivo que sera minificado e logo depois o minificamos com o `jsmin`
// E pra terminar usamos o `gulp.dest` para colocar os arquivos concatenados e minificados na pasta dist/
gulp.task('angular', function () {
  console.log('\nIniciando a task de inclusao e compressao do angular\n');
  gulp.src(filesSrc.angular) // Arquivos que serao carregados, veja variável 'filesSrc.js' no início
      .pipe(plumber({
                      errorHandler: onError
                    }))
      .pipe(sourcemaps.init())
      .pipe(include())
      //      .pipe(compressor())
      .pipe(rename({
                     suffix: '.min'
                   })) // Arquivo único de saída
      .pipe(sourcemaps.write(dist.mapJSAngular)) // Cria os sourcemaps
      .pipe(gulp.dest(dist.angular)) // pasta de destino do arquivo(s)
      .pipe(connect.reload()); // LiveReload
});

// Apaga a pasta da dist para recomeçar
gulp.task('clean:dist', function () {
  console.log('\nLimpando o diretorio "dist"\n');
  return gulp.src(baseDist) // Arquivos que serao carregados, veja variável 'filesSrc.html' no início
             .pipe(clean({
                           read: false,
                           force: true
                         }))
});

// Carregamos os arquivos html
// Minificamos os HTML's
// E pra terminar usamos o `gulp.dest` para colocar os arquivos e minificados na pasta dist/
gulp.task('html', function () {
  console.log('\nIniciando a task de inclusao e compressao do html\n');
  return gulp.src(filesSrc.html) // Arquivos que serao carregados, veja variável 'filesSrc.html' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(fileinclude())
             .pipe(htmlmin({
                             "collapseWhitespace": whitespace,
                             "removeComments": true,
                             "removeRedundantAttributes": true,
                             "conservativeCollapse": true

                           })) // Transforma para formato ilegível
             .pipe(gulp.dest(dist.html)) // pasta de destino do arquivo(s)
             .pipe(connect.reload()); // LiveReload
});

// Movemos a index para a pasta dist
// e a minificamos
gulp.task('index', function () {
  console.log('\nIniciando a task de inclusao e compressao do index\n');
  return gulp.src(filesSrc.index) // Arquivos que serao carregados, veja variável 'filesSrc.index' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(fileinclude())
             .pipe(htmlmin({
                             "collapseWhitespace": whitespace,
                             "removeComments": true,
                             "removeRedundantAttributes": true,
                             "conservativeCollapse": false

                           })) // Transforma para formato ilegível
             .pipe(gulp.dest(dist.index)) // pasta de destino do arquivo(s);
             .pipe(connect.reload()); // LiveReload
});

// Movemos as imagens para a pasta dist
gulp.task('imgs', function () {
  console.log('\nIniciando a task de inclusao das imagens\n');
  gulp.src(filesSrc.imgs) // Arquivos que serao carregados, veja variável 'filesSrc.imgs' no início
      .pipe(plumber({
                      errorHandler: onError
                    }))
      .pipe(gulp.dest(dist.imgs)) // pasta de destino do arquivo(s)
      .pipe(connect.reload()); // LiveReload
});

// Movemos as fontes para a pasta dist
console.log('\nIniciando a task de inclusao das fontes\n');
gulp.task('fonts', function () {
  return gulp.src(filesSrc.fonts) // Arquivos que serao carregados, veja variável 'filesSrc.fonts' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(rename({dirname: ""}))
             .pipe(gulp.dest(dist.fonts)); // pasta de destino do arquivo(s)
});

// Carregamos os arquivos SCSS
// E compilamos o SASS
// Criamos o sourcemap
gulp.task('sass', function () {
  console.log('\nIniciando a task de compilacao, inclusao e compressao do sass\n');
  return gulp.src(filesSrc.scss) // Arquivos que serao carregados, veja variável 'filesSrc.scss' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(sourcemaps.init())
             .pipe(sass({
                          outputStyle: 'compressed'
                        })) // Converte Sass para CSS
             .pipe(rename('style.min.css'))
             .pipe(sourcemaps.write(dist.mapCSS)) // Cria os sourcemaps
             .pipe(gulp.dest(dist.css)) // pasta de destino do arquivo(s)
             .pipe(connect.reload()); // LiveReload
});

// Carregamos os arquivos SCSS
gulp.task('cleanCSS', function () {
  console.log('\nIniciando a task de compilacao, inclusao e compressao do sass\n');
  return gulp.src(filesSrc.scss) // Arquivos que serao carregados, veja variável 'filesSrc.scss' no início
             .pipe(plumber({
                             errorHandler: onError
                           }))
             .pipe(cleanCSS({
                              debug: true,
                              level: {
                                2: {all: true}
                              }
                            }))
             .pipe(gulp.dest(dist.css)) // pasta de destino do arquivo(s)
});

var choiceslabel = ['SASS => s', 'Fonts => f', 'Imgs => i', 'JS => j', 'HTML => h', 'Index => x', 'Angular => g', 'Abrir no navegador => a', 'Fim => q'];

function message() {
  console.log('-----------------------------');
  console.log('\n');
  console.log('Digite a task que deseja recomeçar:');
  console.log(choiceslabel);
  console.log('\n');
  console.log('-----------------------------')
}

gulp.task('type', function () {
  var readline = require('readline');
  const exec = require('child_process').exec;

  var rl = readline.createInterface({
                                      input: process.stdin,
                                      output: process.stdout,
                                      terminal: true
                                    });

  var choices = ['s', 'f', 'i', 'j', 'h', 'x', 'g', 'a', 'q'];
  var tasks = ['sass', 'fonts', 'imgs', 'js', 'html', 'index', 'angular'];
  message();

  rl.on('line', function (line) {
    var index = choices.indexOf(line);
    if (index > -1) {
      if (index == (choices.length - 1)) {
        process.exit();
      } else if (index == (choices.length - 2)) {
        console.log("\nAbrindo em http://localhost:" + portNumber + '/\n');
        exec('start chrome "http://localhost:"' + portNumber + '/');
      } else {
        console.log('Iniciando task: ', tasks[index]);
        gulp.start(tasks[index]);
      }
    } else {
      console.log('Comando inválido');
    }
  })
});

// Tarefa de monitoraçao caso algum arquivo seja modificado, deve ser executado e deixado aberto, comando "gulp watch".
gulp.task('watch', function () {
  console.log('\nAssistindo mudanças do projeto\n');
  gulp.watch(baseSrc + 'assets/js/*.js', ['js']); // Olha por mudanças nos arquivos JS
  gulp.watch(filesSrc.html, ['html']); // Olha por mudanças nos arquivos HTML
  gulp.watch(baseSrc + 'assets/css/**/*.scss', ['sass']); // Olha por mudanças nos arquivos JS
  gulp.watch(baseSrc + 'angular/**/*.js', ['angular']); // Olha por mudanças nos arquivos JS
  gulp.watch(filesSrc.imgs, ['imgs']); // Olha por mudanças nos arquivos IMGS
  gulp.watch(filesSrc.index, ['index']); // Olha por mudanças nos arquivos IMGS
});

gulp.task('build', ['sass', 'fonts', 'imgs', 'js', 'angular', 'html', 'index'], function () {
  return gulp.start(['watch', 'type', 'connect']);
});

gulp.task('buildProd', ['cleanCSS', 'compressJS']);

// Tarefa padrao quando executado o comando GULP
gulp.task('default', ['build']);
