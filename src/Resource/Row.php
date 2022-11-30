<?php

declare(strict_types=1);
/**
 * MIT License
 * Copyright (c) 2022 Electronic Student Services @ Appalachian State University
 *
 * See LICENSE file in root directory for copyright and distribution permissions.
 *
 * @author
 * @license https://opensource.org/licenses/MIT
 */

namespace faq\Resource;

use faq\AbstractClass\AbstractResource;

class Row extends AbstractResource
{
    /**
     * @var question
     */
    private $question;

    /**
    * @var answer
    */
    private $answer;

    /**
     * @returns question
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @returns answer
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
        return;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer)
    {
        $this->answer = $answer;
        return;
    }

    public function __construct()
    {
        parent::__construct('faq_qa');
    }
}