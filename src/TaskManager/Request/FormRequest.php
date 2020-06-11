<?php

declare(strict_types=1);

namespace TaskManager\Request;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Valitron\Validator;

class FormRequest
{
    /**
     * @var Request
     */
    protected $request;

    protected $validator;

    public function __construct(ContainerInterface $container, Validator $validator)
    {
        $app = $container->get('app');
        $this->request = $app->getRequest();
        $this->validator = $validator
            ->withData($this->request->request->all())
            ->rule('required', ['username', 'email', 'description'])
            ->rule('email', ['email']);
    }

    public function validate(): array
    {
        $data['data'] = $this->validator->data();
        if (!$this->validator->validate()) {
            $data['errors'] = $this->validator->errors();
        }

        return $data;
    }
}
