<?php

require_once('05-monad.php');

?>

<?php

print_r(check_monad_laws(
    10,
    IdentityMonad::return(20),
    function(int $a) { return IdentityMonad::return($a + 10); },
    function(int $a) { return IdentityMonad::return($a * 2); }
));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

?>

<?php

// those lines won't appear in the book, they are here just
// so that PHP can correctly lint the code.
function read_file() {}
function post() {}
class Either {
    public static function pure($a) {}
    public function bind($a) {}
}

?>

<?php

function upload(string $path, callable $f) {
    $content = read_file(filename);
    if($content === false) {
        return false;
    }

    $status = post('/uploads', $content);
    if($status === false) {
        return $false;
    }

    return $f($status);
}


?>

<?php

function upload_fp(string $path, callable $f) {
    return Either::pure($path)
      ->bind('read_file')
      ->bind(post('/uploads'))
      ->bind($f);
}

?>
