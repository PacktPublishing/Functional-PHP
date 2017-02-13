#Functional PHP
This is the code repository for [Functional PHP](https://www.packtpub.com/application-development/functional-php?utm_source=github&utm_medium=repository&utm_campaign=9781785880322), published by [Packt](https://www.packtpub.com/?utm_source=github). It contains all the supporting project files necessary to work through the book from start to finish.
## About the Book
A functional approach encourages code reuse, greatly simplifies testing, and results in code that is concise and easy to understand. This book will demonstrate how PHP can also be used as a functional language, letting you learn about various function techniques to write maintainable and readable code
##Instructions and Navigation
All of the code is organized into folders. Each folder starts with a number followed by the application name. For example, Chapter02.



The code will look like the following:
```
﻿<?php
function getPrices(array $products) {
  $prices = [];
  foreach($products as $p) {
    if($p->stock > 0) {
      $prices[] = $p->price;
    }
  }
  return $prices;
}
```

You will need to have access to a computer with PHP installed. It will be easier if you know how to use the command line, but all examples should also work in a browser with maybe some small adaptations.

While learning functional programming, I also recommend the usage of a Read-Eval-Print-Loop (REPL). I personally used Boris when writing this book. You can find it at https://github.com/borisrepl/boris. Another great option is psysh, available at
http://psysh.org.

Although not at all mandatory, a REPL will allow you to quickly test your ideas and play around with the various concepts that will be presented in this book without having to juggle between your editor and command line.

##Related Products
* [Functional PHP 7 [Video]](https://www.packtpub.com/application-development/php-7-functional-programming-video?utm_source=github&utm_medium=repository&utm_campaign=9781787121454)

* [PHP 7 Data Structures and Algorithms](https://www.packtpub.com/application-development/php-7-data-structures-and-algorithms?utm_source=github&utm_medium=repository&utm_campaign=9781786463890)

* [Learning PHP 7](https://www.packtpub.com/application-development/learning-php-7?utm_source=github&utm_medium=repository&utm_campaign=9781785880544)

###Suggestions and Feedback
[Click here](https://docs.google.com/forms/d/e/1FAIpQLSe5qwunkGf6PUvzPirPDtuy1Du5Rlzew23UBp2S-P3wB-GcwQ/viewform) if you have any feedback or suggestions.
