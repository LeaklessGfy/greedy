<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Report;
use AppBundle\Form\Type\ReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ReportController extends Controller {
    public function reportControlAction() {
        return $this->render('pages/report-control.html.twig', array(

        ));
    }

    public function reportByChatAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {
            $data = $request->request->get('reportForm');

            $report = new Report();
            $formReport = $this->createForm(new ReportType(), $report);

            $reportUser = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $data['reportUser']));

            $alredyReport = $em->getRepository('AppBundle:Report')->findBy(array('informer' => $this->getUser(), 'reportUser' => $reportUser));
            if($alredyReport) {
                $this->addFlash('info','Vous avez déjà signalé cet utilisateur. Vous ne pouvez pas signaler plus d\'une fois un utilisateur');

                return $this->redirectToRoute('homepage');
            }

            $qb = $em->createQueryBuilder('m')
                ->select('c.id')
                ->from('AppBundle:Messages', 'm')
                ->join('AppBundle:ChatRoom', 'c')
                ->where('m.sender = :report OR m.receiver = :report')
                ->andWhere('m.sender = :informer OR m.receiver = :informer')
                ->setParameters(array(':report' => $reportUser, ':informer' => $this->getUser()));

            $query = $qb->getQuery();
            $result = $query->getResult();

            if($result) {
                $formReport->handleRequest($request);
                if ($formReport->isValid()) {
                    $report->setReportUser($reportUser);
                    $report->setAction($data['action']);
                    $report->setComment($data['comment']);
                    $report->setInformer($this->getUser());
                    $report->setDate(new \DateTime('now'));

                    switch ($report->getAction()) {
                        case 'insulte':
                            $report->getReportUser()->setEReputation($report->getReportUser()->getEReputation() - 30);
                            break;
                        case 'racisme':
                            $report->getReportUser()->setEReputation($report->getReportUser()->getEReputation() - 50);
                            break;
                        case 'fake':
                            $report->getReportUser()->setEReputation($report->getReportUser()->getEReputation() - 80);
                            break;
                        case 'police':
                            $report->getReportUser()->setEReputation($report->getReportUser()->getEReputation() - 100);
                            break;
                    }

                    $em->persist($report);
                    $em->flush();

                    $this->addFlash('success', 'Votre signalement à bien été enregistré');

                    return $this->redirectToRoute('homepage');
                } elseif ($formReport->isSubmitted() && !$formReport->isValid()) {
                    $this->addFlash('danger', 'Votre signalement n\'est pas valide');

                    return $this->redirectToRoute('homepage');
                }
            } else {
                $this->addFlash('danger', 'Vous ne pouvez pas signaler cet utilisateur');

                return $this->redirectToRoute('homepage');
            }
        } else {
            return $this->redirectToRoute('homepage');
        }
    }
}