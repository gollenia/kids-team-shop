# kids-team-shop
DokuWiki Template

## Prerequisites
- PHP 7.4, Composer, NPM
- The PHP local server can be used for development:\
`php -S localhost:8000`


## Setup
1. Download & Install DokuWiki [https://www.dokuwiki.org/install]
2. Clone this project into /lib/tpl/kids-team
3. In kids-team, run
    - `composer install`
    - `npm install`
    - `npm run {development|production}` to create {dev|prod} build of css/js
4. In DokuWiki log-in, then select the kids-team template in the Configuration Manager\
`http://localhost:8000/doku.php?id=wiki:welcome&do=admin&page=config`
5. Install Plugins:\
`http://localhost:8000/doku.php?id=wiki:welcome&do=admin&page=extension`
   - pagelist
   - filelist
   - wrap
   - tag
6. Install bibelverse Plugin (clone into /lib/plugins):\
`https://github.com/gollenia/bibleverse`
