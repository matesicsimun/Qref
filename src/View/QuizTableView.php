<?php


namespace src\View;


use mysql_xdevapi\Table;
use src\Interfaces\IView;
use src\Model\Quiz;

class QuizTableView implements IView
{
    private array $userQuizes;
    private array $foreignQuizzes;

    public function __construct(array $userQuizes, array $foreignQuizzes)
    {
        $this->userQuizes = $userQuizes;
        $this->foreignQuizzes = $foreignQuizzes;
    }

    private function createHeaderRow(array $headers): \HTMLRowElement{
        $row = new \HTMLRowElement();
        foreach($headers as $headerText){
            $cell = new \HTMLCellElement("th");
            $cell->add_text($headerText);

            $row->add_child($cell);
        }

        return $row;
    }

    private function createRowForQuiz(Quiz $quiz):\HTMLRowElement{
        $row = new \HTMLRowElement();

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

        $timeLimit = new \HTMLCellElement();
        $timeLimit->add_text($quiz->getTimeLimit());

        $action = new \HTMLCellElement();
        $solveLink = new \HTMLAElement();
        $solveLink->add_attribute(new \HTMLAttribute("href", "quiz_solve?quizId=".$quiz->getQuizId()));
        $solveLink->add_child(new \HTMLTextNode("Solve quiz!"));
        $action->add_child($solveLink);

        $row->add_cells([$name, $description, $author, $isPublic, $commentsEnabled, $timeLimit, $action]);

        return $row;
    }

    private function createUserQuizzesTable(array $quizzes, string $caption) :\HTMLTableElement{

        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("border", "true"));
        
        $headerRow = $this->createHeaderRow(["Name", "Description", "Author", "Public?", "Comments enabled?",
                                                "TimeLimit", "Solve", "Edit", "Delete"]);

        $table->add_child($headerRow);

        $rows = [];
        foreach($quizzes as $quiz){
            $row = $this->createRowForQuiz($quiz);
            $edit = new \HTMLCellElement();

            $editLink = new \HTMLAElement();
            $editLink->add_attribute(new \HTMLAttribute("href", "edit_quiz?quiz_id=".$quiz->getQuizId()));
            $editLink->add_child(new \HTMLTextNode("Edit"));

            $edit->add_child($editLink);
            $row->add_child($edit);

            $delete = new \HTMLCellElement();

            $deleteLink = new \HTMLAElement();
            $deleteLink->add_attribute(new \HTMLAttribute("href", "delete_quiz?quiz_id=".$quiz->getQuizId()));
            $deleteLink->add_child(new \HTMLTextNode("Delete"));
            $delete->add_child($deleteLink);

            $row->add_child($delete);

            $rows[] = $row;
        }

        $table->add_children(new \HTMLCollection($rows));

        return $table;
    }

    private function createForeignQuizzesTable(array $quizzes, string $captionText):\HTMLTableElement{
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
                echo $this->createUserQuizzesTable($this->userQuizes, "Your quizzes");
            }
            if (!empty($this->foreignQuizzes)){
                echo $this->createForeignQuizzesTable($this->foreignQuizzes, "Other quizzes");
            }
        }
    }
}