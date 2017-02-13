<?php

function getPrices(array $products) {
  // let's assume the $products parameter is an array of products.
  $prices = [];

  foreach($products as $p) {
    if($p->stock > 0) {
      $prices[] = $p->price;
    }
  }

  return $prices;
}

?>

<?php

function getPrices2(array $products) {
  return array_map(function($p) {
    return $p->price;
  }, array_filter(function($p) {
    return $p->stock > 0;
  }));
}
