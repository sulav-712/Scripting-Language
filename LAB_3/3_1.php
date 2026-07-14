<?php

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
$book1->setDetails("Harry Potter", "J.K. Rowling", "Fiction", "A008");

$book2 = new Book();
$book2->setDetails("Advanced PHP", "Jane Smith", "Academic", "A002");

$book3 = new Book();
$book3->setDetails("PHP for Beginners", "Alice Johnson", "Academic", "A005");

echo $book1->getDetails() . PHP_EOL;
echo $book2->getDetails() . PHP_EOL;
echo $book3->getDetails() . PHP_EOL;


echo "Book 1 matches Fiction: " . ($book1->matchesGenre("Fiction") ? 1 : 0) . PHP_EOL;
echo "Book 3 matches Academic: " . ($book3->matchesGenre("Academic") ? 1 : 0) . PHP_EOL;


?>
