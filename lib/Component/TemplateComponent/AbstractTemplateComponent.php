<?php

namespace Core\Component\TemplateComponent;

use League\Plates\Engine as View;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract class AbstractTemplateComponent
{

    protected string $templateFile;
    protected array $fields;
    protected array $templateData;
    private View $view;
    protected HtmlComponentFactory $componentFactory;
    protected array $options = [
        'is_header' => true
    ];
    /**
     * @var array $data
     */
    protected array $data;

    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflectionClass;
    private ReflectionProperty $reflectionProperty;

    private $entity;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function configureComponent(string $entity): self
    {
        try {
            $this->reflectionClass = new ReflectionClass($entity);
            if(class_exists($entity)){
                $this->entity = new $entity;
            } else {
                die('Class nicht aufrufbar!');
            }

        } catch (ReflectionException $e) {
            die($e->getMessage());
        }

        return $this;
    }

    public function add(string $field,string $format = 'string', array $options = []): self
    {
        try {
            $reflectionProperty = new ReflectionProperty($this->entity, $field);
            if($reflectionProperty->isProtected()){
                $field = ucfirst($field);
                $getProperty = "get$field";
                $this->fields['fields'][$field]['label'] = $field;
                $this->fields['fields'][$field]['format'] = $format;
                $options = (!empty($options)) ? $options : $this->options;
                foreach ($options as $option => $value)
                {
                    $this->fields['fields'][$field][$option] = $value;
                }
            }
        } catch (ReflectionException $e) {
            die('Fehler');
        }

        return $this;
    }

    public function addIdentifier(string $field,string $routeName, string $identifier, string $format = 'string', array $options = []): self
    {
        try {
            $reflectionProperty = new ReflectionProperty($this->entity, $field);
                $field = ucfirst($field);
                $getProperty = "get$field";
                $this->fields['fields'][$field]['label'] = $field;
                $this->fields['fields'][$field]['route_identifier'] = $identifier;
                $this->fields['fields'][$field]['format'] = $format;
                $this->fields['fields'][$field]['route_name'] = $routeName;
                $options = (!empty($options)) ? $options : $this->options;
                foreach ($options as $option => $value)
                {
                    $this->fields['fields'][$field][$option] = $value;
                }

        } catch (ReflectionException $e) {
            die($e->getMessage());
        }

        return $this;
    }

    public function setData($data):self
    {
        $this->data['data'] = ($data) ?: null;

        return $this;
    }

    public function setCaption(string $caption):self
    {
        $this->addTemplateData(['caption' => $caption]);
        return $this;
    }

    public function render($templateFile = null, array $templateData = null): string
    {
        if(!$templateFile)
        {
            $templateFile = $this->templateFile;
        }

        if(!$templateData)
        {
            $this->addTemplateData($this->fields);
            $this->addTemplateData($this->data);
            $templateData = $this->templateData;
        }


     return $this->view->render($templateFile,$templateData);
    }

    /**
     * @return string
     */
    public function getTemplateFile(): string
    {
        return $this->templateFile;
    }

    /**
     * @param string $templateFile
     * @return AbstractTemplateComponent
     */
    public function setTemplateFile(string $templateFile): AbstractTemplateComponent
    {
        $this->templateFile = $templateFile;
        return $this;
    }

    public function addTemplateData(array $data): self
    {
        foreach ($data as $key => $value)
        {
            $this->templateData[$key] = $value;
        }
        return $this;
    }

}