<?php
namespace App\Command;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ParseDataCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:parse-xml';

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Parsing data from xml file to database.';

    protected function configure(): void
    {
        // ...
    }

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;

        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))

        $url= 'http://zr.devsel.pl/comparison/ceneo.xml';
        $xml_parsed = simplexml_load_file($url) or die("not loading");

        $number_of_products = $xml_parsed->o->count();

        for ($i=0; $i<$number_of_products; $i++){

            $entityManager= $this->doctrine->getManager();
            $product[$i] = new Product();
            $product[$i]->setName((string) $xml_parsed->o[$i]->name);
            $product[$i]->setPrice((string) $xml_parsed->o[$i]->attributes()->price);
            $product[$i]->setQuantity((string) $xml_parsed->o[$i]->attributes()->stock);
            $product[$i]->setDescription((string) $xml_parsed->o[$i]->desc);

            $attributes = $xml_parsed->o[$i]->attrs;
            $attributes_array = [];
            $k = 0;

            foreach($attributes->a as $Item){
                // $attr_name - shows tags name inside attr
                $attr_name = (string) $Item->attributes()->name;
                $attr_val = (string) $Item;
                $attributes_array [$k][$attr_name] = $attr_val;
                $k++;
            }
            $product[$i]->setAttributes($attributes_array);

            $images = $xml_parsed->o[$i]->imgs;
            $main_image = (string) $images->main->attributes()->url;
            $images_array[$i][] = $main_image;
            $j = 1;

            foreach($images->i as $Item){
                $image_link = (string) $Item->attributes()->url;
                $images_array[$i][] = $image_link;
                $j++;
            }
            $product[$i]->setimages($images_array[$i]);

            $entityManager->persist($product[$i]);
            $entityManager->flush();

        }


        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }

}