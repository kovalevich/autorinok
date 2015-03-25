<?php
namespace Auto\UsedBundle\Parser;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Finder\SplFileInfo;

class ParserManager
{

    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getBrandIdFromName($name){
        $brands = $this->em->getRepository('AutoCatalogBundle:Brand')->findAll();
        $temp_obj = null;
        foreach($brands as $entry){
            $synonyms = explode(';', $entry->getSynonyms());
            foreach($synonyms as $synonym) {
                if(strstr($name, $synonym)){
                    $temp_obj = $entry;
                    break;
                }
            }
            if ($temp_obj) break;
        }

        return $temp_obj;
    }

    public function getModelIdFromName($name, $brand = null){
        $models = $brand === null ? $this->em->getRepository('AutoCatalogBundle:Model')->findAll()
            : $this->em->getRepository('AutoCatalogBundle:Model')->findByBrand($brand);
        $temp_obj = null;

        if(count($models)) {
            $temp_name = '';

            foreach($models as $entry) {
                $synonyms = explode(';', $entry->getSynonyms());
                foreach($synonyms as $synonym) {
                    if(strstr($name, $synonym) && strlen($synonym) >= strlen($temp_name)){
                        $temp_obj = $entry;
                        $temp_name = $synonym;
                    }
                }
            }
        }

        return $temp_obj;
    }

    public function getGenerationIdByModel($model, $year){
        $generations = $this->em->getRepository('AutoCatalogBundle:Generation')->findByModel($model);

        $temp_obj = null;

        if(count($generations) >= 1) {
            foreach ($generations as $generation) {
                if($year >= $generation->getFirstYear() && $year <= $generation->getLastYear())
                    $temp_obj = $generation;
            }
        }

        return $temp_obj;
    }

    public function uploadImages($images)
    {
        $_dir = 'uploads/used/' . date('d-m-y');
        $ret_images = array();
        if(count($images)) {

            if(!is_dir($_dir)) mkdir($_dir);
            $i = 0;

            foreach($images as $image) {
                $fileInfo = new \SplFileInfo($image);
                $newFilename = 'photo-' . $this->generateId() . '-' . $i++ . '.' . $fileInfo->getExtension();

                $img = new \Imagick($image);

                $this->cropImage($img, $_dir.'/'.$newFilename, 800, 600);
                $this->cropImage($img, $_dir.'/'.$newFilename, 200, 150);
                $this->cropImage($img, $_dir.'/'.$newFilename, 80, 80);

                $ret_images[] = $_dir.'/'.$newFilename;
                if($i > 8) break;
            }
        }

        return $ret_images;
    }

    private function cropImage(\Imagick $image, $new_name, $w, $h)
    {
        $image->cropThumbnailImage($w, $h);
        $name = str_replace('photo-', 'photo-' . $w . '-' . $h . '-', $new_name);
        $image->writeImage($name);
    }

    public function generateId() {
        $id = uniqid();

        $id = base_convert($id, 16, 2);
        $id = str_pad($id, strlen($id) + (8 - (strlen($id) % 8)), '0', STR_PAD_LEFT);

        $chunks = str_split($id, 8);
        //$mask = (int) base_convert(IDGenerator::BIT_MASK, 2, 10);

        $id = array();
        foreach ($chunks as $key => $chunk) {
            //$chunk = str_pad(base_convert(base_convert($chunk, 2, 10) ^ $mask, 10, 2), 8, '0', STR_PAD_LEFT);
            if ($key & 1) {  // odd
                array_unshift($id, $chunk);
            } else {         // even
                array_push($id, $chunk);
            }
        }

        return base_convert(implode($id), 2, 36);
    }
}