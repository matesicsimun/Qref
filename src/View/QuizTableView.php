<?php


namespace src\View;


use mysql_xdevapi\Table;
use src\Interfaces\IView;

class QuizTableView implements IView
{
    private array $userQuizes;
    private array $foreignQuizzes;

    public function __construct(array $userQuizes, array $foreignQuizzes)
    {
        $this->userQuizes = $userQuizes;
        $this->foreignQuizzes = $foreignQuizzes;
    }

    private function createTable(array $quizzes, string $captionText):\HTMLTableElement{
        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("border", "true"));
        $caption = new \HTMLCaptionElement();
        $caption->add_child(new \HTMLTextNode($captionText));
        $table->add_child($caption);

        $headerRow = new \HTMLRowElement();

        $quizNameCell = new \HTMLCellElement("th");
        $quizNameCell->add_text("Name");

        $quizDescriptionCell = new \HTMLCellElement("th");
        $quizDescriptionCell->add_text("Description");

        $quizAuthorCell = new \HTMLCellElement("th");
        $quizAuthorCell->add_text("Author");

        $quizIsPublicCell = new \HTMLCellElement("th");
        $quizIsPublicCell->add_text("Public?");

        $quizCommentsEnabledCell = new \HTMLCellElement("th");
        $quizCommentsEnabledCell->add_text("Comments enabled?");

        $actionCell = new \HTMLCellElement("th");
        $actionCell->add_text("Action");

        $headerRow->add_cells([$quizNameCell, $quizDescriptionCell, $quizAuthorCell,
                        $quizIsPublicCell, $quizCommentsEnabledCell, $actionCell]);
        $table->add_child($headerRow);

        foreach($quizzes as $quiz){
            $quizRow = new \HTMLRowElement();

            $name = new \HTMLCellElement();
            $name->add_text($quiz->getName());

            $description = new \HTMLCellElement();
            $description->add_text($quiz->getDescription());

            $author = new \HTMLCellElement();
            $author->add_text($quiz->getAuthor()->getUsername());

            $isPublic = new \HTMLCellElement();
            $isPublic->add_text($quiz->getIsPublic() == 0 ? "No" : "Yes");

            $commentsEnabled = new \HTMLCellElement();
            $commentsEnabled->add_text($quiz->getCommentsEnabled() == 0 ? "No" : "Yes");

            $action = new \HTMLCellElement();
            $solveLink = new \HTMLAElement();
            $solveLink->add_attribute(new \HTMLAttribute("href", "quiz_solve?quizId=".$quiz->getQuizId()));
            $solveLink->add_child(new \HTMLTextNode("Solve quiz!"));
            $action->add_child($solveLink);

            $quizRow->add_cells([$name, $description, $author, $isPublic, $commentsEnabled, $action]);

            $table->add_child($quizRow);
        }

        return $table;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        if (empty($this->foreignQuizzes) && empty($this->userQuizes)){
            $empty = new \HTMLHElement(1);
            $empty->add_child(new \HTMLTextNode("No quizzes yet."));
            echo $empty->get_html();
        }else{
            if (!empty($this->userQuizes)){
                echo $this->createTable($this->userQuizes, "Your quizzes");
            }
            if (!empty($this->foreignQuizzes)){
                echo $this->createTable($this->foreignQuizzes, "Other quizzes");
            }
        }
    }
}