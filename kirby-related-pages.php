<?php
/**
 * Kirby Related Pages Plugin
 *
 * @version   1.1.0
 * @author    Sonja Broda <info@texniq.de>
 * @copyright Sonja Broda <info@texniq.de>
 * @link      https://github.com/texnixe/kirby-related
 * @license   MIT
 */


function getRelatedPages($options = array()) {

  // defaults
  $defaults = array(
    'searchCollection' => site()->children()->index(),
    'searchField'      => 'tags',
    'matches'          => 1,
    'delimiter'        => ',',
    'languageFilter'   => false,
  );

  // Merge default and user options
  $options = array_merge($defaults,$options);

  // define variables
  $searchCollection = $options['searchCollection'];
  $matches          = $options['matches'];
  $searchField      = str::lower($options['searchField']);
  $delimiter        = $options['delimiter'];
  $languageFilter   = $options['languageFilter'];
  $activePage       = site()->activePage();


  // get search items from active page
  $searchItems     = $activePage->$searchField()->split(',');
  $noOfSearchItems = count($searchItems);

  if($noOfSearchItems > 0):

     // no. of matches can't be greater than no. of searchItems
    $matches > $noOfSearchItems? $matches = $noOfSearchItems: $matches;

    // filter pages with matches greater or equal to given match rate and sort by relevance
    $relatedPages = new Pages();

    for($i = $noOfSearchItems; $i >= $matches; $i--) {
      $relevant{$i} = $searchCollection->not($activePage)->filter(function($p) use($searchItems, $searchField, $delimiter, $i){
        return count(array_intersect($searchItems, $p->$searchField()->split($delimiter))) == $i;
      });
      $relatedPages->add($relevant{$i});
    }

    // filter collection by current language
    if(site()->multilang() && $languageFilter) {
      $relatedPages = $relatedPages->filter(function($p) {
        return $p->content(site()->language()->code())->exists();
      });
    }

    // return result collection
    return $relatedPages;
  else:
    return new Pages();
  endif;
}
