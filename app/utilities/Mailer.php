<?php


namespace App\Utility;


use App\Core\App;
use App\Core\Conf;
use DI\DependencyException;
use DI\NotFoundException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Mailer
{
    private ?string $targetEmail = null;

    private ?string $targetLastName = null;

    private ?string $subject = null;

    private ?string $message = null;

    /**
     * @return bool
     */
    public function send(): bool
    {
        if (!$this->checkMailParameters()) {
            return false;
        }

        return mail($this->getTargetEmail(), $this->getSubject(), $this->getMessage(), self::getHeaders());
    }

    private function getHeaders(): string
    {
        $headers = [];

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // En-têtes additionnels
        $headers[] = 'To: '. $this->getTargetLastName() .' <'. $this->getTargetEmail() .'>';
        $headers[] = 'From: '. Conf::get('appTitle') .' <'. Conf::get('contactEmail') .'>';

        return implode("\r\n", $headers);
    }

    /**
     * @return string|null
     */
    public function getTargetEmail(): ?string
    {
        return $this->targetEmail;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setTargetEmail(string $email): self
    {
        $this->targetEmail = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargetLastName(): ?string
    {
        return $this->targetLastName;
    }

    /**
     * @param string $targetLastName
     * @return Mailer
     */
    public function setTargetLastName(string $targetLastName): self
    {
        $this->targetLastName = $targetLastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Mailer
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Mailer
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Define email message from a twig template.
     *
     * @param string $layoutName
     * @param array $parameters
     *
     * @return $this
     *
     * @throws DependencyException
     * @throws NotFoundException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function setLayout(string $layoutName, array $parameters = []): self
    {
        $twig = App::get()
            ->getContainer()
            ->get(Environment::class);

        $this->setMessage($twig->render($layoutName, array_merge(
           $parameters,
            [
                'appTitle' => Conf::get('appTitle'),
                'copyright' => Conf::get('copyright'),
                'tld' => Conf::get('tld'),
           ]
        )));

        return $this;
    }

    private function checkMailParameters(): bool
    {
        if (is_null($this->getTargetEmail())) {
            return false;
        }

        if (is_null($this->getTargetLastName())) {
            return false;
        }

        if (is_null($this->getMessage())) {
            return false;
        }

        if (is_null($this->getSubject())) {
            return false;
        }

        return true;
    }
}
