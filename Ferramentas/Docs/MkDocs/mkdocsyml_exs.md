Exemplo de mkdocs.yml:
```php
pages:
  stage: deploy
  script:
  - mkdir .public
  - cp -r * .public
  - mv .public public
logo: "/images/logo.png?raw=true" # your photo (or logo) here
description: > # your text below (remove <br> elements if you don't need line breaks)
  First description 
  <br><br>
  Second description 
  <br><br>
  <a href="https://www.linkedin.com/in/example/">View My LinkedIn Profile</a> 
google_analytics: UA-000000-0 # your Google Analytics tracking ID here
```
```php
site_name: RibaFS no GitHub
nav:
    - Início: index.md
    - Categoria Códigos: codigos/
    - Categoria Joomla: joomla/
    - Categoria CakePHP: cakephp/
    - Categoria Mobile: mobile/
theme:
    name: amelia
markdown_extensions:
    - codehilite:
            guess_lang: False
            use_pygments: True
            noclasses: True
            linenums: True
            pygments_style: monokai
```

```php
site_name: My Awesome Site
pages:
  - Home: index.md
  - About: about.md

theme_dir: custom

site_description: My awesome site
site_url: https://username.github.io/awesome_site
repo_url: https://github.com/username/awesome_site
site_author: Your Name Here
site_favicon: favicon.png
docs_dir: src
site_dir: _site
copyright: Preferably a copyleft ;-)
markdown_extensions:
    - toc:
        permalink: ""
    - extra
    - smarty
    - math
    - markdown_checklist.extension
extra_javascript: ['https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML','js/mathjaxhelper.js']
google_analytics: ['UA-xxxxxx-xx', 'username.github.io']
```

