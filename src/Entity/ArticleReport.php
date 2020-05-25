<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ArticleReport extends AbstractReport
{
    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="reports")
     */
    private $article;

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getSubject(): string
    {
        return 'Article';
    }

    public function getSubjectSlug(): string
    {
        return $this->article->getSlug();
    }
}
