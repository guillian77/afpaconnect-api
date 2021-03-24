<?php


namespace App\Command;


use App\Core\App;

class Command {
    private array $commandFiles;

    private array $commands = [];

    private array $args;

    public function __construct()
    {
        $this->args = $this->args = $_SERVER['argv'];

        $this->commandFiles = array_diff(scandir('app/commands'), ['.', '..', 'Command.php']);

        $this->getCommandNames();

        if (!isset($this->args[1])) {
            $this->listCommands();
            return;
        }

        if (!array_key_exists($this->args[1], $this->commands)) {
            $this->findSimilarCommands();
            return;
        }

        $className = $this->commands[$this->args[1]]['classname'];

        $app = App::get();
        $container = $app->getContainer();
        $container->get($className);
    }

    private function getCommandNames()
    {
        foreach ($this->commandFiles as $commandFile) {
            $className = str_replace('.php', '', '\App\Command\\' . $commandFile);

            $reflection = null;

            try {
                $reflection = new \ReflectionClass($className);
            } catch (Exception $exception) {
                echo "Undefined class " . $className;
                break;
            }

            $properties = $reflection->getProperties();

            $commandName = $this->extractCommandProperty('defaultName', $properties);

            $this->commands[$commandName] = [
                'classname' => $className,
                'description' => $this->extractCommandProperty('defaultDescription', $properties)
            ];
        }
    }

    private function extractCommandProperty(string $needle, array $properties)
    {
        foreach ($properties as $property) {
            if ($property->name === $needle) {
                return $property->getValue();
            }
        }

        return null;
    }

    private function findSimilarCommands()
    {
        $count = 0;

        $commands = [];


        echo $this->args[1]." not found. Try to find similar commands:\n\n";

        foreach ($this->commands as $key => $command) {
            similar_text($key, $this->args[1], $percent);

            if ($percent > 40.00) {
                $count++;
                $commands[$key] = round($percent, 0);
            }
        }

        if ($count === 0) {
            echo "No similar command found.\n";
            return;
        }

        asort($commands,SORT_NUMERIC);

        $commands = array_reverse($commands);

        foreach ($commands as $key => $command) {
            echo $key."\n";
        }
    }

    private function listCommands()
    {
        foreach ($this->commands as $key => $command) {
            echo $key."    -    ".$command['description']."\n";
        }
    }
}
