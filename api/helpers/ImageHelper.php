<?php
namespace api\helpers;

class ImageHelper
{
    private $originalImage;
    private $originalWidth;
    private $originalHeight;

    private $finalImage;
    private $finalWidth;
    private $finalHeight;
    private $quality;

    public $minimumQuality = 50;
    public $maximumDimension = 800;
    public $maximumSize = 307200;

    public $originFile;
    private $tipo;
    private $tamanho;

    public $keepTransparency = true;


    private function openImg()
    {
        if (!file_exists($this->originFile)) return false;
        $this->tamanho = filesize($this->originFile);
        list($this->originalWidth, $this->originalHeight, $this->tipo) = getimagesize($this->originFile);
        switch ($this->tipo) {
            case IMAGETYPE_JPEG:
                $this->originalImage = imagecreatefromjpeg($this->originFile);
                break;

            case IMAGETYPE_PNG:
                $this->originalImage = imagecreatefrompng($this->originFile);
                break;

            case IMAGETYPE_GIF:
                $this->originalImage = imagecreatefromgif($this->originFile);
                break;

            default:
                return false;
                break;
        }
        return true;
    }

    private function resizeImage()
    {
        if ($this->originalWidth > $this->originalHeight) {
            $this->finalWidth = $this->maximumDimension;
            $this->finalHeight = ($this->maximumDimension * $this->originalHeight) / $this->originalWidth;
        } else {
            $this->finalHeight = $this->maximumDimension;
            $this->finalWidth = ($this->maximumDimension * $this->originalWidth) / $this->originalHeight;
        }
        $this->finalImage = imagecreatetruecolor($this->finalWidth, $this->finalHeight);
        if ($this->keepTransparency) {
            imagealphablending($this->finalImage, false);
            imagesavealpha($this->finalImage, true);
            imagecolortransparent($this->finalImage, imagecolorallocatealpha($this->finalImage, 0, 0, 0, 127));
        } else {
            imagefill($this->finalImage, 0, 0, imagecolorallocate($this->finalImage, 255, 255, 255));
        }
        imagecopyresampled($this->finalImage, $this->originalImage, 0, 0, 0, 0, $this->finalWidth, $this->finalHeight, $this->originalWidth, $this->originalHeight);
    }

    private function calcQuality()
    {
        $this->quality = 100;
        $arquivoTemporario = tempnam(sys_get_temp_dir(), 'img');
        while ($this->quality >= $this->minimumQuality) {
            clearstatcache();
            imagejpeg($this->finalImage, $arquivoTemporario, $this->quality);
            if (filesize($arquivoTemporario) > $this->maximumSize) $this->quality -= 5;
            else break;
        }
        unlink($arquivoTemporario);
    }

    public function resize()
    {
        if (!$this->openImg()) return -1;

        if (($this->originalWidth > $this->maximumDimension) || ($this->originalHeight > $this->maximumDimension)) {
            $this->resizeImage();
        } else {
            if ($this->tamanho <= $this->maximumSize) return 0;
            $this->finalImage = $this->originalImage;
        }

        if ((($this->tipo == IMAGETYPE_PNG) || ($this->tipo == IMAGETYPE_GIF)) && ($this->keepTransparency)) {
            if (!$this->finalImage) $this->finalImage = $this->originalImage;
            return 1;
        }

        $this->calcQuality();
        return 1;
    }

