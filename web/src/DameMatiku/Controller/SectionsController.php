<?php
namespace DameMatiku\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use DameMatiku\Entity\Subject;

class SectionsController extends BaseController
{
    public function indexAction(Request $request, Application $app, $subjectId)
    {
    	$subjects = $app['repository.subject']->findAll();
        $result = array_map(function (Subject $entity) {
        	return [
        		"id" => $entity->getId(),
        		"name" => $entity->getName()
        	];
        });
        return $app->json($result);
    }
}