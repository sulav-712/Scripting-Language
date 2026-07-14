<?php
require_once 'value.php';

class Book {
  private string $title;
  private string $author;
  private string $genre;
  private string $accessionNo;


  public function setDetails(string $title, string $author, string $genre, string $accessionNo) : void {
    $this->title = $title;
    $this->author = $author;
    $this->genre = $genre;
    $this->accessionNo = $accessionNo;
  }


  public function getDetails() : string {
    return $this->accessionNo . ": " . $this->title . " by " . $this->author . " [" . $this->genre . "]";
  }


  public function matchesGenre(string $genre) : bool {
    return $this->genre === $genre;
  }
}


$book1 = new Book();
$accessionNo1 = "ACC-00" . $A;
$book1->setDetails("Harry Potter", "J.K. Rowling", "Fiction", $accessionNo1);

$book2 = new Book();
$accessionNo2 = "ACC-00" . $B;
$book2->setDetails("Advanced PHP", "Jane Smith", "Academic", $accessionNo2);

$book3 = new Book();
$title3 = "PHP for Beginners";
$wordCount = count(array_filter(explode(" ", $title3)));

if ($wordCount != ($C % 3) + 2) {
  $title3 = "PHP Basics";
}
$book3->setDetails($title3, "Alice Johnson", "Academic", "A005");

echo $book1->getDetails() . PHP_EOL;
echo $book2->getDetails() . PHP_EOL;
echo $book3->getDetails() . PHP_EOL;


echo "Book 1 matches Fiction: " . ($book1->matchesGenre("Fiction") ? 1 : 0) . PHP_EOL;
echo "Book 3 matches Academic: " . ($book3->matchesGenre("Academic") ? 1 : 0) . PHP_EOL;


?>
