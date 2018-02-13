<?php
//
//namespace AppBundle\Controller;
//
//use AppBundle\Repository\PokerRepository;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Session\Session;
//
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//
//use AppBundle\Entity\User;
//use AppBundle\Entity\Room;
//
//use function Symfony\Component\Validator\Tests\Constraints\choice_callback;
//
//class UserController extends Controller
//{
//    /**
//     * @Route("poker/", name="poker_start")
//     */
//    public function startAction(Request $request)
//    {
//
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
//
//
//        return $this->render('poker/index.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * @Route("poker/room", name="poker_room")
//     */
//    public function roomAction()
//    {
//        /*
//        $room = new Room();
//        $room->setName('miovent');
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($room);
//        $em->flush();
//        */
//
//        $em = $this->getDoctrine()->getManager();
//        $rooms = $em->getRepository('AppBundle:Room')
//            ->findAll();
//
//        return $this->render('poker/room.html.twig', [
//            'rooms' => $rooms
//        ]);
//    }
//}
