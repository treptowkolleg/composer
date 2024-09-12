<?php

namespace Core\View;

use Core\Component\ConfigComponent\Config;
use League\Plates\Engine as View;

class AbstractView
{

    protected Config $config;
    protected View $view;

    public function __construct()
    {
        $this->config = new Config('config/env.yaml');
        $this->view = new View(project_root . $this->config->getConfig('template_base_path'));
    }

}
