# Kirby Related Pages

Related Pages is a [Kirby CMS](https://getkirby.com) plugin that lets you fetch pages related to the current page based on matching values in a given field. The resulting collection is sorted by number of matches as an indicator of relevance.

Example:
The current page has a tags field with three values (red, green, blue). You want to find all sibling pages with at least 2 matching tag values.


## Installation

### Download

[Download the files](https://github.com/texnixe/kirby-related-pages/archive/master.zip) and place them inside `site/plugins/kirby-related-pages`.

### Kirby CLI
Installing via Kirby's [command line interface](https://github.com/getkirby/cli):

    $ kirby plugin:install texnixe/kirby-related-pages

To update the plugin, run:

    $ kirby plugin:update texnixe/kirby-related-pages

### Git Submodule
You can add the plugin as a Git submodule.

    $ cd your/project/root
    $ git submodule add https://github.com/texnixe/kirby-related-pages.git site/plugins/kirby-related-pages
    $ git submodule update --init --recursive
    $ git commit -am "Add Kirby Related Pages plugin"

Run these commands to update the plugin:

    $ cd your/project/root
    $ git submodule foreach git checkout master
    $ git submodule foreach git pull
    $ git commit -am "Update submodules"
    $ git submodule update --init --recursive


## Usage

```
<?php

$relatedPages = getRelatedPages();

foreach($relatedPages as $p) {
  echo $p->title();
}

?>
```

### Options

You can pass an array of options:

```
<?php
$relatedPages = getRelatedPages(array(
  'searchCollection' => $page->siblings()->visible(),
  'searchField'      => 'tags',
  'matches'          => 2,
  'delimiter'        => ',',
  'languageFilter'   => false
  ));
?>
```
#### searchCollection

The pages collection to search in.
Default: ``$site->index()``

#### searchField

The name of the field to search in.
Default: tags

#### delimiter

The delimiter that you use to separate values in a field
Default: ,

#### matches

The minimum number of values that should match.
Default: 1

#### languageFilter

Filter related pages by language in a multi-language installation.
Default: false


## License

Kirby Related Pages is open-sourced software licensed under the MIT license.

Copyright © 2016 Sonja Broda info@texniq.de https://www.texniq.de
