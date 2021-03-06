<?php


namespace src\Model;

use src\Model\AbstractClasses\AbstractDBModel;
use src\Model\AbstractClasses\Types;

/**
 * Class Question
 * Models a question which has a type, question text,
 * a list of choices, and a list of correct answers.
 * The choices list can be an empty array (0), an array containing one (1) choice
 * or an array containing four (4) choices.
 * The correct answers list can contain any number of answers
 * between one (1) and four (4).
 * The type is a code
 * @package src\Model
 */
class Question extends AbstractDBModel
{
    private int $id;

    private string $text;

    /**
     * The type of the question.
     * MULTI_ONE, MULTI_MULTI or FILL_IN.
     * @var int
     */
    private int $type;

    /**
     * An array containing Choice objects.
     * @var array
     */
    private array $choices;

    /**
     * An array containing Choice objects
     * with isCorrect = true attribute.
     * @var array
     */
    private array $correctChoices;

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
     * @return Quiz
     */
    public function getQuiz(): string
    {
        return $this->quiz;
    }

    /**
     * @param Quiz $quiz
     */
    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param  int
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    /**
     * @return array
     */
    public function getCorrectChoices(): array
    {
        if (empty($this->correctChoices) || $this->correctChoices == null){
            $this->correctChoices = array_filter($this->choices,
                function ($choice){
                    return $choice->getIsCorrect() == 1;
                });
            $this->correctChoices = array_values($this->correctChoices);
        }
        return $this->correctChoices;
    }

    /**
     * @param array $correctChoices
     */
    public function setCorrectChoices(array $correctChoices): void
    {
        $this->correctChoices = $correctChoices;
    }


    public function getPrimaryKeyColumn()
    {
        return "Id";
    }

    public function getTable()
    {
        return "questions";
    }

    public function getColumns()
    {
        return ["QuizId", "Text", "Type"];
    }
}