<?php

use Eris\Generator;

class ArrayReverseTest extends \PHPUnit_Framework_TestCase
{
    use Eris\TestTrait;

    public function testSingleElement()
    {
        $this->forAll(Generator\vector(1, Generator\nat()))
             ->then(function ($x) {
                 $this->assertEquals($x, array_reverse($x));
             });
    }

    public function testInverse()
    {
      $this->forAll(Generator\seq(Generator\nat()))
           ->then(function ($x) {
               $this->assertEquals($x, array_reverse(array_reverse($x)));
           });
    }

    public function testMerge()
    {
      $this->forAll(
               Generator\seq(Generator\nat()),
               Generator\seq(Generator\nat())
           )
           ->then(function ($x, $y) {
               $this->assertEquals(
                   array_reverse(array_merge($x, $y)),
                   array_merge(array_reverse($y), array_reverse($x))
               );
           });
    }
}

?>

<?php

class StringAreNotNumbersTest extends \PHPUnit_Framework_TestCase
{
    use Eris\TestTrait;

    public function testStrings()
    {
        $this->limitTo(1000)
             ->forAll(Generator\string())
             ->then(function ($s) {
                 $this->assertFalse(
                     is_numeric($s),
                     "'$s' is a numeric value."
                 );
             });
     }
}

?>
