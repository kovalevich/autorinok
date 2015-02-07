<?php

namespace Files\ImagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Files\ImagesBundle\Entity\BrandLogo;
use Files\ImagesBundle\Entity\Image;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function uploadBrandLogoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $brand = $em->getRepository('AutoCatalogBundle:Brand')->find($id);
        $photo = new BrandLogo();

        $files = $this->getFiles($request->files);

        if(count($files)) {
            $file = $files[0];
            $photo->setImage($file);
            $photo->setDate(new \DateTime("now"));
            $photo->setTitle($brand->getName());
            $brand->setLogo($photo);

            $em->persist($photo);
            $em->persist($brand);
            $em->flush();
        }

        return new JsonResponse(array(
            'success' => true,
            'src' => $photo->getImage()['path']
        ));
    }

    public function uploadImageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $photo = new Image();
        $files = $this->getFiles($request->files);

        if(count($files)) {
            $file = $files[0];
            $photo->setImage($file);
            $photo->setDate(new \DateTime("now"));
            $photo->setTitle($file->getClientOriginalName());

            $em->persist($photo);
            $em->flush();
        }

        return new JsonResponse(array(
            'filelink'      => $photo->getImage()['path'],
            'filename'      => $photo->getImage()['originalName']
        ));
    }

    protected function getFiles(FileBag $bag)
    {
        $files = array();
        $fileBag = $bag->all();
        $fileIterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($fileBag), \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($fileIterator as $file) {
            if (is_array($file) || null === $file) {
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }
}
