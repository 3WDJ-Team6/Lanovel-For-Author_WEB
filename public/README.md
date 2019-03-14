### npm install -g bower

npm install -g bower-installer

### bower install <package>

bower install jquery -save
bower-installer - 지정된 path로 설치한 파일을 넣는 과정

#### installs the project dependencies listed in bower.json

bower install

#### registered package

bower install jquery

#### GitHub shorthand

bower install desandro/masonry

#### Git endpoint

bower install git://github.com/user/package.git

#### URL

bower install http://example.com/script.js

##### Search packages

Search Bower packages and find the registered package names for your favorite projects.

##### Save packages

Create a bower.json file for your package with bower init.

Then save new dependencies to your bower.json with bower install PACKAGE --save

##### Use packages

How you use packages is up to you. We recommend you use Bower together with Grunt, RequireJS, Yeoman, and lots of other tools or build your own workflow with the API. You can also use the installed packages directly, like this, in the case of jquery:

<script src="bower_components/jquery/dist/jquery.min.js"></script>
