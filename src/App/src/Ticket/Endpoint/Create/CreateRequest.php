<?php declare(strict_types=1);

namespace App\Ticket\Endpoint\Create;

use RequestValidation\Model\AbstractValidRequest;
use Symfony\Component\Validator\Constraints;

class CreateRequest extends AbstractValidRequest
{

    /**
     * @var string
     */
    protected $title;

    protected function getConstraints(): array
    {
        return [
            'title' => new Constraints\Type('string'),
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

}
