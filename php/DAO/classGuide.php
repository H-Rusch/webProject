<?php

class classGuide {
    private $guideID = null;
    private $author = null; // the id
    private $track = null; // the id
    private $title = null;
    private $category = null;
    private $text = null;
    private $lastEdit = null;
    private $tags = array();
    private $dislikes = 0;
    private $likes = 0;

    public function __construct($guideID, $author, $track, $title, $category, $text, $lastEdit, array $tags, $dislikes, $likes) {
        $this->guideID = $guideID;
        $this->author = $author;
        $this->track = $track;
        $this->title = $title;
        $this->category = $category;
        $this->text = $text;
        $this->lastEdit = $lastEdit;
        $this->tags = $tags;
        $this->dislikes = $dislikes;
        $this->likes = $likes;
    }

    public function getTrack() {
        return $this->track;
    }

    public function setTrack($track): void {
        $this->track = $track;
    }

    public function getGuideID() {
        return $this->guideID;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title): void {
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category): void {
        $this->category = $category;
    }

    public function getLastEdited() {
        return $this->lastEdit;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text): void {
        $this->text = $text;
    }

    public function getTags(): array {
        return $this->tags;
    }

     public function setTags(array $tags): void {
        $this->tags = $tags;
    }

     public function getDislikes(): int {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): void {
        $this->dislikes = $dislikes;
    }

    public function getLikes(): int {
        return $this->likes;
    }

    public function setLikes(int $likes): void {
        $this->likes = $likes;
    }
}
?>
