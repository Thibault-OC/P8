<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(Request $request, PaginatorInterface $paginator , TaskRepository $taskRepository)
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Vous devez vous connecter pour voir les tâches');
            return $this->redirectToRoute('homepage');
        }

        elseif($this->getUser() && $this->isGranted('ROLE_ADMIN') == true){

            $tasks = $taskRepository->findAll();

            $articles = $paginator->paginate(
                $tasks, // Requête contenant les données à paginer (ici nos tasks)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );

            return $this->render('task/list.html.twig', ['tasks' => $articles]);
        }

        $tasks = $taskRepository->findBy(
            ['user' => $this->getUser()->getId()]
        );

        $articles = $paginator->paginate(
            $tasks, // Requête contenant les données à paginer (ici nos tasks)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('task/list.html.twig', ['tasks' => $articles]);
    }

    /**
     * @Route("/tasks/finished", name="task_list_finished")
     */
    public function listActionFinished(Request $request, PaginatorInterface $paginator ,TaskRepository $taskRepository) :Response
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Vous devez vous connecter pour voir les tâches');
            return $this->redirectToRoute('homepage');
        }
        elseif($this->getUser() && $this->isGranted('ROLE_ADMIN') == true){

            $tasks = $taskRepository->findBy(
                ['isDone' => 1]
            );

            $articles = $paginator->paginate(
                $tasks, // Requête contenant les données à paginer (ici nos tasks)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            return $this->render('task/list.html.twig', ['tasks' => $articles]);
        }

        $tasks = $taskRepository->findBy(
            ['isDone' => 1 , 'user' => $this->getUser()->getId()]
        );

        $articles = $paginator->paginate(
            $tasks, // Requête contenant les données à paginer (ici nos tasks)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('task/list.html.twig', ['tasks' => $articles]);
    }

    /**
     * @Route("/tasks/notdone", name="task_not_done")
     */
    public function listActionNotDone(Request $request, PaginatorInterface $paginator ,TaskRepository $taskRepository) :Response
    {
        if(!$this->getUser()) {
            $this->addFlash('error', 'Vous devez vous connecter pour voir les tâches');
            return $this->redirectToRoute('homepage');
        }
        elseif($this->getUser() && $this->isGranted('ROLE_ADMIN') == true){
            $tasks = $taskRepository->findBy(
                ['isDone' => 0]
            );

            $articles = $paginator->paginate(
                $tasks, // Requête contenant les données à paginer (ici nos tasks)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            return $this->render('task/list.html.twig', ['tasks' => $articles]);
        }

        $tasks = $taskRepository->findBy(
            ['isDone' => 0 , 'user' => $this->getUser()->getId()]
        );
        $articles = $paginator->paginate(
            $tasks, // Requête contenant les données à paginer (ici nos tasks)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('task/list.html.twig', ['tasks' => $articles]);
    }


    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!$this->getUser()){
                $this->addFlash('error', 'Vous devez vous connecter pour ajouter une tache');
                return $this->redirectToRoute('task_create');
            }

            $task->setUser($this->getUser());


            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($this->getUser() || $this->isGranted('ROLE_ADMIN') == true){

                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success', 'La tâche a bien été modifiée.');

                    return $this->redirectToRoute('task_list');

            }
            else{

                $this->addFlash('error', 'Vous devez vous connecter pour modifier une tache');

                return $this->redirectToRoute('task_list');
            }

        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        if(!$this->getUser()) {

            $this->addFlash('error', 'Vous devez vous connecter pour valider une tache');

            return $this->redirectToRoute('task_list');
        }

        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {

        if($this->getUser() == $task->getUser() || $this->isGranted('ROLE_ADMIN') == true){

            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');

            return $this->redirectToRoute('task_list');
        }

            $this->addFlash('error', 'Vous devez vous connecter ou etre le createur pour supprimer une tâche');

            return $this->redirectToRoute('task_list');



    }


}
