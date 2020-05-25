<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleReport;
use App\Form\ReportType;
use App\Repository\AbstractReportRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param Request $request
     * @param Article $article
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reportArticle(Request $request, Article $article): Response
    {
        $form = $this->createForm(ReportType::class, null, [
            'data_class' => ArticleReport::class
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $report = $form->getData();
            $report->setArticle($article);
            $this->reportRepository->save($report);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('report/create.html.twig', [
            'reportForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/reports/{id}/update", name="report_update")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateReport(Request $request, int $id): Response
    {
        $report = $this->reportRepository->find($id);

        if (null === $report) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ReportType::class, $report, [
            'data_class' => get_class($report)
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->reportRepository->save($form->getData());

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('report/update.html.twig', [
            'reportForm' => $form->createView()
        ]);
    }
}
