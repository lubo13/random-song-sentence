<?php

namespace App\Controller;

use App\Entity\Song;
use Psr\Log\LogLevel;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class GetSongSentenceController extends AbstractController
{
    public $logger;
    public $kernel;

    public function __construct(Logger $logger, KernelInterface $kernel)
{
    $this->logger = $logger;
    $this->kernel = $kernel;
}

    /**
     * @Route(name="index", path="/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response    {
        $song = $this->getDoctrine()->getManager()->getRepository(Song::class)->findAll();



        $html = '<div>';
        foreach ($song  as $songs){
            $html .= '<a href=/get-sentence?'.http_build_query(['name' => $songs->getTitle()]).'>'.$songs->getTitle().'</a>';
            $html .= '<BR>';
        }

        $html .= '</div>';



        $result = new Response($html);


        return $result;
    }

    /**
     * @Route(name="get-sentemce", path="/get-sentence")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSetntences(): Response    {
        $song = $this->getDoctrine()->getManager()->getRepository(Song::class)->findAll();

        parse_str($_SERVER['QUERY_STRING'], $queries);

        $this->logger->log(LogLevel::CRITICAL, 'Get sentence for '.$queries['name'] .'song');

        $html = '<div>';
        foreach ($song  as $songs){
            if($songs->getTitle() == $queries['name'])
            {
                $s = $songs;
            }
        }


        // Our Super Heavy Business Logic ---------------------
        $exp = explode('.', $s->getFullTextInThisColumn());

        $count = count($exp);
        $rand = rand(0, $count-1);

        foreach ($exp as $k => $item) {
            if($k != $rand){
                continue;
            } else{
                $html .= "<h1>$item</h1>";
            }
        }
        // Our Super Heavy Business Logic ---------------------


        $html .= '</div>';


        $this->logger->log(LogLevel::CRITICAL, 'Return sentence for '.$html);

        $result = new Response($html);


        return $result;
    }

    /**
     * @Route(name="load", path="/load")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function load(){

        $app = new Application($this->kernel);
        $app->setAutoExit(false);

        $input = new ArrayInput([
                                    'command' => 'doctrine:mig:mig',
                                    '--env' => 'dev',
                                    '--no-interaction'
                                ]);

        // ...
        $output = new BufferedOutput(
            OutputInterface::VERBOSITY_NORMAL,
            true // true for decorated
        );
        // ...
        $app->run($input, $output);

        // return the output
        $converter = new AnsiToHtmlConverter();
        $content = $output->fetch();

        $input = new ArrayInput([
                                    'command' => 'doctrine:fixtures:load',
                                    '--env' => 'dev',
                                    '--no-interaction'
                                ]);

        // ...
        $output = new BufferedOutput(
            OutputInterface::VERBOSITY_NORMAL,
            true // true for decorated
        );
        // ...
        $app->run($input, $output);

        // return the output
        $converter = new AnsiToHtmlConverter();
        $content = $output->fetch();

        return new Response($converter->convert($content));
    }
}
