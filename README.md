# WholeTextFinder

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/b9c1cf5c3f014285b5d7748cb4175c69)](https://www.codacy.com/app/mauretto78_2/whole-text-finder?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=mauretto78/whole-text-finder&amp;utm_campaign=Badge_Grade)
[![license](https://img.shields.io/github/license/matecat/whole-text-finder.svg)]()
[![Packagist](https://img.shields.io/packagist/v/matecat/whole-text-finder.svg)]()

**WholeTextFinder** is a simple whole text finder.

## Basic Usage

Use the `find` method. Here is a basic search:

```php
//..
use Finder\WholeTextFinder;

$haystack  = "PHP PHP is the #1 web scripting PHP language of choice.";
$needle = "php";

// 3 matches
$matches = WholeTextFinder::find($haystack, $needle);

// $matches will be:
//
// array(3) {
//    [0] =>
//  array(2) {
//            [0] =>
//    string(3) "PHP"
//            [1] =>
//    int(0)
//  }
//  [1] =>
//  array(2) {
//            [0] =>
//    string(3) "PHP"
//            [1] =>
//    int(4)
//  }
//  [2] =>
//  array(2) {
//            [0] =>
//    string(3) "PHP"
//            [1] =>
//    int(32)
//  }
// }

```

## Search options

Some options are avaliable:

* **$skipHtmlEntities** (`true` by default)  
* **$exactMatch** (`false` by default) 
* **$caseSensitive** (`false` by default) 
* **$preserveNbsps** (`false` by default) 

Here are some examples:

```php
//..
use Finder\WholeTextFinder;

$haystack  = "PHP PHP is the #1 web scripting PHP language of choice.";

// 0 matches
$needle = "php";
$matches = WholeTextFinder::find($haystack, $needle, true, true, true);
   
// 1 match 
$needle = "#1";
$matches = WholeTextFinder::find($haystack, $needle, true, true, true);

// 1 match, even if the haystack contains an invisible nbsp and the needle has an ordinary spacer
$haystackWithNbsp  = "Lawful basis for processing including basis of legitimate interest";
$needleWithoutNbsp = "Lawful basis for processing including basis of legitimate interest";
$matches = WholeTextFinder::find($haystackWithNbsp, $needleWithoutNbsp, true, true, true);
   
```

## Support

If you found an issue or had an idea please refer [to this section](https://github.com/mauretto78/whole-text-finder/issues).

## Authors

* **Mauro Cassani** - [github](https://github.com/mauretto78)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
