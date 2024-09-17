<?php

namespace Core\Controller;

use App\Repository\GenericRepository;
use Core\Component\ConfigComponent\Config;
use Core\Component\ConfigComponent\RouteConfig;
use Core\Component\HttpComponent\Request;
use Core\Component\HttpComponent\Response;
use Core\Component\SeoComponent\Meta;
use Core\Component\SessionComponent\Session;
use Core\Component\SessionComponent\Translation;
use Exception;
use League\Plates\Engine as View;

abstract class AbstractController implements ControllerInterface
{


    protected Meta $meta;

    protected Request $request;

    protected Response $response;

    protected Session $session;

    private RouteConfig $routes;

    protected Config $trans;

    private ?array $templateData = [];

    private View $view;

    public function __construct()
    {
        $config = new Config('config/env.yaml');
        $this->session = new Session($config->getConfig('APP_SECRET'));
        $this->session->init();
        $this->routes = new RouteConfig('config/routes.yaml');
        $this->response = new Response($this->routes);



        $this->request = new Request();
        $this->request->setToken($this->session->get("csrf_token"));

        $trans = new Translation($config, $this->session);
        $this->trans = $trans->parse();

        $this->meta = new Meta($config->getConfig('meta'));
        $this->view = new View(project_root . $config->getConfig('template_base_path'));
        $this->view->addData([
            'response' => $this->response,
            'meta'=> $this->meta,
            'session'=> $this->session,
            'trans' => $this->trans,
            'locale'=> $trans->locale,
            'locales'=> $trans->availableLanguages,
            'flash' => $this->getFlash(),
            'controller' => $this,
        ]);

    }

    public function generateRandomString($length = 8): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getView(): View
    {
        return $this->view;
    }

    public function denyAccessUnlessGranted(string $role): void
    {
        if(false !== $user = $this->session->getUser()){
            if($user->getRole() != $role) {
                $this->response->redirectToRoute(302,'app_index');
            }
        } else {
            $this->response->redirectToRoute(302,'app_index');
        }
    }

    public function denyAccessUnlessLogin(string $redirectToRoute = 'app_index'): void
    {
        if(!$this->session->getUser()) {
            $this->setFlash(501,"danger");
            $this->response->redirectToRoute(302,$redirectToRoute);
        }
    }

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    private function addTemplateData(string $key, $value): void
    {
        $this->templateData[$key] = $value;
    }

    /**
     * @return void
     */
    protected function generateToken(): void
    {
        if($this->request->isGetRequest())
        {
            $csrfToken = null;
            try {
                $csrfToken = sha1(random_bytes(9));
            } catch (Exception $e) {
            }

            $this->session->set('csrf_token', $csrfToken);
        }
    }

    /**
     * @param string $route the name of the route defined in config.
     * @param array|null $mandatory the needed route parameters (optional).
     * @param null $anchor the needed anchor (optional).
     * @return string url including protocol, host, request uri and optional anchor.
     */
    public function generateUrlFromRoute(string $route, array $mandatory = null, $anchor = null): string
    {
        return $this->response->generateUrlFromRoute($route, $mandatory, $anchor);
    }

    /**
     * @param string $entity
     * @return GenericRepository the repository factory to build sql requests.
     */
    public function getRepositoryManager(string $entity): GenericRepository
    {
        return  new GenericRepository($entity);
    }

    public function getRoutes(): RouteConfig
    {
        return $this->routes;
    }

    /**
     * @param string|null $message
     * @param string|null $type
     */
    public function getFlash(string $message = null, string $type = null): ?string
    {

        $message = $message ?: $this->session->get('message');
        $type = $type ?: $this->session->get('message_type');
        $type = $type ?: 'success';

        if ($message) {

            $flash = $this->render('/component/_toast.html', [
                'type' => $type,
                'message' => $message,
                'trans' => $this->trans,
            ]);
            $this->session->clear('message');
            $this->session->clear('message_type');
            return $flash;
        }
        return null;
    }

    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    public function setFlash(string $message, string $type = 'success'): void
    {
        $this->session->set('message', $message);
        $this->session->set('message_type', $type);
    }


    /**
     * @param string $template path to the template being rendered without ".php"
     * @param array $data data put along the template
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        foreach ($data as $key => $value) {
            $this->addTemplateData($key, $value);
        }
        return $this->view->render($template, $this->templateData);
    }

}
