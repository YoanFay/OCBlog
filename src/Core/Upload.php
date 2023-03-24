<?php

namespace App\Src\Core;

class Upload
{

    private $file;
    private $where;

    public function __construct($file, $where)
    {
        $this->file = $file;
        $this->where = $where;
    }

    function addFile()
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

    function addPdf()
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

    function addFileByUrl($url)
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