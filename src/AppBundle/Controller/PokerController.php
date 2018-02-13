<?php

namespace AppBundle\Controller;

use AppBundle\Repository\PokerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;
use AppBundle\Entity\Room;
use AppBundle\Entity\Poker;
use function Symfony\Component\Validator\Tests\Constraints\choice_callback;

class PokerController extends Controller
{

    /**
     * @Route("poker/start", name="poker_start")
     */
    public function startAction(Request $request)
    {

//        $user = new User;
//        $form = $this->createFormBuilder($user)
//            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
//            ->add('save', SubmitType::class, array('label' => 'Create User'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $name = $form['name']->getData();
//            $session = $request->getSession();
//            $session->set('user', $name);
//
//            $this->addFlash(
//                'notice',
//                'Hallo ' . $session->get('user')
//            );
//
//            return $this->redirectToRoute('poker_room');
//        }

        return $this->render('poker/start.html.twig');
    }

    /**
     * @Route("poker/room", name="poker_room")
     */
    public function roomAction()
    {
        /*
        $room = new Room();
        $room->setName('miovent');
        $em = $this->getDoctrine()->getManager();
        $em->persist($room);
        $em->flush();
        */

        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('AppBundle:Room')
            ->findAll();

        return $this->render('poker/room.html.twig', [
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("poker/rlist", name="poker_roomlist")
     */
    public function roomsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('AppBundle:Room')
            ->findAll();

        return $this->render('poker/rlist.html.twig', [
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("poker/digit", name="poker_digit")
     */
    public function digitAction(Request $request)
    {

        $room = $request->get('room');
        $session = $request->getSession();

        $em1 = $this->getDoctrine()->getManager();
        $digits = $em1->getRepository('AppBundle:Room')
            ->findOneBy(['name' => $room])
            ->getDigits();

        $digits = explode(',', $digits);
        $session->set('digits', $digits);
        $session->set('room', $room);
        $user = $this->getUser()->getUsername();
        $session->set('user', $user);

        if ($request->get('back') == 'Neu') {

            $em = $this->getDoctrine()->getManager();
            $choice = $em->getRepository('AppBundle:Poker')
                ->findOneBy(['user' => $session->get('user')]);

            if($choice) {
                $choice->setChoiceDigit('');
                $choice->setChoice('');
                $em = $this->getDoctrine()->getManager();
                $em->persist($choice);
                $em->flush();
            }
        }

        $session->set('choice', '');
        $back = 'Zurueck';

        if ($request->get('choice') !== null) {
            $session->set('choice', $request->get('choice'));
            //$session->set('choiceDigit', $request->get('choice'));

            $em = $this->getDoctrine()->getManager();
            $poker = $em->getRepository('AppBundle:Poker')
                ->findOneBy(['user' => $user]);

            if($poker){

                $small = '<';
                $big = '>';
                $bigger  = strpos($session->get('choice'), $big);
                $smaller  = strpos($session->get('choice'), $small);

                if ($bigger !== false) {

                    $string = $session->get('choice');
                    $new_string=substr($string,1);
                    $new_string = intval($new_string);
                    $session->set('choiceDigit', $new_string);

                }else if ($smaller !== false) {

                    $string = $session->get('choice');
                    $new_string = substr($string,1);
                    $new_string = intval($new_string);
                    $session->set('choiceDigit', $new_string);

                }else{

                    $session->set('choiceDigit', $session->get('choice'));
                }

                $poker->setChoice($session->get('choice'));
                $poker->setChoiceDigit($session->get('choiceDigit'));
                $poker->setRoom($session->get('room'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($poker);
                $em->flush();

            }else{

                $poker = new Poker();
                $poker->setRoom($session->get('room'));
                $poker->setUser($user);
                $poker->setChoice($session->get('choice'));

                $small = '<';
                $big = '>';
                $bigger  = strpos($session->get('choice'), $big);
                $smaller  = strpos($session->get('choice'), $small);

                if ($bigger !== false) {

                    $string = $session->get('choice');
                    $new_string = substr($string,1);
                    $new_string = intval($new_string);
                    $session->set('choiceDigit', $new_string);

                }else if ($smaller !== false) {

                    $string = $session->get('choice');
                    $new_string = substr($string,1);
                    $new_string = intval($new_string);
                    $session->set('choiceDigit', $new_string);
                }else{

                    $session->set('choiceDigit', $session->get('choice'));
                }

                $poker->setChoiceDigit($session->get('choiceDigit'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($poker);
                $em->flush();
            }

            $back = 'Neu';
        }

        return $this->render('poker/digit.html.twig', [
            'room' => $session->get('room'),
            'digits' => $session->get('digits'),
            'choice' => $session->get('choice'),
            'back' => $back
        ]);
    }

    /**
     * @Route("poker/box", name="poker_box")
     */
    public function boxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('AppBundle:Room')
            ->findAll();

        if ($request->get('room') !== null) {

            return $this->redirect('result/box.html.twig', [
                'rooms' => $request->get('room')
            ]);
        }

        return $this->render('poker/box.html.twig', [
            'rooms' => $rooms
        ]);
    }

    /**
     * @Route("poker/result", name="poker_result")
     */
    public function resultAction(Request $request)
    {

        if($request->get('neu')){
            $em = $this->getDoctrine()->getManager();
            $query  = $em->createQuery('DELETE AppBundle:Poker');
            $query->execute();
        }

        $em = $this->getDoctrine()->getManager();
        $pokers = $em->getRepository('AppBundle:Poker')
        ->findBy(['room' => $request->get('room')]);

        return $this->render('poker/result.html.twig', [
            'pokers' => $pokers,
            'room' => $request->get('room'),
        ]);
    }

    /**
     * @Route("poker/show", name="poker_show")
     */
    public function showAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        /** @var PokerRepository $repository */
        $repository = $em->getRepository('AppBundle:Poker');

        /** @var Poker[] $pokers */
        $pokers = $repository->findPokerWithChoice($request->get('room'));

        $zahlen = array();
        foreach($pokers as $poker){
            $zahlen[] = $poker->getChoiceDigit();
        }

        $zahl_max = "";
        $zahl_min = "";
        $zahl_avg = "";
        $anz = "";

        if(count($zahlen) >= 2) {
            $zahl_max = max($zahlen);
            $zahl_min = min($zahlen);
            $zahl_avg = (!empty($zahlen) ? array_sum($zahlen) / count($zahlen) : 0);
            $anz = true;
        }

        return $this->render('poker/show.html.twig', [
            'pokers' => $pokers,
            'room' => $request->get('room'),
            'zahl_max' => $zahl_max,
            'zahl_min' => $zahl_min,
            'zahl_avg' => round($zahl_avg, 1),
            'anz' => $anz
        ]);
    }

}
