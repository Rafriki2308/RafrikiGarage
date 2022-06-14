<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PrintToPdf
{
    public function parsePictureToBase64($pictureRoute)
    {
        $binaryContent = file_get_contents($pictureRoute);
        $pictureBase64 = base64_encode($binaryContent);

        return $pictureBase64;
    }

    public function parseToPdf($html)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);

        $pdf = new Dompdf($options);
        $pdf->setPaper('A4');

        /*This assignamet is necesary in order to avoid some fails loading
        the view of the PDF*/
        $htmlClean = ob_get_clean();
        $htmlClean = $html;
        $pdf->loadHtml($html);
        $pdf->render();

        return $pdf;
    }

}
