?php

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

class Row extends AbstractResource
{
    /**
     * @var question
     */
    private string $question;

    /**
    * @var answer
    */
    private string $answer;

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
    public function setQuestion(string $question): self
    {
        $this->question = $question;
        return self;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        return self;
    }
}