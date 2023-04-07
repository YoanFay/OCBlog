<?php

namespace App\Src\Core;

use App\Src\Entity\File;

class Upload
{

    /**
     * @var File
     */
    private $file;

    /**
     * @var string
     */
    private $where;


    /**
     * @param File   $file  parameter
     * @param string $where parameter
     */
    public function __construct(File $file, string $where)
    {
        $this->file = $file;
        $this->where = $where;

        //end __construct()
    }


    /**
     * @return false|string
     */
    public function addFile()
    {

        $path = "img/".$this->where."/";
        $prefix = $this->where."_";

        $filename = uniqid($prefix).".".pathinfo($this->file->getName(), PATHINFO_EXTENSION);

        try {
            move_uploaded_file($this->file->getTmpName(), $path.$filename);
        } catch (\Exception $e) {
            return false;
        }

        return $filename;
    }

    /**
     * @return false|string
     */
    public function addPdf()
    {

        $path = "pdf/".$this->where."/";
        $prefix = $this->where."_";

        $filename = uniqid($prefix).".".pathinfo($this->file->getName(), PATHINFO_EXTENSION);

        try {
            move_uploaded_file($this->file->getTmpName(), $path.$filename);
        } catch (\Exception $e) {
            return false;
        }

        return $filename;
    }

    /**
     * @param string $url parameter
     *
     * @return false|string
     */
    public function addFileByUrl(string $url)
    {

        $path = "img/".$this->where."/";
        $prefix = $this->where."_";
        $img = file_get_contents($url);
        $filename = uniqid($prefix).".png";

        if (!$img) {
            return false;
        }

        try {
            file_put_contents($path.$filename, $img);
        } catch (\Exception $e) {
            return false;
        }

        return $filename;
    }

}
