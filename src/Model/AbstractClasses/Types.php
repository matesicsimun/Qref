<?php


namespace src\Model\AbstractClasses;

/**
 * Class Types
 * Models the different types of questions.
 * MULTI_ONE is a multiple choice question with one correct answer.
 * MULTI_MULTI is a multiple choice question with multiple correct answers (one or more)
 * FILL_IN is a "fill in the blanks" type question.
 * @package src\Model
 */
abstract class Types
{
    const MULTI_ONE = 1;

    const MULTI_MULTI = 2;

    const FILL_IN = 3;
}