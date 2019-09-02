# WholeTextFinder

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/88c3e7517a2b46c59e9a0cc75856433e)](https://app.codacy.com/app/mauretto78_2/whole-text-finder?utm_source=github.com&utm_medium=referral&utm_content=mauretto78/whole-text-finder&utm_campaign=Badge_Grade_Settings)

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
//    int(51)
//  }
// }

```

You can also specify three options:

* $skipHtmlEntities (`true` by default)
* $exactMatch (`false` by default)
* $caseSensitive (`false` by default)

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
   
```

## Support

If you found an issue or had an idea please refer [to this section](https://github.com/mauretto78/whole-text-finder/issues).

## Authors

* **Mauro Cassani** - [github](https://github.com/mauretto78)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details