    public function resizeWithWatermark($arquivoWatermark, $posicao)
    {
        if (!$this->openImg()) return -1;

        if (($this->originalWidth > $this->maximumDimension) || ($this->originalHeight > $this->maximumDimension)) {
            $this->resizeImage();
        } else {
            $this->finalImage = $this->originalImage;
            $this->finalWidth = $this->originalWidth;
            $this->finalHeight = $this->originalHeight;
        }

        $imagemWatermark = imagecreatefrompng($arquivoWatermark);
        imagealphablending($imagemWatermark, true);
        imagesavealpha($imagemWatermark, true);
        list($originalWidthWatermark, $originalHeightWatermark) = getimagesize($arquivoWatermark);

        $limiteLargura = $this->finalWidth / 3;
        $limiteAltura = $this->finalHeight / 3;

        if ($originalWidthWatermark > $originalHeightWatermark) {
            $finalWidthWatermark = $limiteLargura;
            $finalHeightWatermark = ($limiteLargura * $originalHeightWatermark) / $originalWidthWatermark;
            if ($finalHeightWatermark > $limiteAltura) {
                $finalHeightWatermark = $limiteAltura;
                $finalWidthWatermark = ($limiteAltura * $originalWidthWatermark) / $originalHeightWatermark;
            }
        } else {
            $finalHeightWatermark = $limiteAltura;
            $finalWidthWatermark = ($limiteAltura * $originalWidthWatermark) / $originalHeightWatermark;
            if ($finalWidthWatermark > $limiteLargura) {
                $finalWidthWatermark = $limiteLargura;
                $finalHeightWatermark = ($limiteLargura * $originalHeightWatermark) / $originalWidthWatermark;
            }
        }

        switch ($posicao) {
            case 1:
                $xWatermark = 0;
                $yWatermark = 0;
                break;

            case 2:
                $xWatermark = ($this->finalWidth - $finalWidthWatermark) / 2;
                $yWatermark = 0;
                break;

            case 3:
                $xWatermark = $this->finalWidth - $finalWidthWatermark;
                $yWatermark = 0;
                break;

            case 4:
                $xWatermark = 0;
                $yWatermark = ($this->finalHeight - $finalHeightWatermark) / 2;
                break;

            case 5:
            default:
                $xWatermark = ($this->finalWidth - $finalWidthWatermark) / 2;
                $yWatermark = ($this->finalHeight - $finalHeightWatermark) / 2;
                break;

            case 6:
                $xWatermark = $this->finalWidth - $finalWidthWatermark;
                $yWatermark = ($this->finalHeight - $finalHeightWatermark) / 2;
                break;

            case 7:
                $xWatermark = 0;
                $yWatermark = $this->finalHeight - $finalHeightWatermark;
                break;

            case 8:
                $xWatermark = ($this->finalWidth - $finalWidthWatermark) / 2;
                $yWatermark = $this->finalHeight - $finalHeightWatermark;
                break;

            case 9:
                $xWatermark = $this->finalWidth - $finalWidthWatermark;
                $yWatermark = $this->finalHeight - $finalHeightWatermark;
        }

        if ($this->keepTransparency) {
            imagealphablending($this->finalImage, true);
            imagesavealpha($this->finalImage, true);
        }

        imagecopyresampled($this->finalImage, $imagemWatermark, $xWatermark, $yWatermark, 0, 0, $finalWidthWatermark, $finalHeightWatermark, $originalWidthWatermark, $originalHeightWatermark);

        if ((($this->tipo == IMAGETYPE_PNG) || ($this->tipo == IMAGETYPE_GIF)) && ($this->keepTransparency)) {
            if (!$this->finalImage) $this->finalImage = $this->originalImage;
            return 1;
        }

        $this->calcQuality();
        return 1;
    }

    public function save($arquivoDestino)
    {
        if (!$this->finalImage) {
            return copy($this->originFile, $arquivoDestino);
        }

        if ($this->keepTransparency) {
            switch ($this->tipo) {
                case IMAGETYPE_PNG:
                    imagepng($this->finalImage, $arquivoDestino, 9);
                    return true;
                    break;

                case IMAGETYPE_GIF:
                    imagegif($this->finalImage, $arquivoDestino);
                    return true;
                    break;
            }
        }

        imagejpeg($this->finalImage, $arquivoDestino, $this->quality);
        return true;
    }

    public function saveThumb($arquivoDestino, $larguraMiniatura, $alturaMiniatura)
    {
        if (!$this->openImg()) return false;

        if ($this->originalWidth > $this->originalHeight) {
            $finalWidth = $larguraMiniatura;
            $finalHeight = ($larguraMiniatura * $this->originalHeight) / $this->originalWidth;
            if ($finalHeight < $alturaMiniatura) {
                $finalHeight = $alturaMiniatura;
                $finalWidth = ($alturaMiniatura * $this->originalWidth) / $this->originalHeight;
            }
        } else {
            $finalHeight = $alturaMiniatura;
            $finalWidth = ($alturaMiniatura * $this->originalWidth) / $this->originalHeight;
            if ($finalWidth < $larguraMiniatura) {
                $finalWidth = $larguraMiniatura;
                $finalHeight = ($larguraMiniatura * $this->originalHeight) / $this->originalWidth;
            }
        }

        $finalImage = imagecreatetruecolor($finalWidth, $finalHeight);
        if ($this->keepTransparency) {
            imagealphablending($finalImage, false);
            imagesavealpha($finalImage, true);
            imagecolortransparent($finalImage, imagecolorallocatealpha($finalImage, 0, 0, 0, 127));
        } else {
            imagefill($finalImage, 0, 0, imagecolorallocate($finalImage, 255, 255, 255));
        }
        imagecopyresampled($finalImage, $this->originalImage, 0, 0, 0, 0, $finalWidth, $finalHeight, $this->originalWidth, $this->originalHeight);
        $finalImage = imagecrop($finalImage, array(
            'x' => ($finalWidth - $larguraMiniatura) / 2,
            'y' => ($finalHeight - $alturaMiniatura) / 2,
            'width' => $larguraMiniatura,
            'height' => $alturaMiniatura
        ));

        if ($this->keepTransparency) {
            switch ($this->tipo) {
                case IMAGETYPE_PNG:
                    imagepng($finalImage, $arquivoDestino, 9);
                    return true;
                    break;

                case IMAGETYPE_GIF:
                    imagegif($finalImage, $arquivoDestino);
                    return true;
                    break;
            }
        }

        imagejpeg($finalImage, $arquivoDestino, 75);
        return true;
    }

    public function getThumb($larguraMiniatura, $alturaMiniatura)
    {
        $caminhoTemporario = tempnam(sys_get_temp_dir(), 'img');
        $this->saveThumb($caminhoTemporario, $larguraMiniatura, $alturaMiniatura);
        if (file_exists($caminhoTemporario)) {
            $conteudoMiniatura = file_get_contents($caminhoTemporario);
            unlink($caminhoTemporario);
            return $conteudoMiniatura;
        }
        return false;
    }
}