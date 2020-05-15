<?php


namespace src\Model;


use src\Model\AbstractClasses\AbstractDBModel;

class Comment extends AbstractDBModel
{

    private int $id;
    private string $content;
    private User $author;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }



    public function getPrimaryKeyColumn()
    {
        return "Id";
    }

    public function getTable()
    {
        return "comments";
    }

    public function getColumns()
    {
        return ["AuthorId", "QuizId", "Content"];
    }

    public function toString(){
        return "Author: " . $this->author->getUserName() . ", comment: " . $this->content . ".";
    }
}