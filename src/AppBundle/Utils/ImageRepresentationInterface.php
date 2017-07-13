<?php
/**
 * Created by Adam The Great.
 * Date: 23. 1. 2017
 * Time: 12:51
 */

namespace AppBundle\Utils;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageRepresentationInterface
{
    public function getImageDir(): ?string;
    public function isRepresentImg(): bool;
    public function getRepresentImgPath(): ?string;
    public function isUploadedRepresentImg(): bool;
    public function getUploadedRepresentImg(): ?UploadedFile;
}