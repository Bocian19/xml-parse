<?php
namespace App\Command;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use SimpleXMLElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;

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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo('yes1');
        function createProduct(ManagerRegistry $doctrine): Response
        {
            echo('yes2');
            $entityManager = $doctrine->getManager();

            $product = new Product();
            $product->setName('blab');
            $product->setPrice('3');
            $product->setQuantity('5');
            $product->setDescription('ok');
            $product->setAttributes([1,2]);
            $product->setimages(['http1', 'http2', 'http3']);


            $entityManager->persist($product);
            $entityManager->flush();


            return new Response('Saved new product with id ' . $product->getId());
        }echo('yes3');

        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))





//        $number_of_products = $xml_parsed->o->count();

//            $url= 'http://zr.devsel.pl/comparison/ceneo.xml';

//            $xml_parsed = simplexml_load_file($url) or die("not loading");

        // ilość w magazynie
//            $quantity = (string) $xml_parsed->o[1]->attributes()->stock;
//            //cena
//            $price = (string) $xml_parsed->o[1]->attributes()->price;
//            // nazwa
//            $name = (string) $xml_parsed->o[1]->name;
//            // opis
//            $description = (string) $xml_parsed->o[1]->desc;
//            //atrybuty
//            $attributes = $xml_parsed->o[1]->attrs;
//
//            $attributes_array = [];
//            $i = 0;
//
//            foreach($attributes->a as $Item){
//                //Now you can access the 'row' data using $Item in this case
//                //two elements, a name and an array of key/value pairs
//                // $attr_name - wyswietla nazwy tagów wewnątrz tagu attr
//                $attr_name = (string) $Item->attributes()->name;
//                $attr_val = (string) $Item;
//                $attributes_array [$i][$attr_name] = $attr_val;
//                $i++;
//            }
//
//            // getting links to images from object and pushing into an array
//
//            $images = $xml_parsed->o[1]->imgs;
//            $main_image = (string) $images->main->attributes()->url;
//            $images_array[] = $main_image;
//            $i = 1;
//
//            foreach($images->i as $Item){
//                //Now you can access the 'row' data using $Item in this case
//                //two elements, a name and an array of key/value pairs
//                // $attr_name - wyswietla nazwy tagów wewnątrz tagu attr
//                $image_link = (string) $Item->attributes()->url;
//                $images_array[] = $image_link;
//                $i++;
//            }


        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }

}