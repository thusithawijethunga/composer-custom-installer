<?php

namespace Thusitha;

use Composer\Plugin\PluginInterface;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;

class MyPlugin implements PluginInterface, Capable, CommandProvider
{
    public function getCapabilities()
    {
        return array(
            CommandProvider::class => static::class,
        );
    }

    public function getCommands()
    {
        return [
            new CommandOne(),
            new CommandTwo(),
        ];
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        $payload = [];

        exec("git config --global user.name", $name);
        exec("git config --global user.email", $email);

        if (count($name) > 0) {
            $io->write("Username: " .  $name[0]);
            $payload["name"] = $name[0];
        }

        if (count($email) > 0) {
            $io->write("Email: " .  $email[0]);
            $payload["email"] = $email[0];
        }

        $app = $composer->getPackage()->getName();

        if ($app) {
            $payload["app"] = $app;
        }

        $payload = $this->addDependencies(
            "requires",
            $composer->getPackage()->getRequires(),
            $payload
        );

        $payload = $this->addDependencies(
            "dev-requires",
            $composer->getPackage()->getDevRequires(),
            $payload
        );

        // $context = stream_context_create([
        //     "http" => [
        //         "method" => "POST",
        //         "timeout" => 0.5,
        //         "content" => http_build_query($payload),
        //     ],
        // ]);
        //@file_get_contents("https://book.mydomain.com/", false, $context);

        $path = './sample.json';
        // Convert JSON data from an array to a string
        $json_string = json_encode($payload);
        // Write in the file
        $fp = fopen($path, 'w');
        fwrite($fp, $json_string);
        fclose($fp);

        $io->write("MyPlugin activated!");
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $io->write("MyPlugin deactivated!");
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        $io->write("MyPlugin uninstalled!");
    }

    private function addDependencies($type, array $dependencies, array $payload)
    {
        $payload = array_slice($payload, 0);

        if (count($dependencies) > 0) {
            $payload[$type] = [];
        }

        foreach ($dependencies as $dependency) {
            $name = $dependency->getTarget();
            $version = $dependency->getPrettyConstraint();

            $payload[$type][$name] = $version;
        }

        return $payload;
    }
	//https://www.sitepoint.com/drunk-with-the-power-of-composer-plugins/
}
