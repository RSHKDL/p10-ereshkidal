<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleReport;
use App\Repository\AbstractReportRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportController
 * @author ereshkidal
 */
class ReportController extends BaseController
{
    /**
     * @var AbstractReportRepository
     */
    private $reportRepository;

    public function __construct(AbstractReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @Route("/reports/{id}", name="report_show")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $report = $this->reportRepository->find($id);
        dd($report);
    }

    /**
     * @Route("/reports/article/{id}/create", name="report_article_create")
     * @param Article $article
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function reportArticle(Article $article): Response
    {
        $report = new ArticleReport();
        $report->setArticle($article);
        $report->setMotive('todo');
        $this->reportRepository->save($report);

        return $this->redirectToRoute('admin_reports');
    }
}
